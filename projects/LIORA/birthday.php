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
          <h2 class="section__title"><span>Birthday</span> Collections</h2>
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
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="details.php?id=sunflower-classic" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower" class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-classic">
              <h3 class="product__title">Classic Yellow Sunflower</h3>
              <p class="product__subtitle">گولی گەرداڵەی زەردی کلاسیک</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$18</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=rose-rainbow-romance" class="product__images">
              <img src="assets/img/items/roses/rose_2.jpg" alt="Rainbow Romance Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_2.jpg" alt="Rainbow Romance Roses" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="17.00">
          <div class="product__banner">
            <a href="details.php?id=daisy-simple-white" class="product__images">
              <img src="assets/img/items/daisies/whitedaisy.jpg" alt="Simple White Daisy Wrap" class="product__img default" />
              <img src="assets/img/items/daisies/whitedaisy.jpg" alt="Simple White Daisy Wrap" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=buttercup-modern" class="product__images">
              <img src="assets/img/items/buttercup/modernbuttercup.jpg" alt="Modern Buttercup" class="product__img default" />
              <img src="assets/img/items/buttercup/modernbuttercup.jpg" alt="Modern Buttercup" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Buttercup</span>
            <a href="details.php?id=buttercup-modern">
              <h3 class="product__title">Modern Buttercup</h3>
              <p class="product__subtitle">گولی باتەرکاپ مۆدێرن</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-golden-sunrise" class="product__images">
              <img src="assets/img/items/orchids/orchid_9.jpg" alt="Golden Sunrise Orchids" class="product__img default" />
              <img src="assets/img/items/orchids/orchid_9.jpg" alt="Golden Sunrise Orchids" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=sunflower-elegant" class="product__images">
              <img src="assets/img/items/sunflowers/sunflower_10.jpg" alt="Elegant Wrapped Sunflowers" class="product__img default" />
              <img src="assets/img/items/sunflowers/sunflower_10.jpg" alt="Elegant Wrapped Sunflowers" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-orange">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Sunflowers</span>
            <a href="details.php?id=sunflower-elegant">
              <h3 class="product__title">Elegant Wrapped Sunflowers</h3>
              <p class="product__subtitle">گولی گەرداڵەی جوان پێچراو</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <!-- 1 Roses -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-blue-sapphire" class="product__images">
              <img src="assets/img/items/roses/rose_1.jpg" alt="Blue Sapphire Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_1.jpg" alt="Blue Sapphire Roses hover" class="product__img hover" />
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
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-blue-sapphire">
              <h3 class="product__title">Blue Sapphire Roses</h3>
              <p class="product__subtitle">گولی سەفیر شین</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 2 Roses -->
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
            <div class="product__badge light-orange">Premium</div>
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

        <!-- 3 Tulips -->
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

        <!-- 4 Tulips -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-lavender" class="product__images">
              <img src="assets/img/items/tulips/tulip_5.jpg" alt="Lavender Love Tulips" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_5.jpg" alt="Lavender Love Tulips hover"
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
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-lavender">
              <h3 class="product__title">Lavender Love Tulips</h3>
              <p class="product__subtitle">گولی تیولیپ لاڤەندەر خۆشەویستی</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 5 Orchids -->
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 6 Orchids -->
        <div class="product__item" data-price="30.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-sunset-coral" class="product__images">
              <img src="assets/img/items/orchids/orchid_6.jpg" alt="Sunset Coral Orchids"
                class="product__img default" />
              <img src="assets/img/items/orchids/orchid_6.jpg" alt="Sunset Coral Orchids hover"
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
            <div class="product__badge light-orange">Hot</div>
          </div>
          <div class="product__content">
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-sunset-coral">
              <h3 class="product__title">Sunset Coral Orchids</h3>
              <p class="product__subtitle">گولی ئۆرکید کۆرالی غرووبی خۆر</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$30</span>
              <span class="old__price">$39</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 7 Lilies -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=lily-sunset-orange" class="product__images">
              <img src="assets/img/items/lilys/lily_2.jpg" alt="Sunset Orange Tiger Lilies"
                class="product__img default" />
              <img src="assets/img/items/lilys/lily_2.jpg" alt="Sunset Orange Tiger Lilies hover"
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
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-sunset-orange">
              <h3 class="product__title">Sunset Orange Tiger Lilies</h3>
              <p class="product__subtitle">گولی لیلیی ئۆرنجی غرووبی خۆر</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 8 Lilies -->
        <div class="product__item" data-price="27.00">
          <div class="product__banner">
            <a href="details.php?id=lily-ocean-blue" class="product__images">
              <img src="assets/img/items/lilys/lily_9.jpg" alt="Ocean Blue Magic Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_9.jpg" alt="Ocean Blue Magic Lilies hover"
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
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-ocean-blue">
              <h3 class="product__title">Ocean Blue Magic Lilies</h3>
              <p class="product__subtitle">گولی لیلیی شینی ئۆقیانوس</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$27</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i
                class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 9 Mixed -->
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
            <div class="product__badge light-pink">Hot</div>
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

        <!-- 10 Daisies -->
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

        <!-- 11 Daffodils -->
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
            <div class="product__badge light-orange">Hot</div>
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

        <!-- 12 Buttercup -->
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


