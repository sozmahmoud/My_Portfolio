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
        <a href="mixed_flower.php" class="tab__btn active-tab">Mixed Bouquets</a>
        <a href="buttercup.php" class="tab__btn">Buttercup</a>
        <a href="daisies.php" class="tab__btn">Daisies</a>
        <a href="minirose.php" class="tab__btn">Mini Rose</a>
        <a href="daffodils.php" class="tab__btn">Daffodils</a>
       
      </div>
    </div>

    <!--=============== MIXED BOUQUETS COLLECTION ===============-->
    <section class="products container section--lg" style="padding-top: 1.5rem;">
      <div class="section__header centered">
        <div class="cute-header-box">
          <h2 class="section__title"><span>Mixed</span> Bouquets</h2>
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
        <div class="product__item" data-price="22.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-pink-garden" class="product__images">
              <img src="assets/img/items/mixed/mixed_1.jpg" alt="Pink Garden Delight" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_1.jpg" alt="Pink Garden Delight hover" class="product__img hover" />
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
            <a href="details.php?id=mixed-pink-garden"><h3 class="product__title">Pink Garden Delight</h3>
              <p class="product__subtitle">بوکێتی باخچەی پینکی</p></a>
            <div class="product__price flex">
              <span class="new__price">$22</span>
              <span class="old__price">$28</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 2 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-sweet-blossom" class="product__images">
              <img src="assets/img/items/mixed/mixed_2.jpg" alt="Sweet Blossom Dream" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_2.jpg" alt="Sweet Blossom Dream hover" class="product__img hover" />
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
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-sweet-blossom"><h3 class="product__title">Sweet Blossom Dream</h3>
              <p class="product__subtitle">خەونی گوڵی شیرین</p></a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 3 -->
        <div class="product__item" data-price="28.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-white-daisy" class="product__images">
              <img src="assets/img/items/mixed/mixed_3.jpg" alt="White Daisy Charm" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_3.jpg" alt="White Daisy Charm hover" class="product__img hover" />
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
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-white-daisy"><h3 class="product__title">White Daisy Charm</h3>
              <p class="product__subtitle">جوانی دەیزی سپی</p></a>
            <div class="product__price flex">
              <span class="new__price">$28</span>
              <span class="old__price">$36</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 4 -->
        <div class="product__item" data-price="27.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-soft-pastel" class="product__images">
              <img src="assets/img/items/mixed/mixed_6.jpg" alt="Soft Pastel Love" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_6.jpg" alt="Soft Pastel Love hover" class="product__img hover" />
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
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-soft-pastel"><h3 class="product__title">Soft Pastel Love</h3>
              <p class="product__subtitle">خۆشەویستی پاستێلی نەرم</p></a>
            <div class="product__price flex">
              <span class="new__price">$27</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 5 -->
        <div class="product__item" data-price="20.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-lavender-whisper" class="product__images">
              <img src="assets/img/items/mixed/mixed_7.jpg" alt="Lavender Whisper" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_7.jpg" alt="Lavender Whisper hover" class="product__img hover" />
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
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-lavender-whisper"><h3 class="product__title">Lavender Whisper</h3>
              <p class="product__subtitle">نسیمی لاڤەندەر</p></a>
            <div class="product__price flex">
              <span class="new__price">$20</span>
              <span class="old__price">$26</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 6 -->
        <div class="product__item" data-price="27.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-spring-morning" class="product__images">
              <img src="assets/img/items/mixed/mixed_8.jpg" alt="Spring Morning Glow" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_8.jpg" alt="Spring Morning Glow hover" class="product__img hover" />
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
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-spring-morning"><h3 class="product__title">Spring Morning Glow</h3>
              <p class="product__subtitle">ڕوناکی بەیانی بەهار</p></a>
            <div class="product__price flex">
              <span class="new__price">$27</span>
              <span class="old__price">$35</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 7 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-blush-blossom" class="product__images">
              <img src="assets/img/items/mixed/mixed_9.jpg" alt="Blush Blossom Fantasy" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_9.jpg" alt="Blush Blossom Fantasy hover" class="product__img hover" />
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
            <a href="details.php?id=mixed-blush-blossom"><h3 class="product__title">Blush Blossom Fantasy</h3>
              <p class="product__subtitle">فانتازیای بلاش بلۆسم</p></a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

        <!-- Product 8 -->
        <div class="product__item" data-price="25.00">
          <div class="product__banner">
            <a href="details.php?id=mixed-white-elegance" class="product__images">
              <img src="assets/img/items/mixed/mixed_10.jpg" alt="White Elegance Bouquet" class="product__img default" />
              <img src="assets/img/items/mixed/mixed_10.jpg" alt="White Elegance Bouquet hover" class="product__img hover" />
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
            <span class="product__category">Mixed</span>
            <a href="details.php?id=mixed-white-daisy"><h3 class="product__title">White Elegance Bouquet</h3>
              <p class="product__subtitle">بوکێتی سپی جوان</p></a>
            <div class="product__price flex">
              <span class="new__price">$25</span>
              <span class="old__price">$32</span>
            </div>
            <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart"><i class="fi fi-rs-shopping-bag-add"></i></a>
          </div>
        </div>

      

      </div>
    </section>
  </main><?php include 'footer.php'; ?>



