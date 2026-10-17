<?php
function testParse($image) {
    $path = parse_url($image, PHP_URL_PATH);
    var_export($image);
    echo " => path: ";
    var_export($path);
    echo "\n";
}
testParse('assets/img/items/roses/rose_1.jpg');
testParse('/assets/img/items/roses/rose_1.jpg');
testParse('http://localhost/LIORA/assets/img/items/roses/rose_1.jpg');
testParse('./assets/img/items/roses/rose_1.jpg');
testParse('assets\\img\\items\\roses\\rose_1.jpg');
?>
