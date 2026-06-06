#!/usr/bin/env bash
# Drug Pharma Egypt — pre-built bundle deployer.
#
# Differs from deploy.sh by shipping vendor/ in the tarball, so the server
# never has to run `composer install`. Output is one self-contained bundle.
#
# Bundle layout (extracted on the server):
#   ~/laravel-drugpharma/        ← code + vendor/ (overwrites existing)
#   ~/dpe-public/                ← compiled assets to drop into public_html/
#
# Vendor is cached locally in .deploy-cache/vendor-<lockhash>.tar so repeated
# runs without composer.lock changes skip the install step.
#
# Usage:
#   ./scripts/deploy-bundled.sh                       # full deploy
#   ./scripts/deploy-bundled.sh --images              # also rebuild WebP images
#   ./scripts/deploy-bundled.sh --skip-frontend       # don't rebuild Vite (reuse dist/)
#
# Env vars (override defaults):
#   DPE_SSH_HOST, DPE_SSH_PORT, DPE_SSH_USER, DPE_SSH_PASS

set -euo pipefail

# ---------------------------------------------------------------------------
# Config
# ---------------------------------------------------------------------------
SSH_HOST="${DPE_SSH_HOST:-82.25.102.203}"
SSH_PORT="${DPE_SSH_PORT:-65002}"
SSH_USER="${DPE_SSH_USER:-u188133440}"
REMOTE_HOME="/home/${SSH_USER}"
APP_DIR="${REMOTE_HOME}/laravel-drugpharma"
WEBROOT="${REMOTE_HOME}/domains/drugpharmaeg.com/public_html"

ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
STAGE="$(mktemp -d)"
CACHE_DIR="$ROOT/.deploy-cache"
mkdir -p "$CACHE_DIR"
trap 'rm -rf "$STAGE"' EXIT

# ---------------------------------------------------------------------------
# Flags
# ---------------------------------------------------------------------------
DO_FRONTEND=1
DO_IMAGES=0
for arg in "$@"; do
  case "$arg" in
    --skip-frontend) DO_FRONTEND=0 ;;
    --images)        DO_IMAGES=1 ;;
    -h|--help)
      sed -n '2,21p' "$0"
      exit 0
      ;;
    *) echo "unknown flag: $arg" >&2; exit 2 ;;
  esac
done

# ---------------------------------------------------------------------------
# Tools
# ---------------------------------------------------------------------------
need() { command -v "$1" >/dev/null || { echo "missing: $1" >&2; exit 1; }; }
need tar
need scp
need ssh
need python3
need composer
[[ "$DO_FRONTEND" == "1" ]] && need npm
[[ "$DO_IMAGES" == "1" ]]   && need convert

# ---------------------------------------------------------------------------
# SSH password
# ---------------------------------------------------------------------------
if [[ -z "${DPE_SSH_PASS:-}" ]]; then
  read -r -s -p "SSH password for ${SSH_USER}@${SSH_HOST}: " DPE_SSH_PASS
  echo
fi
export DPE_SSH_PASS

ssh_run() {
  local script="$1"
  python3 - "$script" <<'PYEOF'
import os, sys, pexpect
host=os.environ.get("DPE_SSH_HOST","82.25.102.203")
user=os.environ.get("DPE_SSH_USER","u188133440")
port=os.environ.get("DPE_SSH_PORT","65002")
script=sys.argv[1]
cmd = f"ssh -p {port} -o StrictHostKeyChecking=accept-new -o UserKnownHostsFile=/tmp/dpe_known_hosts {user}@{host} 'bash -s'"
p = pexpect.spawn("/bin/bash", ["-c", cmd], timeout=1200, encoding="utf-8")
i = p.expect(["password:", "Password:", pexpect.EOF, pexpect.TIMEOUT])
if i in (0, 1):
    p.sendline(os.environ["DPE_SSH_PASS"])
p.sendline(script)
p.sendline("exit")
p.expect(pexpect.EOF, timeout=1200)
out = p.before or ""
print(out)
PYEOF
}

scp_send() {
  local src="$1" dst="$2"
  python3 - "$src" "$dst" <<'PYEOF'
import os, sys, pexpect
host=os.environ.get("DPE_SSH_HOST","82.25.102.203")
user=os.environ.get("DPE_SSH_USER","u188133440")
port=os.environ.get("DPE_SSH_PORT","65002")
src, dst = sys.argv[1], sys.argv[2]
cmd = f"scp -P {port} -o StrictHostKeyChecking=accept-new -o UserKnownHostsFile=/tmp/dpe_known_hosts '{src}' {user}@{host}:{dst}"
p = pexpect.spawn("/bin/bash", ["-c", cmd], timeout=1200, encoding="utf-8")
i = p.expect(["password:", "Password:", pexpect.EOF, pexpect.TIMEOUT])
if i in (0, 1):
    p.sendline(os.environ["DPE_SSH_PASS"])
p.expect(pexpect.EOF, timeout=1200)
PYEOF
}

