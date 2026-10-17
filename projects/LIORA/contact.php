<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'config.php';

$prefillName = trim(($_SESSION['first_name'] ?? '') . ' ' . ($_SESSION['last_name'] ?? ''));
$prefillEmail = $_SESSION['email'] ?? '';

if (!empty($_SESSION['user_id'])) {
    $userId = intval($_SESSION['user_id']);
    $userStmt = $conn->prepare('SELECT first_name, last_name, email FROM users WHERE id = ? LIMIT 1');
    if ($userStmt) {
        $userStmt->bind_param('i', $userId);
        $userStmt->execute();
        $userResult = $userStmt->get_result();
        if ($userRow = $userResult->fetch_assoc()) {
            $prefillName = trim(($userRow['first_name'] ?? '') . ' ' . ($userRow['last_name'] ?? '')) ?: $prefillName;
            $prefillEmail = $userRow['email'] ?? $prefillEmail;
        }
        $userStmt->close();
    }
}

include 'header.php';
?>

<main class="main contact-support-page">
  <section class="contact-hero section">
    <div class="contact-hero__inner container">
      <div class="contact-hero__content">
        <span class="contact-kicker">Liora care desk</span>
        <h1>Contact & Support</h1>
        <p>Reach the Liora team for flower advice, delivery help, order questions, and account support.</p>
        <div class="contact-hero__actions">
          <a href="#support-form" class="btn">Send a Message</a>
          <a href="chatbot.php" class="btn contact-btn--ghost">Live Chat</a>
        </div>
      </div>
      <div class="contact-hero__panel">
        <div class="contact-mini-card">
          <span>Phone</span>
          <a href="tel:+7508990555">+7508990555</a>
        </div>
        <div class="contact-mini-card">
          <span>Email</span>
          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=supportliora@gmail.com" target="_blank" rel="noopener">supportliora@gmail.com</a>
        </div>
        <div class="contact-mini-card">
          <span>Visit</span>
          <p>52 alwand street, TwiMalik</p>
        </div>
      </div>
    </div>
  </section>

  <section class="contact-support-grid container section">
    <article class="contact-info-panel">
      <div class="contact-section-title">
        <span>About Liora</span>
        <h2>Thoughtful flowers, handled with care.</h2>
      </div>
      <p>Liora is built around fresh arrangements, clear service, and reliable delivery for the moments customers trust us with.</p>

      <div class="trust-grid">
        <div>
          <strong>Fresh handling</strong>
          <span>Prepared close to delivery time.</span>
        </div>
        <div>
          <strong>Secure accounts</strong>
          <span>Protected login, wishlist, cart, and order history.</span>
        </div>
        <div>
          <strong>Order support</strong>
          <span>Questions are stored and reviewed from the admin dashboard.</span>
        </div>
        <div>
          <strong>AI florist help</strong>
          <span>Use live chat for bouquet guidance any time.</span>
        </div>
      </div>
    </article>

    <article class="contact-table-panel">
      <div class="contact-section-title">
        <span>Support channels</span>
        <h2>Choose the fastest path.</h2>
      </div>
      <div class="contact-table-wrap">
        <table class="contact-support-table">
          <thead>
            <tr>
              <th>Need</th>
              <th>Best Contact</th>
              <th>Response</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Order or delivery issue</td>
              <td><a href="#support-form">Support form</a></td>
              <td>Same day</td>
            </tr>
            <tr>
              <td>Bouquet advice</td>
              <td><a href="chatbot.php">Live chat</a></td>
              <td>Instant</td>
            </tr>
            <tr>
              <td>Urgent delivery question</td>
              <td><a href="tel:+7508990555">Phone</a></td>
              <td>Fastest</td>
            </tr>
            <tr>
              <td>Business or partnership</td>
              <td><a href="https://mail.google.com/mail/?view=cm&fs=1&to=supportliora@gmail.com" target="_blank" rel="noopener">Email</a></td>
              <td>1 business day</td>
            </tr>
          </tbody>
        </table>
      </div>
    </article>
  </section>

  <section class="contact-form-section container section" id="support-form">
    <div class="contact-form-card">
      <div class="contact-section-title">
        <span>Send request</span>
        <h2>Tell us what you need.</h2>
      </div>
      <form id="contact-support-form" class="contact-form">
        <div class="contact-form__row">
          <label>
            Full name
            <input class="contact-input" type="text" name="name" value="<?php echo htmlspecialchars($prefillName, ENT_QUOTES, 'UTF-8'); ?>" required>
          </label>
          <label>
            Email
            <input class="contact-input" type="email" name="email" value="<?php echo htmlspecialchars($prefillEmail, ENT_QUOTES, 'UTF-8'); ?>" required>
          </label>
        </div>

        <div class="contact-form__row">
          <label>
            Phone
            <input class="contact-input" type="tel" name="phone" placeholder="07XXXXXXXXX" maxlength="11" pattern="\d{11}" inputmode="numeric" title="Enter exactly 11 digits" />
          </label>
          <label>
            Order number
            <input class="contact-input" type="text" name="order_number" placeholder="Optional">
          </label>
        </div>

        <div class="contact-form__row">
          <label>
            Topic
            <select class="contact-input" name="topic">
              <option>Order help</option>
              <option>Delivery question</option>
              <option>Product advice</option>
              <option>Account help</option>
              <option>Partnership</option>
              <option>General question</option>
            </select>
          </label>
          <label>
            Preferred contact
            <select class="contact-input" name="preferred_contact">
              <option value="email">Email</option>
              <option value="phone">Phone</option>
            </select>
          </label>
        </div>

        <label>
          Message
          <textarea class="contact-input contact-textarea" name="message" rows="6" required placeholder="Share the details and we will help."></textarea>
        </label>

        <div class="contact-form__footer">
          <button type="submit" class="btn">Submit Request</button>
          <p id="contact-form-notice" class="contact-form-notice" role="status" aria-live="polite"></p>
        </div>
      </form>
    </div>

  </section>

  <section class="contact-faq container section">
    <div class="contact-section-title contact-section-title--center">
      <span>FAQ</span>
      <h2>Helpful answers before you message us.</h2>
    </div>
    <div class="faq-grid">
      <details open>
        <summary>Can I change my delivery details?</summary>
        <p>Send your order number through the form as soon as possible. The team can help before the bouquet is prepared for dispatch.</p>
      </details>
      <details>
        <summary>Can Liora help me choose flowers?</summary>
        <p>Yes. Use live chat for fast bouquet recommendations or send the support form for more personal help.</p>
      </details>
      <details>
        <summary>Where are messages saved?</summary>
        <p>Every support request is saved in the support messages table and visible to admins from the dashboard.</p>
      </details>
    </div>
  </section>
</main>

<script src="assets/js/contact.js?v=<?php echo filemtime(__DIR__ . '/assets/js/contact.js'); ?>"></script>
<?php include 'footer.php'; ?>
