<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'config.php';

if (!$conn || $conn->connect_error) {
    echo json_encode(['success' => false, 'reminders' => []]);
    exit;
}

$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

// If not logged in, return empty reminders
if ($userId <= 0) {
    echo json_encode(['success' => true, 'reminders' => []]);
    exit;
}

// Get today's date in YYYY-MM-DD format
$today = date('Y-m-d');

// Query reminders that match today's date
$stmt = $conn->prepare(
    'SELECT id, event_name, event_date, occasion_type
     FROM user_special_dates
     WHERE user_id = ? AND event_date = ?
     ORDER BY created_at DESC'
);

if (!$stmt) {
    echo json_encode(['success' => false, 'reminders' => []]);
    exit;
}

$stmt->bind_param('is', $userId, $today);
$stmt->execute();
$result = $stmt->get_result();
$reminders = [];

while ($row = $result->fetch_assoc()) {
    $fullTitle = $row['event_name'];
    $occ = $row['occasion_type'] ?? '';
    if (!empty($occ) && strtolower($occ) !== 'special moment' && strtolower($occ) !== 'other') {
        $fullTitle .= ' ' . $occ;
    }
    
    $reminders[] = [
        'id' => intval($row['id']),
        'title' => $fullTitle,
        'date' => $row['event_date']
    ];
}

$stmt->close();

echo json_encode([
    'success' => true,
    'reminders' => $reminders,
    'count' => count($reminders)
]);
?>
