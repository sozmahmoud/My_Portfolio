<?php
session_start();
include 'config.php';
include 'reward_helper.php';
include 'header.php';

$isLoggedIn = !empty($_SESSION['user_id']);
$userPoints = 0;
if ($isLoggedIn) {
    $userPoints = getUserRewardPoints($conn, $_SESSION['user_id']);
}
?>

<link rel="stylesheet" href="assets/css/checkout_redesign.css?v=<?php echo filemtime(__DIR__ . '/assets/css/checkout_redesign.css'); ?>">

<main class="main checkout-redesign">
  <?php if (!$isLoggedIn): ?>
    <section class="checkout-login section">
      <div class="checkout-login__panel container">
        <span class="checkout-login__icon" aria-hidden="true"><i class="fi fi-rs-lock"></i></span>
        <p class="checkout__eyebrow">Almost there</p>
        <h2>Please log in to finish your order</h2>
        <p>Your cart is waiting. Sign in to choose delivery details and place your bouquet order securely.</p>
        <div class="checkout-login__actions">
          <a href="login-register.php" class="btn-redesign btn-redesign--primary">Login / Register</a>
          <a href="cart.php" class="btn-redesign btn-redesign--secondary">Back to Cart</a>
        </div>
      </div>
    </section>
  <?php else: ?>
    <div class="checkout__header-box container">
      <p class="checkout__eyebrow">Secure Checkout</p>
      <h2 class="section__title">Checkout Details</h2>
      <p class="delivery__order">Tell us where and when to deliver your flowers.</p>
    </div>

    <section class="checkout section">
      <div class="container">
        <form class="checkout-grid" id="checkout-form" autocomplete="off">
          <!-- Hidden inputs for JS -->
          <input type="hidden" name="coupon_code" id="checkout-coupon-code" value="" />
          
          <div class="checkout-left">
            <div class="checkout-card">
              <div class="checkout-card__header">
                <div class="checkout-card__number"><i class="fi fi-rs-marker"></i></div>
                <div class="checkout-card__title">
                  <h2>Recipient & Address</h2>
                  <p>Make sure these details are easy for our driver to follow.</p>
                </div>
              </div>

              <div class="checkout-fields">
                <label class="form-field">
                  <span>Full name</span>
                  <input type="text" name="full_name" placeholder="Your full name" class="form-input" autocomplete="name" required />
                </label>

                <label class="form-field">
                  <span>Phone</span>
                  <input type="tel" name="phone" placeholder="07XXXXXXXXX" class="form-input" maxlength="11" pattern="\d{11}" inputmode="numeric" autocomplete="tel" title="Enter exactly 11 digits" required />
                </label>

                <label class="form-field field-wide">
                  <span>Address</span>
                  <input type="text" name="address" placeholder="Street, building, apartment" class="form-input" autocomplete="street-address" required />
                </label>

                <label class="form-field">
                  <span>City</span>
                  <input type="text" name="city" placeholder="City" class="form-input" autocomplete="address-level2" required />
                </label>

                <label class="form-field">
                  <span>Email</span>
                  <input type="email" name="email" placeholder="name@example.com" class="form-input" autocomplete="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" required />
                </label>
              </div>
            </div>

            <div class="checkout-card">
              <div class="checkout-card__header">
                <div class="checkout-card__number"><i class="fi fi-rs-calendar-clock"></i></div>
                <div class="checkout-card__title">
                  <h2>Schedule & Gift Notes</h2>
                  <p>Add a short message and anything important for delivery.</p>
                </div>
              </div>

              <div class="checkout-fields">
                <label class="form-field">
                  <span>Delivery date</span>
                  <input type="date" name="delivery_date" class="form-input" required />
                </label>

                <label class="form-field">
                  <span>Delivery time</span>
                  <input type="text" name="delivery_time" class="form-input" placeholder="12:00 PM" inputmode="text" autocomplete="off" maxlength="8" pattern="(0[1-9]|1[0-2]):([0-5][0-9]|60) (am|pm|AM|PM)" title="Use this format: 12:00 PM. Hours 01-12, minutes 00-60, AM or PM." required />
                  <small class="checkout__helper">you can only add a time after one hour</small>
                </label>

                <label class="form-field field-wide">
                  <span>Gift message</span>
                  <textarea name="gift_message" rows="4" maxlength="500" data-max-lines="10" placeholder="Write your personal message" class="form-input checkout__note-box"></textarea>
                </label>

                <label class="form-field field-wide">
                  <span>Order note</span>
                  <textarea name="order_note" rows="3" maxlength="280" placeholder="Anything our florists or driver should know?" class="form-input checkout__note-box checkout__note-box--small"></textarea>
                </label>
              </div>
            </div>
          </div>

          <aside class="checkout-summary" aria-label="Order summary">
            <div class="summary-card">
              <div class="summary-header">
                <div>
                  <p class="summary-kicker">Your order</p>
                  <h2>Order Summary</h2>
                </div>
                <a href="cart.php">Edit cart</a>
              </div>

              <div class="order-items-list" id="checkout-items" aria-live="polite">
                <p class="checkout-empty">Loading your cart...</p>
              </div>

              <div class="summary-totals">
                <div class="total-row">
                  <span>Subtotal</span>
                  <span id="checkout-subtotal">$0.00</span>
                </div>
                <div class="total-row">
                  <span>Discount</span>
                  <span class="discount-text" id="checkout-discount">-$0.00</span>
                </div>
                <div class="total-row">
                  <span>Reward Points</span>
                  <span class="discount-text" id="checkout-rewards">-$0.00</span>
                </div>
                <div class="total-row">
                  <span>Shipping</span>
                  <span id="checkout-shipping">$0.00</span>
                </div>
                <div class="total-row">
                  <span>Total</span>
                  <span id="checkout-total">$0.00</span>
                </div>
              </div>

              <div class="payment-methods">
                <h3 class="payment-title">Payment Method</h3>

                <label class="payment-option active" for="l1">
                  <input type="radio" name="payment_method" id="l1" value="Credit Card (Visa)" checked />
                  <span class="payment-option__label">
                    <i class="fi fi-rs-credit-card"></i>
                    Credit Card
                  </span>
                </label>

                <div id="card-details" class="payment-details">
                  <div class="checkout-fields checkout-fields--single">
                    <label class="form-field">
                      <span>Cardholder Name</span>
                      <input type="text" name="card_name" placeholder="visa or visacard" class="form-input" autocomplete="off" maxlength="8" pattern="[Vv][Ii][Ss][Aa]([Cc][Aa][Rr][Dd])?" title="Enter visa or visacard" />
                    </label>
                    <label class="form-field">
                      <span>Card Number</span>
                      <input type="text" name="credit_card_number" placeholder="0000 0000 0000 0000" class="form-input" maxlength="19" inputmode="numeric" autocomplete="off" data-card-number-input />
                      <input type="hidden" name="card_number" value="" data-card-number-value />
                    </label>
                    <div class="card-mini-grid">
                      <label class="form-field">
                        <span>Expiry</span>
                        <div class="input-with-icon">
                          <input type="month" name="card_expiry" id="card_expiry" class="form-input" />
                          <i class="fi fi-rs-calendar-day"></i>
                        </div>
                      </label>
                      <label class="form-field">
                        <span>CVV</span>
                        <input type="password" name="card_cvv" placeholder="***" class="form-input" maxlength="3" pattern="\d{3}" inputmode="numeric" autocomplete="off" title="Enter exactly 3 digits" />
                      </label>
                    </div>
                  </div>
                </div>

                <label class="payment-option" for="l2">
                  <input type="radio" name="payment_method" id="l2" value="PayPal" />
                  <span class="payment-option__label">
                    <i class="fi fi-rs-wallet"></i>
                    PayPal
                  </span>
                </label>

                <div id="paypal-details" class="payment-details payment-details--note">
                  <div class="checkout-fields checkout-fields--single">
                    <label class="form-field">
                      <span>PayPal Card Number</span>
                      <input type="text" name="paypal_email" placeholder="0000 0000 0000 0000" class="form-input" maxlength="19" inputmode="numeric" autocomplete="off" />
                    </label>
                  </div>
                </div>

                <?php if ($userPoints >= 100): ?>
                  <label class="payment-option" for="l3">
                    <input type="radio" name="payment_method" id="l3" value="Reward Points" />
                    <span class="payment-option__label">
                      <i class="fi fi-rs-gift"></i>
                      Reward Points
                    </span>
                  </label>
                  <div id="reward-points-details" class="payment-details payment-details--reward">
                    <label class="form-field">
                      <span>Points to spend</span>
                      <input
                        type="number"
                        name="redeem_points"
                        id="checkout-redeem-points"
                        class="form-input"
                        min="1"
                        max="<?php echo intval($userPoints); ?>"
                        step="1"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        placeholder="100"
                      />
                    </label>
                    <p class="reward-points-help">
                      Available: <strong id="checkout-available-points"><?php echo intval($userPoints); ?></strong> points
                    </p>
                  </div>
                <?php else: ?>
                  <label class="payment-option payment-option--disabled">
                    <input type="radio" name="payment_method" id="l3" value="Reward Points" disabled />
                    <span class="payment-option__label">
                      <i class="fi fi-rs-gift"></i>
                      Reward Points (Need 100+)
                    </span>
                  </label>
                <?php endif; ?>
              </div>

              <button id="place-order-btn" class="place-order-btn" type="submit">
                <i class="fi fi-rs-shopping-bag"></i>
                Place Order
              </button>
            </div>
          </aside>
        </form>
      </div>
    </section>
  <?php endif; ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="payment_method"]');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
            if (this.checked) {
                this.closest('.payment-option').classList.add('active');
            }
        });
    });
});
</script>

<script src="assets/js/checkout.js?v=<?php echo filemtime(__DIR__ . '/assets/js/checkout.js'); ?>"></script>
<?php include 'footer.php'; ?>
