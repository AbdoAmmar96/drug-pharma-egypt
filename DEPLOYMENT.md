# Drug Pharma Egypt — Deployment Guide

Production deployment guide for **https://drugpharmaeg.com** on Hostinger shared hosting.

---

## 1. Server overview

| Item | Value |
|------|-------|
| Host | Hostinger Shared (hPanel) |
| SSH | `ssh -p 65002 u188133440@82.25.102.203` |
| Domain | `drugpharmaeg.com` |
| Webroot | `~/domains/drugpharmaeg.com/public_html/` |
| Laravel app | `~/laravel-drugpharma/` |
| PHP | 8.3 (with composer pre-installed) |
| Node.js on server | ❌ **not installed** — frontend must be built locally |
| Database | SQLite (`~/laravel-drugpharma/database/database.sqlite`) |
| Backups | `~/_backups_claude/` |

### Architecture

```
public_html/
├── index.html              # React SPA entry
├── assets/                 # Vite-built JS/CSS bundles
├── images/products/        # WebP + PNG product images
├── logo-*.png/jpeg         # Header & footer logos
├── laravel.php             # Laravel front controller (renamed from index.php)
├── storage -> /home/.../laravel-drugpharma/storage/app/public  (symlink)
└── .htaccess               # Routes /api, /admin, /livewire, ... to Laravel; everything else → SPA

laravel-drugpharma/
├── app/  bootstrap/  config/  routes/  resources/  database/  vendor/
└── .env                    # Production env (NEVER commit)
```

---

## 2. One-time setup (already done — for reference)

These steps only run when bootstrapping a fresh server.

```bash
# 1) Upload backend + clone into ~/laravel-drugpharma
# 2) composer install --no-dev --optimize-autoloader
# 3) php artisan key:generate && php artisan migrate --seed --force
# 4) chmod -R ug+rwX storage bootstrap/cache database
# 5) Copy backend/public/* into public_html (rename index.php → laravel.php)
# 6) Copy frontend dist/* into public_html
# 7) Install custom .htaccess (see scripts/htaccess.conf)
```

The `laravel.php` front controller is patched to point at `/home/u188133440/laravel-drugpharma` (because `public_html` is no longer a symlink to `backend/public`).

---

## 3. Routine deploy

### Prerequisites (local machine)

