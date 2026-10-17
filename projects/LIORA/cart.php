<?php 
session_start();
include 'header.php';

// Check if user is logged in
$isLoggedIn = !empty($_SESSION['user_id']);
$userId = $isLoggedIn ? intval($_SESSION['user_id']) : null;
?>
  <!--=============== HEADER ===============-->
  

  <!--=============== MAIN ===============-->
  <main class="main">

    <!-- Cart Header -->
    <div class="cart__header cart__header-box container">
      <h2 class="section__title">
        <span>Your</span> Shopping Cart 🌸
      </h2>
      <p class="delivery__order">Confirm your products to proceed to checkout 🌷</p>
    </div>

    <?php if (!$isLoggedIn): ?>
    <!-- Login Required Message -->
    <div class="empty-cart-container container" style="display: block;">
      <div class="empty-cart-illustration">
        <div class="empty-cart-icon">🔐</div>
      </div>
      <h3>Please log in to view your cart</h3>
      <p>You need to be logged in to manage your shopping cart 🛒</p>
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
    <!-- Cart Content (only for logged in users) -->

    <!-- Empty Cart State -->
    <div id="empty-cart-message" class="empty-cart-container container" style="display: none;">
      <div class="empty-cart-illustration">
        <div class="empty-cart-icon">🛒</div>
      </div>
      <h3>Your cart is blooming empty!</h3>
      <p>Add some beautiful flowers to make someone's day special 💐</p>
      <a href="flower.php" class="btn btn--lg">
        <i class="fi-rs-shopping-bag"></i> Browse Flowers
      </a>
    </div>

    <!-- Cart Content -->
    <section class="cart section--lg container" id="cart-content">
      <div class="cart-layout">

        <!-- Left: Cart Items -->
        <div class="cart-items-section">
          <div class="table__container">

            <div class="products__container grid" id="cart-items-container">
              <!-- JS will render items -->
            </div>
          </div>

          <!-- Cart Actions -->
          <div class="cart__actions">
            <button class="btn flex btn__md btn--outline" onclick="clearCart()">
              <i class="fi-rs-trash"></i> Clear Cart
            </button>
            <a href="flower.php" class="btn flex btn__md btn--secondary">
              <i class="fi-rs-shopping-bag"></i> Continue Shopping
            </a>
          </div>
        </div>

        <!-- Right: Summary & Offers -->
        <div class="cart-sidebar">

          <!-- Special Offer Banner -->
          <div class="cart__offer">
            <div class="offer-header">
              <span class="offer-icon">🌸</span>
              <h3>Special Flower Offers</h3>
            </div>
            <div class="offer-item">
              <span class="offer-badge">10% OFF</span>
              <p>Spend <strong>$50+</strong> and save 10%</p>
            </div>
            <div class="offer-item">
              <span class="offer-badge free">FREE</span>
              <p>Spend <strong>$75+</strong> for free delivery</p>
            </div>
            <div class="coupon-code">
              <span>Use code: <strong style="cursor: pointer; text-decoration: underline;" onclick="document.getElementById('coupon-input').value='LOVE10'; applyCoupon();">LOVE10</strong></span>
              <p style="font-size: 0.75rem; color: #888; margin-top: 4px;">(Click code to apply automatically)</p>
            </div>
          </div>

          <!-- Coupon Section -->
          <div class="cart__coupon sidebar-coupon">
            <h3 class="section__title">🎁 Apply Coupon</h3>
            <div class="coupon__form form">
              <div class="form__group">
                <input type="text" class="form__input" id="coupon-input" placeholder="Enter coupon code" />
                <button class="btn btn--sm" type="button" onclick="applyCoupon()">
                  <i class="fi-rs-label"></i> Apply
                </button>
              </div>
              <p id="coupon-message" class="coupon-message"></p>
              <div class="coupon-info" style="font-size: 0.85rem; color: #666; margin-top: 0.75rem; line-height: 1.4;">
                <p><strong>Available Codes:</strong></p>
                <p>• LOVE10 → 10% OFF 💗</p>
                <p>• SPRING15 → 15% OFF 🌸</p>
                <p>• SUMMER20 → 20% OFF ☀️</p>
              </div>
            </div>
          </div>

          <!-- Cart Totals -->
          <div class="cart__total sidebar-total">
            <h3 class="section__title">💐 Cart Summary</h3>
            <table class="cart__total-table">
              <tr>
                <td><span class="cart__total-title">Subtotal</span></td>
                <td><span class="cart__total-price" id="summary-subtotal">$0.00</span></td>
              </tr>
              <tr id="discount-row" style="display: none;">
                <td><span class="cart__total-title discount">Discount</span></td>
                <td><span class="cart__total-price discount" id="summary-discount">-$0.00</span></td>
              </tr>
              <tr>
                <td><span class="cart__total-title">Shipping</span></td>
                <td><span class="cart__total-price" id="summary-shipping">$0.00</span></td>
              </tr>
              <tr>
                <td><span class="cart__total-title">Reward Points</span></td>
                <td><span class="cart__summary-value" id="summary-rewards">-$0.00</span></td>
              </tr>
              <tr class="total-row">
                <td><span class="cart__total-title">Total</span></td>
                <td><span class="cart__total-price grand-total" id="summary-total">$0.00</span></td>
              </tr>
            </table>

            <!-- Progress Bar for Free Shipping -->
            <div class="shipping-progress" id="shipping-progress">
              <p class="progress-text" id="progress-text">Add $75 more for FREE shipping! 🚚</p>
              <div class="progress-bar">
                <div class="progress-fill" id="progress-fill" style="width: 0%"></div>
              </div>
            </div>

            <a href="checkout.php" class="btn flex btn--md btn--checkout" onclick="return proceedToCheckout(event)">
              <i class="fi fi-rs-box-alt"></i> Proceed To Checkout
            </a>

            <div class="secure-checkout">
              <span>🔒 Secure Checkout</span>
              <small>SSL Encrypted & Protected</small>
            </div>
          </div>

          <!-- Need Help -->
          <div class="cart-help">
            <h4>Need Help? 💬</h4>
            <p>Our florists are here to assist you</p>
            <a href="chatbot.php" class="help-link">
              <i class="fi-rs-comment"></i> Chat with AI Assistant
            </a>
          </div>
        </div>
      </div>
    </section>
    <?php endif; // End of isLoggedIn check ?>
  </main>

  <!-- Toast Notifications -->
  <div id="toast-container" class="toast-container"></div><!--=============== CART JS ===============-->
  <?php include 'footer.php'; ?>
