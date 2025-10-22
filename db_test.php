<?php
/**
 * Database Connection Test Script
 * This script helps verify database connectivity in different environments
 */

echo "<h1>Database Connection Test</h1>";

// Test environment variables
echo "<h2>Environment Variables</h2>";
echo "<pre>";
echo "DB_HOST: " . ($_ENV['DB_HOST'] ?? 'Not set') . "\n";
echo "DB_USER: " . ($_ENV['DB_USER'] ?? 'Not set') . "\n";
echo "DB_PASS: " . ($_ENV['DB_PASS'] ?? 'Not set') . "\n";
echo "DB_NAME: " . ($_ENV['DB_NAME'] ?? 'Not set') . "\n";
echo "</pre>";

// Test database connection
echo "<h2>Connection Test</h2>";

$servername = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASS'] ?? '';
$dbname = $_ENV['DB_NAME'] ?? 'packers_movers';

echo "<p>Attempting to connect to MySQL at $servername with user $username...</p>";

try {
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        echo "<p style='color: red;'>Connection failed: " . $conn->connect_error . "</p>";
    } else {
        echo "<p style='color: green;'>Connected successfully to MySQL server!</p>";
        
        // Try to select database
        if ($conn->select_db($dbname)) {
            echo "<p style='color: green;'>Database '$dbname' selected successfully!</p>";
        } else {
            echo "<p style='color: orange;'>Database '$dbname' not found. You may need to create it.</p>";
        }
        
        $conn->close();
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

echo "<h2>PHP Info</h2>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";

// Check if MySQLi extension is loaded
if (extension_loaded('mysqli')) {
    echo "<p style='color: green;'>MySQLi extension is loaded.</p>";
} else {
    echo "<p style='color: red;'>MySQLi extension is NOT loaded.</p>";
}

echo "<p><a href='index.php'>Back to Home</a></p>";
?>