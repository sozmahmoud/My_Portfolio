<?php
require 'config.php';
require 'reward_helper.php';

// Find all orders that should have awarded points
$res = $conn->query("SELECT user_id, total, order_number FROM orders WHERE status NOT IN ('cancelled')");
while ($order = $res->fetch_assoc()) {
    $uid = $order['user_id'];
    $total = $order['total'];
    $newPoints = calculatePointsFromAmount($total);
    
    echo "Order {$order['order_number']}: Total \${$total} -> New Points: {$newPoints}\n";
    
    // We'll just clear the reward_points table and re-insert for all orders to be consistent
    // BUT only if they are not redemptions (negative points)
}

// Better: Clear all positive points and re-award based on all non-cancelled orders
$conn->query("DELETE FROM reward_points WHERE points > 0");
$res = $conn->query("SELECT user_id, total FROM orders WHERE status NOT IN ('cancelled')");
while ($order = $res->fetch_assoc()) {
    $pts = calculatePointsFromAmount($order['total']);
    if ($pts > 0) {
        $stmt = $conn->prepare("INSERT INTO reward_points (user_id, points) VALUES (?, ?)");
        $stmt->bind_param('ii', $order['user_id'], $pts);
        $stmt->execute();
        $stmt->close();
    }
}
echo "✓ All positive reward points have been recalculated proportionally!\n";
?>
