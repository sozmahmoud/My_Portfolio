<?php
session_start();
require_once 'config.php';

echo "<h2>🔍 Calendar Toggle System Test</h2>";

// Check if user is logged in
$userId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($userId <= 0) {
    echo "<p style='color: red;'>❌ Not logged in! Please log in first to test.</p>";
    exit;
}

echo "<p>✅ Logged in as User ID: <strong>$userId</strong></p>";

// Check database connection
if (!$conn || $conn->connect_error) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $conn->connect_error . "</p>";
    exit;
}

echo "<p>✅ Database connected</p>";

// Check if table exists
$result = $conn->query("SHOW TABLES LIKE 'user_special_dates'");
if ($result && $result->num_rows > 0) {
    echo "<p>✅ Table 'user_special_dates' exists</p>";
} else {
    echo "<p style='color: orange;'>⚠️ Table 'user_special_dates' doesn't exist yet (will be created on first use)</p>";
}

// Get all special dates for this user
$stmt = $conn->prepare("SELECT id, event_name, event_date, occasion_type, created_at FROM user_special_dates WHERE user_id = ? ORDER BY event_date ASC");
if ($stmt) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<h3>📅 Your Special Dates in Database:</h3>";
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Event Name</th><th>Date</th><th>Type</th><th>Created At</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['occasion_type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No special dates saved yet.</p>";
    }
    
    $stmt->close();
}

// Check for duplicate dates
$stmt = $conn->prepare("SELECT event_date, COUNT(*) as count FROM user_special_dates WHERE user_id = ? GROUP BY event_date HAVING count > 1");
if ($stmt) {
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<h3 style='color: red;'>⚠️ WARNING - Duplicate Dates Found:</h3>";
        while ($row = $result->fetch_assoc()) {
            echo "<p>Date <strong>" . htmlspecialchars($row['event_date']) . "</strong> appears <strong>" . $row['count'] . "</strong> times in the database!</p>";
        }
    } else {
        echo "<p>✅ No duplicate dates found - database is clean!</p>";
    }
    
    $stmt->close();
}

echo "<hr>";
echo "<h3>📋 Test Instructions:</h3>";
echo "<ol>";
echo "<li>Go to <a href='calendar.php'>Calendar Page</a></li>";
echo "<li>Click on a day (e.g., day 19 in May)</li>";
echo "<li>Check if it appears in 'My Selected Flower Moments'</li>";
echo "<li>Click the same day again - it should disappear and remove from the list</li>";
echo "<li>Come back here to verify the database</li>";
echo "</ol>";
?>
