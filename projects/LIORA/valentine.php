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
          <h2 class="section__title"><span>Valentine's</span> Day</h2>
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
        <div class="product__item" data-price="24.00">
          <div class="product__banner">
            <a href="details.php?id=rose-ruby-red" class="product__images">
              <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance" class="product__img default" />
              <img src="assets/img/items/roses/rose_5.jpg" alt="Ruby Red Romance" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
            <a href="details.php?id=minirose-crimson" class="product__images">
              <img src="assets/img/items/minirose/redminirose.jpg" alt="Crimson Mini Rose Bouquet" class="product__img default" />
              <img src="assets/img/items/minirose/redminirose.jpg" alt="Crimson Mini Rose Bouquet" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=lily-pink-galaxy" class="product__images">
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Galaxy Stargazer Lilies" class="product__img default" />
              <img src="assets/img/items/lilys/lily_4.jpg" alt="Pink Galaxy Stargazer Lilies" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-blue-sapphire" class="product__images">
              <img src="assets/img/items/roses/rose_1.jpg" alt="Blue Sapphire Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_1.jpg" alt="Blue Sapphire Roses" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-pink">Premium</div>
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
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=rose-pure-white" class="product__images">
              <img src="assets/img/items/roses/rose_9.jpg" alt="Pure White Elegance" class="product__img default" />
              <img src="assets/img/items/roses/rose_9.jpg" alt="Pure White Elegance" class="product__img hover" />
            </a>
            <div class="product__actions">
              <a href="javascript:void(0)" class="action__btn wishlist__btn" aria-label="Add to Wishlist"><i class="fi fi-rs-heart"></i></a>
              <a href="javascript:void(0)" class="action__btn share__btn" aria-label="Share"><i class="fi fi-rs-share"></i></a>
            </div>
            <div class="product__badge light-blue">Premium</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-pure-white">
              <h3 class="product__title">Pure White Elegance</h3>
              <p class="product__subtitle">گولی سپی پاک و جوان</p>
            </a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>
              <!-- ===== 5 BEARS ===== -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=bear_1" class="product__images">
              <img src="assets/img/items/bear/bear_1.jpg" class="product__img default">
              <img src="assets/img/items/bear/bear_1.jpg" class="product__img hover">
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
            <div class="product__badge light-pink">Cute</div>
          </div>
          <div class="product__content">
            <span class="product__category">Gifts</span>
            <h3 class="product__title">Soft Classic Teddy Bear</h3>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$30</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <div class="product__item" data-price="24.00">
          <div class="product__banner">
            <a href="details.php?id=rose-ruby-red" class="product__images">
              <img src="assets/img/items/roses/rose_5.jpg" class="product__img default" />
              <img src="assets/img/items/roses/rose_5.jpg" class="product__img hover" />
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
            <h3 class="product__title">Ruby Red Romance</h3>
              <p class="product__subtitle">گولی ڕوبی سوور ڕۆمانس</p>
            <div class="product__price flex">
              <span class="new__price">$24</span>
              <span class="old__price">$31</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <div class="product__item" data-price="30.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=chocolate_4" class="product__images">
              <img src="assets/img/items/chocolate/chocolate_4.jpg" class="product__img default">
              <img src="assets/img/items/chocolate/chocolate_4.jpg" class="product__img hover">
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
            <div class="product__badge light-orange">Sweet Box</div>
          </div>
          <div class="product__content">
            <span class="product__category">Chocolates</span>
            <h3 class="product__title">Premium Chocolate Collection</h3>
            <div class="product__price flex">
              <span class="new__price">$30</span>
              <span class="old__price">$39</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=bear_2" class="product__images">
              <img src="assets/img/items/bear/bear_2.jpg" class="product__img default">
              <img src="assets/img/items/bear/bear_2.jpg" class="product__img hover">
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
            <div class="product__badge light-pink">Lovely</div>
          </div>
          <div class="product__content">
            <span class="product__category">Gifts</span>
            <h3 class="product__title">Elegant Pink Dress Bear</h3>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$30</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>



        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=bear_3" class="product__images">
              <img src="assets/img/items/bear/bear_3.jpg" class="product__img default">
              <img src="assets/img/items/bear/bear_3.jpg" class="product__img hover">
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
            <div class="product__badge light-pink">Mini</div>
          </div>
          <div class="product__content">
            <span class="product__category">Gifts</span>
            <h3 class="product__title">Mini Cute Bear</h3>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$19</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>


        <!-- 3 -->
        <div class="product__item" data-price="21.00">
          <div class="product__banner">
            <a href="details.php?id=rose-blush-pink" class="product__images">
              <img src="assets/img/items/roses/rose_7.jpg" class="product__img default" />
              <img src="assets/img/items/roses/rose_7.jpg" class="product__img hover" />
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
            <span class="product__category">Roses</span>
            <h3 class="product__title">Blush Pink Dream</h3>
              <p class="product__subtitle">گولی پینکی بلاش درێم</p>
            <div class="product__price flex">
              <span class="new__price">$21</span>
              <span class="old__price">$27</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=bear_6" class="product__images">
              <img src="assets/img/items/bear/bear_6.jpg" class="product__img default">
              <img src="assets/img/items/bear/bear_6.jpg" class="product__img hover">
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
            <h3 class="product__title">Pink Love Bear</h3>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$19</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <div class="product__item" data-price="14.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=bear_7" class="product__images">
              <img src="assets/img/items/bear/bear_7.jpg" class="product__img default">
              <img src="assets/img/items/bear/bear_7.jpg" class="product__img hover">
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
            <h3 class="product__title">Classic Brown Bear</h3>
            <div class="product__price flex">
              <span class="new__price">$14</span>
              <span class="old__price">$19</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- ===== 5 CHOCOLATES ===== -->
        <div class="product__item" data-price="27.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=chocolate_1" class="product__images">
              <img src="assets/img/items/chocolate/chocolate_1.jpg" class="product__img default">
              <img src="assets/img/items/chocolate/chocolate_1.jpg" class="product__img hover">
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
            <div class="product__badge light-orange">Sweet</div>
          </div>
          <div class="product__content">
            <span class="product__category">Chocolates</span>
            <h3 class="product__title">Luxury Chocolate Box</h3>
            <div class="product__price flex">
              <span class="new__price">$27</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=chocolate_2" class="product__images">
              <img src="assets/img/items/chocolate/chocolate_2.jpg" class="product__img default">
              <img src="assets/img/items/chocolate/chocolate_2.jpg" class="product__img hover">
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
            <div class="product__badge light-orange">Romantic</div>
          </div>
          <div class="product__content">
            <span class="product__category">Chocolates</span>
            <h3 class="product__title">Heart Chocolate Box</h3>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=chocolate_3" class="product__images">
              <img src="assets/img/items/chocolate/chocolate_3.jpg" class="product__img default">
              <img src="assets/img/items/chocolate/chocolate_3.jpg" class="product__img hover">
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
            <h3 class="product__title">Strawberry Chocolate Set</h3>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>



        <div class="product__item" data-price="32.00">
          <div class="product__banner">
            <a href="giftdetail.php?id=chocolate_5" class="product__images">
              <img src="assets/img/items/chocolate/chocolate_5.jpg" class="product__img default">
              <img src="assets/img/items/chocolate/chocolate_5.jpg" class="product__img hover">
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
            <div class="product__badge light-orange">Luxury</div>
          </div>
          <div class="product__content">
            <span class="product__category">Chocolates</span>
            <h3 class="product__title">Luxury Valentine Chocolate</h3>
            <div class="product__price flex">
              <span class="new__price">$32</span>
              <span class="old__price">$41</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>



        <!-- ===== RED FLOWERS (WORKING + LINKED) ===== -->

        <!-- 1 -->

        <!-- 2 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-peach-paradise" class="product__images">
              <img src="assets/img/items/roses/rose_6.jpg" class="product__img default" />
              <img src="assets/img/items/roses/rose_6.jpg" class="product__img hover" />
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
            <div class="product__badge light-pink">Romantic</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <h3 class="product__title">Peach Romance Roses</h3>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>


        <!-- 4 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=rose-rainbow-romance" class="product__images">
              <img src="assets/img/items/roses/rose_2.jpg" class="product__img default" />
              <img src="assets/img/items/roses/rose_2.jpg" class="product__img hover" />
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
            <div class="product__badge light-orange">Special</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <h3 class="product__title">Romantic Rose Mix</h3>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 5 -->
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=lily-pink-galaxy" class="product__images">
              <img src="assets/img/items/lilys/lily_4.jpg" class="product__img default" />
              <img src="assets/img/items/lilys/lily_4.jpg" class="product__img hover" />
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
            <h3 class="product__title">Pink Galaxy Lilies</h3>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 6 -->
        <div class="product__item" data-price="24.00">
          <div class="product__banner">
            <a href="details.php?id=tulip-ruby-red" class="product__images">
              <img src="assets/img/items/tulips/tulip_6.jpg" class="product__img default" />
              <img src="assets/img/items/tulips/tulip_6.jpg" class="product__img hover" />
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
            <h3 class="product__title">Ruby Red Tulips</h3>
            <div class="product__price flex">
              <span class="new__price">$24</span>
              <span class="old__price">$31</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 7 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=minirose-pretty-pink" class="product__images">
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" class="product__img default" />
              <img src="assets/img/items/minirose/prettypinkyrosie.jpg" class="product__img hover" />
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
            <div class="product__badge light-pink">Cute</div>
          </div>
          <div class="product__content">
            <span class="product__category">Mini Roses</span>
            <h3 class="product__title">Pretty Pink Mini Roses</h3>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- 8 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-soft-pink" class="product__images">
              <img src="assets/img/items/roses/rose_10.jpg" class="product__img default" />
              <img src="assets/img/items/roses/rose_10.jpg" class="product__img hover" />
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
            <div class="product__badge light-pink">Soft</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <h3 class="product__title">Soft Pink Roses</h3>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      </div>
    </section>

  </main><!--=============== search ===============--><?php include 'footer.php'; ?>