- Node 18+, npm
- `python3-pexpect` (for the deploy script's SSH password handling) — `sudo apt install python3-pexpect`
- The SSH password (set on the server)

### Two deploy modes

| Mode | Script | What it ships | When to use |
|------|--------|---------------|-------------|
| **Source** | `./scripts/deploy.sh` | Code only (~500 KB) — server runs `composer install` | Quick one-off code tweaks, server has fast composer cache |
| **Bundled** | `./scripts/deploy-bundled.sh` | Code **+ vendor** + dist in one tarball (~30 MB) | Default. Faster server-side, deterministic, works if composer hiccups |

#### Source mode

```bash
./scripts/deploy.sh                # backend + frontend
./scripts/deploy.sh --images       # also resync WebP images
```

The script does:
1. Builds the frontend with `VITE_API_BASE=""` (same-origin in prod)
2. Tars `backend/{app,config,database/migrations,database/seeders,lang,resources/views,routes}` + `frontend/dist`
3. SCPs both archives to the server
4. SSH-runs the remote deploy: extracts, `composer install --no-dev`, `migrate --force`, rebuilds caches, syncs files to `public_html`

#### Bundled mode (recommended)

```bash
./scripts/deploy-bundled.sh                  # full deploy
./scripts/deploy-bundled.sh --skip-frontend  # reuse existing frontend/dist
./scripts/deploy-bundled.sh --images         # also rebuild WebP images
```

What's in the bundle (`dpe-bundle.tar.gz`):
```
pkg/
├── laravel/       app, config, database, vendor/, routes, ... (no .env, no sqlite)
├── public/        index.html + assets/ + images/products/*.webp + favicon
└── meta.json      { built_at_unix, lock_hash, git_sha }
```

Why it's faster on the server: skips `composer install` (no 200 MB download from packagist; just untar). The script atomically swaps the old app dir into `laravel-drugpharma.old`, drops the new one, runs migrations, then deletes the old. `.env`, `storage/`, and `database.sqlite` are preserved across deploys.

**Vendor caching:** the script hashes `backend/composer.lock`. If the hash hasn't changed since the last run, it reuses `.deploy-cache/vendor-<hash>.tar` instead of re-installing — repeat deploys take seconds.

---

## 4. Mail configuration (SMTP)

Contact-form submissions are routed through `App\Mail\ContactMessageReceived` and delivered to whatever address is set in `MAIL_CONTACT_TO`.

### Required `.env` keys on the server

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=465                                  # 465 = SSL, 587 = TLS
MAIL_USERNAME=noreply@drugpharmaeg.com
MAIL_PASSWORD=__SET_FROM_HOSTINGER_HPANEL__
MAIL_ENCRYPTION=ssl                            # use 'tls' if you picked port 587
MAIL_FROM_ADDRESS="noreply@drugpharmaeg.com"
MAIL_FROM_NAME="Drug Pharma Egypt"
MAIL_CONTACT_TO=hr@drugpharmaeg.com
```

### Create the sending mailbox in hPanel

1. hPanel → **Emails** → **Email Accounts** → **Create**
2. Pick e.g. `noreply@drugpharmaeg.com`
3. Set a strong password
4. SSH into the server and update `.env`:

```bash
ssh -p 65002 u188133440@82.25.102.203
cd ~/laravel-drugpharma
nano .env             # paste the MAIL_* block above with the real password
php artisan config:clear
php artisan config:cache
```

### Verify

```bash
# On the server
php artisan tinker --execute='
  Mail::raw("SMTP works", function($m) {
    $m->to("hr@drugpharmaeg.com")->subject("test from drugpharmaeg.com");
  });
  echo "sent\n";
'
```

Or submit the contact form on https://drugpharmaeg.com/contact and check `hr@drugpharmaeg.com`. If it fails, tail the log:

```bash
tail -100 ~/laravel-drugpharma/storage/logs/laravel.log
```

### Anti-spam choices (already wired in the Mailable)

| Header | Reason |
|--------|--------|
| `Reply-To` set to the visitor's email | Hitting **Reply** in your inbox replies to the customer, not yourself |
| `Auto-Submitted: auto-generated` | Tells receiving servers it's automated; suppresses vacation replies |
| `X-Auto-Response-Suppress: All` | Same intent, Outlook-specific |
| `Precedence: bulk` | Lower priority but won't trigger user spam filters |
| `List-Unsubscribe` | Required by Gmail/Yahoo bulk policy |
| `Message-Id: contact-{id}@drugpharmaeg.com` | Stable, domain-aligned ID |
| Sender = `noreply@drugpharmaeg.com` (same domain) | Passes SPF automatically |
| HTML + text alternative | Gmail flags HTML-only as suspicious |

If you also want DKIM (recommended), enable it in hPanel → Emails → Email Accounts → **Email Configuration** → toggle DKIM for `drugpharmaeg.com`. SPF should already be in your DNS by default on Hostinger.

---

## 5. Manual deploy (fallback if the script breaks)

```bash
# === LOCAL ===
cd "/path/to/drug-pharma-app"

# Build frontend
cd frontend && VITE_API_BASE="" npm run build && cd ..

# Tar what we need
tar -czf /tmp/backend-update.tar.gz \
  backend/app backend/config backend/database/migrations \
  backend/database/seeders backend/lang \
  backend/resources/views backend/routes
tar -czf /tmp/frontend-dist.tar.gz -C frontend dist

# Upload
scp -P 65002 /tmp/backend-update.tar.gz /tmp/frontend-dist.tar.gz \
  u188133440@82.25.102.203:~/

# === SERVER ===
ssh -p 65002 u188133440@82.25.102.203
cd ~

# Backend
tar -xzf backend-update.tar.gz -C laravel-drugpharma --strip-components=1
cd laravel-drugpharma
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache

# Frontend
cd ~
rm -rf domains/drugpharmaeg.com/public_html/assets
tar -xzf frontend-dist.tar.gz
cp -a dist/. domains/drugpharmaeg.com/public_html/
rm -rf dist *.tar.gz
```

---

## 6. Smoke tests after every deploy

```bash
curl -s -o /dev/null -w "home: %{http_code}\n"       https://drugpharmaeg.com/
curl -s -o /dev/null -w "api:  %{http_code}\n"       https://drugpharmaeg.com/api/v1/categories
curl -s -o /dev/null -w "admin:%{http_code}\n"       https://drugpharmaeg.com/admin/login
curl -s -o /dev/null -w "img:  %{http_code} %{content_type}\n" \
  https://drugpharmaeg.com/images/products/three-cool.webp
```

Expected: `200 / 200 / 200 / 200 image/webp`.

If `image/webp` returns `text/html` instead, Hostinger CDN cached a 404 before the image existed — bump the file's mtime to invalidate:

```bash
ssh -p 65002 u188133440@82.25.102.203 \
  'touch ~/domains/drugpharmaeg.com/public_html/images/products/*.webp'
```

---

## 7. Common operations

### Reset the admin password

```bash
ssh -p 65002 u188133440@82.25.102.203
cd ~/laravel-drugpharma
php artisan tinker --execute='
  $u = \App\Models\User::where("email","admin@drugpharma-eg.com")->first();
  $u->password = bcrypt("YOUR_NEW_PASSWORD");
  $u->save();
  echo "ok\n";
'
```

### Re-seed the catalog (⚠ destroys all user data: products, categories, messages)

```bash
cd ~/laravel-drugpharma
php artisan migrate:fresh --seed --force
```

### Inspect contact messages without leaving the shell

```bash
php artisan tinker --execute='
  foreach (\App\Models\ContactMessage::latest()->take(10)->get() as $m) {
    echo $m->id." | ".$m->topic." | ".$m->email." | ".$m->message."\n---\n";
  }
'
```

### Convert newly-added images to WebP (server-side)

```bash
cd ~/laravel-drugpharma/public/images/products
for f in *.png *.jpg; do
  [ -f "$f" ] || continue
  name="${f%.*}"
  [ -f "${name}.webp" ] && continue
  convert "$f" -resize '1200x1200>' -strip -quality 85 "${name}.webp"
done
cp -f *.webp ~/domains/drugpharmaeg.com/public_html/images/products/
```

### Rollback to a previous backup

```bash
ls -lh ~/_backups_claude/                    # pick a tarball
cd ~
mv laravel-drugpharma laravel-drugpharma.broken
tar -xzf _backups_claude/laravel-drugpharma-YYYYMMDD-HHMMSS.tar.gz
```

---

## 8. Things NOT to commit to git

These are in `.gitignore` and must stay there:

- `backend/.env` (contains `APP_KEY`, DB creds, mail password)
- `backend/vendor/`, `backend/node_modules/`, `frontend/node_modules/`
- `backend/database/database.sqlite` (production data lives on the server)
- `frontend/dist/` (built artifact, regenerate per deploy)
- Local IDE config, `*.pptx`, `*.ai`

---

## 9. Production credentials (current)

| Service | Value |
|---------|-------|
| Admin panel | https://drugpharmaeg.com/admin/login |
| Admin email | `admin@drugpharma-eg.com` |
| Admin password | _set on the server; rotate via the snippet in §7_ |
| Contact recipient | `hr@drugpharmaeg.com` |
| Site sender | `noreply@drugpharmaeg.com` _(after SMTP setup)_ |

⚠ **Never paste the SSH password, admin password, or SMTP password into commits or chat. Update them via hPanel and propagate to `.env` over SSH.**
