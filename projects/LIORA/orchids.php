<?php
session_start();
include 'header.php';
?>
  <!--=============== HEADER ===============-->
  

  <!--=============== MAIN ===============-->
  <main class="main">
    <!--=============== FLOWER TABS BAR ===============-->
    <div class="flower-tabs-bar">
      <div class="tab__btns flower-types-menu">
        <a href="rose.php" class="tab__btn">Roses</a>
        <a href="tulip.php" class="tab__btn">Tulips</a>
        <a href="lily.php" class="tab__btn">Lilies</a>
        <a href="orchids.php" class="tab__btn active-tab">Orchids</a>
        <a href="sunflower.php" class="tab__btn">Sunflowers</a>
        <a href="mixed_flower.php" class="tab__btn">Mixed Bouquets</a>
        <a href="buttercup.php" class="tab__btn">Buttercup</a>
        <a href="daisies.php" class="tab__btn">Daisies</a>
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
       
      </div>
    </div>

    <!--=============== ORCHIDS COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Orchids</span> Collection</h2>
        </div>
      </div>

      <div class="sort-container container">
        <div class="sort-wrapper">
          <span class="sort-label">Sort by Price:</span>
          <select id="price-sort" class="sort-select">
            <option value="default">✨ Default</option>
            <option value="low-to-high">🌸 Lowest to Highest</option>
            <option value="high-to-low">💎 Highest to Lowest</option>
          </select>
        </div>
      </div>

      <div class="products__container grid">

        <!-- Product 1 -->
        <div class="product__item" data-price="30.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-purple-majesty" class="product__images">
              <img src="assets/img/items/orchids/orchid_1.jpg" alt="Purple Majesty Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_1.jpg" alt="Purple Majesty Orchids hover" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            <div class="share-menu">
              <a class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            </div>
            <div class="product__badge light-pink">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-purple-majesty"><h3 class="product__title">Purple Majesty Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید مۆر شاهانە</p></a>
            <div class="product__price flex">
              <span class="new__price">$30</span>
              <span class="old__price">$39</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-pink-champagne" class="product__images">
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids hover" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            <div class="share-menu">
              <a class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            </div>
            <div class="product__badge light-pink">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-pink-champagne"><h3 class="product__title">Pink Champagne Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید پینکی شەمپاین</p></a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="30.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-sunset-coral" class="product__images">
              <img src="assets/img/items/orchids/orchid_6.jpg" alt="Sunset Coral Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_6.jpg" alt="Sunset Coral Orchids hover" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            <div class="share-menu">
              <a class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            </div>
            <div class="product__badge light-orange">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-sunset-coral"><h3 class="product__title">Sunset Coral Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید کۆرالی غرووبی خۆر</p></a>
            <div class="product__price flex">
              <span class="new__price">$30</span>
              <span class="old__price">$39</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-pink-cascade" class="product__images">
              <img src="assets/img/items/orchids/orchid_7.jpg" alt="Pink Cascade Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_7.jpg" alt="Pink Cascade Orchids hover" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            <div class="share-menu">
              <a class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            </div>
            <div class="product__badge light-green">New</div>
          </div>
          <div class="product__content">
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-pink-cascade"><h3 class="product__title">Pink Cascade Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید پینکی کاسکید</p></a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-golden-sunrise" class="product__images">
              <img src="assets/img/items/orchids/orchid_9.jpg" alt="Golden Sunrise Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_9.jpg" alt="Golden Sunrise Orchids hover" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            <div class="share-menu">
              <a class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            </div>
            <div class="product__badge light-orange">-15%</div>
          </div>
          <div class="product__content">
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-golden-sunrise"><h3 class="product__title">Golden Sunrise Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید زێڕینی هەڵاتنی خۆر</p></a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="35.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-ocean-breeze" class="product__images">
              <img src="assets/img/items/orchids/orchid_10.jpg" alt="Ocean Breeze Blue Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_10.jpg" alt="Ocean Breeze Blue Orchids hover" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            <div class="share-menu">
              <a class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            </div>
            <div class="product__badge light-blue">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-ocean-breeze"><h3 class="product__title">Ocean Breeze Blue Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید شینی نسیمی ئۆقیانوس</p></a>
            <div class="product__price flex">
              <span class="new__price">$35</span>
              <span class="old__price">$45</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>


      </div>
    </section>
  </main><script src="assets/js/orchids.js"></script>
   

<?php include 'footer.php'; ?>



