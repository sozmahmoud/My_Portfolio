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
        <a href="daisies.php" class="tab__btn">Daisies</a>
        <a href="minirose.php" class="tab__btn active-tab">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
       
      </div>
    </div>

    <!--=============== MINI ROSES COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Mini</span> Rose</h2>
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
            <a href="details.php?id=minirose-crimson" class="product__images">
              <img src="assets/img/items/minirose/redminirose.jpg" alt="Crimson Mini Rose Bouquet"
                class="product__img default" />
              <img src="assets/img/items/minirose/redminirose.jpg" alt="Crimson Mini Rose Bouquet hover"
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
            <span class="product__category">Mini Roses</span>
            <a href="details.php?id=minirose-crimson">
              <h3 class="product__title">Crimson Mini Rose Bouquet</h3>
              <p class="product__subtitle">گولی مینی ڕۆز کریمسۆن</p>
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
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-pinky-baby" class="product__images">
              <img src="assets/img/items/minirose/pinkybabyrosie.jpg" alt="Pinky Baby Rose Wrap"
                class="product__img default" />
              <img src="assets/img/items/minirose/pinkybabyrosie.jpg" alt="Pinky Baby Rose Wrap hover"
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
            <div class="product__badge light-green">New</div>
          </div>
          <div class="product__content">
            <span class="product__category">Mini Roses</span>
            <a href="details.php?id=minirose-pinky-baby">
              <h3 class="product__title">Pinky Baby Rose Wrap</h3>
              <p class="product__subtitle">گولی مینی پینکی منداڵ</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$18</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-pretty-pink" class="product__images">
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" alt="Pretty Pink Rosie Bunch"
                class="product__img default" />
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" alt="Pretty Pink Rosie Bunch hover"
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
            <div class="product__badge light-orange">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Mini Roses</span>
            <a href="details.php?id=minirose-pretty-pink">
              <h3 class="product__title">Pretty Pink Rosie Bunch</h3>
              <p class="product__subtitle">گولی مینی پینکی جوان</p>
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
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-ocean-peach" class="product__images">
              <img src="assets/img/items/minirose/oceanrosie.jpg" alt="Ocean Peach Rosie Bouquet"
                class="product__img default" />
              <img src="assets/img/items/minirose/oceanrosie.jpg" alt="Ocean Peach Rosie Bouquet hover"
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
            <span class="product__category">Mini Roses</span>
            <a href="details.php?id=minirose-ocean-peach">
              <h3 class="product__title">Ocean Peach Rosie Bouquet</h3>
              <p class="product__subtitle">گولی مینی پێچی ئۆقیانوس</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-golden-sunset" class="product__images">
              <img src="assets/img/items/minirose/goldenrosie.jpg" alt="Golden Sunset Rosie"
                class="product__img default" />
              <img src="assets/img/items/minirose/goldenrosie.jpg" alt="Golden Sunset Rosie hover"
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
            <div class="product__badge light-orange">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Mini Roses</span>
            <a href="details.php?id=minirose-golden-sunset">
              <h3 class="product__title">Golden Sunset Rosie</h3>
              <p class="product__subtitle">گولی مینی زێڕینی غرووبی خۆر</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="16.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-fairy-white" class="product__images">
              <img src="assets/img/items/minirose/fairywhiterosie.jpg" alt="Fairy White Rosie Bouquet"
                class="product__img default" />
              <img src="assets/img/items/minirose/fairywhiterosie.jpg" alt="Fairy White Rosie Bouquet hover"
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
            <div class="product__badge light-green">New</div>
          </div>
          <div class="product__content">
            <span class="product__category">Mini Roses</span>
            <a href="details.php?id=minirose-fairy-white">
              <h3 class="product__title">Fairy White Rosie Bouquet</h3>
              <p class="product__subtitle">گولی مینی سپی پەری</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$16</span>
              <span class="old__price">$20</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>
    </section>
  </main><?php include 'footer.php'; ?>
