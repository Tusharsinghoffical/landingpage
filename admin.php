<?php
include 'includes/db_config.php';

// Simple authentication (in a real application, use proper authentication)
$authenticated = false;
$auth_error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // In a real application, use proper password hashing
    // For this demo, we'll use a simple check
    if ($username === 'admin' && $password === 'packers123') {
        $authenticated = true;
    } else {
        $auth_error = "Invalid username or password";
    }
}

// If authenticated, show the admin panel
if ($authenticated) {
    // Fetch inquiries from database
    $sql = "SELECT * FROM inquiries ORDER BY created_at DESC";
    $result = $conn->query($sql);
    
    include 'includes/header.php';
    ?>
    
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 fw-bold mb-4">Admin Panel - Inquiries</h1>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Customer Inquiries</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($result->num_rows > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Service</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                                            <td><?php echo htmlspecialchars($row['service']); ?></td>
                                            <td><?php echo htmlspecialchars(substr($row['message'], 0, 50)) . (strlen($row['message']) > 50 ? '...' : ''); ?></td>
                                            <td><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-center">No inquiries found.</p>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <a href="admin.php" class="btn btn-secondary">Refresh</a>
                            <a href="?logout=true" class="btn btn-outline-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php 
    include 'includes/footer.php';
    
    // Handle logout
    if (isset($_GET['logout'])) {
        header("Location: admin.php");
        exit();
    }
} else {
    // Show login form
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login - Reliable Packers & Movers</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h3>Admin Login</h3>
                                <p class="text-muted">Reliable Packers & Movers</p>
                            </div>
                            
                            <?php if ($auth_error): ?>
                                <div class="alert alert-danger"><?php echo $auth_error; ?></div>
                            <?php endif; ?>
                            
                            <form method="POST" action="admin.php">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                            </form>
                            
                            <div class="mt-4 text-center">
                                <p class="text-muted small">Demo credentials: admin / packers123</p>
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
}
?>