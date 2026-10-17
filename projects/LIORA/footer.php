<?php
// footer.php
?>


  <!--=============== FOOTER ===============-->
  <footer class="footer">
    <div class="footer__wrapper container">

      <div class="footer__container">

        <div class="footer__brand">
          <a href="index.php" class="footer__logo">
            <img src="assets/img/liora_logo.svg" alt="Liora Logo" class="footer__logo-img">
          </a>
          <p class="footer__tagline">
            Fresh flowers for every special moment 🌷
          </p>
          <div class="footer__socials">
            <a href="https://www.instagram.com/supportliora?utm_source=ig_web_button_share_sheet&amp;igsh=ZDNlZDc0MzIxNw==" class="footer__social-btn" title="Instagram" target="_blank" rel="noopener noreferrer">
              <img src="assets/img/icon-instagram.svg" alt="Instagram">
            </a>
            <a href="https://www.facebook.com/share/18spetvvhu/?mibextid=wwXIfr" class="footer__social-btn" title="Facebook" target="_blank" rel="noopener noreferrer">
              <img src="assets/img/icon-facebook.svg" alt="Facebook">
            </a>
            <a href="https://www.snapchat.com/add/liorasupport?share_id=IvYDVFcAROiCxRFCsVaaTQ&amp;locale=en_US" class="footer__social-btn" title="Snapchat" target="_blank" rel="noopener noreferrer" aria-label="Snapchat">
              <img src="assets/img/snapchat-ghost.svg" alt="Snapchat">
            </a>
          </div>
        </div>

        <!-- Shop -->
        <div class="footer__column">
          <h4>Shop</h4>
          <a href="flower.php">All Flowers</a>
          <a href="rose.php">Roses</a>
          <a href="tulip.php">Tulips</a>
          <a href="orchids.php">Orchids</a>
          <a href="mixed_flower.php">Mixed Bouquets</a>
        </div>

        <!-- Occasions -->
        <div class="footer__column">
          <h4>Occasions</h4>
          <a href="mother.php">Mother’s Day</a>
          <a href="birthday.php">Birthday</a>
          <a href="valentine.php">Valentine’s Day</a>
          <a href="newyear.php">New Year</a>
        </div>

        <!-- Why Liora -->
        <div class="footer__column">
          <h4>Why Liora?</h4>
          <a href="contact.php">About & Contact</a>
          <a href="chatbot.php">AI Florist Assistant</a>
          <a href="accounts.php?tab=reward-points">Flower Points Rewards</a>
          <a href="calendar.php">Highlight Your Calendar</a>
        </div>

        <!-- Contact + Liora Brand -->
        <div class="footer__contact-brand">
          <div class="footer__column">
            <h4>Contact Us</h4>
            <p>📍 52 alwand street, TwiMalik</p>
            <p>📞 +7508990555</p>
            <p>(+91) 01 6767 6789</p>
            <p><a href="https://mail.google.com/mail/?view=cm&fs=1&to=supportliora@gmail.com" target="_blank" rel="noopener">supportliora@gmail.com</a></p>
          </div>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="footer__bottom">
        <p>© 2026 Liora. All rights reserved.</p>
      </div>

    </div>
  </footer>

  <!--=============== SWIPER JS ===============-->
  <script src="assets/js/swiper.js"></script>
  <!--=============== SEARCH JS ===============-->
  <script src="assets/js/search.js"></script>
  <!--=============== CART JS ===============-->
  <script src="assets/js/cart.js"></script>
  <!--=============== WISHLIST JS ===============-->
  <script src="assets/js/wishlist.js?v=<?php echo filemtime(__DIR__ . '/assets/js/wishlist.js'); ?>"></script>
  <!--=============== REVIEW HELPER JS ===============-->
  <script src="assets/js/review_helper.js?v=<?php echo time(); ?>"></script>
  <!--=============== MAIN JS ===============-->
  <script src="assets/js/main.js?v=<?php echo time(); ?>"></script>

</body>

</html>
