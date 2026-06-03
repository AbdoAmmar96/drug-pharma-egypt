#!/usr/bin/env bash
# Drug Pharma Egypt — production deploy helper.
# Builds the React frontend, packages a slim backend archive, uploads both to
# Hostinger over SSH, then runs the remote install steps in one go.
#
# Usage:
#   ./scripts/deploy.sh                # backend code + frontend dist
#   ./scripts/deploy.sh --images       # also resync converted WebP images
#   ./scripts/deploy.sh --images-only  # ONLY sync images (skip code/build)
#
# Requirements:
#   - Node 18+ and npm in PATH
#   - python3-pexpect installed locally (sudo apt install python3-pexpect)
#   - SSH password exported as DPE_SSH_PASS or entered interactively
#
# Read DEPLOYMENT.md first.

set -euo pipefail

# ---------------------------------------------------------------------------
# Config (override via env vars if your server credentials change)
# ---------------------------------------------------------------------------
SSH_HOST="${DPE_SSH_HOST:-82.25.102.203}"
SSH_PORT="${DPE_SSH_PORT:-65002}"
SSH_USER="${DPE_SSH_USER:-u188133440}"
REMOTE_HOME="/home/${SSH_USER}"
APP_DIR="${REMOTE_HOME}/laravel-drugpharma"
WEBROOT="${REMOTE_HOME}/domains/drugpharmaeg.com/public_html"

# ---------------------------------------------------------------------------
# Paths
# ---------------------------------------------------------------------------
ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
STAGE="$(mktemp -d)"
trap 'rm -rf "$STAGE"' EXIT

# ---------------------------------------------------------------------------
# Flags
# ---------------------------------------------------------------------------
DO_CODE=1
DO_IMAGES=0
for arg in "$@"; do
  case "$arg" in
    --images)       DO_IMAGES=1 ;;
    --images-only)  DO_CODE=0; DO_IMAGES=1 ;;
    -h|--help)
      sed -n '2,18p' "$0"
      exit 0
      ;;
    *) echo "unknown flag: $arg" >&2; exit 2 ;;
  esac
done

# ---------------------------------------------------------------------------
# Get the SSH password
# ---------------------------------------------------------------------------
if [[ -z "${DPE_SSH_PASS:-}" ]]; then
  read -r -s -p "SSH password for ${SSH_USER}@${SSH_HOST}: " DPE_SSH_PASS
  echo
fi
export DPE_SSH_PASS

# ---------------------------------------------------------------------------
# Helpers — use python pexpect for password-driven scp/ssh
# ---------------------------------------------------------------------------
ssh_run() {
  local script="$1"
  python3 - <<PYEOF
import os, pexpect, sys
host="${SSH_HOST}"; user="${SSH_USER}"; port="${SSH_PORT}"
script = """${script//"/\\"}"""
cmd = f"ssh -p {port} -o StrictHostKeyChecking=accept-new -o UserKnownHostsFile=/tmp/dpe_known_hosts {user}@{host} 'bash -s'"
p = pexpect.spawn("/bin/bash", ["-c", cmd], timeout=900, encoding="utf-8")
i = p.expect(["password:", "Password:", pexpect.EOF, pexpect.TIMEOUT])
if i in (0, 1):
    p.sendline(os.environ["DPE_SSH_PASS"])
p.sendline(script)
p.sendline("exit")
p.expect(pexpect.EOF, timeout=900)
print(p.before)
PYEOF
}

scp_send() {
  local src="$1" dst="$2"
  python3 - <<PYEOF
import os, pexpect
host="${SSH_HOST}"; user="${SSH_USER}"; port="${SSH_PORT}"
src="${src}"; dst="${dst}"
cmd = f"scp -P {port} -o StrictHostKeyChecking=accept-new -o UserKnownHostsFile=/tmp/dpe_known_hosts '{src}' {user}@{host}:{dst}"
p = pexpect.spawn("/bin/bash", ["-c", cmd], timeout=900, encoding="utf-8")
i = p.expect(["password:", "Password:", pexpect.EOF, pexpect.TIMEOUT])
if i in (0, 1):
    p.sendline(os.environ["DPE_SSH_PASS"])
p.expect(pexpect.EOF, timeout=900)
PYEOF
}

