<?php
require 'config.php';
require_once 'map_product_id.php';

function isUsableProductImage($image) {
    $image = trim((string) $image);
    if ($image === '') {
        echo "Empty image\n";
        return false;
    }
    echo "Checking: $image\n";
    if (preg_match('/^(https?:)?\/\//i', $image) || strpos($image, 'data:') === 0) {
        echo "  -> Matched URL pattern, usable\n";
        return true;
    }
    $path = parse_url($image, PHP_URL_PATH);
    echo "  parse_url path: ";
    var_export($path);
    echo "\n";
    if (!$path) {
        echo "  -> No path, not usable\n";
        return false;
    }
    $path = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
    $full = __DIR__ . DIRECTORY_SEPARATOR . $path;
    echo "  Full path: $full\n";
    $exists = is_file($full);
    echo "  -> is_file: " . ($exists ? 'YES' : 'NO') . "\n";
    return $exists;
}

// Test for product ID 8 and 103
$testIds = [8, 103];
foreach ($testIds as $id) {
    $static = getStaticProductById($id);
    echo "=== Static product for ID $id:\n";
    print_r($static);
    $img = $static['image'] ?? '';
    $usable = isUsableProductImage($img);
    echo "Usable? " . ($usable ? 'YES' : 'NO') . "\n\n";
}
?>
