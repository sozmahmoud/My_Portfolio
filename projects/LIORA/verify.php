<?php
session_start();
require_once 'config.php';

$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$status = 'pending';
$message = '';

if (empty($token)) {
    $status = 'error';
    $message = '❌ Invalid verification link.';
} else {
    // Check token in DB
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE verification_token = ? AND is_active = 0 LIMIT 1");
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Activate user
        $updateStmt = $conn->prepare("UPDATE users SET is_active = 1, verification_token = NULL WHERE id = ?");
        $updateStmt->bind_param('i', $user['id']);
        
        if ($updateStmt->execute()) {
            $status = 'success';
            $message = "✨ Welcome, {$user['username']}! Your email has been verified.";
        } else {
            $status = 'error';
            $message = '❌ Something went wrong while activating your account. Please try again.';
        }
        $updateStmt->close();
    } else {
        $status = 'error';
        $message = '❌ Invalid or expired verification link.';
    }
    $stmt->close();
}

include 'header.php';
?>

<main class="main">
    <section class="section container">
        <div class="auth-container" style="max-width: 600px; margin: 4rem auto; text-align: center;">
            <div class="auth-box" style="padding: 3rem;">
                <?php if ($status === 'success'): ?>
                    <div style="font-size: 4rem; margin-bottom: 1.5rem;">🎉</div>
                    <h2 class="section__title">Verified! 🌸</h2>
                    <p class="auth-subtitle" style="margin-bottom: 2rem;"><?php echo $message; ?></p>
                    <a href="login-register.php" class="auth-btn" style="display: inline-block; text-decoration: none;">Go to Login 💖</a>
                <?php else: ?>
                    <div style="font-size: 4rem; margin-bottom: 1.5rem;">⚠️</div>
                    <h2 class="section__title">Oops!</h2>
                    <p class="auth-subtitle" style="margin-bottom: 2rem;"><?php echo $message; ?></p>
                    <a href="login-register.php" class="auth-btn" style="display: inline-block; text-decoration: none;">Back to Login 🌷</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
