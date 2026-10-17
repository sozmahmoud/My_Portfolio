<?php
// Mock script dir for testing
$_SERVER['SCRIPT_NAME'] = '/LIORA/cart_action.php';
$_SERVER['SCRIPT_FILENAME'] = 'C:\xampp\htdocs\LIORA\cart_action.php';

function normalizeImagePath($image) {
    $image = trim((string) $image);
    if (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?/#i', $image)) {
        $path = parse_url($image, PHP_URL_PATH);
        if ($path) {
            $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
            if ($scriptDir && $scriptDir !== '/' && strpos($path, $scriptDir) === 0) {
                $path = substr($path, strlen($scriptDir));
            }
            $path = ltrim($path, '/');
            return $path;
        }
    }
    return $image;
}

$tests = [
    'http://localhost/LIORA/assets/img/items/roses/rose_10.jpg',
    'http://localhost/assets/img/items/roses/rose_10.jpg',
    'http://127.0.0.1/LIORA/assets/img/test.jpg',
    'assets/img/items/roses/rose_1.jpg',
];
foreach ($tests as $t) {
    echo $t . ' => ' . normalizeImagePath($t) . "\n";
}
?>
