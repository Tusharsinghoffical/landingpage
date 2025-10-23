<?php
/**
 * Configuration file for Reliable Packers & Movers
 * Generated on <?php echo date('Y-m-d H:i:s'); ?>
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'packers_movers');

// Site configuration
define('SITE_NAME', 'Reliable Packers & Movers');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/packers_movers_final_clean');
define('ADMIN_EMAIL', 'admin@' . $_SERVER['HTTP_HOST']);

// WhatsApp configuration
define('WHATSAPP_NUMBER', '+919876543210');

// Security configuration
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'packers123'); // Change this in production!

// Error reporting (set to false in production)
define('DEBUG_MODE', true);

?>