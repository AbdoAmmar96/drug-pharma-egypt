#!/usr/bin/env bash
# ================================================================
# Drug Pharma Egypt — Linux/Mac setup script
# Requires PHP 8.2+, Composer, and Node 18+
# ================================================================

set -e

echo
echo "========================================"
echo "  Drug Pharma Egypt — Setup"
echo "========================================"
echo

# ---- Check requirements ----
command -v php >/dev/null 2>&1 || { echo "[ERROR] PHP not found. Install PHP 8.2+"; exit 1; }
command -v composer >/dev/null 2>&1 || { echo "[ERROR] Composer not found"; exit 1; }
command -v node >/dev/null 2>&1 || { echo "[ERROR] Node.js not found. Install Node 18+"; exit 1; }

echo "[1/6] Installing backend dependencies (Laravel + Filament)..."
echo "      This will take a few minutes the first time."
cd backend
composer install --no-interaction --prefer-dist

echo
echo "[2/6] Generating application key..."
[ -f .env ] || cp .env.example .env
php artisan key:generate --force

echo
echo "[3/6] Running database migrations and seeding (31 products, 5 categories)..."
[ -f database/database.sqlite ] || touch database/database.sqlite
php artisan migrate:fresh --seed --force

echo
echo "[4/6] Linking storage for Filament-uploaded images..."
php artisan storage:link

echo
echo "[5/6] Installing frontend dependencies (React + Vite)..."
cd ../frontend
[ -f .env ] || cp .env.example .env
npm install

echo
echo "[6/6] All done!"
cd ..

cat <<'EOF'

============================================================
  Setup complete! Now run two terminals:

  Terminal 1 (backend):
    cd backend
    php artisan serve

  Terminal 2 (frontend):
    cd frontend
    npm run dev

  Then open:
    - Frontend:  http://localhost:5173
    - Admin:     http://localhost:8000/admin
    - Login:     admin@drugpharmaeg.com / password
============================================================
EOF
