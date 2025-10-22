<?php
/**
 * Deployment Helper Script for Reliable Packers & Movers
 * This script helps verify the deployment environment and configuration
 */

// Prevent direct access in production
if (!defined('DEVELOPMENT_MODE') && php_sapi_name() !== 'cli') {
    die('Direct access not allowed.');
}

// Check PHP version
if (version_compare(PHP_VERSION, '7.4.0') < 0) {
    die('PHP 7.4 or higher is required. Current version: ' . PHP_VERSION);
}

// Check required extensions
$required_extensions = ['mysqli', 'pdo', 'json', 'gd'];
$missing_extensions = [];

foreach ($required_extensions as $ext) {
    if (!extension_loaded($ext)) {
        $missing_extensions[] = $ext;
    }
}

if (!empty($missing_extensions)) {
    die('Missing required PHP extensions: ' . implode(', ', $missing_extensions));
}

// Check file permissions
$writable_dirs = ['assets/images/'];
$unwritable_dirs = [];

foreach ($writable_dirs as $dir) {
    if (!is_writable($dir)) {
        $unwritable_dirs[] = $dir;
    }
}

// Display deployment checklist
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deployment Checklist - Reliable Packers & Movers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="display-4 fw-bold">
                    <i class="fas fa-server me-3"></i>Deployment Checklist
                </h1>
                <p class="lead">Reliable Packers & Movers Website</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-check-circle me-2"></i>System Requirements</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                PHP Version (<?php echo PHP_VERSION; ?>)
                                <span class="badge bg-<?php echo version_compare(PHP_VERSION, '7.4.0') >= 0 ? 'success' : 'danger'; ?> rounded-pill">
                                    <?php echo version_compare(PHP_VERSION, '7.4.0') >= 0 ? 'OK' : 'FAIL'; ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                MySQLi Extension
                                <span class="badge bg-<?php echo extension_loaded('mysqli') ? 'success' : 'danger'; ?> rounded-pill">
                                    <?php echo extension_loaded('mysqli') ? 'OK' : 'FAIL'; ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                PDO Extension
                                <span class="badge bg-<?php echo extension_loaded('pdo') ? 'success' : 'danger'; ?> rounded-pill">
                                    <?php echo extension_loaded('pdo') ? 'OK' : 'FAIL'; ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                JSON Extension
                                <span class="badge bg-<?php echo extension_loaded('json') ? 'success' : 'danger'; ?> rounded-pill">
                                    <?php echo extension_loaded('json') ? 'OK' : 'FAIL'; ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                GD Extension
                                <span class="badge bg-<?php echo extension_loaded('gd') ? 'success' : 'danger'; ?> rounded-pill">
                                    <?php echo extension_loaded('gd') ? 'OK' : 'FAIL'; ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-folder me-2"></i>Directory Permissions</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                assets/images/ Directory
                                <span class="badge bg-<?php echo is_writable('assets/images/') ? 'success' : 'warning'; ?> rounded-pill">
                                    <?php echo is_writable('assets/images/') ? 'WRITABLE' : 'NOT WRITABLE'; ?>
                                </span>
                            </li>
                        </ul>
                        <?php if (!empty($unwritable_dirs)): ?>
                            <div class="alert alert-warning mt-3">
                                <h5><i class="fas fa-exclamation-triangle me-2"></i>Permission Issues</h5>
                                <p>The following directories need to be writable:</p>
                                <ul>
                                    <?php foreach ($unwritable_dirs as $dir): ?>
                                        <li><?php echo $dir; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <p>Run: <code>chmod 755 <?php echo implode(' ', $unwritable_dirs); ?></code></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-database me-2"></i>Database Configuration</h4>
                    </div>
                    <div class="card-body">
                        <p>Ensure your database is properly configured in <code>includes/db_config.php</code></p>
                        <p>Import the database schema: <code>database_schema.sql</code></p>
                        
                        <?php
                        // Test database connection
                        $db_config_exists = file_exists('includes/db_config.php');
                        $db_test_result = 'UNKNOWN';
                        $db_test_class = 'secondary';
                        
                        if ($db_config_exists) {
                            include 'includes/db_config.php';
                            if (isset($servername, $username, $password, $dbname)) {
                                $conn = new mysqli($servername, $username, $password);
                                if ($conn->connect_error) {
                                    $db_test_result = 'FAIL - ' . $conn->connect_error;
                                    $db_test_class = 'danger';
                                } else {
                                    $db_test_result = 'OK';
                                    $db_test_class = 'success';
                                    $conn->close();
                                }
                            } else {
                                $db_test_result = 'FAIL - Missing config variables';
                                $db_test_class = 'danger';
                            }
                        } else {
                            $db_test_result = 'FAIL - Config file missing';
                            $db_test_class = 'danger';
                        }
                        ?>
                        
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Database Configuration File
                                <span class="badge bg-<?php echo $db_config_exists ? 'success' : 'danger'; ?> rounded-pill">
                                    <?php echo $db_config_exists ? 'FOUND' : 'MISSING'; ?>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Database Connection
                                <span class="badge bg-<?php echo $db_test_class; ?> rounded-pill">
                                    <?php echo $db_test_result; ?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-rocket me-2"></i>Next Steps</h4>
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>Update database credentials in <code>includes/db_config.php</code></li>
                            <li>Change default admin password in <code>admin.php</code></li>
                            <li>Update contact information throughout the site</li>
                            <li>Test all forms and functionality</li>
                            <li>Configure SSL certificate for HTTPS</li>
                            <li>Set up regular backups</li>
                        </ol>
                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-primary btn-lg">
                                <i class="fas fa-home me-2"></i>Go to Website
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>