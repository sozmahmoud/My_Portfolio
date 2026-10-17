<?php include 'header.php';

?>
  <!--=============== BREADCRUMB ===============-->
  <div class="details__breadcrumb container cart__header cart__header-box container">
    <span id="breadcrumb-name">Product Detail</span>
  </div>

  <!--=============== MAIN ===============-->
  <main class="main">

    <!--=============== DETAILS ===============-->
    <section class="details section--lg">
      <div class="details__container container grid">

        <!-- LEFT: Images -->
        <div class="details__group">
          <img id="detail-img-main" src="./assets/img/product-8-1.jpg" alt="Flower"
            class="details__img details__img--main" />
          <div class="details__thumbnails" id="detail-thumbnails">
            <!-- Thumbnails injected by JS -->
          </div>
        </div>

        <!-- RIGHT: Info -->
        <div class="details__group">
          <div class="details__badge" id="detail-badge">Hot</div>
          <h3 class="details__title" id="detail-title">Romantic Rose Bouquet</h3>
          <p class="details__subtitle details__subtitle--small" id="detail-kurdish-title"></p>
          <p class="details__brand">Brand: <span>Liora Flowers</span></p>

          <div class="details__price flex">
            <span class="new__price" id="detail-price">$116</span>
            <span class="old__price" id="detail-old-price">$200.00</span>
            <span class="save__price" id="detail-discount">25% Off</span>
          </div>

          <p class="short__description" id="detail-description">
            Fresh handpicked roses arranged in a beautiful bouquet, perfect for
            birthdays, anniversaries, and heartfelt surprises.
          </p>

          <!-- Flower Details Table -->
          <div class="details__info-table" id="detail-info-table">
            <!-- Injected by JS -->
          </div>

          <div class="details__customization">
            <h4 class="details__subtitle">Customize Your Bouquet</h4>

            <div class="custom__option custom__option--choices">
              <span class="custom__label">Wrapping Style</span>
              <div class="detail-option-grid">
                <label class="detail-option-card">
                  <input type="radio" name="wrapping_style" value="Classic Pink Wrap" data-cart-option="Wrapping Style" checked />
                  <span>Classic Pink</span>
                  <small>Soft bouquet paper</small>
                </label>
                <label class="detail-option-card">
                  <input type="radio" name="wrapping_style" value="Luxury White Wrap" data-cart-option="Wrapping Style" />
                  <span>Luxury White</span>
                  <small>Clean satin finish</small>
                </label>
                <label class="detail-option-card">
                  <input type="radio" name="wrapping_style" value="Golden Ribbon Wrap" data-cart-option="Wrapping Style" />
                  <span>Golden Wrap</span>
                  <small>Warm celebration look</small>
                </label>
              </div>
            </div>

            <div class="custom__option custom__option--choices">
              <span class="custom__label">Ribbon Color</span>
              <div class="detail-option-grid detail-option-grid--compact">
                <label class="detail-option-chip detail-option-chip--pink">
                  <input type="radio" name="ribbon_color" value="Pink" data-cart-option="Ribbon Color" checked />
                  <span>Pink</span>
                </label>
                <label class="detail-option-chip detail-option-chip--white">
                  <input type="radio" name="ribbon_color" value="White" data-cart-option="Ribbon Color" />
                  <span>White</span>
                </label>
                <label class="detail-option-chip detail-option-chip--gold">
                  <input type="radio" name="ribbon_color" value="Gold" data-cart-option="Ribbon Color" />
                  <span>Gold</span>
                </label>
                <label class="detail-option-chip detail-option-chip--red">
                  <input type="radio" name="ribbon_color" value="Red" data-cart-option="Ribbon Color" />
                  <span>Red</span>
                </label>
              </div>
            </div>
          </div>

          <ul class="products__list">
            <li class="list__item flex">
              <i class="fi fi-rs-crown"></i> 7 Days Freshness Guarantee
            </li>
            <li class="list__item flex">
              <i class="fi fi-rs-refresh"></i> Easy order update before delivery
            </li>
            <li class="list__item flex">
              <i class="fi fi-rs-credit-card"></i> Visa and PayPal payment demo
            </li>
          </ul>

          <div class="details__action">
            <a href="javascript:void(0)" class="btn btn--sm" data-detail-cart="true">Add To Cart</a>
            <a href="javascript:void(0)" class="details__action-btn wishlist__btn" aria-label="Add to Wishlist" title="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
          </div>

        </div>
      </div>
    </section>
    <!--=============== REVIEWS ===============-->
    <section class="reviews-section container section--lg">
      <h3 class="section__title"><span>Customer</span> Reviews</h3>

      <!-- Rating Summary & Breakdown -->
      <div id="rating-summary-container" class="rating-summary-container">
        <!-- Injected by JS -->
      </div>

      <!-- Write a Review Box -->
      <div class="review-box">
        <h4>💌 Write a Review</h4>
        
        <div class="star-rating-input" id="star-rating-input">
          <span data-value="1">★</span>
          <span data-value="2">★</span>
          <span data-value="3">★</span>
          <span data-value="4">★</span>
          <span data-value="5">★</span>
        </div>

        <textarea 
          id="review-text" 
          class="review-textarea" 
          placeholder="Tell us how you loved your flowers... 🌸"
        ></textarea>

        <button class="review-submit-btn" onclick="submitReview()">
          Post Review 🌷
        </button>
      </div>

      <!-- Reviews List -->
      <div class="reviews-list" id="reviews-list">
        <!-- Reviews injected here by JS -->
      </div>
    </section>
    <!--=============== RELATED PRODUCTS ===============-->
    <section class="products container section--lg">
      <h3 class="section__title"><span>Related</span> Products</h3>
      <div class="products__container grid" id="related-products">
        <!-- Injected dynamically by JS -->
      </div>
    </section>

     
  </main><!-- ✅ AUTO-LOAD CORRECT COLLECTION SCRIPT — ALL 12 FLOWER TYPES READY -->
  <script src="assets/js/review_helper.js"></script>
  <script>
    (function () {
      const id = new URLSearchParams(window.location.search).get("id") || "";

      // Extract collection name from ID (e.g., "rose-red" → "rose", "tulip-pink" → "tulip")
      const collection = id.split("-")[0];

      // ✅ ALL COLLECTIONS MAPPED — Just create the JS file and you're done!
      const collectionMap = {
        "buttercup": "buttercup.js",
        "daffodil": "daffodils.js",
        "daisy": "daisy.js",
        "rose": "rose.js",
        "tulip": "tulip.js",
        "lily": "lily.js",
        "orchid": "orchids.js",
        "sunflower": "sunflower.js",
        "mixed": "mixed_flower.js",
        "minirose": "minirose.js",
        "vip": "vip.js",
        "gift": "gifts.js",
        "bear": "bearchocolate.js",
        "chocolate": "bearchocolate.js"
      };

      const scriptName = collectionMap[collection] || "buttercup.js";

      const script = document.createElement("script");
      script.async = false;
      script.src = "assets/js/" + scriptName + "?v=20260514";
      document.body.appendChild(script);
    })();
  </script>


  <!--=============== REMOVE COMPARE & SHARE ICONS FROM RELATED PRODUCTS ===============-->
  <script>
    (function() {
      // Function to remove compare and share icons
      function removeUnwantedIcons() {
        // Common compare icon classes/patterns
        const compareSelectors = [
          '.fi-rs-shuffle',
          '.fi-rs-exchange',
          '.fi-rs-random',
          '[aria-label="Compare"]',
          '[title="Compare"]',
          '.action__btn[aria-label="Compare"]',
          'a[href="#"]:has(.fi-rs-shuffle)',
          'a:has(.fi-rs-shuffle)',
          '.compare-btn',
          '.action__btn:nth-child(2)' // Often compare is the 2nd action button
        ];

        // Share icon classes/patterns
        const shareSelectors = [
          '.fi-rs-eye',
          '.fi-rs-preview',
          '.fi-rs-view',
          '[aria-label="Share"]',
          '[title="Share"]',
          '[aria-label="Share"]',
          '[title="Share"]',
          '.action__btn[aria-label="Share"]',
          '.action__btn[aria-label="Share"]',
          'a:has(.fi-rs-eye)',
          '.share-btn',
          '.share-btn',
          '.action__btn:nth-child(1)' // Often share is the 1st action button
        ];

        // Remove compare icons
        compareSelectors.forEach(selector => {
          try {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
              const parent = el.closest('.action__btn, a, button');
              if (parent && parent !== el) {
                parent.remove();
              } else {
                el.remove();
              }
            });
          } catch(e) {
            // Invalid selector, skip
          }
        });

        // Remove share icons
        shareSelectors.forEach(selector => {
          try {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => {
              const parent = el.closest('.action__btn, a, button');
              if (parent && parent !== el) {
                parent.remove();
              } else {
                el.remove();
              }
            });
          } catch(e) {
            // Invalid selector, skip
          }
        });

        // Also look for any element containing compare or quick view text
        document.querySelectorAll('.action__btn, .product__actions a, .product__actions button').forEach(btn => {
          const ariaLabel = btn.getAttribute('aria-label') || '';
          const title = btn.getAttribute('title') || '';
          const text = btn.textContent || '';

          if (ariaLabel.toLowerCase().includes('compare') || 
              title.toLowerCase().includes('compare') ||
              ariaLabel.toLowerCase().includes('share') || 
              title.toLowerCase().includes('share') ||
              ariaLabel.toLowerCase().includes('share') || 
              title.toLowerCase().includes('share') ||
              text.toLowerCase().includes('share') ||
              text.toLowerCase().includes('share')) {
            btn.remove();
          }
        });
      }

      // Run immediately
      removeUnwantedIcons();

      // Also run after short delays in case JS loads products dynamically
      setTimeout(removeUnwantedIcons, 500);
      setTimeout(removeUnwantedIcons, 1500);
      setTimeout(removeUnwantedIcons, 3000);

      // Use MutationObserver to catch dynamically added products
      const observer = new MutationObserver(function(mutations) {
        let shouldRemove = false;
        mutations.forEach(function(mutation) {
          if (mutation.addedNodes.length > 0) {
            shouldRemove = true;
          }
        });
        if (shouldRemove) {
          removeUnwantedIcons();
        }
      });

      observer.observe(document.body, {
        childList: true,
        subtree: true
      });
    })();
  </script>
 <!--=============== search ===============--><?php include 'footer.php'; ?>

