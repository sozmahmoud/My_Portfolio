<?php
session_start();
require 'config.php';

echo "Session User ID: " . ($_SESSION['user_id'] ?? 'None') . "\n";
if (isset($_SESSION['user_id'])) {
    $uid = intval($_SESSION['user_id']);
    $res = $conn->query("SELECT * FROM users WHERE id = $uid");
    if ($res && $res->num_rows > 0) {
        $user = $res->fetch_assoc();
        echo "✓ User exists in DB: " . $user['username'] . " (ID: $uid)\n";
    } else {
        echo "✗ User does NOT exist in DB! Session is stale.\n";
    }
} else {
    echo "User is not logged in.\n";
}

echo "\nTables Status:\n";
$tables = ['users', 'products', 'cart_items', 'wishlist_items', 'orders'];
foreach ($tables as $table) {
    $res = $conn->query("SELECT COUNT(*) FROM $table");
    if ($res) {
        echo " - $table: " . $res->fetch_row()[0] . " rows\n";
    } else {
        echo " - $table: ERROR (" . $conn->error . ")\n";
    }
}
?>
