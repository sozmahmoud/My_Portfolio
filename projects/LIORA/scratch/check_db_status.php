<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Checking Database Connection...\n";
$host = "localhost";
$user = "root";
$pass = "";
$db = "liora_db";

$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}
echo "✓ MySQL Connected successfully\n";

// Check if database exists
$result = $conn->query("SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '$db'");
if ($result->num_rows > 0) {
    echo "✓ Database '$db' exists\n";
    $conn->select_db($db);
    
    // Check tables
    $result = $conn->query("SHOW TABLES");
    echo "Tables in '$db':\n";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_row()) {
            echo " - " . $row[0] . "\n";
            // Count rows in users table
            if ($row[0] === 'users') {
                $countRes = $conn->query("SELECT COUNT(*) FROM users");
                $count = $countRes->fetch_row()[0];
                echo "   (Users count: $count)\n";
            }
        }
    } else {
        echo " (No tables found)\n";
    }
} else {
    echo "✗ Database '$db' does NOT exist!\n";
    echo "Attempting to create database '$db'...\n";
    if ($conn->query("CREATE DATABASE $db")) {
        echo "✓ Database '$db' created successfully\n";
    } else {
        echo "✗ Failed to create database: " . $conn->error . "\n";
    }
}

$conn->close();
?>
