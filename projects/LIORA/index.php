<?php
session_start();
include 'header.php';
?>

  <!--=============== HEADER ===============-->
  <!--=============== HEADER ===============-->
  
  <!--=============== MAIN ===============-->
  <main class="main">
    <!--=============== HOME ===============-->
    <section class="home hero-home">
      <div class="hero-home__container container">

        <div class="hero-home__content">
          <h1 class="hero-home__title">LIORA</h1>
          <p class="hero-home__description">
            Discover beautiful bouquets you can order online and schedule for delivery
            on any date you choose, perfect for birthdays, anniversaries, and every
            special moment in between. Browse a wide collection of fresh, handpicked
            flowers and personalize your order with ease. Not sure what to choose?
            Our smart AI assistant is here to guide you to the perfect arrangement in seconds.
          </p>

          <a href="flower.php" class="hero-home__btn">Shop Now</a>
        </div>

        <div class="hero-home__image"></div>

      </div>
    </section>
  <!--=============== populer flowers ===============-->
<section class="categories container section">
  <h3 class="section__title"><span>Popular</span> flowers</h3>
  <div class="categories__container swiper occ-swiper">   <!-- ← ONLY THIS LINE CHANGED -->
    <div class="swiper-wrapper">
      <a href="rose.php" class="category__item swiper-slide">
        <img src="assets/img/items/roses/rose_1.jpg" alt="" class="category__img" />
        <h3 class="category__title">Roses</h3>
      </a>
      <a href="tulip.php" class="category__item swiper-slide">
        <img src="assets/img/items/tulips/tulip_8.jpg" alt="" class="category__img" />
        <h3 class="category__title">Tulips</h3>
      </a>
      <a href="minirose.php" class="category__item swiper-slide">
        <img src="assets/img/items/minirose/oceanrosie.jpg" alt="" class="category__img" />
        <h3 class="category__title">MiniRose</h3>
      </a>
      <a href="orchids.php" class="category__item swiper-slide">
        <img src="assets/img/items/orchids/orchid_5.jpg" alt="" class="category__img" />
        <h3 class="category__title">Orchids</h3>
      </a>
      <a href="mixed_flower.php" class="category__item swiper-slide">
        <img src="assets/img/items/mixed/mixed_1.jpg" alt="" class="category__img" />
        <h3 class="category__title">Mixed Flowers</h3>
      </a>
      <a href="sunflower.php" class="category__item swiper-slide">
        <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="" class="category__img" />
        <h3 class="category__title">Sunflowers </h3>
      </a>
      <a href="lily.php" class="category__item swiper-slide">
        <img src="assets/img/items/lilys/lily_10.jpg" alt="" class="category__img" />
        <h3 class="category__title">Lilies</h3>
      </a>
      <a href="daisies.php" class="category__item swiper-slide">
        <img src="assets/img/items/daisies/daisy.jpg" alt="" class="category__img" />
        <h3 class="category__title">Daisies</h3>
      </a>
      <a href="daffodils.php" class="category__item swiper-slide">
        <img src="assets/img/items/daffodils/daffoldilsss.jpg" alt="" class="category__img" />
        <h3 class="category__title">daffodils</h3>
      </a>
      <a href="buttercup.php" class="category__item swiper-slide">
        <img src="assets/img/items/buttercup/modernbuttercup.jpg" alt="" class="category__img" />
        <h3 class="category__title">Butercup</h3>
      </a>
    </div>
    <div class="swiper-button-prev">
      <i class="fi fi-rs-angle-left"></i>
    </div>
    <div class="swiper-button-next">
      <i class="fi fi-rs-angle-right"></i>
    </div>
  </div>
