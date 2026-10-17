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
        <a href="orchids.php" class="tab__btn">Orchids</a>
        <a href="sunflower.php" class="tab__btn">Sunflowers</a>
        <a href="mixed_flower.php" class="tab__btn">Mixed Bouquets</a>
        <a href="buttercup.php" class="tab__btn active-tab">Buttercup</a>
        <a href="daisies.php" class="tab__btn">Daisies</a>
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
      </div>
    </div>

    <!--=============== BUTTERCUP COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Buttercup</span> Collection</h2>
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
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="details.php?id=buttercup-golden" class="product__images">
              <img src="assets/img/items/buttercup/buttercup.jpg" alt="Golden Buttercup Bouquet"
                class="product__img default" />
              <img src="assets/img/items/buttercup/buttercup.jpg" alt="Golden Buttercup Bouquet hover"
                class="product__img hover" />
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
            <span class="product__category">Buttercup</span>
            <a href="details.php?id=buttercup-golden">
              <h3 class="product__title">Golden Buttercup Bouquet</h3>
              <p class="product__subtitle">گولی باتەرکاپ زێڕین</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$18</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="16.00">
          <div class="product__banner">
            <a href="details.php?id=buttercup-cream" class="product__images">
              <img src="assets/img/items/buttercup/buttercup6.jpg" alt="Cream & Gold Buttercup Wrap"
                class="product__img default" />
              <img src="assets/img/items/buttercup/buttercup6.jpg" alt="Cream & Gold Buttercup Wrap hover"
                class="product__img hover" />
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
            <span class="product__category">Buttercup</span>
            <a href="details.php?id=buttercup-cream">
              <h3 class="product__title">Cream & Gold Buttercup Wrap</h3>
              <p class="product__subtitle">گولی باتەرکاپ کریم و زێڕ</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$16</span>
              <span class="old__price">$20</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=buttercup-modern" class="product__images">
              <img src="assets/img/items/buttercup/modernbuttercup.jpg" alt="Modern Buttercup Arrangement"
                class="product__img default" />
              <img src="assets/img/items/buttercup/modernbuttercup.jpg" alt="Modern Buttercup Arrangement hover"
                class="product__img hover" />
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
            <span class="product__category">Buttercup</span>
            <a href="details.php?id=buttercup-modern">
              <h3 class="product__title">Modern Buttercup Arrangement</h3>
              <p class="product__subtitle">گولی باتەرکاپ مۆدێرن</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=buttercup-sunset" class="product__images">
              <img src="assets/img/items/buttercup/orangebuttercup.jpg" alt="Sunset Orange Buttercup"
                class="product__img default" />
              <img src="assets/img/items/buttercup/orangebuttercup.jpg" alt="Sunset Orange Buttercup hover"
                class="product__img hover" />
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
            <span class="product__category">Buttercup</span>
            <a href="details.php?id=buttercup-sunset">
              <h3 class="product__title">Sunset Orange Buttercup</h3>
              <p class="product__subtitle">گولی باتەرکاپ ئۆرنجی غرووب</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$22</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="details.php?id=buttercup-rosy" class="product__images">
              <img src="assets/img/items/buttercup/pinkbuttercup.jpg" alt="Rosy Pink Buttercup Bundle"
                class="product__img default" />
              <img src="assets/img/items/buttercup/pinkbuttercup.jpg" alt="Rosy Pink Buttercup Bundle hover"
                class="product__img hover" />
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
            <div class="product__badge light-green">-20%</div>
          </div>
          <div class="product__content">
            <span class="product__category">Buttercup</span>
            <a href="details.php?id=buttercup-rosy">
              <h3 class="product__title">Rosy Pink Buttercup Bundle</h3>
              <p class="product__subtitle">گولی باتەرکاپ پینکی ڕۆزی</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$18</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>
    </section>
  </main><script src="assets/js/buttercup.js"></script>


<?php include 'footer.php'; ?>
