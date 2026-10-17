<?php
session_start();
require_once 'config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'stats') {
    // 1. Weekly Sales (last 7 days)
    $weeklySales = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $label = date('D', strtotime($date));
        $res = $conn->query("SELECT SUM(total) FROM orders WHERE DATE(created_at) = '$date' AND status != 'cancelled'");
        $val = $res->fetch_row()[0] ?? 0;
        $weeklySales[] = ['label' => $label, 'value' => (float)$val];
    }

    // 2. Monthly Sales (last 30 days)
    $monthlySales = [];
    for ($i = 29; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $label = date('M d', strtotime($date));
        $res = $conn->query("SELECT SUM(total) FROM orders WHERE DATE(created_at) = '$date' AND status != 'cancelled'");
        $val = $res->fetch_row()[0] ?? 0;
        $monthlySales[] = ['label' => $label, 'value' => (float)$val];
    }

    // 3. Top Products (Weekly - last 7 days)
    $topProductsWeekly = [];
    $resWeekly = $conn->query("
        SELECT p.name, SUM(oi.quantity) as sold 
        FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        JOIN orders o ON oi.order_id = o.id 
        WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
          AND o.status != 'cancelled'
        GROUP BY p.id 
        ORDER BY sold DESC 
        LIMIT 5
    ");
    while ($row = $resWeekly->fetch_assoc()) {
        $topProductsWeekly[] = ['name' => $row['name'], 'sold' => (int)$row['sold']];
    }

    // 3. Top Products (Monthly - last 30 days)
    $topProductsMonthly = [];
    $resMonthly = $conn->query("
        SELECT p.name, SUM(oi.quantity) as sold 
        FROM order_items oi 
        JOIN products p ON oi.product_id = p.id 
        JOIN orders o ON oi.order_id = o.id 
        WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)
          AND o.status != 'cancelled'
        GROUP BY p.id 
        ORDER BY sold DESC 
        LIMIT 5
    ");
    while ($row = $resMonthly->fetch_assoc()) {
        $topProductsMonthly[] = ['name' => $row['name'], 'sold' => (int)$row['sold']];
    }

    echo json_encode([
        'weekly_sales' => $weeklySales,
        'monthly_sales' => $monthlySales,
        'top_weekly' => $topProductsWeekly,
        'top_monthly' => $topProductsMonthly
    ]);
    exit;
}

echo json_encode(['error' => 'Invalid action']);
