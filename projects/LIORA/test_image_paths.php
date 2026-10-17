<?php
// Test isUsableProductImage logic
function isUsableProductImage($image) {
    $image = trim((string) $image);
    if ($image === '') {
        return false;
    }

    if (preg_match('/^(https?:)?\/\//i', $image) || strpos($image, 'data:') === 0) {
        return true;
    }

    $path = parse_url($image, PHP_URL_PATH);
    if (!$path) {
        return false;
    }

    $path = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
    $fullPath = __DIR__ . DIRECTORY_SEPARATOR . $path;
    $exists = is_file($fullPath);
    echo "Image: $image\n";
    echo "  Path: $path\n";
    echo "  Full: $fullPath\n";
    echo "  Exists: " . ($exists ? 'YES' : 'NO') . "\n\n";
    return $exists;
}

// Test various formats
$tests = [
    'assets/img/items/roses/rose_1.jpg',
    'assets/img/first_page.jpg',
    'http://localhost/LIORA/assets/img/items/roses/rose_10.jpg',
    'assets/img/items/roses/rose_10.jpg',
    'assets\\img\\items\\roses\\rose_1.jpg',
];

foreach ($tests as $test) {
    isUsableProductImage($test);
}
?>