# ---------------------------------------------------------------------------
# 1) Build frontend
# ---------------------------------------------------------------------------
if [[ "$DO_FRONTEND" == "1" ]]; then
  echo "▸ Building frontend (production)..."
  (cd "$ROOT/frontend" && VITE_API_BASE="" npm run build)
else
  echo "▸ Reusing existing frontend/dist (--skip-frontend)"
  [[ -d "$ROOT/frontend/dist" ]] || { echo "frontend/dist missing" >&2; exit 1; }
fi

# ---------------------------------------------------------------------------
# 2) Vendor cache — install only if composer.lock changed
# ---------------------------------------------------------------------------
LOCK_HASH=$(sha256sum "$ROOT/backend/composer.lock" | cut -c1-12)
VENDOR_CACHE="$CACHE_DIR/vendor-${LOCK_HASH}.tar"

if [[ ! -f "$VENDOR_CACHE" ]]; then
  echo "▸ composer.lock changed (or first run) — installing vendor for production..."
  (
    cd "$ROOT/backend"
    composer install --no-dev --optimize-autoloader --no-interaction --no-progress
    tar -cf "$VENDOR_CACHE" vendor
  )
  # Clean older cached vendor tarballs
  find "$CACHE_DIR" -maxdepth 1 -name 'vendor-*.tar' ! -name "vendor-${LOCK_HASH}.tar" -delete 2>/dev/null || true
else
  echo "▸ Reusing cached vendor (lock=${LOCK_HASH})"
fi

# Ensure backend/vendor matches the cached tar (in case dev composer install ran)
rm -rf "$ROOT/backend/vendor"
tar -xf "$VENDOR_CACHE" -C "$ROOT/backend"

# ---------------------------------------------------------------------------
# 3) Build the bundle
# ---------------------------------------------------------------------------
echo "▸ Assembling bundle..."
BUNDLE="$STAGE/dpe-bundle.tar.gz"

# Mirror to a clean staging dir so we control exactly what ships
PKG="$STAGE/pkg"
mkdir -p "$PKG/laravel" "$PKG/public"

# Backend payload (excludes .env, sqlite, dev-only stuff)
tar -cf - -C "$ROOT/backend" \
  --exclude='.env' \
  --exclude='.env.backup' \
  --exclude='.env.production' \
  --exclude='node_modules' \
  --exclude='database/database.sqlite' \
  --exclude='database/*.sqlite-journal' \
  --exclude='storage/framework/cache/data/*' \
  --exclude='storage/framework/sessions/*' \
  --exclude='storage/framework/views/*' \
  --exclude='storage/logs/*' \
  --exclude='public/storage' \
  --exclude='public/hot' \
  --exclude='tests' \
  --exclude='public/images/products/*.png' \
  --exclude='public/images/products/*.jpg' \
  app bootstrap config database lang resources routes vendor \
  artisan composer.json composer.lock | tar -xf - -C "$PKG/laravel"

# Webroot payload = dist + minimal backend/public bits (favicon, .htaccess optional)
cp -a "$ROOT/frontend/dist/." "$PKG/public/"
# Include the canonical .htaccess so it can be restored if someone broke it
[[ -f "$ROOT/scripts/htaccess.conf" ]] && cp "$ROOT/scripts/htaccess.conf" "$PKG/public/.htaccess.canonical"
[[ -f "$ROOT/backend/public/favicon.ico" ]] && cp "$ROOT/backend/public/favicon.ico" "$PKG/public/" || true
[[ -f "$ROOT/backend/public/robots.txt" ]]  && cp "$ROOT/backend/public/robots.txt"  "$PKG/public/" || true
# WebP images only (PNG originals stay on the server only if you push --images separately)
if [[ -d "$ROOT/backend/public/images/products" ]]; then
  mkdir -p "$PKG/public/images/products"
  find "$ROOT/backend/public/images/products" -maxdepth 1 -name '*.webp' -exec cp {} "$PKG/public/images/products/" \;
fi

# Bundle metadata
cat > "$PKG/meta.json" <<JSON
{
  "built_at_unix": $(date +%s),
  "lock_hash": "${LOCK_HASH}",
  "git_sha": "$(git -C "$ROOT" rev-parse --short HEAD 2>/dev/null || echo unknown)"
}
JSON

# One compressed tar with everything
tar -czf "$BUNDLE" -C "$STAGE" pkg

SIZE=$(du -h "$BUNDLE" | cut -f1)
echo "▸ Bundle ready: $BUNDLE ($SIZE)"

# ---------------------------------------------------------------------------
# 4) Upload & install
# ---------------------------------------------------------------------------
echo "▸ Uploading bundle..."
scp_send "$BUNDLE" "$REMOTE_HOME/dpe-bundle.tar.gz"

