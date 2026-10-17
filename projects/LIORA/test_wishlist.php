<?php
session_start();
$_SESSION['user_id'] = 1;
$_REQUEST['action'] = 'toggle';
$_REQUEST['product_id'] = '40'; // Using a valid product ID

// Simulate the request
header('Content-Type: application/json');
require_once 'config.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

function sendResponse($data) {
    echo json_encode($data);
    exit;
}

function productExists($conn, $productId) {
    if ($productId <= 0) {
        return false;
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

function getWishlistItems($conn, $userId) {
    if ($userId > 0) {
        $stmt = $conn->prepare('SELECT product_id FROM wishlist_items WHERE user_id = ? ORDER BY added_at DESC');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = $row['product_id'];
        }
        $stmt->close();
        return $items;
    }

    return getSessionWishlist();
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

echo "Testing wishlist with user_id=$userId, action=$action\n";
echo "Product 1 exists: " . (productExists($conn, 1) ? "YES" : "NO") . "\n";

if ($action === 'toggle') {
    $productId = intval($_REQUEST['product_id']);
    echo "Testing toggle for product_id=$productId\n";
    
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
?>
