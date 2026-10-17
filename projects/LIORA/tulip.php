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
        <a href="tulip.php" class="tab__btn active-tab">Tulips</a>
        <a href="lily.php" class="tab__btn">Lilies</a>
        <a href="orchids.php" class="tab__btn">Orchids</a>
        <a href="sunflower.php" class="tab__btn">Sunflowers</a>
        <a href="mixed_flower.php" class="tab__btn">Mixed Bouquets</a>
        <a href="buttercup.php" class="tab__btn">Buttercup</a>
        <a href="daisies.php" class="tab__btn">Daisies</a>
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
        
      </div>
    </div>

    <!--=============== TULIPS COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Tulips</span> Collection</h2>
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
            <a href="details.php?id=tulip-rainbow" class="product__images">
              <img src="assets/img/items/tulips/tulip_1.jpg" alt="Rainbow Mixed Tulips" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_1.jpg" alt="Rainbow Mixed Tulips hover" class="product__img hover" />
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-rainbow">
              <h3 class="product__title">Rainbow Mixed Tulips</h3>
              <p class="product__subtitle">گولی تیولیپ ڕەنگاو</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$22</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-red-white" class="product__images">
              <img src="assets/img/items/tulips/tulip_2.jpg" alt="Red & White Romance Tulips" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_2.jpg" alt="Red & White Romance Tulips hover" class="product__img hover" />
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-red-white">
              <h3 class="product__title">Red & White Romance Tulips</h3>
              <p class="product__subtitle">گولی تیولیپ سوور و سپی ڕۆمانس</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-pure-white" class="product__images">
              <img src="assets/img/items/tulips/tulip_3.jpg" alt="Pure White Elegance Tulips" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_3.jpg" alt="Pure White Elegance Tulips hover" class="product__img hover" />
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-pure-white">
              <h3 class="product__title">Pure White Elegance Tulips</h3>
              <p class="product__subtitle">گولی تیولیپ سپی پاک و جوان</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-lavender" class="product__images">
              <img src="assets/img/items/tulips/tulip_5.jpg" alt="Lavender Love Tulips" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_5.jpg" alt="Lavender Love Tulips hover" class="product__img hover" />
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-lavender">
              <h3 class="product__title">Lavender Love Tulips</h3>
              <p class="product__subtitle">گولی تیولیپ لاڤەندەر خۆشەویستی</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="24.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-ruby-red" class="product__images">
              <img src="assets/img/items/tulips/tulip_6.jpg" alt="Ruby Red Tulip Bouquet" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_6.jpg" alt="Ruby Red Tulip Bouquet hover" class="product__img hover" />
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-ruby-red">
              <h3 class="product__title">Ruby Red Tulip Bouquet</h3>
              <p class="product__subtitle">گولی تیولیپ ڕوبی سوور</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$24</span>
              <span class="old__price">$31</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-blush-pink" class="product__images">
              <img src="assets/img/items/tulips/tulip_8.jpg" alt="Blush Pink Tulip Bouquet" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_8.jpg" alt="Blush Pink Tulip Bouquet hover" class="product__img hover" />
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-blush-pink">
              <h3 class="product__title">Blush Pink Tulip Bouquet</h3>
              <p class="product__subtitle">گولی تیولیپ پینکی بلاش</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>
    </section>
    
  </main><?php include 'footer.php'; ?>