echo "▸ Activating bundle on server..."
ssh_run "$(cat <<REMOTE
set -e
cd ~
TS=\$(date +%Y%m%d-%H%M%S)

# Backup current app + public_html before mutating
mkdir -p _backups_claude
tar --warning=no-file-changed -czf _backups_claude/laravel-\${TS}.tar.gz laravel-drugpharma 2>/dev/null | tail -3 || true

# Extract new bundle
rm -rf /tmp/dpe-extract
mkdir -p /tmp/dpe-extract
tar -xzf dpe-bundle.tar.gz -C /tmp/dpe-extract
rm dpe-bundle.tar.gz

# Preserve current .env (and sqlite if any) before swapping
if [[ -f laravel-drugpharma/.env ]]; then
  cp laravel-drugpharma/.env /tmp/dpe-extract/pkg/laravel/.env
fi
mkdir -p /tmp/dpe-extract/pkg/laravel/database
if [[ -f laravel-drugpharma/database/database.sqlite ]]; then
  cp laravel-drugpharma/database/database.sqlite /tmp/dpe-extract/pkg/laravel/database/database.sqlite
fi
# Carry-over storage (uploads & logs survive deploys)
if [[ -d laravel-drugpharma/storage ]]; then
  rm -rf /tmp/dpe-extract/pkg/laravel/storage
  mv laravel-drugpharma/storage /tmp/dpe-extract/pkg/laravel/storage
fi

# Atomic swap
rm -rf laravel-drugpharma.old
mv laravel-drugpharma laravel-drugpharma.old
mv /tmp/dpe-extract/pkg/laravel laravel-drugpharma

cd laravel-drugpharma

# Ensure runtime dirs/perms
mkdir -p storage/framework/{cache/data,sessions,views} storage/logs storage/app/public bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache database

# Re-create public/ -> public_html symlink (architecture-specific: this server keeps webroot outside the app dir)
rm -rf public
ln -sfn ~/domains/drugpharmaeg.com/public_html public

# DB migrations & cache rebuild
php artisan migrate --force 2>&1 | tail -10
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# storage symlink: public/storage -> storage/app/public (so /storage/... resolves via Apache)
rm -f public/storage
ln -sfn ~/laravel-drugpharma/storage/app/public public/storage

# Drop new webroot on top of public_html (keep laravel.php as-is)
cd ~
rm -rf domains/drugpharmaeg.com/public_html/assets
cp -a /tmp/dpe-extract/pkg/public/. domains/drugpharmaeg.com/public_html/
# Restore .htaccess if missing or empty (uses the canonical version shipped in the bundle)
if [[ -s domains/drugpharmaeg.com/public_html/.htaccess.canonical ]] && [[ ! -s domains/drugpharmaeg.com/public_html/.htaccess ]]; then
  cp domains/drugpharmaeg.com/public_html/.htaccess.canonical domains/drugpharmaeg.com/public_html/.htaccess
fi
touch domains/drugpharmaeg.com/public_html/images/products/*.webp 2>/dev/null || true

# Cleanup old release
rm -rf laravel-drugpharma.old /tmp/dpe-extract

echo "=== smoke ==="
curl -s -o /dev/null -w "api:   %{http_code}\n" https://drugpharmaeg.com/api/v1/categories
curl -s -o /dev/null -w "home:  %{http_code}\n" https://drugpharmaeg.com/
curl -s -o /dev/null -w "admin: %{http_code}\n" https://drugpharmaeg.com/admin/login
echo "✓ done."
REMOTE
)"

# ---------------------------------------------------------------------------
# 5) Optional image conversion
# ---------------------------------------------------------------------------
if [[ "$DO_IMAGES" == "1" ]]; then
  echo "▸ Converting & syncing images separately..."
  (
    cd "$ROOT/backend/public/images/products"
    for f in *.png *.jpg *.jpeg; do
      [ -f "$f" ] || continue
      name="${f%.*}"
      [ -f "${name}.webp" ] && continue
      convert "$f" -resize '1200x1200>' -strip -quality 85 "${name}.webp"
    done
  )
  IMG_TAR="$STAGE/images.tar.gz"
  tar -czf "$IMG_TAR" -C "$ROOT/backend/public/images" products
  scp_send "$IMG_TAR" "$REMOTE_HOME/images.tar.gz"
  ssh_run "tar -xzf ~/images.tar.gz -C ~/laravel-drugpharma/public/images/ && cp -a ~/laravel-drugpharma/public/images/products/. ~/domains/drugpharmaeg.com/public_html/images/products/ && touch ~/domains/drugpharmaeg.com/public_html/images/products/*.webp 2>/dev/null; rm ~/images.tar.gz; echo images synced"
fi

echo
echo "✓ Bundled deploy finished."
echo "  Bundle size: $SIZE"
echo "  Live:        https://drugpharmaeg.com/"
echo "  Admin:       https://drugpharmaeg.com/admin/login"
