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
            <h4 class="details__subtitle">Customize Your Gift</h4>

            <div class="custom__option custom__option--choices">
              <span class="custom__label">Wrapping Style</span>
              <div class="detail-option-grid">
                <label class="detail-option-card">
                  <input type="radio" name="wrapping_style" value="Sweet Gift Bag" data-cart-option="Wrapping Style" checked />
                  <span>Sweet Gift Bag</span>
                  <small>Soft and simple</small>
                </label>
                <label class="detail-option-card">
                  <input type="radio" name="wrapping_style" value="Premium Gift Box" data-cart-option="Wrapping Style" />
                  <span>Premium Box</span>
                  <small>Neat boxed finish</small>
                </label>
                <label class="detail-option-card">
                  <input type="radio" name="wrapping_style" value="Cute Blush Wrap" data-cart-option="Wrapping Style" />
                  <span>Blush Wrap</span>
                  <small>Cute and cozy</small>
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
  <!-- ✅ UPDATED AUTO-LOAD SCRIPT (fix for bear_ and chocolate_) -->
<script src="assets/js/review_helper.js"></script>
<script>
  (function () {
    const id = new URLSearchParams(window.location.search).get("id") || "";

    // Improved collection detection (handles both "rose-ruby-red" and "bear_1")
    let collection;
    if (id.includes("_")) {
      collection = id.split("_")[0];        // bear_1 → bear, chocolate_1 → chocolate
    } else {
      collection = id.split("-")[0];        // rose-ruby-red → rose
    }

    // ALL COLLECTIONS MAPPED
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
      function removeUnwantedIcons() {
        const compareSelectors = [
          '.fi-rs-shuffle', '.fi-rs-exchange', '.fi-rs-random',
          '[aria-label="Compare"]', '[title="Compare"]',
          '.compare-btn', '.action__btn:nth-child(2)'
        ];
        const shareSelectors = [
          '.fi-rs-eye', '.fi-rs-preview', '.fi-rs-view',
          '[aria-label="Share"]', '[title="Share"]',
          '[aria-label="Share"]', '[title="Share"]',
          '.share-btn', '.share-btn', '.action__btn:nth-child(1)'
        ];

        [...compareSelectors, ...shareSelectors].forEach(selector => {
          try {
            document.querySelectorAll(selector).forEach(el => {
              const parent = el.closest('.action__btn, a, button');
              parent && parent !== el ? parent.remove() : el.remove();
            });
          } catch(e) {}
        });

        document.querySelectorAll('.action__btn, .product__actions a, .product__actions button').forEach(btn => {
          const label = (btn.getAttribute('aria-label') || '').toLowerCase();
          const title = (btn.getAttribute('title') || '').toLowerCase();
          const text = (btn.textContent || '').toLowerCase();
          if (label.includes('compare') || title.includes('compare') ||
              label.includes('share') || title.includes('share') ||
              label.includes('share') || title.includes('share') ||
              text.includes('share') || text.includes('share')) {
            btn.remove();
          }
        });
      }

      removeUnwantedIcons();
      [500, 1500, 3000].forEach(t => setTimeout(removeUnwantedIcons, t));

      new MutationObserver(muts => {
        if (muts.some(m => m.addedNodes.length)) removeUnwantedIcons();
      }).observe(document.body, { childList: true, subtree: true });
    })();
  </script>
 <!--=============== search ===============--><?php include 'footer.php'; ?>

