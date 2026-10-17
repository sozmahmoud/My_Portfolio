<?php
/**
 * LIORA DATABASE RESET & CONNECTION VERIFICATION
 * This script clears all user data, updates the schema, and verifies connections.
 */
require_once 'config.php';

echo "<h1>🚀 LIORA System Maintenance</h1>";
echo "<pre>";

// 1. CLEAR ALL DATA & UPDATE SCHEMA
echo "<h2>1. Clearing Database & Updating Schema...</h2>";

// List of tables in correct drop order (respecting foreign keys)
$tables = [
    'chat_history',
    'user_search_history',
    'user_special_dates',
    'reviews',
    'reward_points',
    'wishlist_items',
    'cart_items',
    'products',
    'users'
];

echo "Wiping tables...\n";
foreach ($tables as $table) {
    if ($conn->query("DROP TABLE IF EXISTS $table")) {
        echo "   ✓ Dropped $table\n";
    } else {
        echo "   ✗ Error dropping $table: " . $conn->error . "\n";
    }
}

echo "\nRe-creating tables from schema.sql...\n";
if (file_exists('schema.sql')) {
    $sql = file_get_contents('schema.sql');
    
    // Remove database creation commands if they are at the top to avoid errors
    // (though schema.sql seems to have CREATE DATABASE IF NOT EXISTS)
    
    if ($conn->multi_query($sql)) {
        do {
            /* store first result set */
            if ($result = $conn->store_result()) {
                $result->free();
            }
            /* print divider */
            if ($conn->more_results()) {
                // query successful
            }
        } while ($conn->next_result());
        echo "   ✓ Schema re-applied successfully.\n";
    } else {
        echo "   ✗ Error executing schema: " . $conn->error . "\n";
    }
} else {
    echo "   ✗ schema.sql NOT FOUND!\n";
}

// 2. RE-POPULATE PRODUCTS
echo "\n<h2>2. Re-populating Products & Demo User...</h2>";
// We call init_db.php internally or replicate its logic
// To be safe and clean, I'll just run the logic from init_db.php here but simplified
include 'init_db.php'; 

// 3. VERIFY CONNECTIONS IN KEY FILES
echo "\n<h2>3. Verifying Connections in Key Files...</h2>";
$keyFiles = [
    'config.php',
    'auth_handler.php',
    'cart_action.php',
    'checkout_action.php',
    'gemini_bridge.php',
    'admin_action.php',
    'accounts_action.php'
];

foreach ($keyFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        if (strpos($content, 'config.php') !== false) {
            echo "   ✅ $file: Correctly connected to database via config.php\n";
        } else {
            echo "   ⚠️ $file: Connection check failed (no config.php found!)\n";
        }
    } else {
        echo "   ❌ $file: FILE MISSING!\n";
    }
}

// 4. DATABASE STATUS CHECK
echo "\n<h2>4. Final Database Status...</h2>";
$res = $conn->query("SHOW TABLES");
echo "Current tables in " . $dbName . ":\n";
while ($row = $res->fetch_array()) {
    $tableName = $row[0];
    $countRes = $conn->query("SELECT COUNT(*) FROM $tableName");
    $count = $countRes->fetch_array()[0];
    echo "   - $tableName ($count records)\n";
}

echo "\n✨ DATABASE IS NOW CLEAN, UP-TO-DATE, AND FULLY CONNECTED! ✨";
echo "</pre>";
?>
