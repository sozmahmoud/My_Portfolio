<?php
/**
 * ===================================
 * GET REVIEWS - Fetch Product Reviews
 * ===================================
 */
session_start();
header('Content-Type: application/json; charset=utf-8');

include 'config.php';
require_once 'map_product_id.php';

// Resolve product ID from string slug or numeric ID
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

$product_id = resolveProductId($_GET['product_id'] ?? 0);

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product', 'reviews' => []]);
    exit();
}

// Fetch all reviews for this product with user information
$query = "
    SELECT 
        r.id,
        r.rating,
        r.comment,
        r.created_at,
        u.username,
        u.first_name,
        u.last_name
    FROM reviews r
    JOIN users u ON r.user_id = u.id
    WHERE r.product_id = ?
    ORDER BY r.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

$reviews = [];
while ($row = $result->fetch_assoc()) {
    // Format date nicely
    $date = new DateTime($row['created_at']);
    $formattedDate = $date->format('M d, Y');
    
    $reviews[] = [
        'id' => $row['id'],
        'username' => $row['username'],
        'full_name' => trim($row['first_name'] . ' ' . $row['last_name']),
        'rating' => $row['rating'],
        'comment' => $row['comment'],
        'date' => $formattedDate,
        'raw_date' => $row['created_at']
    ];
}

echo json_encode(['success' => true, 'reviews' => $reviews]);
?>
