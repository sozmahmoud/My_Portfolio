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
        <a href="lily.php" class="tab__btn active-tab">Lilies</a>
        <a href="orchids.php" class="tab__btn">Orchids</a>
        <a href="sunflower.php" class="tab__btn">Sunflowers</a>
        <a href="mixed_flower.php" class="tab__btn">Mixed Bouquets</a>
        <a href="buttercup.php" class="tab__btn">Buttercup</a>
        <a href="daisies.php" class="tab__btn">Daisies</a>
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
      
      </div>
    </div>

    <!--=============== LILIES COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Lilies</span> Collection</h2>
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
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=lily-sunset-orange" class="product__images">
              <img src="assets/img/items/lilys/lily_2.jpg" alt="Sunset Orange Tiger Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_2.jpg" alt="Sunset Orange Tiger Lilies hover" class="product__img hover" />
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
            <div class="product__badge light-orange">New</div>
          </div>
          <div class="product__content">
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-sunset-orange"><h3 class="product__title">Sunset Orange Tiger Lilies</h3>
              <p class="product__subtitle">گولی لیلیی ئۆرنجی غرووبی خۆر</p></a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=lily-pink-galaxy" class="product__images">
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Galaxy Stargazer Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Galaxy Stargazer Lilies hover" class="product__img hover" />
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
            <div class="product__badge light-pink">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-pink-galaxy"><h3 class="product__title">Pink Galaxy Stargazer Lilies</h3>
              <p class="product__subtitle">گولی لیلیی پینکی گەلاکسی</p></a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="27.00">
          <div class="product__banner">
            <a href="details.php?id=lily-blush-pink" class="product__images">
              <img src="assets/img/items/lilys/lily_6.jpg" alt="Blush Pink Bouquet Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_6.jpg" alt="Blush Pink Bouquet Lilies hover" class="product__img hover" />
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
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-blush-pink"><h3 class="product__title">Blush Pink Bouquet Lilies</h3>
              <p class="product__subtitle">گولی لیلیی پینکی بلاش</p></a>
            <div class="product__price flex">
              <span class="new__price">$27</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=lily-white-heaven" class="product__images">
              <img src="assets/img/items/lilys/lily_7.jpg" alt="White Heaven Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_7.jpg" alt="White Heaven Lilies hover" class="product__img hover" />
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
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-white-heaven"><h3 class="product__title">White Heaven Lilies</h3>
              <p class="product__subtitle">گولی لیلیی سپی بەهەشت</p></a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="27.00">
          <div class="product__banner">
            <a href="details.php?id=lily-ocean-blue" class="product__images">
              <img src="assets/img/items/lilys/lily_9.jpg" alt="Ocean Blue Magic Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_9.jpg" alt="Ocean Blue Magic Lilies hover" class="product__img hover" />
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
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-ocean-blue"><h3 class="product__title">Ocean Blue Magic Lilies</h3>
              <p class="product__subtitle">گولی لیلیی شینی ئۆقیانوس</p></a>
            <div class="product__price flex">
              <span class="new__price">$27</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="30.00">
          <div class="product__banner">
            <a href="details.php?id=lily-pastel-dream" class="product__images">
              <img src="assets/img/items/lilys/lily_10.jpg" alt="Pastel Pink Dream Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_10.jpg" alt="Pastel Pink Dream Lilies hover" class="product__img hover" />
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
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-pastel-dream"><h3 class="product__title">Pastel Pink Dream Lilies</h3>
              <p class="product__subtitle">گولی لیلیی پاستێلی پینکی خەون</p></a>
            <div class="product__price flex">
              <span class="new__price">$30</span>
              <span class="old__price">$39</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>


      </div>
    </section>
  </main>
<script>
  console.log("Script loaded successfully");
  console.log("Flower data available:", typeof flowerData !== 'undefined');
  console.log("Load reviews function:", typeof loadReviews !== 'undefined');
</script><?php include 'footer.php'; ?>



