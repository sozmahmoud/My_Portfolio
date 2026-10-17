<?php
/**
 * ===================================
 * WISHLIST ACTION HANDLER
 * Manages wishlist items for logged-in users
 * ===================================
 */
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';
require_once 'map_product_id.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.'], JSON_UNESCAPED_UNICODE);
    exit;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

function sendResponse($data) {
    echo json_encode($data);
    exit;
}

function getStaticWishlistProducts() {
    $products = [];
    for ($productId = 1; $productId <= 114; $productId++) {
        $product = getStaticProductById($productId);
        if ($product) {
            $products[$productId] = $product;
        }
    }
    return $products;
}

function ensureStaticProductExists($conn, $product) {
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

    $id = intval($product['id']);
    $name = $product['name'];
    $price = floatval($product['price']);
    $image = $product['image'];
    $category = $product['category'];
    $stmt->bind_param('isdss', $id, $name, $price, $image, $category);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

function getPostedProductSnapshot($productId) {
    $name = trim($_POST['name'] ?? '');
    $price = isset($_POST['price']) ? floatval(preg_replace('/[^0-9.]/', '', (string) $_POST['price'])) : 0;
    $image = trim($_POST['image'] ?? '');
    $category = trim($_POST['category'] ?? '');

    if ($name === '' || $price <= 0 || $image === '') {
        return null;
    }

    return [
        'id' => intval($productId),
        'product_id' => intval($productId),
        'name' => $name,
        'title' => $name,
        'price' => $price,
        'image' => $image,
        'image_url' => $image,
        'category' => $category !== '' ? $category : 'Flowers'
    ];
}

function productExists($conn, $productId) {
    if ($productId <= 0) {
        return false;
    }
    $snapshot = getPostedProductSnapshot($productId);
    if ($snapshot) {
        return ensureStaticProductExists($conn, $snapshot);
    }
    $staticProducts = getStaticWishlistProducts();
    $staticProduct = $staticProducts[$productId] ?? null;
    if ($staticProduct) {
        return ensureStaticProductExists($conn, $staticProduct);
    }
    $staticProduct = getStaticProductById($productId);
    if ($staticProduct) {
        return ensureStaticProductExists($conn, $staticProduct);
    }
    $stmt = $conn->prepare('SELECT id FROM products WHERE id = ? AND is_active = 1');
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result && $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

function getSessionWishlist() {
    if (!isset($_SESSION['wishlist']) || !is_array($_SESSION['wishlist'])) {
        return [];
    }
    return $_SESSION['wishlist'];
}

function saveSessionWishlist(array $wishlist) {
    $_SESSION['wishlist'] = array_values($wishlist);
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

function resolveWishlistImage($rowImage, $staticProduct = null) {
    $staticImage = '';
    if (is_array($staticProduct)) {
        $staticImage = $staticProduct['image'] ?? $staticProduct['image_url'] ?? '';
    }

    if (isUsableProductImage($staticImage)) {
        return $staticImage;
    }

    if (isUsableProductImage($rowImage)) {
        return trim((string) $rowImage);
    }

    return $staticImage ?: trim((string) $rowImage) ?: 'assets/img/first_page.jpg';
}

function getWishlistItems($conn, $userId) {
    $staticProducts = getStaticWishlistProducts();

    if ($userId > 0) {
        $stmt = $conn->prepare(
            'SELECT wi.product_id AS id, wi.options, wi.product_type, wi.variant,
                    p.name, COALESCE(NULLIF(p.sale_price, 0), p.price) AS price, p.image_url AS image, p.category
             FROM wishlist_items wi
             LEFT JOIN products p ON wi.product_id = p.id AND p.is_active = 1
             WHERE wi.user_id = ?
             ORDER BY wi.added_at DESC'
        );
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $productId = intval($row['id']);
            $staticProduct = $staticProducts[$productId] ?? getStaticProductById($productId);

            if (!$row['name'] && $staticProduct) {
                $items[] = $staticProduct;
                continue;
            }

            if (!$row['name']) {
                continue;
            }

            $image = resolveWishlistImage($row['image'] ?? '', $staticProduct);
            $items[] = [
                'id' => $productId,
                'product_id' => $productId,
                'name' => $staticProduct['name'] ?? $row['name'],
                'title' => $staticProduct['title'] ?? $row['name'],
                'price' => isset($staticProduct['price']) ? floatval($staticProduct['price']) : floatval($row['price']),
                'image' => $image,
                'image_url' => $image,
                'category' => $staticProduct['category'] ?? ($row['category'] ?: 'Flowers'),
                'options' => !empty($row['options']) ? json_decode($row['options'], true) : [],
                'product_type' => $row['product_type'] ?? '',
                'variant' => $row['variant'] ?? ''
            ];
        }
        $stmt->close();
        return $items;
    }

    $wishlist = getSessionWishlist();
    if (empty($wishlist)) {
        return [];
    }

    $productIds = array_values(array_filter(array_map('intval', $wishlist), function ($value) {
        return $value > 0;
    }));
    if (empty($productIds)) {
        return [];
    }

    $itemsById = $staticProducts;
    foreach ($productIds as $productId) {
        if (!isset($itemsById[$productId])) {
            $staticProduct = getStaticProductById($productId);
            if ($staticProduct) {
                $itemsById[$productId] = $staticProduct;
            }
        }
    }

    $dbProductIds = array_values(array_filter($productIds, function ($productId) use ($itemsById) {
        return !isset($itemsById[$productId]);
    }));

    if (empty($dbProductIds)) {
        $items = [];
        foreach ($productIds as $productId) {
            if (isset($itemsById[$productId])) {
                $items[] = $itemsById[$productId];
            }
        }
        return $items;
    }

    $idList = implode(',', $dbProductIds);
    $result = $conn->query(
        'SELECT id, name, COALESCE(NULLIF(sale_price, 0), price) AS price, image_url AS image, category
         FROM products
         WHERE id IN (' . $idList . ') AND is_active = 1'
    );

    while ($row = $result->fetch_assoc()) {
        $productId = intval($row['id']);
        $staticProduct = getStaticProductById($productId);
        $image = resolveWishlistImage($row['image'] ?? '', $staticProduct);
        $itemsById[$productId] = [
            'id' => $productId,
            'product_id' => $productId,
            'name' => $staticProduct['name'] ?? $row['name'],
            'title' => $staticProduct['title'] ?? $row['name'],
            'price' => isset($staticProduct['price']) ? floatval($staticProduct['price']) : floatval($row['price']),
            'image' => $image,
            'image_url' => $image,
            'category' => $staticProduct['category'] ?? ($row['category'] ?: 'Flowers')
        ];
    }

    $items = [];
    foreach ($productIds as $productId) {
        if (isset($itemsById[$productId])) {
            $items[] = $itemsById[$productId];
        }
    }
    return $items;
}

function getWishlistCount($conn, $userId) {
    if ($userId > 0) {
        $stmt = $conn->prepare('SELECT COUNT(*) AS total FROM wishlist_items WHERE user_id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return intval($result['total'] ?? 0);
    }

    return count(getSessionWishlist());
}

function resolveProductId($rawProductId) {
    if ($rawProductId === null) {
        return 0;
    }

    $rawProductId = trim((string) $rawProductId);
    if ($rawProductId === '') {
        return 0;
    }

    if (ctype_digit($rawProductId) && intval($rawProductId) > 0) {
        return intval($rawProductId);
    }

    $mapped = mapProductId($rawProductId);
    return is_int($mapped) ? $mapped : 0;
}

if ($action === 'get') {
    $items = getWishlistItems($conn, $userId);
    sendResponse([
        'success' => true,
        'items' => $items,
        'total_items' => getWishlistCount($conn, $userId),
        'logged_in' => $userId > 0
    ]);
}

if ($action === 'count') {
    sendResponse([
        'success' => true,
        'count' => getWishlistCount($conn, $userId),
        'logged_in' => $userId > 0
    ]);
}

$productId = resolveProductId($_REQUEST['product_id'] ?? null);

if ($action === 'toggle') {
    if ($productId <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid product.']);
    }

    if (!productExists($conn, $productId)) {
        sendResponse(['success' => false, 'message' => 'Product does not exist.']);
    }

    if ($userId > 0) {
        $stmt = $conn->prepare('SELECT id FROM wishlist_items WHERE user_id = ? AND product_id = ?');
        $stmt->bind_param('ii', $userId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $exists = $result->num_rows > 0;
        $stmt->close();

        if ($exists) {
            $stmt = $conn->prepare('DELETE FROM wishlist_items WHERE user_id = ? AND product_id = ?');
            $stmt->bind_param('ii', $userId, $productId);
            $stmt->execute();
            $stmt->close();
            $actionResult = 'removed';
        } else {
            $stmt = $conn->prepare('INSERT INTO wishlist_items (user_id, product_id) VALUES (?, ?)');
            $stmt->bind_param('ii', $userId, $productId);
            $stmt->execute();
            $stmt->close();
            $actionResult = 'added';
        }
    } else {
        $wishlist = getSessionWishlist();
        $index = array_search($productId, $wishlist, true);
        if ($index !== false) {
            unset($wishlist[$index]);
            $actionResult = 'removed';
        } else {
            $wishlist[] = $productId;
            $actionResult = 'added';
        }
        saveSessionWishlist($wishlist);
    }

    $items = getWishlistItems($conn, $userId);
    sendResponse([
        'success' => true,
        'action' => $actionResult,
        'items' => $items,
        'total_items' => getWishlistCount($conn, $userId),
        'logged_in' => $userId > 0
    ]);
}

if ($action === 'get') {
    $items = getWishlistItems($conn, $userId);
    sendResponse([
        'success' => true,
        'items' => $items,
        'total_items' => getWishlistCount($conn, $userId),
        'logged_in' => $userId > 0
    ]);
}

if ($action === 'count') {
    sendResponse([
        'success' => true,
        'count' => getWishlistCount($conn, $userId),
        'logged_in' => $userId > 0
    ]);
}

if ($action === 'add') {
    if ($productId <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid product.']);
    }

    if (!productExists($conn, $productId)) {
        sendResponse(['success' => false, 'message' => 'Product does not exist.']);
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

        $stmt = $conn->prepare('INSERT INTO wishlist_items (user_id, product_id, options, product_type, variant) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE options = VALUES(options), product_type = VALUES(product_type), variant = VALUES(variant)');
        if ($stmt) {
            $stmt->bind_param('iisss', $userId, $productId, $options, $productType, $variant);
            if (!$stmt->execute()) {
                sendResponse(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
            }
            $stmt->close();
        } else {
            sendResponse(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        }
    } else {
        $wishlist = getSessionWishlist();
        if (!in_array($productId, $wishlist, true)) {
            $wishlist[] = $productId;
            saveSessionWishlist($wishlist);
        }
    }

    $items = getWishlistItems($conn, $userId);
    sendResponse([
        'success' => true,
        'items' => $items,
        'total_items' => getWishlistCount($conn, $userId),
        'logged_in' => $userId > 0
    ]);
}

if ($action === 'remove') {
    if ($productId <= 0) {
        sendResponse(['success' => false, 'message' => 'Invalid product.']);
    }

    if ($userId > 0) {
        $stmt = $conn->prepare('DELETE FROM wishlist_items WHERE user_id = ? AND product_id = ?');
        $stmt->bind_param('ii', $userId, $productId);
        $stmt->execute();
        $stmt->close();
    } else {
        $wishlist = getSessionWishlist();
        $wishlist = array_values(array_filter($wishlist, function ($value) use ($productId) {
            return $value !== $productId;
        }));
        saveSessionWishlist($wishlist);
    }

    $items = getWishlistItems($conn, $userId);
    sendResponse([
        'success' => true,
        'items' => $items,
        'total_items' => getWishlistCount($conn, $userId),
        'logged_in' => $userId > 0
    ]);
}

if ($action === 'clear') {
    // ONLY clear wishlist, never touch cart
    if ($userId > 0) {
        $stmt = $conn->prepare('DELETE FROM wishlist_items WHERE user_id = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $stmt->close();
    } else {
        saveSessionWishlist([]);
    }

    // Return only wishlist data, never cart data
    sendResponse([
        'success' => true,
        'items' => [],
        'total_items' => 0,
        'logged_in' => $userId > 0,
        'action' => 'clear'
    ]);
}

sendResponse(['success' => false, 'message' => 'Invalid action.']);
?>
