<?php
include 'config.php';
include 'checkout_action.php';

try {
    ensureOrderColumns($conn);
    echo "Database schema updated successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
