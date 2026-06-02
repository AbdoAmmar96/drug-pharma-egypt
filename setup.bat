@echo off
REM ================================================================
REM Drug Pharma Egypt - Windows setup script
REM Requires PHP 8.2+, Composer, and Node 18+ in PATH
REM (Laravel Herd installs everything you need)
REM ================================================================

echo.
echo ========================================
echo   Drug Pharma Egypt - Setup
echo ========================================
echo.

REM ---- Check requirements ----
where php >nul 2>nul
if errorlevel 1 (
    echo [ERROR] PHP is not in PATH. Install Laravel Herd or PHP 8.2+
    pause
    exit /b 1
)
where composer >nul 2>nul
if errorlevel 1 (
    echo [ERROR] Composer is not in PATH.
    pause
    exit /b 1
)
where node >nul 2>nul
if errorlevel 1 (
    echo [ERROR] Node.js is not in PATH. Install Node 18+
    pause
    exit /b 1
)

echo [1/6] Installing backend dependencies (Laravel + Filament)...
echo       This will take a few minutes the first time.
cd backend
call composer install --no-interaction --prefer-dist
if errorlevel 1 goto :error

echo.
echo [2/6] Generating application key...
if not exist .env copy .env.example .env >nul
call php artisan key:generate --force
if errorlevel 1 goto :error

echo.
echo [3/6] Running database migrations and seeding (31 products, 5 categories)...
if not exist database\database.sqlite type nul > database\database.sqlite
call php artisan migrate:fresh --seed --force
if errorlevel 1 goto :error

echo.
echo [4/6] Linking storage for Filament-uploaded images...
call php artisan storage:link
if errorlevel 1 goto :error

echo.
echo [5/6] Installing frontend dependencies (React + Vite)...
cd ..\frontend
if not exist .env copy .env.example .env >nul
call npm install
if errorlevel 1 goto :error

echo.
echo [6/6] All done!
cd ..

echo.
echo ============================================================
echo   Setup complete! Now run two terminals:
echo.
echo   Terminal 1 (backend):
echo     cd backend
echo     php artisan serve
echo.
echo   Terminal 2 (frontend):
echo     cd frontend
echo     npm run dev
echo.
echo   Then open:
echo     - Frontend:  http://localhost:5173
echo     - Admin:     http://localhost:8000/admin
echo     - Login:     admin@drugpharmaeg.com / password
echo ============================================================
echo.
pause
exit /b 0

:error
echo.
echo [ERROR] Setup failed at step above. See messages.
cd /d "%~dp0"
pause
exit /b 1
