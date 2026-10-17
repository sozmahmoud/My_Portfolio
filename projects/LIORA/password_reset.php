<?php
session_start();
require_once 'config.php';

function ensurePasswordResetTableExists($conn) {
    $createSql = "CREATE TABLE IF NOT EXISTS password_reset_requests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NULL,
        email VARCHAR(255) NOT NULL,
        token VARCHAR(255) NOT NULL UNIQUE,
        requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        expires_at DATETIME DEFAULT NULL,
        sent_at TIMESTAMP NULL DEFAULT NULL,
        used_at TIMESTAMP NULL DEFAULT NULL,
        is_used BOOLEAN DEFAULT FALSE,
        ip_address VARCHAR(45) DEFAULT NULL,
        INDEX idx_password_reset_requests_user_id (user_id),
        INDEX idx_password_reset_requests_email (email),
        INDEX idx_password_reset_requests_token (token),
        CONSTRAINT fk_password_reset_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB";
    $conn->query($createSql);
}

$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$message = '';
$messageType = 'error';
$showForm = false;

ensurePasswordResetTableExists($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = isset($_POST['token']) ? trim($_POST['token']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirmPassword = isset($_POST['confirmPassword']) ? trim($_POST['confirmPassword']) : '';

    if (empty($token) || empty($password) || empty($confirmPassword)) {
        $message = '🌸 Please fill in all fields!';
    } elseif ($password !== $confirmPassword) {
        $message = '❌ Passwords do not match!';
    } elseif (strlen($password) < 6) {
        $message = '🔒 Password must be at least 6 characters!';
    } else {
        $stmt = $conn->prepare('SELECT id, user_id, is_used, expires_at FROM password_reset_requests WHERE token = ? LIMIT 1');
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $request = $result->fetch_assoc();
        $stmt->close();

        if (!$request || $request['is_used']) {
            $message = '❌ Invalid or expired reset link.';
        } elseif ($request['expires_at'] !== null && strtotime($request['expires_at']) < time()) {
            $message = '⏳ This reset link has expired.';
        } else {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
            $updateUser = $conn->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
            $updateUser->bind_param('si', $passwordHash, $request['user_id']);
            $updateUser->execute();
            $updateUser->close();

            $updateRequest = $conn->prepare('UPDATE password_reset_requests SET is_used = 1, used_at = NOW(), new_password_hash = ? WHERE id = ?');
            $updateRequest->bind_param('si', $passwordHash, $request['id']);
            $updateRequest->execute();
            $updateRequest->close();

            $message = '✅ Your password has been updated successfully. You can now log in.';
            $messageType = 'success';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (empty($token)) {
        $message = '❌ Invalid reset link.';
    } else {
        $stmt = $conn->prepare('SELECT id, is_used, expires_at FROM password_reset_requests WHERE token = ? LIMIT 1');
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $request = $result->fetch_assoc();
        $stmt->close();

        if (!$request || $request['is_used'] || ($request['expires_at'] !== null && strtotime($request['expires_at']) < time())) {
            $message = '❌ Invalid or expired reset link.';
        } else {
            $showForm = true;
        }
    }
}

include 'header.php';
?>
<main class="main">
  <div class="cart__header cart__header-box container">
    <h2 class="section__title"><span>Reset Password</span></h2>
  </div>
  <section class="login-register section--lg">
    <div class="auth-container">
      <div class="auth-box" style="width:100%; max-width:500px; margin:0 auto;">
        <h2>Reset your password</h2>
        <?php if ($message): ?>
          <p class="auth-message" style="color: <?php echo $messageType === 'success' ? '#27ae60' : '#e74c3c'; ?>; margin-bottom: 1rem;">
            <?php echo htmlspecialchars($message); ?>
          </p>
        <?php endif; ?>

        <?php if ($showForm): ?>
          <form class="form" method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>" />
            <input type="password" placeholder="New password" class="auth-input" name="password" required />
            <input type="password" placeholder="Confirm new password" class="auth-input" name="confirmPassword" required />
            <button type="submit" class="auth-btn">Update Password 🌷</button>
          </form>
        <?php elseif ($messageType !== 'success'): ?>
          <p>Please request a new password reset from the login page.</p>
          <a href="login-register.php" class="auth-btn">Back to Login</a>
        <?php else: ?>
          <a href="login-register.php" class="auth-btn">Back to Login</a>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
<?php include 'footer.php'; ?>
