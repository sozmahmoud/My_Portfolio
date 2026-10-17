<?php
require 'config.php';
$res = $conn->query("SELECT id, name, category, color FROM products WHERE id = 10 OR name LIKE '%orange%'");
while ($row = $res->fetch_assoc()) {
    echo $row['id'] . " | " . $row['name'] . " | " . $row['color'] . "\n";
}
?>
