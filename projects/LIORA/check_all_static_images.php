<?php
require 'config.php';
require_once 'map_product_id.php';

$result = $conn->query("SELECT id, name, image_url FROM products ORDER BY id");
$issues = [];

while ($row = $result->fetch_assoc()) {
    $id = intval($row['id']);
    $dbImg = $row['image_url'];
    $static = getStaticProductById($id);
    
    if (!$static) {
        $issues[] = "ID $id: No static product data at all.";
        continue;
    }
    
    $staticImg = $static['image'] ?? '';
    if (trim($staticImg) === '') {
        $issues[] = "ID $id: Static product has empty image.";
        continue;
    }
    
    $path = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $staticImg), DIRECTORY_SEPARATOR);
    $full = __DIR__ . DIRECTORY_SEPARATOR . $path;
    if (!is_file($full)) {
        $issues[] = "ID $id: Static image file missing: $staticImg (full: $full)";
    }
}

if (empty($issues)) {
    echo "All products have valid static image references.\n";
} else {
    echo "Issues found:\n";
    foreach ($issues as $msg) {
        echo "- $msg\n";
    }
}
?>