# ---------------------------------------------------------------------------
# 1) Build & package
# ---------------------------------------------------------------------------
if [[ "$DO_CODE" == "1" ]]; then
  echo "▸ Building frontend (production)..."
  (cd "$ROOT/frontend" && VITE_API_BASE="" npm run build)

  echo "▸ Packaging backend..."
  tar -czf "$STAGE/backend-update.tar.gz" \
    -C "$ROOT" \
    backend/app \
    backend/config \
    backend/database/migrations \
    backend/database/seeders \
    backend/lang \
    backend/resources/views \
    backend/routes \
    backend/composer.json \
    backend/composer.lock

  echo "▸ Packaging frontend dist..."
  tar -czf "$STAGE/frontend-dist.tar.gz" -C "$ROOT/frontend" dist

  echo "▸ Uploading code..."
  scp_send "$STAGE/backend-update.tar.gz"  "$REMOTE_HOME/backend-update.tar.gz"
  scp_send "$STAGE/frontend-dist.tar.gz"   "$REMOTE_HOME/frontend-dist.tar.gz"

  echo "▸ Installing on server..."
  ssh_run "$(cat <<'REMOTE'
set -e
cd ~

# Extract backend code on top of the existing install (preserves .env, vendor/, storage/)
tar -xzf backend-update.tar.gz -C laravel-drugpharma --strip-components=1
rm backend-update.tar.gz

cd laravel-drugpharma

# Composer in case composer.json/lock changed
if ! command -v composer >/dev/null; then echo "composer missing" >&2; exit 1; fi
composer install --no-dev --optimize-autoloader --no-interaction --no-progress 2>&1 | tail -5 || true

# DB migrations (additive; never destroys data)
php artisan migrate --force 2>&1 | tail -10

# Rebuild caches
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Frontend: wipe old hashed assets then drop new dist on top of public_html
cd ~
rm -rf domains/drugpharmaeg.com/public_html/assets
tar -xzf frontend-dist.tar.gz
cp -a dist/. domains/drugpharmaeg.com/public_html/
rm -rf dist frontend-dist.tar.gz

echo "=== smoke ==="
curl -s -o /dev/null -w "api: %{http_code}\n" https://drugpharmaeg.com/api/v1/categories
curl -s -o /dev/null -w "home: %{http_code}\n" https://drugpharmaeg.com/
echo "deploy done."
REMOTE
)"
fi

# ---------------------------------------------------------------------------
# 2) Images
# ---------------------------------------------------------------------------
if [[ "$DO_IMAGES" == "1" ]]; then
  echo "▸ Converting local images to WebP..."
  if ! command -v convert >/dev/null; then
    echo "ImageMagick (convert) not found — install with: sudo apt install imagemagick"
    exit 1
  fi
  (
    cd "$ROOT/backend/public/images/products"
    for f in *.png *.jpg *.jpeg; do
      [ -f "$f" ] || continue
      name="${f%.*}"
      [ -f "${name}.webp" ] && continue
      convert "$f" -resize '1200x1200>' -strip -quality 85 "${name}.webp"
    done
  )

  echo "▸ Packaging WebP images..."
  tar -czf "$STAGE/webp-images.tar.gz" \
    -C "$ROOT/backend/public/images" products

  echo "▸ Uploading images..."
  scp_send "$STAGE/webp-images.tar.gz" "$REMOTE_HOME/webp-images.tar.gz"

  echo "▸ Installing images on server..."
  ssh_run "$(cat <<'REMOTE'
set -e
cd ~
mkdir -p domains/drugpharmaeg.com/public_html/images
tar -xzf webp-images.tar.gz -C laravel-drugpharma/public/images/
cp -a laravel-drugpharma/public/images/products/. domains/drugpharmaeg.com/public_html/images/products/
# Touch to invalidate Hostinger HCDN cache
touch domains/drugpharmaeg.com/public_html/images/products/*.webp
rm webp-images.tar.gz
echo "images updated."
REMOTE
)"
fi

echo
echo "✓ Deploy finished."
echo "  Live:    https://drugpharmaeg.com/"
echo "  Admin:   https://drugpharmaeg.com/admin/login"