</section>

    <!--=============== REWARD POSTER ===============-->

    <!--=============== REWARD POINTS OFFER ===============-->
    <section class="poster-section container section">
      <div class="offer-banner reward-banner">
        <div class="offer-content">
          <span class="offer-subtitle">Loyalty Rewards</span>
          <h2 class="offer-title">Earn Flower Points with Every Order 🎁</h2>
          <p class="offer-text">
            Collect points every time you shop and redeem them for discounts,
            premium wrapping, and surprise bouquets.
          </p>
          <a href="accounts.php?tab=reward-points" class="btn">View Rewards</a>
        </div>

        <div class="offer-image">
          <img src="assets/img/point.png" alt="Reward Points Banner" class="poster-img">
        </div>
      </div>
    </section>



        <!--=============== NEW ARRIVALS PRODUCTS ===============-->
    <section class="products container section new__arrivals">

      <div class="section__header">
        <h2 class="section__title vip-title">
          <span>NEW</span> ARRIVALS
        </h2>
      </div>

      <div class="tab__items">

        <div class="tab__item active-tab" content id="popular">
          <div class="products__container grid">
            <div class="product__item" data-price="24.00">
              <div class="product__banner">
                <a href="details.php?id=rose-ruby-red" class="product__images">
                  <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance" class="product__img default" />
                  <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
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
                  <span class="old__price">$31</span>
                </div>
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="20.00">
              <div class="product__banner">
                <a href="details.php?id=lily-white-heaven" class="product__images">
                  <img src="assets/img/items/lilys/lily_7.jpg" alt="White Heaven Lilies" class="product__img default" />
                  <img src="assets/img/items/lilys/lily_7.jpg" alt="White Heaven Lilies hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
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
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="21.00">
              <div class="product__banner">
                <a href="details.php?id=rose-blush-pink" class="product__images">
                  <img src="assets/img/items/roses/rose_7.jpg" alt="Blush Pink Dream" class="product__img default" />
                  <img src="assets/img/items/roses/rose_7.jpg" alt="Blush Pink Dream hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
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
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="17.00">
              <div class="product__banner">
                <a href="details.php?id=daisy-simple-white" class="product__images">
                  <img src="assets/img/items/daisies/whitedaisy.jpg" alt="Simple White Daisy Wrap" class="product__img default" />
                  <img src="assets/img/items/daisies/whitedaisy.jpg" alt="Simple White Daisy Wrap hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
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
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="14.00">
              <div class="product__banner">
                <a href="details.php?id=sunflower-classic" class="product__images">
                  <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower Bouquet" class="product__img default" />
                  <img src="assets/img/items/sunflowers/sunflower_2.jpg" alt="Classic Yellow Sunflower Bouquet hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
                </div>
                <div class="product__badge light-pink">Hot</div>
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
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="28.00">
              <div class="product__banner">
                <a href="details.php?id=orchid-pink-champagne" class="product__images">
                  <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids" class="product__img default" />
                  <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Champagne Orchids hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
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
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="16.00">
              <div class="product__banner">
                <a href="details.php?id=minirose-fairy-white" class="product__images">
                  <img src="assets/img/items/minirose/fairywhiterosie.jpg" alt="Fairy White Rosie Bouquet" class="product__img default" />
                  <img src="assets/img/items/minirose/fairywhiterosie.jpg" alt="Fairy White Rosie Bouquet hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
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
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="17.00">
              <div class="product__banner">
                <a href="details.php?id=daffodil-lightyellow" class="product__images">
                  <img src="assets/img/items/daffodils/lightyellowdaffoldils.jpg" alt="Light Yellow Dream" class="product__img default" />
                  <img src="assets/img/items/daffodils/lightyellowdaffoldils.jpg" alt="Light Yellow Dream hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
                </div>
                <div class="product__badge light-green">-15%</div>
              </div>
              <div class="product__content">
                <span class="product__category">Daffodils</span>
                <a href="details.php?id=daffodil-lightyellow">
                  <h3 class="product__title">Light Yellow Dream</h3>
              <p class="product__subtitle">گولی دەفۆدیل زەردی سووک</p>
                </a>
                <div class="product__price flex">
                  <span class="new__price">$17</span>
                  <span class="old__price">$22</span>
                </div>
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>
            <div class="product__item" data-price="22.00">
              <div class="product__banner">
                <a href="details.php?id=buttercup-modern" class="product__images">
                  <img src="assets/img/items/buttercup/modernbuttercup.jpg" alt="Modern Buttercup Arrangement" class="product__img default" />
                  <img src="assets/img/items/buttercup/modernbuttercup.jpg" alt="Modern Buttercup Arrangement hover" class="product__img hover" />
                </a>
                <div class="product__actions">
                  <div class="share-menu">
                    <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
                    <a class="share-link wa">WhatsApp</a>
                    <button type="button" class="share-link copy">Copy Link</button>
                  </div>
                  <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
                    <i class="fi fi-rs-heart"></i>
                  </a>
                  <a class="action__btn share__btn" aria-label="share">
                    <i class="fi fi-rs-shuffle"></i>
                  </a>
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
                <a class="action__btn cart__btn" aria-label="Add To Cart">
                  <i class="fi fi-rs-shopping-bag-add"></i>
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!--=============== AI ASSISTANT OFFER ===============-->
    <section class="poster-section container section">
      <div class="offer-banner robot-banner">
        <div class="offer-image">
          <img src="assets/img/AI.JPG" alt="Liora Assistant" class="poster-img">
        </div>

        <div class="offer-content">
          <span class="offer-subtitle">AI Florist Assistant</span>
          <h2 class="offer-title">Need Help Choosing Flowers? 🤖🌷</h2>
          <p class="offer-text">
            Let Liora Assistant help you choose the perfect bouquet for birthdays,
            Mother’s Day, Valentine, funerals, and special occasions.
          </p>
          <a href="chatbot.php" class="btn">Chat Now</a>
        </div>
      </div>
    </section>

   <!--=============== VIP ===============-->
