@echo off
title Reliable Packers & Movers - Deployment Script

echo ======================================================
echo  Reliable Packers & Movers - Deployment Script
echo ======================================================
echo.

echo Checking prerequisites...
where php >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: PHP is not installed or not in PATH.
    echo Please install PHP 7.4 or higher and add it to your PATH.
    pause
    exit /b 1
)

where mysql >nul 2>&1
if %errorlevel% neq 0 (
    echo ERROR: MySQL client is not installed or not in PATH.
    echo Please install MySQL and add it to your PATH.
    pause
    exit /b 1
)

echo Prerequisites check passed.
echo.

echo Deployment Configuration
echo ========================
set /p DEPLOY_DIR="Enter deployment directory (default: C:\inetpub\wwwroot\packers): "
if "%DEPLOY_DIR%"=="" set DEPLOY_DIR=C:\inetpub\wwwroot\packers

set /p DB_NAME="Enter database name (default: packers_movers): "
if "%DB_NAME%"=="" set DB_NAME=packers_movers

set /p DB_USER="Enter database username: "
set /p DB_PASS="Enter database password: "
set /p DB_HOST="Enter database host (default: localhost): "
if "%DB_HOST%"=="" set DB_HOST=localhost

echo.
echo Creating deployment directory...
if not exist "%DEPLOY_DIR%" mkdir "%DEPLOY_DIR%"
if %errorlevel% neq 0 (
    echo ERROR: Failed to create deployment directory.
    pause
    exit /b 1
)

echo Copying files to deployment directory...
xcopy "." "%DEPLOY_DIR%" /E /I /H /Y /EXCLUDE:deploy.exclude
if %errorlevel% neq 0 (
    echo ERROR: Failed to copy files.
    pause
    exit /b 1
)

echo Setting file permissions...
echo Note: On Windows, you may need to set permissions manually through File Explorer.
echo Right-click on the deployment folder ^> Properties ^> Security ^> Edit
echo Add IUSR and IIS_IUSRS with Read & execute permissions.

echo.
echo Updating database configuration...
powershell -Command "(Get-Content '%DEPLOY_DIR%\includes\db_config.php') -replace '\$servername = \"[^\"]*\";', ('\$servername = \"' + '%DB_HOST%' + '\";') | Set-Content '%DEPLOY_DIR%\includes\db_config.php'"
powershell -Command "(Get-Content '%DEPLOY_DIR%\includes\db_config.php') -replace '\$username = \"[^\"]*\";', ('\$username = \"' + '%DB_USER%' + '\";') | Set-Content '%DEPLOY_DIR%\includes\db_config.php'"
powershell -Command "(Get-Content '%DEPLOY_DIR%\includes\db_config.php') -replace '\$password = \"[^\"]*\";', ('\$password = \"' + '%DB_PASS%' + '\";') | Set-Content '%DEPLOY_DIR%\includes\db_config.php'"
powershell -Command "(Get-Content '%DEPLOY_DIR%\includes\db_config.php') -replace '\$dbname = \"[^\"]*\";', ('\$dbname = \"' + '%DB_NAME%' + '\";') | Set-Content '%DEPLOY_DIR%\includes\db_config.php'"

echo.
echo Importing database schema...
mysql -h %DB_HOST% -u %DB_USER% -p%DB_PASS% -e "CREATE DATABASE IF NOT EXISTS %DB_NAME%;"
mysql -h %DB_HOST% -u %DB_USER% -p%DB_PASS% %DB_NAME% < "%DEPLOY_DIR%\database_schema.sql"

echo.
echo Testing PHP version...
php -r "echo 'PHP Version: ' . PHP_VERSION . PHP_EOL;"

echo.
echo Deployment completed successfully!
echo.
echo Next steps:
echo 1. Configure your web server (IIS/Apache/Nginx) to serve files from %DEPLOY_DIR%
echo 2. Update your domain's DNS settings if needed
echo 3. Test the website by visiting your domain
echo 4. Change the default admin password in admin.php
echo 5. Update contact information throughout the site
echo 6. Configure SSL certificate for HTTPS
echo.
echo Default admin credentials:
echo Username: admin
echo Password: packers123
echo.
echo Remember to change the default admin password for security!
pause