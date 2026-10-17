<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include 'config.php';
require_once 'map_product_id.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.'], JSON_UNESCAPED_UNICODE);
    exit;
}

function resolveProductId($rawProductId) {
    if ($rawProductId === null || $rawProductId === '') {
        return 0;
    }
    if (is_numeric($rawProductId) && intval($rawProductId) > 0) {
        return intval($rawProductId);
    }
    $mapped = mapProductId($rawProductId);
    return is_int($mapped) ? $mapped : 0;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

function sendResponse($data) {
    echo json_encode($data);
    exit;
}

function getSessionCart() {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        return [];
    }
    return $_SESSION['cart'];
}

function saveSessionCart(array $cart) {
    $_SESSION['cart'] = $cart;
}

function rememberProductSnapshot($productId, $product) {
    if (!$product || $productId <= 0) {
        return;
    }

    if (!isset($_SESSION['cart_product_snapshots']) || !is_array($_SESSION['cart_product_snapshots'])) {
        $_SESSION['cart_product_snapshots'] = [];
    }

    $_SESSION['cart_product_snapshots'][intval($productId)] = $product;
}

function getSessionProductSnapshot($productId) {
    if (!isset($_SESSION['cart_product_snapshots']) || !is_array($_SESSION['cart_product_snapshots'])) {
        return null;
    }

    $productId = intval($productId);
    return $_SESSION['cart_product_snapshots'][$productId] ?? null;
}

function normalizeCartLink($link, $productId) {
    $link = trim((string) $link);
    if ($link !== '') {
        $path = parse_url($link, PHP_URL_PATH);
        $query = parse_url($link, PHP_URL_QUERY);
        $basename = $path ? basename($path) : '';

        if (in_array($basename, ['details.php', 'giftdetail.php'], true) && $query) {
            parse_str($query, $params);
            if (!empty($params['id'])) {
                return $basename . '?id=' . rawurlencode((string) $params['id']);
            }
        }

        if (preg_match('/^(details|giftdetail)\.php\?id=([^&\s]+)/i', $link, $matches)) {
            return strtolower($matches[1]) . '.php?id=' . rawurlencode($matches[2]);
        }
    }

    return 'details.php?id=' . rawurlencode(getStringId($productId));
}

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
    return is_file(__DIR__ . DIRECTORY_SEPARATOR . $path);
}

function normalizeImagePath($image) {
    $image = trim((string) $image);
    // Convert absolute localhost URLs to relative paths
    if (preg_match('#^https?://(localhost|127\.0\.0\.1)(:\d+)?/#i', $image)) {
        $path = parse_url($image, PHP_URL_PATH);
        if ($path) {
            // Determine base path from script's URL directory
            $scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
            // Remove base directory prefix if present
            if ($scriptDir && $scriptDir !== '/' && strpos($path, $scriptDir) === 0) {
                $path = substr($path, strlen($scriptDir));
            }
            // Remove leading slashes to make relative
            $path = ltrim($path, '/');
            return $path;
        }
    }
    return $image;
}

function resolveCartImage($rowImage, $staticProduct = null, $snapshot = null) {
    $staticImage = is_array($staticProduct) ? ($staticProduct['image'] ?? $staticProduct['image_url'] ?? '') : '';
    $snapshotImage = is_array($snapshot) ? ($snapshot['image'] ?? $snapshot['image_url'] ?? '') : '';

    // Priority: row (DB) first, then snapshot, then static catalog
    foreach ([$rowImage, $snapshotImage, $staticImage] as $image) {
        if (isUsableProductImage($image)) {
            $normalized = normalizeImagePath($image);
            return trim((string) $normalized);
        }
    }

    // None are usable, return safe fallback
    return 'assets/img/first_page.jpg';
}

function resolveCartLink($productId, $staticProduct = null, $snapshot = null) {
    if (is_array($snapshot) && !empty($snapshot['link'])) {
        return normalizeCartLink($snapshot['link'], $productId);
    }

    if (is_array($staticProduct) && !empty($staticProduct['link'])) {
        return normalizeCartLink($staticProduct['link'], $productId);
    }

    return normalizeCartLink('', $productId);
}

