<?php
require 'config.php';
$tables = ['cart_items', 'wishlist_items'];
foreach ($tables as $t) {
    echo "Table: $t\n";
    $res = $conn->query("DESCRIBE $t");
    while($row = $res->fetch_assoc()) {
        echo " - " . $row['Field'] . " (" . $row['Type'] . ")\n";
    }
    echo "\n";
}
?>
