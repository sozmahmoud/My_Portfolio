<?php
require 'config.php';
$result = $conn->query("SELECT id, name, image_url FROM products ORDER BY id");
echo "All product image URLs:\n";
echo str_repeat("=", 80) . "\n";
while ($row = $result->fetch_assoc()) {
    $url = $row['image_url'];
    $status = '';
    if (empty(trim($url))) {
        $status = ' [EMPTY]';
    } elseif (preg_match('/^https?:\/\//i', $url)) {
        $status = ' [ABSOLUTE URL]';
    } elseif (strpos($url, 'assets/') === 0 || strpos($url, './assets/') === 0) {
        $status = ' [RELATIVE - OK]';
    } else {
        $status = ' [UNKNOWN FORMAT]';
    }
    printf("%3d: %s => %s%s\n", $row['id'], $row['name'], $url, $status);
}
?>
