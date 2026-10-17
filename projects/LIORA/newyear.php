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
          <h2 class="section__title"><span>NewYear</span> Collections</h2>
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
        <div class="product__item" data-price="48.00">
          <div class="product__banner">
            <a href="details.php?id=vip-7" class="product__images">
              <img src="assets/img/items/vip/vip_7.jpg" alt="VIP flowers" class="product__img default" />
              <img src="assets/img/items/vip/vip_7.jpg" alt="VIP flowers" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">vip</div>
          </div>
          <div class="product__content">
            <span class="product__category">Bouquets</span>
            <a href="details.php?id=vip-7">
              <h3 class="product__title">VIP flowers</h3>
              <p class="product__subtitle">VIP flowers</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$48</span>
              <span class="old__price">$62</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="42.00">
          <div class="product__banner">
            <a href="details.php?id=vip-1" class="product__images">
              <img src="assets/img/items/vip/vip_1.jpg" alt="tulip mix color" class="product__img default" />
              <img src="assets/img/items/vip/vip_1.jpg" alt="tulip mix color" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">vip</div>
          </div>
          <div class="product__content">
            <span class="product__category">Bouquets</span>
            <a href="details.php?id=vip-1">
              <h3 class="product__title">tulip mix color</h3>
              <p class="product__subtitle">tulip mix color</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$42</span>
              <span class="old__price">$54</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="45.00">
          <div class="product__banner">
            <a href="details.php?id=vip-2" class="product__images">
              <img src="assets/img/items/vip/vip_2.jpg" alt="tulips" class="product__img default" />
              <img src="assets/img/items/vip/vip_2.jpg" alt="tulips" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">vip</div>
          </div>
          <div class="product__content">
            <span class="product__category">Bouquets</span>
            <a href="details.php?id=vip-2">
              <h3 class="product__title">tulips</h3>
              <p class="product__subtitle">tulips</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$45</span>
              <span class="old__price">$58</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="48.00">
          <div class="product__banner">
            <a href="details.php?id=vip-3" class="product__images">
              <img src="assets/img/items/vip/vip_3.jpg" alt="white tulips Luxury" class="product__img default" />
              <img src="assets/img/items/vip/vip_3.jpg" alt="white tulips Luxury" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">vip</div>
          </div>
          <div class="product__content">
            <span class="product__category">Bouquets</span>
            <a href="details.php?id=vip-3">
              <h3 class="product__title">white tulips Luxury</h3>
              <p class="product__subtitle">white tulips Luxury</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$48</span>
              <span class="old__price">$62</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="46.00">
          <div class="product__banner">
            <a href="details.php?id=vip-4" class="product__images">
              <img src="assets/img/items/vip/vip_4.jpg" alt="pink VIP flowers" class="product__img default" />
              <img src="assets/img/items/vip/vip_4.jpg" alt="pink VIP flowers" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">vip</div>
          </div>
          <div class="product__content">
            <span class="product__category">Bouquets</span>
            <a href="details.php?id=vip-4">
              <h3 class="product__title">pink VIP flowers</h3>
              <p class="product__subtitle">pink VIP flowers</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$46</span>
              <span class="old__price">$59</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="50.00">
          <div class="product__banner">
            <a href="details.php?id=vip-5" class="product__images">
              <img src="assets/img/items/vip/vip_5.jpg" alt="mini rose pink vip" class="product__img default" />
              <img src="assets/img/items/vip/vip_5.jpg" alt="mini rose pink vip" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">vip</div>
          </div>
          <div class="product__content">
            <span class="product__category">Bouquets</span>
            <a href="details.php?id=vip-5">
              <h3 class="product__title">mini rose pink vip</h3>
              <p class="product__subtitle">mini rose pink vip</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$50</span>
              <span class="old__price">$65</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <!-- Product 1 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-soft-pink" class="product__images">
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Roses" class="product__img default">
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Roses hover" class="product__img hover">
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
            <div class="product__badge light-pink">Best Seller</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-soft-pink">
              <h3 class="product__title">Soft Pink Roses</h3>
            <p class="product__subtitle">گولی ڕۆز پینکی نەرم</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-pure-white" class="product__images">
              <img src="assets/img/items/tulips/tulip_3.jpg" alt="White Tulips" class="product__img default">
              <img src="assets/img/items/tulips/tulip_3.jpg" alt="White Tulips hover" class="product__img hover">
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
            <div class="product__badge light-green">Fresh</div>
          </div>
          <div class="product__content">
            <span class="product__category">Tulips</span>
            <a href="details.php?id=tulip-pure-white">
              <h3 class="product__title">White Tulips</h3>
            <p class="product__subtitle">گولی تولپ سپی پاک</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=chocolate_3" class="product__images">
              <img src="assets/img/items/chocolate/chocolate_3.jpg" alt="Strawberry Chocolate Set" class="product__img default">
              <img src="assets/img/items/chocolate/chocolate_3.jpg" alt="Strawberry Chocolate Set hover" class="product__img hover">
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
            <div class="product__badge light-orange">Love</div>
          </div>
          <div class="product__content">
            <span class="product__category">Chocolates</span>
            <a href="giftdetail.php?id=chocolate_3">
              <h3 class="product__title">Strawberry Chocolate Set</h3>
            </a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=lily-pink-galaxy" class="product__images">
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Lily Bouquet" class="product__img default">
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Lily Bouquet hover" class="product__img hover">
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
            <div class="product__badge light-orange">Elegant</div>
          </div>
          <div class="product__content">
            <span class="product__category">Lilies</span>
            <a href="details.php?id=lily-pink-galaxy">
              <h3 class="product__title">Pink Lily Bouquet</h3>            <p class="product__subtitle">گولی لیلی پینکی بوکێت</p>            </a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=orchid-pink-champagne" class="product__images">
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Orchid" class="product__img default">
              <img src="assets/img/items/orchids/orchid_5.jpg" alt="Pink Orchid hover" class="product__img hover">
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
            <span class="product__category">Orchids</span>
            <a href="details.php?id=orchid-pink-champagne">
              <h3 class="product__title">Pink Orchid</h3>            <p class="product__subtitle">گولی ئۆرکید پینکی</p>            </a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-blush-blossom" class="product__images">
              <img src="assets/img/items/mixed/mixed_9.jpg" alt="New Year Mixed Bouquet" class="product__img default">
              <img src="assets/img/items/mixed/mixed_9.jpg" alt="New Year Mixed Bouquet hover" class="product__img hover">
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
            <div class="product__badge light-orange">Festive</div>
          </div>
          <div class="product__content">
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-blush-blossom">
              <h3 class="product__title">New Year Mixed Bouquet</h3>            <p class="product__subtitle">بوکێتی میکسی ساڵی نوێ</p>            </a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 7 -->
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=bear_6" class="product__images">
              <img src="assets/img/items/bear/bear_6.jpg" alt="Pink Love Bear" class="product__img default">
              <img src="assets/img/items/bear/bear_6.jpg" alt="Pink Love Bear hover" class="product__img hover">
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
            <div class="product__badge light-pink">Sweet</div>
          </div>
          <div class="product__content">
            <span class="product__category">Gifts</span>
            <a href="giftdetail.php?id=bear_6">
              <h3 class="product__title">Pink Love Bear</h3>
            </a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$19</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 8 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=gift-romantic-box" class="product__images">
              <img src="assets/img/items/other/s2.jpg" alt="Romantic Gift Box" class="product__img default">
              <img src="assets/img/items/other/s2.jpg" alt="Romantic Gift Box hover" class="product__img hover">
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
            <span class="product__category">Gift Box</span>
            <a href="details.php?id=gift-romantic-box">
              <h3 class="product__title">Romantic Gift Box</h3>
            </a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 9 -->
        <div class="product__item" data-price="30.00">
          <div class="product__banner">
            <a href="details.php?id=gift-tea-basket" class="product__images">
              <img src="assets/img/items/other/s3.jpg" alt="Tea Time Basket" class="product__img default">
              <img src="assets/img/items/other/s3.jpg" alt="Tea Time Basket hover" class="product__img hover">
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
            <div class="product__badge light-orange">Popular</div>
          </div>
          <div class="product__content">
            <span class="product__category">Gifts</span>
            <a href="details.php?id=gift-tea-basket">
              <h3 class="product__title">Tea Time Basket</h3>
            </a>
            <div class="product__price flex">
              <span class="new__price">$30</span>
              <span class="old__price">$39</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 10 -->
        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=bear_7" class="product__images">
              <img src="assets/img/items/bear/bear_7.jpg" alt="Classic Brown Bear" class="product__img default">
              <img src="assets/img/items/bear/bear_7.jpg" alt="Classic Brown Bear hover" class="product__img hover">
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
            <div class="product__badge light-pink">Classic</div>
          </div>
          <div class="product__content">
            <span class="product__category">Gifts</span>
            <a href="giftdetail.php?id=bear_7">
              <h3 class="product__title">Classic Brown Bear</h3>
            </a>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$19</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
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


