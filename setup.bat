@echo off
echo ========================================
echo    Task Management System Setup
echo ========================================
echo.

echo [1/7] Creating required directories...
mkdir storage\framework\sessions 2>nul
mkdir storage\framework\views 2>nul
mkdir storage\framework\cache 2>nul
mkdir storage\logs 2>nul
mkdir bootstrap\cache 2>nul
echo Directories created successfully.

echo.
echo [2/7] Installing Composer dependencies...
call composer install
if %errorlevel% neq 0 (
    echo Error: Composer install failed
    pause
    exit /b 1
)

echo.
echo [3/7] Installing NPM dependencies...
call npm install
if %errorlevel% neq 0 (
    echo Error: NPM install failed
    pause
    exit /b 1
)

echo.
echo [4/7] Generating application key...
call php artisan key:generate
if %errorlevel% neq 0 (
    echo Error: Key generation failed
    pause
    exit /b 1
)

echo.
echo [5/7] Running database migrations...
call php artisan migrate
if %errorlevel% neq 0 (
    echo Error: Migration failed
    pause
    exit /b 1
)

echo.
echo [6/7] Seeding database with sample data...
call php artisan db:seed
if %errorlevel% neq 0 (
    echo Error: Database seeding failed
    pause
    exit /b 1
)

echo.
echo [7/7] Building assets...
call npm run build
if %errorlevel% neq 0 (
    echo Error: Asset build failed
    pause
    exit /b 1
)

echo.
echo ========================================
echo        Setup Complete!
echo ========================================
echo.
echo Demo Credentials:
echo - admin@example.com / password
echo - john@example.com / password
echo - jane@example.com / password
echo.
echo To start the server, run:
echo php artisan serve
echo.
echo Then visit: http://localhost:8000
echo.
echo Implementation Highlights:
echo 🔐 PHP Session: Login/logout, session protection
echo 🗄️ DB Helper: Task CRUD with DB::table()
echo 📊 ORM Eloquent: User management with models
echo.
pause
