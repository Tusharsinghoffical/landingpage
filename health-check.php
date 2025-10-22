<?php
/**
 * Health Check Script for Reliable Packers & Movers
 * This script verifies that all components are working correctly
 */

// Include database configuration
include 'includes/db_config.php';

// Start output buffering
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Check - Reliable Packers & Movers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .health-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        .health-header {
            background: linear-gradient(135deg, #1e88e5 0%, #0d47a1 100%);
            color: white;
            padding: 2rem;
        }
        .status-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        .status-ok { color: #4caf50; }
        .status-warning { color: #ff9800; }
        .status-error { color: #f44336; }
        .status-info { color: #2196f3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="health-card">
                    <div class="health-header text-center">
                        <h1 class="display-5 fw-bold mb-3">
                            <i class="fas fa-heartbeat me-3"></i>System Health Check
                        </h1>
                        <p class="lead">Reliable Packers & Movers</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="mb-4">
                                    <i class="fas fa-stethoscope me-2"></i>System Status
                                </h3>
                            </div>
                        </div>
                        
                        <div class="row">
                            <!-- PHP Version Check -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon status-<?php echo version_compare(PHP_VERSION, '7.4.0') >= 0 ? 'ok' : 'error'; ?>">
                                                <i class="fas fa-code"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title">PHP Version</h5>
                                                <p class="card-text mb-0">Current: <?php echo PHP_VERSION; ?></p>
                                                <p class="card-text mb-0">
                                                    <?php if (version_compare(PHP_VERSION, '7.4.0') >= 0): ?>
                                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>OK</span>
                                                    <?php else: ?>
                                                        <span class="text-danger"><i class="fas fa-times-circle me-1"></i>Outdated</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Database Connection Check -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon status-<?php echo isset($conn) && $conn !== null ? 'ok' : 'warning'; ?>">
                                                <i class="fas fa-database"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title">Database Connection</h5>
                                                <p class="card-text mb-0">
                                                    <?php if (isset($conn) && $conn !== null): ?>
                                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>Connected</span>
                                                    <?php else: ?>
                                                        <span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Not Connected</span>
                                                    <?php endif; ?>
                                                </p>
                                                <?php if (isset($conn) && $conn !== null): ?>
                                                    <p class="card-text mb-0 text-muted">MySQL <?php echo $conn->server_info; ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Required Extensions Check -->
                            <?php
                            $required_extensions = ['mysqli', 'pdo', 'json', 'gd'];
                            $missing_extensions = [];
                            foreach ($required_extensions as $ext) {
                                if (!extension_loaded($ext)) {
                                    $missing_extensions[] = $ext;
                                }
                            }
                            ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon status-<?php echo empty($missing_extensions) ? 'ok' : 'error'; ?>">
                                                <i class="fas fa-plug"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title">PHP Extensions</h5>
                                                <p class="card-text mb-0">
                                                    <?php if (empty($missing_extensions)): ?>
                                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>All Required Extensions Loaded</span>
                                                    <?php else: ?>
                                                        <span class="text-danger"><i class="fas fa-times-circle me-1"></i>Missing Extensions</span>
                                                    <?php endif; ?>
                                                </p>
                                                <?php if (!empty($missing_extensions)): ?>
                                                    <p class="card-text mb-0 text-danger">Missing: <?php echo implode(', ', $missing_extensions); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- File Permissions Check -->
                            <?php
                            $writable_dirs = ['assets/images/'];
                            $unwritable_dirs = [];
                            foreach ($writable_dirs as $dir) {
                                if (!is_writable($dir)) {
                                    $unwritable_dirs[] = $dir;
                                }
                            }
                            ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon status-<?php echo empty($unwritable_dirs) ? 'ok' : 'warning'; ?>">
                                                <i class="fas fa-folder"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title">File Permissions</h5>
                                                <p class="card-text mb-0">
                                                    <?php if (empty($unwritable_dirs)): ?>
                                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>All Directories Writable</span>
                                                    <?php else: ?>
                                                        <span class="text-warning"><i class="fas fa-exclamation-triangle me-1"></i>Permission Issues</span>
                                                    <?php endif; ?>
                                                </p>
                                                <?php if (!empty($unwritable_dirs)): ?>
                                                    <p class="card-text mb-0 text-warning">Not writable: <?php echo implode(', ', $unwritable_dirs); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Configuration Files Check -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon status-<?php echo file_exists('config.php') ? 'ok' : 'info'; ?>">
                                                <i class="fas fa-cog"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title">Configuration</h5>
                                                <p class="card-text mb-0">
                                                    <?php if (file_exists('config.php')): ?>
                                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>Config File Found</span>
                                                    <?php else: ?>
                                                        <span class="text-info"><i class="fas fa-info-circle me-1"></i>Using Defaults</span>
                                                    <?php endif; ?>
                                                </p>
                                                <p class="card-text mb-0 text-muted">config.php</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Installation Status Check -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="status-icon status-<?php echo file_exists('installed.lock') ? 'ok' : 'info'; ?>">
                                                <i class="fas fa-lock"></i>
                                            </div>
                                            <div>
                                                <h5 class="card-title">Installation Status</h5>
                                                <p class="card-text mb-0">
                                                    <?php if (file_exists('installed.lock')): ?>
                                                        <span class="text-success"><i class="fas fa-check-circle me-1"></i>Installed</span>
                                                    <?php else: ?>
                                                        <span class="text-info"><i class="fas fa-info-circle me-1"></i>Not Locked</span>
                                                    <?php endif; ?>
                                                </p>
                                                <p class="card-text mb-0 text-muted">installed.lock</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12">
                                <h3 class="mb-4">
                                    <i class="fas fa-tasks me-2"></i>System Information
                                </h3>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5><i class="fas fa-server me-2"></i>Server Information</h5>
                                                <ul class="list-unstyled">
                                                    <li><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></li>
                                                    <li><strong>Server Name:</strong> <?php echo $_SERVER['SERVER_NAME'] ?? 'Unknown'; ?></li>
                                                    <li><strong>Server Address:</strong> <?php echo $_SERVER['SERVER_ADDR'] ?? 'Unknown'; ?></li>
                                                    <li><strong>Server Port:</strong> <?php echo $_SERVER['SERVER_PORT'] ?? 'Unknown'; ?></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h5><i class="fas fa-info-circle me-2"></i>Script Information</h5>
                                                <ul class="list-unstyled">
                                                    <li><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></li>
                                                    <li><strong>PHP SAPI:</strong> <?php echo PHP_SAPI; ?></li>
                                                    <li><strong>Max Execution Time:</strong> <?php echo ini_get('max_execution_time'); ?> seconds</li>
                                                    <li><strong>Memory Limit:</strong> <?php echo ini_get('memory_limit'); ?></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <a href="index.php" class="btn btn-primary btn-lg me-2">
                                    <i class="fas fa-home me-2"></i>Go to Website
                                </a>
                                <a href="admin.php" class="btn btn-success btn-lg">
                                    <i class="fas fa-user-shield me-2"></i>Admin Panel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// End output buffering
ob_end_flush();
?>