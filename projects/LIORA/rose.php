<?php
session_start();
include 'header.php';
?>
  <!--=============== HEADER ===============-->
  

  <!--=============== MAIN ===============-->
  <main class="main">
    <!-- Flower Tabs -->
    <div class="flower-tabs-bar">
      <div class="tab__btns flower-types-menu">
        <a href="rose.php" class="tab__btn active-tab">Roses</a>
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

    <!-- Roses Collection -->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Roses</span> Collection</h2>
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
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-blue-sapphire" class="product__images">
              <img src="assets/img/items/roses/rose_1.jpg" alt="Blue Sapphire Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_1.jpg" alt="Blue Sapphire Roses" class="product__img hover" />
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
            <a href="details.php?id=rose-blue-sapphire"><h3 class="product__title">Blue Sapphire Roses</h3>
              <p class="product__subtitle">گولی سەفیر شین</p></a>

            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=rose-rainbow-romance" class="product__images">
              <img src="assets/img/items/roses/rose_2.jpg" alt="Rainbow Romance Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_2.jpg" alt="Rainbow Romance Roses" class="product__img hover" />
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
            <a href="details.php?id=rose-rainbow-romance"><h3 class="product__title">Rainbow Romance Roses</h3>
              <p class="product__subtitle">گولی ڕەنگاو ڕۆمانس</p></a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="19.00">
          <div class="product__banner">
            <a href="details.php?id=rose-golden-sunshine" class="product__images">
              <img src="assets/img/items/roses/rose_3.jpg" alt="Golden Sunshine Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_3.jpg" alt="Golden Sunshine Roses" class="product__img hover" />
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
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-golden-sunshine"><h3 class="product__title">Golden Sunshine Roses</h3>
              <p class="product__subtitle">گولی زێڕینی خۆر</p></a>
            <div class="product__price flex">
              <span class="new__price">$19</span>
              <span class="old__price">$24</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
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
            <div class="product__badge light-pink">-15%</div>
          </div>
          <div class="product__content">
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-ruby-red"><h3 class="product__title">Ruby Red Romance</h3>
              <p class="product__subtitle">گولی ڕوبی سوور ڕۆمانس</p>
            </a>

            <div class="product__price flex">
              <span class="new__price">$24</span>
              <span class="old__price">$31</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-peach-paradise" class="product__images">
              <img src="assets/img/items/roses/rose_6.jpg" alt="Peach Paradise Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_6.jpg" alt="Peach Paradise Roses" class="product__img hover" />
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
            <a href="details.php?id=rose-peach-paradise"><h3 class="product__title">Peach Paradise Roses</h3>
              <p class="product__subtitle">گولی پێچ پارادایز</p></a>

            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="21.00">
          <div class="product__banner">
            <a href="details.php?id=rose-blush-pink" class="product__images">
              <img src="assets/img/items/roses/rose_7.jpg" alt="Blush Pink Dream" class="product__img default" />
              <img src="assets/img/items/roses/rose_7.jpg" alt="Blush Pink Dream" class="product__img hover" />
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
            <span class="product__category">Roses</span>
            <a href="details.php?id=rose-blush-pink"><h3 class="product__title">Blush Pink Dream</h3>
              <p class="product__subtitle">گولی پینکی بلاش درێم</p></a>

            <div class="product__price flex">
              <span class="new__price">$21</span>
              <span class="old__price">$27</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 7 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=rose-pure-white" class="product__images">
              <img src="assets/img/items/roses/rose_9.jpg" alt="Pure White Elegance" class="product__img default" />
              <img src="assets/img/items/roses/rose_9.jpg" alt="Pure White Elegance" class="product__img hover" />
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
            <a href="details.php?id=rose-pure-white"><h3 class="product__title">Pure White Elegance</h3>
              <p class="product__subtitle">گولی سپی پاک و جوان</p></a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 8 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=rose-soft-pink" class="product__images">
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Ribbon Roses" class="product__img default" />
              <img src="assets/img/items/roses/rose_10.jpg" alt="Soft Pink Ribbon Roses" class="product__img hover" />
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
            <a href="details.php?id=rose-soft-pink"><h3 class="product__title">Soft Pink Ribbon Roses</h3>
              <p class="product__subtitle">گولی پینکی نەرم و ڕیبۆن</p></a>
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




