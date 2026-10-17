<?php
/**
 * Clean database data while preserving admin users.
 *
 * Run this file from the browser or CLI to remove all non-admin user rows
 * and clear all other application data tables.
 */
require_once 'config.php';

echo "<h1>LIORA Database Cleanup</h1>";
echo "<pre>";

$cleanupTables = [
    'cart_items',
    'wishlist_items',
    'order_items',
    'reward_points',
    'orders',
    'reviews',
    'user_special_dates',
    'user_search_history',
    'chat_history',
    'support_messages',
    'password_reset_requests',
    'products'
];

if (!empty($cleanupTables)) {
    if (!$conn->query('SET FOREIGN_KEY_CHECKS = 0')) {
        echo "⚠️ Failed to disable foreign key checks: " . $conn->error . "\n";
    }

    foreach ($cleanupTables as $table) {
        if ($conn->query("DELETE FROM $table")) {
            echo "✓ Cleared table: $table\n";
        } else {
            echo "✗ Failed to clear $table: " . $conn->error . "\n";
        }
    }

    if (!$conn->query('SET FOREIGN_KEY_CHECKS = 1')) {
        echo "⚠️ Failed to re-enable foreign key checks: " . $conn->error . "\n";
    }
}

// Preserve admin users and remove all other users
$deleteUsersSql = "DELETE FROM users WHERE role <> 'admin'";
if ($conn->query($deleteUsersSql)) {
    echo "✓ Preserved admin users and removed non-admin users.\n";
} else {
    echo "✗ Failed to delete non-admin users: " . $conn->error . "\n";
}

// Optional: report row counts after cleanup
$tablesToReport = array_merge($cleanupTables, ['users']);

echo "\nDatabase row counts after cleanup:\n";
foreach ($tablesToReport as $table) {
    $result = $conn->query("SELECT COUNT(*) AS count FROM $table");
    if ($result) {
        $count = $result->fetch_assoc()['count'];
        echo "   - $table: $count\n";
    } else {
        echo "   - $table: ERROR (" . $conn->error . ")\n";
    }
}

echo "</pre>";
?>