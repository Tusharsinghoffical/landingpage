#!/bin/bash

# Deployment Script for Reliable Packers & Movers Website
# This script helps automate the deployment process on Linux servers

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if running as root
if [ "$EUID" -eq 0 ]; then
    print_warning "Running as root. This is not recommended for deployment."
fi

# Check prerequisites
print_status "Checking prerequisites..."

# Check if required commands exist
command -v php >/dev/null 2>&1 || { print_error "PHP is not installed. Please install PHP 7.4 or higher."; exit 1; }
command -v mysql >/dev/null 2>&1 || { print_error "MySQL client is not installed. Please install MySQL client."; exit 1; }
command -v rsync >/dev/null 2>&1 || { print_error "rsync is not installed. Please install rsync."; exit 1; }

print_success "All prerequisites are met."

# Get deployment parameters
echo
print_status "Deployment Configuration"
echo "========================"
read -p "Enter deployment directory (default: /var/www/html/packers): " DEPLOY_DIR
DEPLOY_DIR=${DEPLOY_DIR:-/var/www/html/packers}

read -p "Enter database name (default: packers_movers): " DB_NAME
DB_NAME=${DB_NAME:-packers_movers}

read -p "Enter database username: " DB_USER
read -s -p "Enter database password: " DB_PASS
echo

read -p "Enter database host (default: localhost): " DB_HOST
DB_HOST=${DB_HOST:-localhost}

# Create deployment directory
print_status "Creating deployment directory..."
sudo mkdir -p "$DEPLOY_DIR" || { print_error "Failed to create deployment directory."; exit 1; }

# Copy files
print_status "Copying files to deployment directory..."
sudo rsync -av --exclude='deploy.sh' --exclude='deploy.php' --exclude='DEPLOYMENT.md' . "$DEPLOY_DIR/" || { print_error "Failed to copy files."; exit 1; }

# Set permissions
print_status "Setting file permissions..."
sudo chown -R www-data:www-data "$DEPLOY_DIR" || { print_warning "Failed to set ownership. You may need to do this manually."; }
sudo find "$DEPLOY_DIR" -type f -exec chmod 644 {} \;
sudo find "$DEPLOY_DIR" -type d -exec chmod 755 {} \;
sudo chmod 755 "$DEPLOY_DIR/assets/images/"

# Update database configuration
print_status "Updating database configuration..."
DB_CONFIG_FILE="$DEPLOY_DIR/includes/db_config.php"
if [ -f "$DB_CONFIG_FILE" ]; then
    sudo sed -i "s/\$servername = \"[^\"]*\";/\$servername = \"$DB_HOST\";/" "$DB_CONFIG_FILE"
    sudo sed -i "s/\$username = \"[^\"]*\";/\$username = \"$DB_USER\";/" "$DB_CONFIG_FILE"
    sudo sed -i "s/\$password = \"[^\"]*\";/\$password = \"$DB_PASS\";/" "$DB_CONFIG_FILE"
    sudo sed -i "s/\$dbname = \"[^\"]*\";/\$dbname = \"$DB_NAME\";/" "$DB_CONFIG_FILE"
    print_success "Database configuration updated."
else
    print_error "Database configuration file not found."
fi

# Import database schema
print_status "Importing database schema..."
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;" || { print_error "Failed to create database."; }
mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$DEPLOY_DIR/database_schema.sql" || { print_error "Failed to import database schema."; }

print_success "Database setup completed."

# Test deployment
print_status "Testing deployment..."
PHP_VERSION=$(php -r "echo PHP_VERSION;")
print_success "PHP Version: $PHP_VERSION"

# Final instructions
echo
print_success "Deployment completed successfully!"
echo
print_status "Next steps:"
echo "1. Configure your web server (Apache/Nginx) to serve files from $DEPLOY_DIR"
echo "2. Update your domain's DNS settings if needed"
echo "3. Test the website by visiting your domain"
echo "4. Change the default admin password in admin.php"
echo "5. Update contact information throughout the site"
echo "6. Configure SSL certificate for HTTPS"
echo
print_status "Default admin credentials:"
echo "Username: admin"
echo "Password: packers123"
echo
print_warning "Remember to change the default admin password for security!"