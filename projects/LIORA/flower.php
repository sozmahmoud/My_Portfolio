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
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
        
      </div>
    </div>
    <!--=============== PRODUCTS ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Flowers</span> Collection</h2>
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
            <a href="details.php?id=buttercup-cream" class="product__images">
              <img src="assets/img/items/buttercup/buttercup6.jpg" alt="Cream & Gold Buttercup Wrap" class="product__img default" />
              <img src="assets/img/items/buttercup/buttercup6.jpg" alt="Cream & Gold Buttercup Wrap hover" class="product__img hover" />
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
              <span class="old__price">$25</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-soft-pink" class="product__images">
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Ribbon Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Ribbon Roses hover" class="product__img hover" />
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
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-soft-pink">
              <h3 class="product__title">Soft Pink Ribbon Roses</h3>
              <p class="product__subtitle">گولی پینکی نەرم و ڕیبۆن</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=rose-rainbow-romance" class="product__images">
              <img src="assets/img/items/roses/rose_2.jpg" alt="Rainbow Romance Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_2.jpg" alt="Rainbow Romance Roses hover" class="product__img hover" />
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
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-rainbow-romance">
              <h3 class="product__title">Rainbow Romance Roses</h3>
              <p class="product__subtitle">گولی ڕەنگاو ڕۆمانس</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$40</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="26.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-blue-magic" class="product__images">
              <img src="assets/img/items/daisies/prettybluedaisy.jpg" alt="Blue Daisy Magic" class="product__img default" />
              <img src="assets/img/items/daisies/prettybluedaisy.jpg" alt="Blue Daisy Magic hover" class="product__img hover" />
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
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
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
            <a href="details.php?id=lily-white-heaven">
              <h3 class="product__title">White Heaven Lilies</h3>
              <p class="product__subtitle">گولی لیلیی سپی بەهەشت</p>
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
            <a href="details.php?id=lily-pink-galaxy">
              <h3 class="product__title">Pink Galaxy Stargazer Lilies</h3>
              <p class="product__subtitle">گولی لیلیی پینکی گەلاکسی</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 7 -->
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
            <a href="details.php?id=orchid-golden-sunrise">
              <h3 class="product__title">Golden Sunrise Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید زێڕینی هەڵاتنی خۆر</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 8 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-pretty-pink" class="product__images">
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" alt="Pretty Pink Rosie Bunch" class="product__img default" />
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" alt="Pretty Pink Rosie Bunch hover" class="product__img hover" />
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
              <span class="old__price">$34</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 9 -->
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
            <a href="details.php?id=daffodil-classic">
              <h3 class="product__title">Classic Yellow Daffodils</h3>
              <p class="product__subtitle">گۆلی دەفۆدیل زەردی کلاسیک</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$17</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 10 -->
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
            <a href="details.php?id=sunflower-golden-vase">
              <h3 class="product__title">Golden Vase Arrangement</h3>
              <p class="product__subtitle">گولی گەرداڵەی زێڕینی مزە</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 11 -->
        <div class="product__item" data-price="24.00">
          <div class="product__banner">
            <a href="details.php?id=rose-ruby-red" class="product__images">
              <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance" class="product__img default" />
              <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance hover" class="product__img hover" />
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
            <div class="product__badge light-pink">-15%</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-ruby-red">
              <h3 class="product__title">Ruby Red Romance</h3>
              <p class="product__subtitle">گولی ڕوبی سوور ڕۆمانس</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$24</span>
              <span class="old__price">$38</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 12 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-rosy-garden" class="product__images">
              <img src="assets/img/items/daisies/rosiedaisie.jpg" alt="Rosy Daisy Garden" class="product__img default" />
              <img src="assets/img/items/daisies/rosiedaisie.jpg" alt="Rosy Daisy Garden hover" class="product__img hover" />
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
              <span class="old__price">$34</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 13 -->
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
            <a href="details.php?id=orchid-pink-champagne">
              <h3 class="product__title">Pink Champagne Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید پینکی شەمپاین</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$48</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 14 -->
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-pinky-baby" class="product__images">
              <img src="assets/img/items/minirose/pinkybabyrosie.jpg" alt="Pinky Baby Rose Wrap" class="product__img default" />
              <img src="assets/img/items/minirose/pinkybabyrosie.jpg" alt="Pinky Baby Rose Wrap hover" class="product__img hover" />
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
              <span class="old__price">$25</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 15 -->
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
              <span class="old__price">$38</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>

    </section>


  </main><?php include 'footer.php'; ?>