function buildCartItem($productId, $quantity, $row = [], $staticProduct = null, $snapshot = null) {
    $rowName = $row['name'] ?? '';
    $rowPrice = $row['price'] ?? 0;
    $rowImage = $row['image'] ?? ($row['image_url'] ?? '');
    $rowCategory = $row['category'] ?? '';

    // Name priority: DB row first, then snapshot, then static catalog
    $name = $rowName ?: '';
    if ($name === '' && is_array($snapshot)) {
        $name = $snapshot['name'] ?? $snapshot['title'] ?? '';
    }
    if ($name === '') {
        $name = $staticProduct['name'] ?? $staticProduct['title'] ?? 'Product';
    }
    $price = isset($staticProduct['price'])
        ? floatval($staticProduct['price'])
        : (isset($snapshot['price']) ? floatval($snapshot['price']) : floatval($rowPrice));
    $image = resolveCartImage($rowImage, $staticProduct, $snapshot);
    // Category priority: DB row, then snapshot, then static
    $category = $rowCategory ?: '';
    if ($category === '' && is_array($snapshot)) {
        $category = $snapshot['category'] ?? '';
    }
    if ($category === '') {
        $category = $staticProduct['category'] ?? 'Flowers';
    }
    $link = resolveCartLink($productId, $staticProduct, $snapshot);
    $options = [];
    $productType = '';
    $variant = '';

    // Database values take priority for existing items
    if (!empty($row['options'])) {
        $options = normalizeCartOptions($row['options']);
    }
    if (!empty($row['product_type'])) {
        $productType = trim((string)$row['product_type']);
    }
    if (!empty($row['variant'])) {
        $variant = trim((string)$row['variant']);
    }

    // Fallback to snapshot if database values are empty
    if (empty($options) && is_array($snapshot)) {
        $options = normalizeCartOptions($snapshot['options'] ?? []);
    }
    if ($productType === '' && is_array($snapshot)) {
        $productType = trim((string) ($snapshot['product_type'] ?? ''));
    }
    if ($variant === '' && is_array($snapshot)) {
        $variant = trim((string) ($snapshot['variant'] ?? ''));
    }

    if ($productType !== '' && !cartOptionExists($options, 'Product Type')) {
        array_unshift($options, ['label' => 'Product Type', 'value' => $productType]);
    }
    if ($variant !== '' && !cartOptionExists($options, 'Variant')) {
        $options[] = ['label' => 'Variant', 'value' => $variant];
    }

    return [
        'id' => $productId,
        'product_id' => $productId,
        'quantity' => intval($quantity),
        'name' => $name,
        'title' => $name,
        'price' => $price,
        'image' => $image,
        'image_url' => $image,
        'category' => $category,
        'product_type' => $productType,
        'variant' => $variant,
        'options' => $options,
        'link' => $link
    ];
}

function normalizeCartOptions($options) {
    if (is_string($options) && $options !== '') {
        $decoded = json_decode($options, true);
        $options = is_array($decoded) ? $decoded : [];
    }

    if (!is_array($options)) {
        return [];
    }

    $normalized = [];
    foreach ($options as $key => $option) {
        if (is_array($option)) {
            $label = trim((string) ($option['label'] ?? $option['name'] ?? ''));
            $value = trim((string) ($option['value'] ?? $option['text'] ?? ''));
        } else {
            $label = is_string($key) ? trim($key) : '';
            $value = trim((string) $option);
        }

        if ($label !== '' && $value !== '') {
            $normalized[] = ['label' => $label, 'value' => $value];
        }
    }

    return $normalized;
}

function cartOptionExists($options, $label) {
    foreach ($options as $option) {
        if (strcasecmp($option['label'] ?? '', $label) === 0) {
            return true;
        }
    }

    return false;
}