<section class="new__arrivals container section">
  <h3 class="section__title"><span> VIP</span> FLOWERS</h3>
<div class="new__container swiper occ-swiper">
      <div class="swiper-wrapper">

      <!-- VIP 1 -->
      <div class="product__item swiper-slide" data-price="42.00">
        <div class="product__banner">
          <a href="details.php?id=vip-1" class="product__images">
            <img src="assets/img/items/vip/vip_1.jpg" alt="" class="product__img default" />
            <img src="assets/img/items/vip/vip_1.jpg" alt="" class="product__img hover" />
          </a>
          <div class="product__actions">
            <div class="share-menu">
              <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
            <a class="action__btn share__btn" aria-label="share">
              <i class="fi fi-rs-share"></i>
            </a>
          </div>
          <div class="product__badge light-pink">vip</div>
        </div>
        <div class="product__content">
          <span class="product__category">Bouquets</span>
          <a href="details.php?id=vip-1">
            <h3 class="product__title">tulip mix color</h3>
          </a>
          <div class="product__price flex">
            <span class="new__price">$42</span>
            <span class="old__price">$54</span>
          </div>
          <a class="action__btn cart__btn" aria-label="Add To Cart">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>

      <!-- VIP 2 -->
      <div class="product__item swiper-slide" data-price="45.00">
        <div class="product__banner">
          <a href="details.php?id=vip-2" class="product__images">
            <img src="assets/img/items/vip/vip_2.jpg" alt="" class="product__img default" />
            <img src="assets/img/items/vip/vip_2.jpg" alt="" class="product__img hover" />
          </a>
          <div class="product__actions">
            <div class="share-menu">
              <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
            <a class="action__btn share__btn" aria-label="share">
              <i class="fi fi-rs-share"></i>
            </a>
          </div>
          <div class="product__badge light-pink">vip</div>
        </div>
        <div class="product__content">
          <span class="product__category">Bouquets</span>
          <a href="details.php?id=vip-2">
            <h3 class="product__title">tulips </h3>
          </a>
          <div class="product__price flex">
            <span class="new__price">$45</span>
            <span class="old__price">$58</span>
          </div>
          <a class="action__btn cart__btn" aria-label="Add To Cart">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>

      <!-- VIP 3 -->
      <div class="product__item swiper-slide" data-price="48.00">
        <div class="product__banner">
          <a href="details.php?id=vip-3" class="product__images">
            <img src="assets/img/items/vip/vip_3.jpg" alt="" class="product__img default" />
            <img src="assets/img/items/vip/vip_3.jpg" alt="" class="product__img hover" />
          </a>
          <div class="product__actions">
            <div class="share-menu">
              <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
            <a class="action__btn share__btn" aria-label="share">
              <i class="fi fi-rs-shuffle"></i>
            </a>
          </div>
          <div class="product__badge light-pink">vip</div>
        </div>
        <div class="product__content">
          <span class="product__category">Bouquets</span>
          <a href="details.php?id=vip-3">
            <h3 class="product__title">white tulips Luxury</h3>
          </a>
          <div class="product__price flex">
            <span class="new__price">$48</span>
            <span class="old__price">$62</span>
          </div>
          <a class="action__btn cart__btn" aria-label="Add To Cart">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>

      <!-- VIP 4 -->
      <div class="product__item swiper-slide" data-price="46.00">
        <div class="product__banner">
          <a href="details.php?id=vip-4" class="product__images">
            <img src="assets/img/items/vip/vip_4.jpg" alt="" class="product__img default" />
            <img src="assets/img/items/vip/vip_4.jpg" alt="" class="product__img hover" />
          </a>
          <div class="product__actions">
            <div class="share-menu">
              <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
            <a class="action__btn share__btn" aria-label="share">
              <i class="fi fi-rs-shuffle"></i>
            </a>
          </div>
          <div class="product__badge light-pink">vip</div>
        </div>
        <div class="product__content">
          <span class="product__category">Bouquets</span>
          <a href="details.php?id=vip-4">
            <h3 class="product__title">pink VIP flowers</h3>
          </a>
          <div class="product__price flex">
            <span class="new__price">$46</span>
            <span class="old__price">$59</span>
          </div>
          <a class="action__btn cart__btn" aria-label="Add To Cart">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>

      <!-- VIP 5 -->
      <div class="product__item swiper-slide" data-price="50.00">
        <div class="product__banner">
          <a href="details.php?id=vip-5" class="product__images">
            <img src="assets/img/items/vip/vip_5.jpg" alt="" class="product__img default" />
            <img src="assets/img/items/vip/vip_5.jpg" alt="" class="product__img hover" />
          </a>
          <div class="product__actions">
            <div class="share-menu">
              <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
            <a class="action__btn share__btn" aria-label="share">
              <i class="fi fi-rs-shuffle"></i>
            </a>
          </div>
          <div class="product__badge light-pink">vip</div>
        </div>
        <div class="product__content">
          <span class="product__category">Bouquets</span>
          <a href="details.php?id=vip-5">
            <h3 class="product__title">mini rose pink vip </h3>
          </a>
          <div class="product__price flex">
            <span class="new__price">$50</span>
            <span class="old__price">$65</span>
          </div>
          <a class="action__btn cart__btn" aria-label="Add To Cart">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>

      <!-- VIP 6 -->
      <div class="product__item swiper-slide" data-price="49.00">
        <div class="product__banner">
          <a href="details.php?id=vip-6" class="product__images">
            <img src="assets/img/items/vip/vip_6.jpg" alt="" class="product__img default" />
            <img src="assets/img/items/vip/vip_6.jpg" alt="" class="product__img hover" />
          </a>
          <div class="product__actions">
            <div class="share-menu">
              <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
            <a class="action__btn share__btn" aria-label="share">
              <i class="fi fi-rs-shuffle"></i>
            </a>
          </div>
          <div class="product__badge light-pink">vip</div>
        </div>
        <div class="product__content">
          <span class="product__category">Bouquets</span>
          <a href="details.php?id=vip-6">
            <h3 class="product__title">lily whute flowers</h3>
          </a>
          <div class="product__price flex">
            <span class="new__price">$49</span>
            <span class="old__price">$63</span>
          </div>
          <a class="action__btn cart__btn" aria-label="Add To Cart">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>

      <!-- VIP 7 -->
      <div class="product__item swiper-slide" data-price="48.00">
        <div class="product__banner">
          <a href="details.php?id=vip-7" class="product__images">
            <img src="assets/img/items/vip/vip_7.jpg" alt="" class="product__img default" />
            <img src="assets/img/items/vip/vip_7.jpg" alt="" class="product__img hover" />
          </a>
          <div class="product__actions">
            <div class="share-menu">
              <a href="https://www.facebook.com" target="_blank" class="share-link fb">Facebook</a>
              <a class="share-link wa">WhatsApp</a>
              <button type="button" class="share-link copy">Copy Link</button>
            </div>
            <a class="action__btn wishlist__btn" aria-label="Add to Wishlist">
              <i class="fi fi-rs-heart"></i>
            </a>
            <a class="action__btn share__btn" aria-label="share">
              <i class="fi fi-rs-shuffle"></i>
            </a>
          </div>
          <div class="product__badge light-pink">vip</div>
        </div>
        <div class="product__content">
          <span class="product__category">Bouquets</span>
          <a href="details.php?id=vip-7">
            <h3 class="product__title">VIP flowers</h3>
          </a>
          <div class="product__price flex">
            <span class="new__price">$48</span>
            <span class="old__price">$62</span>
          </div>
          <a class="action__btn cart__btn" aria-label="Add To Cart">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>

    </div>

    <div class="swiper-button-prev">
      <i class="fi fi-rs-angle-left"></i>
    </div>
    <div class="swiper-button-next">
      <i class="fi fi-rs-angle-right"></i>
    </div>
  </div>
