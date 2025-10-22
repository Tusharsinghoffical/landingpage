<?php
/**
 * Installation script for Reliable Packers & Movers
 * This script helps set up the database and initial configuration
 */

// Prevent direct access in production after installation
if (file_exists('installed.lock')) {
    die('Installer is locked. Remove installed.lock file to run installer again.');
}

// Include database configuration
include 'includes/db_config.php';

// Check if this is a fresh installation
$fresh_install = !isset($conn) || $conn === null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Install - Reliable Packers & Movers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .install-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
        }
        .install-header {
            background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%);
            color: white;
            padding: 2rem;
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        .step {
            text-align: center;
            flex: 1;
        }
        .step.active .step-number {
            background: #1e88e5;
            color: white;
        }
        .step.completed .step-number {
            background: #4caf50;
            color: white;
        }
        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="install-card">
                    <div class="install-header text-center">
                        <h1 class="display-5 fw-bold mb-3">
                            <i class="fas fa-truck-moving me-3"></i>Reliable Packers & Movers
                        </h1>
                        <p class="lead">Installation Wizard</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                            <?php
                            // Process installation
                            $step = $_POST['step'] ?? 1;
                            
                            if ($step == 1) {
                                // Database configuration
                                $db_host = $_POST['db_host'] ?? 'localhost';
                                $db_user = $_POST['db_user'] ?? 'root';
                                $db_pass = $_POST['db_pass'] ?? '';
                                $db_name = $_POST['db_name'] ?? 'packers_movers';
                                
                                // Create config.php
                                $config_content = "<?php
/**
 * Configuration file for Reliable Packers & Movers
 * Generated on " . date('Y-m-d H:i:s') . "
 */

// Database configuration
define('DB_HOST', '$db_host');
define('DB_USER', '$db_user');
define('DB_PASS', '$db_pass');
define('DB_NAME', '$db_name');

// Site configuration
define('SITE_NAME', 'Reliable Packers & Movers');
define('SITE_URL', 'https://' . \$_SERVER['HTTP_HOST']);
define('ADMIN_EMAIL', 'admin@' . \$_SERVER['HTTP_HOST']);

// WhatsApp configuration
define('WHATSAPP_NUMBER', '+919876543210');

// Security configuration
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'packers123'); // Change this in production!

// Error reporting (set to false in production)
define('DEBUG_MODE', true);

?>";
                                
                                file_put_contents('config.php', $config_content);
                                
                                // Test database connection
                                $conn_test = new mysqli($db_host, $db_user, $db_pass);
                                $db_success = !$conn_test->connect_error;
                                if ($db_success) {
                                    $conn_test->close();
                                }
                                ?>
                                <div class="step-indicator">
                                    <div class="step completed">
                                        <div class="step-number">1</div>
                                        <div>Database</div>
                                    </div>
                                    <div class="step active">
                                        <div class="step-number">2</div>
                                        <div>Finish</div>
                                    </div>
                                </div>
                                
                                <?php if ($db_success): ?>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle me-2"></i>Database configuration saved successfully!
                                    </div>
                                    
                                    <div class="text-center mt-4">
                                        <h3 class="mb-3">Installation Complete!</h3>
                                        <p class="lead">Your website is now ready to use.</p>
                                        
                                        <div class="row mt-4">
                                            <div class="col-md-6 mb-3">
                                                <a href="index.php" class="btn btn-primary btn-lg w-100">
                                                    <i class="fas fa-home me-2"></i>Go to Website
                                                </a>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <a href="admin.php" class="btn btn-success btn-lg w-100">
                                                    <i class="fas fa-user-shield me-2"></i>Admin Panel
                                                </a>
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-warning mt-4">
                                            <h5><i class="fas fa-exclamation-triangle me-2"></i>Important Security Notice</h5>
                                            <p>Please remember to:</p>
                                            <ul class="text-start">
                                                <li>Change the default admin password in admin.php</li>
                                                <li>Update the WhatsApp number in includes/footer.php</li>
                                                <li>Update all contact information throughout the site</li>
                                                <li>Set up SSL certificate for HTTPS</li>
                                            </ul>
                                        </div>
                                        
                                        <button class="btn btn-outline-secondary" onclick="createLockFile()">
                                            <i class="fas fa-lock me-2"></i>Create Installation Lock File
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-circle me-2"></i>Database connection failed. Please check your credentials.
                                    </div>
                                    <a href="install.php" class="btn btn-primary">Try Again</a>
                                <?php endif; ?>
                                
                                <script>
                                    function createLockFile() {
                                        fetch('install.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded',
                                            },
                                            body: 'step=2'
                                        })
                                        .then(response => response.text())
                                        .then(data => {
                                            alert('Installation lock file created. Installer is now disabled for security.');
                                            window.location.href = 'index.php';
                                        });
                                    }
                                </script>
                            <?php } elseif ($step == 2) {
                                // Create lock file
                                file_put_contents('installed.lock', 'Installation completed on ' . date('Y-m-d H:i:s'));
                                echo '<script>window.location.href = "index.php";</script>';
                            } ?>
                        <?php else: ?>
                            <!-- Step 1: Database Configuration -->
                            <div class="step-indicator">
                                <div class="step active">
                                    <div class="step-number">1</div>
                                    <div>Database</div>
                                </div>
                                <div class="step">
                                    <div class="step-number">2</div>
                                    <div>Finish</div>
                                </div>
                            </div>
                            
                            <h3 class="text-center mb-4">
                                <i class="fas fa-database me-2"></i>Database Configuration
                            </h3>
                            
                            <form method="POST">
                                <input type="hidden" name="step" value="1">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="db_host" class="form-label">Database Host</label>
                                        <input type="text" class="form-control" id="db_host" name="db_host" value="localhost" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="db_name" class="form-label">Database Name</label>
                                        <input type="text" class="form-control" id="db_name" name="db_name" value="packers_movers" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="db_user" class="form-label">Database Username</label>
                                        <input type="text" class="form-control" id="db_user" name="db_user" value="root" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="db_pass" class="form-label">Database Password</label>
                                        <input type="password" class="form-control" id="db_pass" name="db_pass" value="">
                                    </div>
                                </div>
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Tip:</strong> The database and tables will be created automatically if they don't exist.
                                </div>
                                
                                <div class="d-grid mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-cogs me-2"></i>Continue Installation
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="text-center mt-4 text-muted">
                    <p>Reliable Packers & Movers Installation Wizard</p>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>