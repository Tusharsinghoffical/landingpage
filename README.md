# Reliable Packers & Movers - Business Website

A responsive business website for an Indian Packers & Movers company built with PHP, Bootstrap 5, and MySQL.

## Project Overview

This project demonstrates a complete business website for a Packers & Movers company in India, featuring:
- Responsive design using Bootstrap 5
- Modular PHP structure
- Inquiry form with MySQL database integration
- SEO optimization
- Performance best practices
- Admin panel for managing inquiries

## Features

### Core Pages
1. **Home Page** - Hero section, services preview, testimonials, and CTA
2. **About Us** - Company information, mission/vision, team
3. **Services** - Detailed service offerings with images
4. **Inquiry Form** - Contact form with validation and database storage
5. **Terms & Conditions** - Legal terms
6. **Privacy Policy** - Privacy information
7. **Sitemap** - Dynamic sitemap

### Technical Features
- Modular PHP includes for header, footer, and navigation
- Responsive design for all device sizes
- Client-side and server-side form validation
- SEO best practices (meta tags, structured data, etc.)
- Schema markup for LocalBusiness
- Performance optimizations
- Dark mode toggle
- WhatsApp chat button

### Bonus Features
- Admin panel for viewing inquiries
- Dark mode support
- WhatsApp "Chat Now" floating button

## Setup Instructions

### Prerequisites
- XAMPP or LAMP environment
- PHP 7.4 or higher
- MySQL 5.7 or higher

### Local Development Installation Steps

1. **Clone or Download the Project**
   - Extract the project files to your web server directory (htdocs for XAMPP)

2. **Database Setup**
   - Start Apache and MySQL services in XAMPP
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `packers_movers`
   - Import the `database_schema.sql` file to create the table structure and sample data

3. **Configure Database Connection**
   - Open `includes/db_config.php`
   - Update database credentials if needed (default XAMPP settings are pre-configured)

4. **Access the Website**
   - Place the project folder in your web server directory
   - Access the website via browser: http://localhost/your-folder-name/

5. **Admin Panel Access**
   - Visit: http://localhost/your-folder-name/admin.php
   - Login with:
     - Username: `admin`
     - Password: `packers123`

## Deployment Instructions

### Prerequisites for Deployment
- Web server with PHP 7.4+ support (Apache/Nginx)
- MySQL 5.7+ database
- PHP extensions: mysqli, pdo, json, gd (for image processing)

### Deployment Steps

1. **Upload Files**
   - Upload all files from this directory to your web server's document root:
     - All PHP files (index.php, about.php, services.php, etc.)
     - The `includes/` directory and its contents
     - The `assets/` directory and its contents

2. **Database Setup**
   - Create a new MySQL database (e.g., `packers_movers`)
   - Import the database schema:
     ```sql
     mysql -u [username] -p [database_name] < database_schema.sql
     ```
   - Update database credentials in `includes/db_config.php`

3. **Configure Permissions**
   - Set appropriate permissions:
     - Make sure PHP can read all files (644)
     - Make sure directories are executable (755)
     - If using file uploads, ensure `assets/images/` is writable (755)

4. **Update Configuration Files**
   - In `includes/db_config.php`, update the database connection details
   - Update the WhatsApp number in `includes/footer.php` and other files as needed
   - Update contact information throughout the site

5. **Test the Deployment**
   - Visit your domain to ensure the homepage loads
   - Test all navigation links
   - Test the inquiry form submission
   - Verify the admin panel works (admin.php)
   - Check that all images load correctly

### Server Configuration

#### Apache (.htaccess)
The included .htaccess file provides:
- URL rewriting for cleaner URLs
- Security enhancements
- Performance optimizations

#### Nginx Configuration
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

## Directory Structure

```
.
├── assets/
│   ├── css/
│   │   └── style.css          # Custom styles
│   ├── js/
│   │   └── script.js          # Custom JavaScript
│   └── images/                # Images folder
├── includes/
│   ├── db_config.php          # Database configuration
│   ├── header.php             # HTML header and opening tags
│   ├── navbar.php             # Navigation menu
│   └── footer.php             # Footer and closing tags
├── pages/                     # Additional pages (if needed)
├── index.php                  # Home page
├── about.php                  # About us page
├── services.php               # Services page
├── inquiry.php                # Inquiry form page
├── terms.php                  # Terms and conditions
├── privacy.php                # Privacy policy
├── sitemap.php                # Sitemap page
├── admin.php                  # Admin panel
├── database_schema.sql        # Database structure and sample data
├── deploy.php                 # Deployment helper script
├── DEPLOYMENT.md              # Detailed deployment guide
└── README.md                  # This file
```

## Time Investment Breakdown

| Task | Time |
|------|------|
| Project Planning & Setup | 2 hours |
| Core Pages Development | 6 hours |
| Backend & Database Integration | 2 hours |
| SEO & Performance Optimization | 2 hours |
| Bonus Features Implementation | 2 hours |
| Content Creation & Testing | 2 hours |
| **Total** | **16 hours** |

## AI Content Generation

For this project, AI-generated content was created using tools like ChatGPT with prompts focused on:
- Indian audience and cultural context
- Relevant keywords for packers and movers services
- Professional yet approachable tone
- Location-specific content (Mumbai-based business)

Keywords targeted:
- "Best packers and movers in [city]"
- "Reliable house shifting services"
- "Affordable packing services"
- "Safe transportation of goods"
- "Local and domestic shifting experts"

## Performance Optimizations

- Minified CSS and JavaScript
- Optimized images
- Efficient database queries
- Proper caching headers
- Gzip compression ready

## SEO Best Practices

- Proper title and meta description tags
- Structured heading hierarchy (H1-H3)
- Alt attributes for all images
- Schema markup (JSON-LD) for LocalBusiness
- Internal linking between pages
- Responsive design for mobile SEO

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript, Bootstrap 5
- **Backend**: PHP (Core, no frameworks)
- **Database**: MySQL
- **Tools**: XAMPP for local development

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (Android and iOS)

## Customization

To customize this website for a different business:
1. Replace business name and contact information
2. Update services to match your offerings
3. Modify color scheme in `assets/css/style.css`
4. Replace images with your own
5. Update schema markup with your business details
6. Customize content to match your brand voice

## License

This project is for educational and demonstration purposes only. Feel free to use and modify for your own projects.