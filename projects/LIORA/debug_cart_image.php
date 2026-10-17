<?php
session_start();
require 'config.php';
require_once 'map_product_id.php';

// Simulate what happens in resolveCartImage
function isUsableProductImage($image) {
    $image = trim((string) $image);
    if ($image === '') return false;
    if (preg_match('/^(https?:)?\/\//i', $image) || strpos($image, 'data:') === 0) return true;
    $path = parse_url($image, PHP_URL_PATH);
    if (!$path) return false;
    $path = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path), DIRECTORY_SEPARATOR);
    return is_file(__DIR__ . DIRECTORY_SEPARATOR . $path);
}

function resolveCartImage($rowImage, $staticProduct = null, $snapshot = null) {
    $staticImage = is_array($staticProduct) ? ($staticProduct['image'] ?? $staticProduct['image_url'] ?? '') : '';
    $snapshotImage = is_array($snapshot) ? ($snapshot['image'] ?? $snapshot['image_url'] ?? '') : '';

    foreach ([$staticImage, $snapshotImage, $rowImage] as $image) {
        if (isUsableProductImage($image)) {
            return trim((string) $image);
        }
    }

    return $staticImage ?: $snapshotImage ?: trim((string) $rowImage) ?: 'assets/img/first_page.jpg';
}

// Test with a known product (id 8 = Soft Pink Ribbon Roses)
// Check what getStaticProductById returns
$productId = 8;
$staticProduct = getStaticProductById($productId);
echo "Static product for ID $productId:\n";
print_r($staticProduct);

// Check what database row would have
$stmt = $conn->prepare('SELECT id, name, COALESCE(sale_price, price) AS price, image_url AS image, category FROM products WHERE id = ? AND is_active = 1');
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
echo "\nDatabase row for ID $productId:\n";
print_r($row);

// Check session snapshot
session_start();
$_SESSION['cart_product_snapshots'] = $_SESSION['cart_product_snapshots'] ?? [];
$snapshot = $_SESSION['cart_product_snapshots'][$productId] ?? null;
echo "\nSession snapshot for ID $productId:\n";
print_r($snapshot);

// Simulate buildCartItem
$built = [
    'image_from_resolve' => resolveCartImage($row['image'] ?? '', $staticProduct, $snapshot),
];
echo "\nResolved image:\n";
print_r($built);

// Now test adding to cart
$form = new stdClass();
$form->action = 'add';
$form->product_id = $productId;
$form->quantity = 1;
$form->name = $staticProduct['name'] ?? 'Test';
$form->price = $staticProduct['price'] ?? 0;
$form->image = $staticProduct['image'] ?? '';
$form->category = $staticProduct['category'] ?? 'Flowers';
$form->link = $staticProduct['link'] ?? '';

echo "\n\nSimulated POST snapshot data:\n";
print_r([
    'name' => $form->name,
    'price' => $form->price,
    'image' => $form->image,
    'category' => $form->category,
    'link' => $form->link,
]);
?>
