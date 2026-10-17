<?php 
session_start();
include 'header.php';

// Check if user is logged in
$isLoggedIn = !empty($_SESSION['user_id']);
$userId = $isLoggedIn ? intval($_SESSION['user_id']) : null;
?>

  <!--=============== HEADER ===============-->
  <!--=============== HEADER ===============-->
  <!--=============== HEADER ===============-->
  

  <!--=============== MAIN ===============-->
  <main class="main">

    <div class="cart__header cart__header-box container">
      <h2 class="section__title">
        <span>Your</span> Wishlist
      </h2>
      <p class="delivery__order">Save your favorite flowers for later 💕</p>
    </div>

    <?php if (!$isLoggedIn): ?>
    <!-- Login Required Message -->
    <div class="empty-cart-container container" style="display: block;">
      <div class="empty-cart-illustration">
        <div class="empty-cart-icon">🔐</div>
      </div>
      <h3>Please log in to view your wishlist</h3>
      <p>You need to be logged in to save favorite flowers 💕</p>
      <div style="display: flex; gap: 10px; justify-content: center;">
        <a href="login-register.php" class="btn btn--lg">
          <i class="fi-rs-user"></i> Login / Register
        </a>
        <a href="flower.php" class="btn btn--lg btn--secondary">
          <i class="fi-rs-shopping-bag"></i> Browse Flowers
        </a>
      </div>
    </div>
    <?php else: ?>
    <!-- Wishlist Content (only for logged in users) -->


    <!--=============== WISHLIST ===============-->
    <!--=============== WISHLIST ===============-->
    <section class="products container section--lg">
      <div class="products__container grid" id="wishlist-items">
        <!-- JS will inject products here -->
      </div>

      <div class="wishlist__actions" id="wishlist-actions" style="display:none;">
        <button type="button" class="btn wishlist-clear-btn" id="clear-wishlist-btn">
          Clear Wishlist
        </button>
      </div>

      <div id="wishlist-empty" class="wishlist__empty" style="display:none;">
        <h3>Your wishlist is empty 💔</h3>
        <p>Add your favorite flowers and gifts to see them here.</p>
        <a href="flower.php" class="btn">Browse Flowers</a>
      </div>
    </section>
    <?php endif; // End of isLoggedIn check ?>
  </main><!--=============== search ===============--><?php include 'footer.php'; ?>
