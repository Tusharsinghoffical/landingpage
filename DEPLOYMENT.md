# Deployment Guide for Reliable Packers & Movers Website

## Prerequisites
- Web server with PHP 7.4+ support (Apache/Nginx)
- MySQL 5.7+ database
- PHP extensions: mysqli, pdo, json, gd (for image processing)

## Deployment Steps

### 1. Upload Files
Upload all files from this directory to your web server's document root:
- All PHP files (index.php, about.php, services.php, etc.)
- The `includes/` directory and its contents
- The `assets/` directory and its contents

### 2. Database Setup
1. Create a new MySQL database (e.g., `packers_movers`)
2. Import the database schema:
   ```sql
   mysql -u [username] -p [database_name] < database_schema.sql
   ```
3. Update database credentials in `includes/db_config.php`:
   ```php
   $servername = "localhost";
   $username = "your_database_username";
   $password = "your_database_password";
   $dbname = "packers_movers";
   ```

### 3. Configure Permissions
Set appropriate permissions:
- Make sure PHP can read all files (644)
- Make sure directories are executable (755)
- If using file uploads, ensure `assets/images/` is writable (755)

### 4. Update Configuration Files
1. In `includes/db_config.php`, update the database connection details
2. Update the WhatsApp number in `includes/footer.php` and other files as needed
3. Update contact information throughout the site

### 5. Test the Deployment
1. Visit your domain to ensure the homepage loads
2. Test all navigation links
3. Test the inquiry form submission
4. Verify the admin panel works (admin.php)
5. Check that all images load correctly

## Server Configuration

### Apache (.htaccess)
The included .htaccess file provides:
- URL rewriting for cleaner URLs
- Security enhancements
- Performance optimizations

### Nginx Configuration
If using Nginx, add these rules to your server block:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}
```

## Environment Variables
Set these environment variables if needed:
- DB_HOST=localhost
- DB_USER=your_database_username
- DB_PASS=your_database_password
- DB_NAME=packers_movers

## Troubleshooting

### Common Issues
1. **Database Connection Failed**: Check credentials in `includes/db_config.php`
2. **404 Errors**: Ensure mod_rewrite is enabled for Apache
3. **Permission Denied**: Check file permissions (644 for files, 755 for directories)
4. **Images Not Loading**: Verify `assets/images/` directory permissions

### Error Logs
Check your web server's error logs for:
- PHP errors: `/var/log/apache2/error.log` or `/var/log/nginx/error.log`
- Database errors in the application's error messages

## Security Recommendations
1. Change the default admin password in `admin.php`
2. Use HTTPS for all connections
3. Regularly update PHP and MySQL versions
4. Implement proper input validation and sanitization
5. Use prepared statements for all database queries

## Performance Optimization
1. Enable Gzip compression on your web server
2. Use a CDN for static assets
3. Optimize images in the `assets/images/` directory
4. Enable browser caching through .htaccess

## Backup Procedures
1. Regularly backup the MySQL database:
   ```bash
   mysqldump -u [username] -p [database_name] > backup_$(date +%F).sql
   ```
2. Backup all website files to a secure location
3. Test restoration procedures periodically

## Support
For deployment issues, contact the development team or check the project documentation.