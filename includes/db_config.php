<?php
// Check if config.php exists, otherwise use default values
if (file_exists(__DIR__ . '/../config.php')) {
    include __DIR__ . '/../config.php';
    
    $servername = defined('DB_HOST') ? DB_HOST : "localhost";
    $username = defined('DB_USER') ? DB_USER : "root";
    $password = defined('DB_PASS') ? DB_PASS : "";
    $dbname = defined('DB_NAME') ? DB_NAME : "packers_movers";
} else {
    // Default configuration - check for Render environment variables first
    $servername = $_ENV['DB_HOST'] ?? "localhost";
    $username = $_ENV['DB_USER'] ?? "root";
    $password = $_ENV['DB_PASS'] ?? "";
    $dbname = $_ENV['DB_NAME'] ?? "packers_movers";
}

// Create connection
$conn = null;

try {
    // Try to connect with the database directly
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check if inquiries table exists, if not create it
    $table_check = $conn->query("SHOW TABLES LIKE 'inquiries'");
    if ($table_check && $table_check->num_rows == 0) {
        $create_table_sql = "CREATE TABLE `inquiries` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `mobile` varchar(20) NOT NULL,
            `service` varchar(100) NOT NULL,
            `message` text NOT NULL,
            `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        
        if ($conn->query($create_table_sql) === TRUE) {
            // Insert sample data
            $insert_sql = "INSERT INTO `inquiries` (`name`, `email`, `mobile`, `service`, `message`) VALUES
            ('Rajesh Kumar', 'rajesh.kumar@gmail.com', '9876543210', 'House Shifting', 'Looking for house shifting services from Mumbai to Delhi. Need quotation for 2BHK apartment.'),
            ('Priya Sharma', 'priya.sharma@yahoo.com', '9876543211', 'Office Relocation', 'Need to relocate our office from Bangalore to Hyderabad. Around 50 workstations and IT equipment.'),
            ('Anil Reddy', 'anil.reddy@hotmail.com', '9876543212', 'Packing Services', 'Require professional packing services for fragile items including electronics and glassware.'),
            ('Sunita Verma', 'sunita.verma@outlook.com', '9876543213', 'Car Transportation', 'Need to transport my car from Chennai to Pune. Open carrier is fine.'),
            ('Vikram Singh', 'vikram.singh@gmail.com', '9876543214', 'Storage Services', 'Looking for short-term storage solution for 3 months during home renovation.')";
            
            $conn->query($insert_sql);
        }
    }
} catch (mysqli_sql_exception $e) {
    // If connection fails, show a user-friendly message
    echo "<div class='alert alert-warning text-center'>";
    echo "<strong>Database Connection Notice:</strong> ";
    echo "The inquiry form requires a database connection. ";
    echo "Please ensure MySQL is running and the database is set up correctly. ";
    echo "You can still browse the website, but the inquiry form will not work without a database connection.";
    echo "</div>";
    $conn = null; // Set to null so we can check later
}
?>