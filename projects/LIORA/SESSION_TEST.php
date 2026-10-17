<?php
/**
 * ===================================
 * SESSION DIAGNOSTIC TEST
 * ===================================
 * This file helps verify that session handling is working correctly
 * after the session fix. Access via: http://localhost/LIORA/SESSION_TEST.php
 */

session_start();

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Session Test - LIORA</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h1 { color: #d81b60; }
        .test { margin: 15px 0; padding: 15px; border-left: 4px solid #ddd; }
        .test.pass { border-left-color: #27ae60; background: #f0fdf4; }
        .test.fail { border-left-color: #e74c3c; background: #fdf4f4; }
        .test.info { border-left-color: #3498db; background: #f0f8ff; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .status { font-weight: bold; }
        .pass .status { color: #27ae60; }
        .fail .status { color: #e74c3c; }
        .info .status { color: #3498db; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌸 LIORA Session Diagnostic Test</h1>
        <p>This test verifies that your session handling is working correctly.</p>

        <?php
        // Test 1: Session active
        echo '<div class="test info">';
        echo '<span class="status">ℹ️ Session Status:</span> ';
        if (session_status() === PHP_SESSION_ACTIVE) {
            echo 'ACTIVE ✓';
        } else {
            echo 'NOT ACTIVE (Status: ' . session_status() . ')';
        }
        echo '</div>';

        // Test 2: Session ID
        echo '<div class="test info">';
        echo '<span class="status">ℹ️ Session ID:</span> ';
        echo htmlspecialchars(session_id());
        echo '</div>';

        // Test 3: Check if user is logged in
        $isLoggedIn = !empty($_SESSION['user_id']);
        echo '<div class="test ' . ($isLoggedIn ? 'pass' : 'fail') . '">';
        echo '<span class="status">' . ($isLoggedIn ? '✓ User Logged In:' : '✗ User NOT Logged In:') . '</span> ';
        if ($isLoggedIn) {
            echo 'User ID = ' . htmlspecialchars($_SESSION['user_id']);
            echo ' | Username = ' . htmlspecialchars($_SESSION['username'] ?? 'N/A');
            echo ' | Email = ' . htmlspecialchars($_SESSION['email'] ?? 'N/A');
        } else {
            echo 'No session data found. Please <a href="login-register.php">login</a> first.';
        }
        echo '</div>';

        // Test 4: Session data
        if ($isLoggedIn) {
            echo '<div class="test pass">';
            echo '<span class="status">✓ Session Data:</span><br>';
            echo '<pre>';
            echo 'user_id: ' . htmlspecialchars($_SESSION['user_id'] ?? 'NOT SET') . "\n";
            echo 'username: ' . htmlspecialchars($_SESSION['username'] ?? 'NOT SET') . "\n";
            echo 'email: ' . htmlspecialchars($_SESSION['email'] ?? 'NOT SET') . "\n";
            echo 'first_name: ' . htmlspecialchars($_SESSION['first_name'] ?? 'NOT SET') . "\n";
            echo '</pre>';
            echo '</div>';

            // Test 5: Database connection
            require_once 'config.php';
            if ($conn && !$conn->connect_error) {
                echo '<div class="test pass">';
                echo '<span class="status">✓ Database Connected</span>';
                echo '</div>';

                // Test 6: Verify user in database
                $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id = ?");
                $userId = intval($_SESSION['user_id']);
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    echo '<div class="test pass">';
                    echo '<span class="status">✓ User Found in Database:</span><br>';
                    echo 'ID: ' . htmlspecialchars($user['id']) . '<br>';
                    echo 'Username: ' . htmlspecialchars($user['username']) . '<br>';
                    echo 'Email: ' . htmlspecialchars($user['email']);
                    echo '</div>';
                } else {
                    echo '<div class="test fail">';
                    echo '<span class="status">✗ User NOT Found in Database</span>';
                    echo '</div>';
                }
                $stmt->close();
            } else {
                echo '<div class="test fail">';
                echo '<span class="status">✗ Database Connection Failed</span>';
                echo '</div>';
            }
        }

        // Test 7: Instructions
        echo '<div class="test info">';
        echo '<span class="status">📋 How to Test:</span><br>';
        echo '<ol>';
        echo '<li>If you see "✗ User NOT Logged In", <a href="login-register.php">login here</a> first</li>';
        echo '<li>After login, you should see "✓ User Logged In" above</li>';
        echo '<li>Navigate to other pages (accounts.php, cart.php, wishlist.php) - session should persist</li>';
        echo '<li>Logout and the session should be cleared</li>';
        echo '</ol>';
        echo '</div>';

        // Test 8: Links to test pages
        echo '<div class="test info">';
        echo '<span class="status">🔗 Quick Links:</span><br>';
        echo '<ul>';
        echo '<li><a href="accounts.php">My Account</a> (should show user info if logged in)</li>';
        echo '<li><a href="cart.php">Shopping Cart</a> (should allow cart actions if logged in)</li>';
        echo '<li><a href="wishlist.php">Wishlist</a> (should allow wishlist actions if logged in)</li>';
        echo '<li><a href="login-register.php">Login/Register</a></li>';
        echo '<li><a href="index.php">Home Page</a></li>';
        echo '</ul>';
        echo '</div>';
        ?>
    </div>
</body>
</html>
