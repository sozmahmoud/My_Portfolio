<?php 
session_start();

// If user already logged in, redirect to home
if (!empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$loginMessage = '';
if (isset($_GET['message']) && $_GET['message'] === 'login_required') {
    $loginMessage = '🔐 Please log in to access your account.';
}

$showForgotPassword = false;
$resetMessage = '';

include 'header.php';
?>
<!--=============== MAIN ===============-->
    <main class="main">
      <div class="cart__header cart__header-box container">
      <h2 class="section__title">
        <span>Login</span> Register 🌸
      </h2>
      <p class="delivery__order">Register to save your details </p>
    </div>

      <!--=============== LOGIN-REGISTER ===============-->
      <section class="login-register section--lg">
  <div class="auth-container">
    
    <!-- LEFT SIDE - LOGIN -->
    <div class="auth-box">
      <h2>Welcome Back 🌸</h2>
      <p class="auth-subtitle">Log in to continue your flower journey</p>
      <?php if ($loginMessage): ?>
        <p class="auth-message" style="color: #d35400; margin-bottom: 1rem;">
          <?php echo htmlspecialchars($loginMessage); ?>
        </p>
      <?php endif; ?>

      <form class="form login-form" id="login-form">
        <input type="email" placeholder="Email address" class="auth-input" name="email" required />
        <input type="password" placeholder="Password" class="auth-input" name="password" required />
        <a href="#" class="forgot-password-link" id="show-forgot-password">Forgot password?</a>
        <button type="submit" class="auth-btn">Login 💖</button>
        <p id="login-message" class="auth-message"></p>
      </form>

      <form class="form forgot-password-form" id="forgot-password-form" hidden>
        <div style="text-align: center; margin-bottom: 1.5rem;">
          <span style="font-size: 3rem;">💌</span>
          <h3 style="color: #d86f9a; margin-top: 1rem;">Reset Password</h3>
          <p class="auth-subtitle">Enter your email and we'll send you a link to reset your password.</p>
        </div>
        <input type="email" placeholder="Email address" class="auth-input" name="resetEmail" required />
        <button type="submit" class="auth-btn" id="forgot-submit-btn">Send Reset Link 🌷</button>
        <p id="forgot-password-message" class="auth-message"></p>
        <div style="text-align: center; margin-top: 1.5rem;">
          <a href="#" class="forgot-password-back" id="back-to-login" style="color: #c14e8f; font-weight: 600; text-decoration: none;">✨ Back to Login</a>
        </div>
      </form>
    </div>

    <!-- RIGHT SIDE - REGISTER -->
    <div class="auth-box">
      <h2>Create Account ✨</h2>
      <p class="auth-subtitle">Join Liora and spread love 🌷</p>

      <form class="form register-form" id="register-form">
        <input type="text" placeholder="Username" class="auth-input" name="username" required />
        <input type="email" placeholder="Email address" class="auth-input" name="email" required />
        <input type="password" placeholder="Password" class="auth-input" name="password" required />
        <input type="password" placeholder="Confirm Password" class="auth-input" name="confirmPassword" required />
        <button type="submit" class="auth-btn">Register 🌼</button>
        <p id="register-message" class="auth-message"></p>
      </form>
    </div>

  </div>
</section>

    </main><script src="assets/js/login-register.js"></script>
     <!--=============== search ===============--><?php include 'footer.php'; ?>


