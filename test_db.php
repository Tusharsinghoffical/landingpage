<?php
include 'includes/db_config.php';

// Test database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Database connection successful!<br>";

// Test if inquiries table exists
$sql = "SHOW TABLES LIKE 'inquiries'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Inquiries table exists.<br>";
    
    // Count records in the table
    $sql = "SELECT COUNT(*) as count FROM inquiries";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo "Number of records in inquiries table: " . $row['count'] . "<br>";
} else {
    echo "Inquiries table does not exist.<br>";
}

$conn->close();
?>