function getPostedProductSnapshot($productId) {
    $name = trim($_POST['name'] ?? '');
    $price = isset($_POST['price']) ? floatval(preg_replace('/[^0-9.]/', '', (string) $_POST['price'])) : 0;
    $image = trim($_POST['image'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $link = normalizeCartLink($_POST['link'] ?? '', $productId);
    $options = normalizeCartOptions($_POST['options'] ?? []);
    $productType = trim($_POST['product_type'] ?? '');
    $variant = trim($_POST['variant'] ?? '');

    if ($name === '' || $price <= 0 || $image === '') {
        return null;
    }

    return [
        'id' => intval($productId),
        'name' => $name,
        'title' => $name,
        'price' => $price,
        'image' => $image,
        'image_url' => $image,
        'category' => $category !== '' ? $category : 'Flowers',
        'product_type' => $productType,
        'variant' => $variant,
        'options' => $options,
        'link' => $link
    ];
}

function saveProductSnapshot($conn, $productId, $product) {
    if (!$product) {
        return false;
    }

    $stmt = $conn->prepare(
        'INSERT INTO products (id, name, price, sale_price, image_url, category, is_active)
         VALUES (?, ?, ?, 0.00, ?, ?, 1)
         ON DUPLICATE KEY UPDATE
            name = VALUES(name),
            price = VALUES(price),
            image_url = VALUES(image_url),
            category = VALUES(category),
            is_active = 1'
    );
    if (!$stmt) {
        return false;
    }
    $name = $product['name'] ?? $product['title'] ?? 'Product';
    $price = floatval($product['price'] ?? 0);
    $image = $product['image'] ?? $product['image_url'] ?? '';
    $category = $product['category'] ?? 'Flowers';
    $stmt->bind_param('isdss', $productId, $name, $price, $image, $category);
    $success = $stmt->execute();
    $stmt->close();

    return $success;
}

function ensureProductExists($conn, $productId) {
    if ($productId <= 0) {
        return false;
    }

    $postedProduct = getPostedProductSnapshot($productId);
    if ($postedProduct && saveProductSnapshot($conn, $productId, $postedProduct)) {
        rememberProductSnapshot($productId, $postedProduct);
        return true;
    }

    $staticProduct = getStaticProductById($productId);
    if ($staticProduct && saveProductSnapshot($conn, $productId, $staticProduct)) {
        return true;
    }

    $stmt = $conn->prepare('SELECT id FROM products WHERE id = ? AND is_active = 1');
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();

    return $exists;
}

function getCartItems($conn, $userId) {
    if ($userId > 0) {
        $stmt = $conn->prepare(
            'SELECT ci.product_id AS id, ci.quantity, ci.options, ci.product_type, ci.variant,
                    p.name, COALESCE(NULLIF(p.sale_price, 0), p.price) AS price, p.image_url AS image, p.category
             FROM cart_items ci
             LEFT JOIN products p ON ci.product_id = p.id AND p.is_active = 1
             WHERE ci.user_id = ?
             ORDER BY ci.added_at DESC'
        );
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $productId = intval($row['id']);
            $staticProduct = getStaticProductById($productId);
            $snapshot = getSessionProductSnapshot($productId);

            if (!$row['name'] && !$staticProduct && !$snapshot) {
                continue;
            }

            $items[] = buildCartItem($productId, intval($row['quantity']), $row, $staticProduct, $snapshot);
        }
        $stmt->close();
        return $items;
    }

    $sessionCart = getSessionCart();
    if (empty($sessionCart)) {
        return [];
    }

    $productIds = array_map('intval', array_keys($sessionCart));
    $productIds = array_filter($productIds, function ($value) {
        return $value > 0;
    });
    if (empty($productIds)) {
        return [];
    }

    $idList = implode(',', $productIds);
    $result = $conn->query(
        'SELECT id, name, COALESCE(NULLIF(sale_price, 0), price) AS price, image_url AS image, category
         FROM products
         WHERE id IN (' . $idList . ') AND is_active = 1'
    );

    $itemsById = [];
    while ($row = $result->fetch_assoc()) {
        $id = intval($row['id']);
        $itemsById[$id] = buildCartItem($id, intval($sessionCart[$id] ?? 1), $row, null, getSessionProductSnapshot($id));
    }

    $items = [];
    foreach ($productIds as $id) {
        $staticProduct = getStaticProductById($id);
        $snapshot = getSessionProductSnapshot($id);
        if ($staticProduct || $snapshot) {
            $items[] = buildCartItem(
                $id,
                intval($sessionCart[$id] ?? 1),
                $itemsById[$id] ?? [],
                $staticProduct,
                $snapshot
            );
            continue;
        }

        if (isset($itemsById[$id])) {
            $items[] = $itemsById[$id];
        }
    }
    return $items;
}

function getCartCount($conn, $userId) {
    if ($userId > 0) {
        $stmt = $conn->prepare('SELECT COALESCE(SUM(quantity), 0) AS total FROM cart_items WHERE user_id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return intval($result['total'] ?? 0);
    }

    $sessionCart = getSessionCart();
    return array_sum(array_map('intval', $sessionCart));
}

if ($action === 'get') {
    $items = getCartItems($conn, $userId);
    sendResponse(['success' => true, 'items' => $items, 'total_items' => getCartCount($conn, $userId), 'logged_in' => $userId > 0]);
}

if ($action === 'count') {
    sendResponse(['success' => true, 'count' => getCartCount($conn, $userId), 'logged_in' => $userId > 0]);
}

$productId = resolveProductId($_REQUEST['product_id'] ?? null);
$quantity = isset($_REQUEST['quantity']) ? intval($_REQUEST['quantity']) : 1;
$setQuantity = !empty($_REQUEST['set_quantity']) && $_REQUEST['set_quantity'] !== '0';
if ($quantity > 99) {
    $quantity = 99;
}

if ($action === 'add') {
    if ($productId <= 0 || $quantity < 1) {
        sendResponse(['success' => false, 'message' => 'Invalid product or quantity.']);
    }

    if (!ensureProductExists($conn, $productId)) {
        sendResponse(['success' => false, 'message' => 'Product not found.']);
    }

    if ($userId > 0) {
        $options = $_POST['options'] ?? '';
        $productType = $_POST['product_type'] ?? '';
        $variant = $_POST['variant'] ?? '';

        // Set defaults from product data if not provided
        if ($productType === '' || $variant === '') {
            $productStmt = $conn->prepare('SELECT category, color FROM products WHERE id = ?');
            $productStmt->bind_param('i', $productId);
            $productStmt->execute();
            $productResult = $productStmt->get_result();
            if ($productRow = $productResult->fetch_assoc()) {
                if ($productType === '') {
                    $productType = $productRow['category'] ?? '';
                }
                if ($variant === '') {
                    $variant = $productRow['color'] ?? '';
                }
            }
            $productStmt->close();
        }

        $sql = $setQuantity
            ? 'INSERT INTO cart_items (user_id, product_id, quantity, options, product_type, variant) 
               VALUES (?, ?, ?, ?, ?, ?)
               ON DUPLICATE KEY UPDATE 
                  quantity = LEAST(VALUES(quantity), 99),
                  options = VALUES(options),
                  product_type = VALUES(product_type),
                  variant = VALUES(variant)'
            : 'INSERT INTO cart_items (user_id, product_id, quantity, options, product_type, variant) 
               VALUES (?, ?, ?, ?, ?, ?)
               ON DUPLICATE KEY UPDATE 
                  quantity = LEAST(quantity + VALUES(quantity), 99),
                  options = VALUES(options),
                  product_type = VALUES(product_type),
                  variant = VALUES(variant)';
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param('iiisss', $userId, $productId, $quantity, $options, $productType, $variant);
            if (!$stmt->execute()) {
                sendResponse(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            sendResponse(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        }
    } else {
        $cart = getSessionCart();
        $current = isset($cart[$productId]) ? intval($cart[$productId]) : 0;
        $cart[$productId] = $setQuantity ? min(99, $quantity) : min(99, $current + $quantity);
        saveSessionCart($cart);
    }

    $items = getCartItems($conn, $userId);
    sendResponse(['success' => true, 'items' => $items, 'total_items' => getCartCount($conn, $userId), 'logged_in' => $userId > 0]);
}

if ($action === 'update') {
    if ($productId <= 0 || $quantity < 1) {
        sendResponse(['success' => false, 'message' => 'Invalid product or quantity.']);
    }

    if ($userId > 0) {
        $stmt = $conn->prepare('UPDATE cart_items SET quantity = LEAST(?, 99) WHERE user_id = ? AND product_id = ?');
        $stmt->bind_param('iii', $quantity, $userId, $productId);
        $stmt->execute();
        $stmt->close();
    } else {
        $cart = getSessionCart();
        if (isset($cart[$productId])) {
            $cart[$productId] = min(99, $quantity);
            saveSessionCart($cart);
        }
    }

    $items = getCartItems($conn, $userId);
    sendResponse(['success' => true, 'items' => $items, 'total_items' => getCartCount($conn, $userId), 'logged_in' => $userId > 0]);
}

if ($action === 'remove') {
    if ($productId <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid product.']);
    }

    if ($userId > 0) {
        $stmt = $conn->prepare('DELETE FROM cart_items WHERE user_id = ? AND product_id = ?');
        $stmt->bind_param('ii', $userId, $productId);
        $stmt->execute();
        $stmt->close();
    } else {
        $cart = getSessionCart();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            saveSessionCart($cart);
        }
    }

    $items = getCartItems($conn, $userId);
    sendResponse(['success' => true, 'items' => $items, 'total_items' => getCartCount($conn, $userId), 'logged_in' => $userId > 0]);
}

if ($action === 'clear') {
    // ONLY clear cart, never touch wishlist
    if ($userId > 0) {
        $stmt = $conn->prepare('DELETE FROM cart_items WHERE user_id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->close();
    } else {
        saveSessionCart([]);
    }

    // Return only cart data, never wishlist data
    sendResponse(['success' => true, 'items' => [], 'total_items' => 0, 'logged_in' => $userId > 0, 'action' => 'clear']);
}

sendResponse(['success' => false, 'message' => 'Invalid cart action.']);
