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
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn active-tab">Daffodils</a>
      
      </div>
    </div>

    <!--=============== DAFFODILS COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Daffodils</span> Collection</h2>
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
        <div class="product__item" data-price="16.00">
          <div class="product__banner">
            <a href="details.php?id=daffodil-baby" class="product__images">
              <img src="assets/img/items/daffodils/babydaffoldis.jpg" alt="Baby Spring Daffodils" class="product__img default" />
              <img src="assets/img/items/daffodils/babydaffoldis.jpg" alt="Baby Spring Daffodils hover" class="product__img hover" />
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
            <span class="product__category">Daffodils</span>
            <a href="details.php?id=daffodil-baby"><h3 class="product__title">Baby Spring Daffodils</h3>
              <p class="product__subtitle">گولی دەفۆدیل منداڵی بەهار</p></a>
            <div class="product__price flex">
              <span class="new__price">$16</span>
              <span class="old__price">$20</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=daffodil-classic" class="product__images">
              <img src="assets/img/items/daffodils/daffoldilsss.jpg" alt="Classic Yellow Daffodils" class="product__img default" />
              <img src="assets/img/items/daffodils/daffoldilsss.jpg" alt="Classic Yellow Daffodils hover" class="product__img hover" />
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
            <span class="product__category">Daffodils</span>
            <a href="details.php?id=daffodil-classic"><h3 class="product__title">Classic Yellow Daffodils</h3>
              <p class="product__subtitle">گۆلی دەفۆدیل زەردی کلاسیک</p></a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$18</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=daffodil-golden" class="product__images">
              <img src="assets/img/items/daffodils/gorgousdaffoldils.jpg" alt="Golden Spring Elegance" class="product__img default" />
              <img src="assets/img/items/daffodils/gorgousdaffoldils.jpg" alt="Golden Spring Elegance hover" class="product__img hover" />
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
            <span class="product__category">Daffodils</span>
            <a href="details.php?id=daffodil-golden"><h3 class="product__title">Golden Spring Elegance</h3>
              <p class="product__subtitle">گۆلی دەفۆدیل زێڕینی بەهار</p></a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=daffodil-lavender" class="product__images">
              <img src="assets/img/items/daffodils/lavenderdaffoldils.jpg" alt="Lavender Sunshine Mix" class="product__img default" />
              <img src="assets/img/items/daffodils/lavenderdaffoldils.jpg" alt="Lavender Sunshine Mix hover" class="product__img hover" />
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
            <span class="product__category">Daffodils</span>
            <a href="details.php?id=daffodil-lavender"><h3 class="product__title">Lavender Sunshine Mix</h3>
              <p class="product__subtitle">گولی دەفۆدیل لاڤەندەر خۆر</p></a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=daffodil-lightyellow" class="product__images">
              <img src="assets/img/items/daffodils/lightyellowdaffoldils.jpg" alt="Light Yellow Dream" class="product__img default" />
              <img src="assets/img/items/daffodils/lightyellowdaffoldils.jpg" alt="Light Yellow Dream hover" class="product__img hover" />
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
            <div class="product__badge light-green">-15%</div>
          </div>
          <div class="product__content">
            <span class="product__category">Daffodils</span>
            <a href="details.php?id=daffodil-lightyellow"><h3 class="product__title">Light Yellow Dream</h3>
              <p class="product__subtitle">گولی دەفۆدیل زەردی سووک</p></a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$22</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>
    </section>
  </main><script src="assets/js/daffodils.js"></script>
  

<?php include 'footer.php'; ?>



