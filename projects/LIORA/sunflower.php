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
        <a href="sunflower.php" class="tab__btn active-tab">Sunflowers</a>
        <a href="mixed_flower.php" class="tab__btn">Mixed Bouquets</a>
        <a href="buttercup.php" class="tab__btn">Buttercup</a>
        <a href="daisies.php" class="tab__btn">Daisies</a>
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
       
      </div>
    </div>

    <!--=============== SUNFLOWERS COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Sunflowers</span> Collection</h2>
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
            <a href="details.php?id=sunflower-classic" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower Bouquet" class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower Bouquet hover" class="product__img hover" />
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
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-classic"><h3 class="product__title">Classic Yellow Sunflower Bouquet</h3>
              <p class="product__subtitle">گولی گەرداڵەی زەردی کلاسیک</p></a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$18</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=sunflower-sunny-basket" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_3.jpg" alt="Sunny Day Basket" class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_3.jpg" alt="Sunny Day Basket hover" class="product__img hover" />
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
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-sunny-basket"><h3 class="product__title">Sunny Day Basket</h3>
              <p class="product__subtitle">سەبەتەی گەرداڵەی ڕۆژەکی خۆر</p></a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$22</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=sunflower-golden-vase" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_4.jpg" alt="Golden Vase Arrangement" class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_4.jpg" alt="Golden Vase Arrangement hover" class="product__img hover" />
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
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-golden-vase"><h3 class="product__title">Golden Vase Arrangement</h3>
              <p class="product__subtitle">گولی گەرداڵەی زێڕینی مزە</p></a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=sunflower-giant-heart" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_6.jpg" alt="Giant Sunflower Heart" class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_6.jpg" alt="Giant Sunflower Heart hover" class="product__img hover" />
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
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-giant-heart"><h3 class="product__title">Giant Sunflower Heart</h3>
              <p class="product__subtitle">دڵی گەرداڵەی گەورە</p></a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=sunflower-elegant" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_10.jpg" alt="Elegant Wrapped Sunflowers" class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_10.jpg" alt="Elegant Wrapped Sunflowers hover" class="product__img hover" />
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
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-elegant"><h3 class="product__title">Elegant Wrapped Sunflowers</h3>
              <p class="product__subtitle">گولی گەرداڵەی جوان پێچراو</p></a>
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

  


