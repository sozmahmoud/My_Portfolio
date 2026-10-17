<?php
/**
 * ===================================
 * REVIEW HANDLER - Submit Reviews
 * ===================================
 */
session_start();
header('Content-Type: application/json; charset=utf-8');

// Check if user is logged in
if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to submit a review']);
    exit();
}

// Include database config
include 'config.php';
require_once 'map_product_id.php';

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

function ensureReviewProductExists($conn, $productId) {
    $product = getStaticProductById($productId);
    if (!$product) {
        return false;
    }

    $stmt = $conn->prepare(
        'INSERT INTO products (id, name, price, sale_price, image_url, category, is_active)
         VALUES (?, ?, ?, NULL, ?, ?, 1)
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
    $image = $product['image'] ?? '';
    $category = $product['category'] ?? 'Flowers';
    $stmt->bind_param('isdss', $productId, $name, $price, $image, $category);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

// Get request data
$action = $_POST['action'] ?? '';
$product_id = resolveProductId($_POST['product_id'] ?? null);
$rating = intval($_POST['rating'] ?? 0);
$comment = trim($_POST['comment'] ?? '');
$user_id = intval($_SESSION['user_id']);

// Validate input
if ($action !== 'submit') {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit();
}

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product']);
    exit();
}

// Check if product exists
$productCheckQuery = "SELECT id FROM products WHERE id = ? AND is_active = 1";
$productCheckStmt = $conn->prepare($productCheckQuery);
if (!$productCheckStmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}
$productCheckStmt->bind_param("i", $product_id);
$productCheckStmt->execute();
$productCheckResult = $productCheckStmt->get_result();
if ($productCheckResult->num_rows === 0) {
    $productCheckStmt->close();
    if (!ensureReviewProductExists($conn, $product_id)) {
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit();
    }
} else {
    $productCheckStmt->close();
}

if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'Rating must be between 1 and 5']);
    exit();
}

// Check if user already reviewed this product
$checkQuery = "SELECT id FROM reviews WHERE user_id = ? AND product_id = ?";
$checkStmt = $conn->prepare($checkQuery);
if (!$checkStmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}
$checkStmt->bind_param("ii", $user_id, $product_id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // Update existing review
    $updateQuery = "UPDATE reviews SET rating = ?, comment = ?, created_at = NOW() WHERE user_id = ? AND product_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    if (!$updateStmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        $checkStmt->close();
        exit();
    }
    $updateStmt->bind_param("isii", $rating, $comment, $user_id, $product_id);
    
    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Review updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating review: ' . $updateStmt->error]);
    }
    $updateStmt->close();
} else {
    // Insert new review
    $insertQuery = "INSERT INTO reviews (user_id, product_id, rating, comment, created_at) VALUES (?, ?, ?, ?, NOW())";
    $insertStmt = $conn->prepare($insertQuery);
    if (!$insertStmt) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        $checkStmt->close();
        exit();
    }
    $insertStmt->bind_param("iiis", $user_id, $product_id, $rating, $comment);
    
    if ($insertStmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Review submitted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error submitting review: ' . $insertStmt->error]);
    }
    $insertStmt->close();
}
$checkStmt->close();
?>
