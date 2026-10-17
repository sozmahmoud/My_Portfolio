<?php
/**
 * ===================================
 * GET BATCH RATINGS - Fetch Average Ratings for multiple products
 * ===================================
 */
session_start();
header('Content-Type: application/json; charset=utf-8');

include 'config.php';
require_once 'map_product_id.php';

$ids = $_GET['ids'] ?? '';
if (empty($ids)) {
    echo json_encode(['success' => true, 'ratings' => []]);
    exit();
}

$idArray = explode(',', $ids);
$numericIds = [];

foreach ($idArray as $id) {
    if (is_numeric($id)) {
        $numericIds[] = (int)$id;
    } else {
        $mapped = mapProductId($id);
        if (is_int($mapped)) {
            $numericIds[] = $mapped;
        }
    }
}

if (empty($numericIds)) {
    echo json_encode(['success' => true, 'ratings' => []]);
    exit();
}

// Fetch average ratings for these products
$placeholders = implode(',', array_fill(0, count($numericIds), '?'));
$query = "
    SELECT 
        product_id,
        AVG(rating) as average_rating,
        COUNT(*) as total_reviews
    FROM reviews
    WHERE product_id IN ($placeholders)
    GROUP BY product_id
";

$stmt = $conn->prepare($query);
$stmt->bind_param(str_repeat('i', count($numericIds)), ...$numericIds);
$stmt->execute();
$result = $stmt->get_result();

$ratings = [];
while ($row = $result->fetch_assoc()) {
    $ratings[$row['product_id']] = [
        'average' => round($row['average_rating'], 1),
        'total' => (int)$row['total_reviews']
    ];
}

// Also return the mapping back if they used string IDs
$response = [
    'success' => true,
    'ratings' => $ratings
];

echo json_encode($response);
?>