</section>

<!-- Swiper Initialization for Occasions + VIP -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const allOccasionSwipers = document.querySelectorAll('.occ-swiper');

    allOccasionSwipers.forEach((swiperEl) => {
      new Swiper(swiperEl, {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 20,
        navigation: {
          nextEl: swiperEl.querySelector('.swiper-button-next'),
          prevEl: swiperEl.querySelector('.swiper-button-prev'),
        },
        breakpoints: {
          640:  { slidesPerView: 2 },
          768:  { slidesPerView: 3 },
          1024: { slidesPerView: 4 }
        }
      });
    });
  });
</script>

    <!--=============== NEWSLETTER ===============
    <section class="newsletter section home__newsletter">
      <div class="newsletter__container container grid">
        <h3 class="newsletter__title flex">
          <img src="./assets/img/icon-email.svg" alt="" class="newsletter__icon" />
          Sign in to Newsletter
        </h3>
        <p class="newsletter__description">
          ...and receive $25 coupon for first shopping.
        </p>
        <form action="" class="newsletter__form">
          <input type="text" placeholder="Enter Your Email" class="newsletter__input" />
          <button type="submit" class="newsletter__btn">Subscribe</button>
        </form>
      </div>
    </section>
-->

    <!--=============== ADMIN ENTRY (HIDDEN FOR NOW) ===============-->
    <section class="container section" style="display: none;" id="admin-dashboard-entry">
      <h3 class="section__title"><span>Admin</span> Dashboard</h3>
      <!-- <p class="newsletter__description">
        Sales charts and order statistics are available in the admin dashboard only.
      </p> -->
      <a href="admin-dashboard.php" class="btn">Open Dashboard</a>
    </section>
    
  </main>


<?php
include 'footer.php';
?>
