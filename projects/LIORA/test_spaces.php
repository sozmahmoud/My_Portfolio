<?php
$tests = [
    'assets/img/items/other/Mini Garden Gift.jpg',
    'assets/img/items/other/s3.jpg',
    'assets/img/items/other/c6.jpg',
];
foreach ($tests as $path) {
    $full = __DIR__ . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    $exists = is_file($full);
    echo "$path => " . ($exists ? 'EXISTS' : 'MISSING') . " ($full)\n";
}
?>
