@echo off
echo ========================================
echo    PretConnect Financial - Setup
echo ========================================
echo.

echo [1/7] Verification des prerequis...
php --version >nul 2>&1
if errorlevel 1 (
    echo ERREUR: PHP n'est pas installe ou pas dans le PATH
    echo Veuillez installer PHP 8.1+ et l'ajouter au PATH
    pause
    exit /b 1
)

composer --version >nul 2>&1
if errorlevel 1 (
    echo ERREUR: Composer n'est pas installe
    echo Veuillez installer Composer depuis https://getcomposer.org/
    pause
    exit /b 1
)

node --version >nul 2>&1
if errorlevel 1 (
    echo ERREUR: Node.js n'est pas installe
    echo Veuillez installer Node.js 18+ depuis https://nodejs.org/
    pause
    exit /b 1
)

echo ✓ PHP, Composer et Node.js detectes
echo.

echo [2/7] Installation des dependances PHP...
composer install --no-dev --optimize-autoloader
if errorlevel 1 (
    echo ERREUR: Echec de l'installation des dependances PHP
    pause
    exit /b 1
)
echo ✓ Dependances PHP installees
echo.

echo [3/7] Installation des dependances JavaScript...
npm install
if errorlevel 1 (
    echo ERREUR: Echec de l'installation des dependances JavaScript
    pause
    exit /b 1
)
echo ✓ Dependances JavaScript installees
echo.

echo [4/7] Configuration de l'environnement...
if not exist .env (
    copy .env.example .env
    echo ✓ Fichier .env cree
) else (
    echo ✓ Fichier .env existe deja
)

php artisan key:generate --force
echo ✓ Cle d'application generee
echo.

echo [5/7] Configuration de la base de donnees...
echo.
echo ATTENTION: Assurez-vous que MySQL est demarre !
echo.
set /p db_name="Nom de la base de donnees (pretconnect_financial): "
if "%db_name%"=="" set db_name=pretconnect_financial

set /p db_user="Utilisateur MySQL (root): "
if "%db_user%"=="" set db_user=root

set /p db_pass="Mot de passe MySQL: "

echo Création de la base de données...
mysql -u %db_user% -p%db_pass% -e "CREATE DATABASE IF NOT EXISTS %db_name% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if errorlevel 1 (
    echo ERREUR: Impossible de creer la base de donnees
    echo Verifiez vos identifiants MySQL
    pause
    exit /b 1
)
echo ✓ Base de donnees creee
echo.

echo [6/7] Migration et seeding...
php artisan migrate --force
if errorlevel 1 (
    echo ERREUR: Echec des migrations
    pause
    exit /b 1
)

php artisan db:seed --force
if errorlevel 1 (
    echo ERREUR: Echec du seeding
    pause
    exit /b 1
)
echo ✓ Base de donnees initialisee
echo.

echo [7/7] Compilation des assets...
npm run build
if errorlevel 1 (
    echo ERREUR: Echec de la compilation des assets
    pause
    exit /b 1
)
echo ✓ Assets compiles
echo.

echo ========================================
echo    Installation terminee avec succes !
echo ========================================
echo.
echo Comptes de test :
echo.
echo ADMINISTRATEUR:
echo Email: admin@pretconnect.financial
echo Mot de passe: admin123
echo.
echo UTILISATEUR:
echo Email: user@example.com
echo Mot de passe: password
echo.
echo Pour demarrer l'application :
echo 1. php artisan serve
echo 2. Ouvrir http://localhost:8000
echo.
echo Pour le developpement (nouveau terminal) :
echo npm run dev
echo.
pause