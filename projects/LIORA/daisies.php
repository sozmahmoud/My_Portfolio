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
        <a href="buttercup.php" class="tab__btn">Buttercup</a>
        <a href="daisies.php" class="tab__btn active-tab">Daisies</a>
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
      
      </div>
    </div>

    <!--=============== DAISIES COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Daisies</span> Collection</h2>
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
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-golden" class="product__images">
              <img src="assets/img/items/daisies/beautifuldaisy.jpg" alt="Golden Daisy Sunshine"
                class="product__img default" />
              <img src="assets/img/items/daisies/beautifuldaisy.jpg" alt="Golden Daisy Sunshine hover"
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
            <span class="product__category">Daisies</span>
            <a href="details.php?id=daisy-golden">
              <h3 class="product__title">Golden Daisy Sunshine</h3>
              <p class="product__subtitle">گولی دەیزی زێڕینی خۆر</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$22</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-pure-white" class="product__images">
              <img src="assets/img/items/daisies/daisies.jpg" alt="Pure White Daisy Bloom"
                class="product__img default" />
              <img src="assets/img/items/daisies/daisies.jpg" alt="Pure White Daisy Bloom hover"
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
            <span class="product__category">Daisies</span>
            <a href="details.php?id=daisy-pure-white">
              <h3 class="product__title">Pure White Daisy Bloom</h3>
              <p class="product__subtitle">گولی دەیزی سپی پاک</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-soft-charm" class="product__images">
              <img src="assets/img/items/daisies/daisy.jpg" alt="Soft Daisy Charm" class="product__img default" />
              <img src="assets/img/items/daisies/daisy.jpg" alt="Soft Daisy Charm hover" class="product__img hover" />
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
            <span class="product__category">Daisies</span>
            <a href="details.php?id=daisy-soft-charm">
              <h3 class="product__title">Soft Daisy Charm</h3>
              <p class="product__subtitle">گولی دەیزی نەرم و جوانی</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="26.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-blue-magic" class="product__images">
              <img src="assets/img/items/daisies/prettybluedaisy.jpg" alt="Blue Daisy Magic"
                class="product__img default" />
              <img src="assets/img/items/daisies/prettybluedaisy.jpg" alt="Blue Daisy Magic hover"
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
            <div class="product__badge light-blue">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Daisies</span>
            <a href="details.php?id=daisy-blue-magic">
              <h3 class="product__title">Blue Daisy Magic</h3>
              <p class="product__subtitle">گولی دەیزی شینی جادوویی</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$26</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-rosy-garden" class="product__images">
              <img src="assets/img/items/daisies/rosiedaisie.jpg" alt="Rosy Daisy Garden"
                class="product__img default" />
              <img src="assets/img/items/daisies/rosiedaisie.jpg" alt="Rosy Daisy Garden hover"
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
            <span class="product__category">Daisies</span>
            <a href="details.php?id=daisy-rosy-garden">
              <h3 class="product__title">Rosy Daisy Garden</h3>
              <p class="product__subtitle">گولی دەیزی ڕۆزی باخچە</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-simple-white" class="product__images">
              <img src="assets/img/items/daisies/whitedaisy.jpg" alt="Simple White Daisy Wrap"
                class="product__img default" />
              <img src="assets/img/items/daisies/whitedaisy.jpg" alt="Simple White Daisy Wrap hover"
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
            <span class="product__category">Daisies</span>
            <a href="details.php?id=daisy-simple-white">
              <h3 class="product__title">Simple White Daisy Wrap</h3>
              <p class="product__subtitle">گولی دەیزی سپی سادە</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$22</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>
    </section>
  </main><?php include 'footer.php'; ?>
