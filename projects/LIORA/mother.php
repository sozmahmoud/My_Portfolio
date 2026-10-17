<?php
session_start();
include 'header.php';
?>
  <!--=============== HEADER ===============-->
  

  <!--=============== MAIN ===============-->
  <main class="main">


    <!--=============== FEATURED PRODUCTS ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Mother's</span> Day</h2>
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
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-pink-champagne" class="product__images">
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-soft-pink" class="product__images">
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Ribbon Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Ribbon Roses" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="21.00">
          <div class="product__banner">
            <a href="details.php?id=rose-blush-pink" class="product__images">
              <img src="assets/img/items/roses/rose_7.jpg" alt="Blush Pink Dream" class="product__img default" />
              <img src="assets/img/items/roses/rose_7.jpg" alt="Blush Pink Dream" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-blush-pink">
              <h3 class="product__title">Blush Pink Dream</h3>
              <p class="product__subtitle">گولی پینکی بلاش درێم</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$21</span>
              <span class="old__price">$27</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-rosy-garden" class="product__images">
              <img src="assets/img/items/daisies/rosiedaisie.jpg" alt="Rosy Daisy Garden" class="product__img default" />
              <img src="assets/img/items/daisies/rosiedaisie.jpg" alt="Rosy Daisy Garden" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-green">New</div>
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-pretty-pink" class="product__images">
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" alt="Pretty Pink Rosie Bunch" class="product__img default" />
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" alt="Pretty Pink Rosie Bunch" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">Premium</div>
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=lily-white-heaven" class="product__images">
              <img src="assets/img/items/lilys/lily_7.jpg" alt="White Heaven Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_7.jpg" alt="White Heaven Lilies" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <!-- Product 1 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-peach-paradise" class="product__images">
              <img src="assets/img/items/roses/rose_6.jpg" alt="Peach Paradise Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_6.jpg" alt="Peach Paradise Roses hover"
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
            <div class="product__badge light-pink">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-peach-paradise">
              <h3 class="product__title">Peach Paradise Roses</h3>
              <p class="product__subtitle">گولی پێچ پارادایز</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-pure-white" class="product__images">
              <img src="assets/img/items/tulips/tulip_3.jpg" alt="Pure White Elegance Tulips"
                class="product__img default" />
              <img src="assets/img/items/tulips/tulip_3.jpg" alt="Pure White Elegance Tulips hover"
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-pure-white">
              <h3 class="product__title">Pure White Elegance Tulips</h3>
              <p class="product__subtitle">گولی تیولیپ سپی پاک و جوان</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-pink-champagne" class="product__images">
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids"
                class="product__img default" />
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids hover"
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
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-pink-champagne">
              <h3 class="product__title">Pink Champagne Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید پینکی شەمپاین</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-blush-blossom" class="product__images">
              <img src="assets/img/items/mixed/mixed_9.jpg" alt="Blush Blossom Fantasy" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_9.jpg" alt="Blush Blossom Fantasy hover"
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
            <div class="product__badge light-blue">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-blush-blossom">
              <h3 class="product__title">Blush Blossom Fantasy</h3>
              <p class="product__subtitle">فانتازیای بلاش بلۆسم</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=lily-pink-galaxy" class="product__images">
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Galaxy Stargazer Lilies"
                class="product__img default" />
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Galaxy Stargazer Lilies hover"
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

        <!-- Product 6 -->
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
            <div class="product__badge light-green">New</div>
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

        <!-- Product 7 -->
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

        <!-- Product 8 -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=daffodil-golden" class="product__images">
              <img src="assets/img/items/daffodils/gorgousdaffoldils.jpg" alt="Golden Spring Elegance"
                class="product__img default" />
              <img src="assets/img/items/daffodils/gorgousdaffoldils.jpg" alt="Golden Spring Elegance hover"
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
            <span class="product__category">Daffodils</span>
            <a href="details.php?id=daffodil-golden">
              <h3 class="product__title">Golden Spring Elegance</h3>
              <p class="product__subtitle">گۆلی دەفۆدیل زێڕینی بەهار</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 9 -->
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
            <div class="product__badge light-blue">New</div>
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

        <!-- Product 10 -->
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="details.php?id=sunflower-classic" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower Bouquet"
                class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower Bouquet hover"
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
            <div class="product__badge light-green">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-classic">
              <h3 class="product__title">Classic Yellow Sunflower Bouquet</h3>
              <p class="product__subtitle">گولی گەرداڵەی زەردی کلاسیک</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$18</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      
        <!-- Ruby Red Romance -->
        <div class="product__item" data-price="24.00">
          <div class="product__banner">
            <a href="details.php?id=rose-ruby-red" class="product__images">
              <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance" class="product__img default" />
              <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance" class="product__img hover" />
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
            <div class="product__badge light-pink">Love</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-ruby-red">
              <h3 class="product__title">Ruby Red Romance</h3>
              <p class="product__subtitle">گولی ڕوبی سوور ڕۆمانس</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$24</span>
              <span class="old__price">$31</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Ruby Red Tulips -->
        <div class="product__item" data-price="24.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-ruby-red" class="product__images">
              <img src="assets/img/items/tulips/tulip_6.jpg" alt="Ruby Red Tulips" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_6.jpg" alt="Ruby Red Tulips" class="product__img hover" />
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
            <div class="product__badge light-pink">Romance</div>
          </div>
          <div class="product__content">
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-ruby-red">
              <h3 class="product__title">Ruby Red Tulips</h3>
              <p class="product__subtitle">گولی تولپی ڕوبی سوور</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$24</span>
              <span class="old__price">$31</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Crimson Mini Rose -->
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-crimson" class="product__images">
              <img src="assets/img/items/minirose/redminirose.jpg" alt="Crimson Mini Rose Bouquet" class="product__img default" />
              <img src="assets/img/items/minirose/redminirose.jpg" alt="Crimson Mini Rose Bouquet" class="product__img hover" />
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
            <div class="product__badge light-purple">Best Choice</div>
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>
    </section>

  </main><!--=============== search ===============--><?php include 'footer.php'; ?>


