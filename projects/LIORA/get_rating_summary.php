<?php
/**
 * ===================================
 * GET RATING SUMMARY - Fetch Average Rating and Breakdown
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
    echo json_encode(['success' => false, 'message' => 'Invalid product']);
    exit();
}

// Fetch average rating and total reviews
$querySummary = "
    SELECT 
        AVG(rating) as average_rating,
        COUNT(*) as total_reviews
    FROM reviews
    WHERE product_id = ?
";

$stmt = $conn->prepare($querySummary);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$resultSummary = $stmt->get_result();
$summary = $resultSummary->fetch_assoc();

$average = $summary['average_rating'] ? round($summary['average_rating'], 2) : 0;
$total = $summary['total_reviews'] ? (int)$summary['total_reviews'] : 0;

// Fetch star breakdown
$queryBreakdown = "
    SELECT 
        rating,
        COUNT(*) as count
    FROM reviews
    WHERE product_id = ?
    GROUP BY rating
";

$stmt = $conn->prepare($queryBreakdown);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$resultBreakdown = $stmt->get_result();

$breakdown = [
    5 => 0,
    4 => 0,
    3 => 0,
    2 => 0,
    1 => 0
];

while ($row = $resultBreakdown->fetch_assoc()) {
    $breakdown[(int)$row['rating']] = (int)$row['count'];
}

echo json_encode([
    'success' => true,
    'average' => $average,
    'total' => $total,
    'breakdown' => $breakdown
]);
?>
