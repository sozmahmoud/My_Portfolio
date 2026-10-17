// ============================================================
// BEAR + CHOCOLATE — SINGLE IMAGE + BEAUTIFUL DETAIL BOX
// Updated: Chocolates now clean (no Category / no Type)
// ============================================================

const flowerData = {
  // BEARS
  "bear_1": { title: "Soft Classic Teddy Bear", category: "Gifts", badge: "Cute", price: "$22", oldPrice: "$35", discount: "28% Off", image: "assets/img/items/bear/bear_1.jpg", description: "Soft and adorable teddy bear perfect for romantic gifts.", details: { "Type": "Teddy Bear", "Color": "Beige", "Size": "Medium", "Occasion": "Valentine, Birthday", "Material": "Plush" } },
  "bear_2": { title: "Elegant Pink Dress Bear", category: "Gifts", badge: "Lovely", price: "$22", oldPrice: "$42", discount: "24% Off", image: "assets/img/items/bear/bear_2.jpg", description: "Elegant teddy bear with a cute pink dress.", details: { "Type": "Teddy Bear", "Color": "Pink", "Size": "Medium", "Occasion": "Romantic", "Material": "Plush" } },
  "bear_3": { title: "Mini Cute Bear", category: "Gifts", badge: "Mini", price: "$14", oldPrice: "$25", discount: "28% Off", image: "assets/img/items/bear/bear_3.jpg", description: "Small adorable teddy bear gift.", details: { "Type": "Mini Bear", "Size": "Small", "Occasion": "Gift Add-on" } },
  "bear_6": { title: "Pink Love Bear", category: "Gifts", badge: "Sweet", price: "$14", oldPrice: "$45", discount: "22% Off", image: "assets/img/items/bear/bear_6.jpg", description: "Perfect pink teddy for love occasions.", details: { "Color": "Pink", "Occasion": "Valentine" } },
  "bear_7": { title: "Classic Brown Bear", category: "Gifts", badge: "Classic", price: "$14", oldPrice: "$38", discount: "23% Off", image: "assets/img/items/bear/bear_7.jpg", description: "Classic teddy bear everyone loves.", details: { "Color": "Brown", "Occasion": "All" } },

  // CHOCOLATES
  "chocolate_1": { title: "Luxury Chocolate Box", category: "Chocolates", badge: "Sweet", price: "$27", oldPrice: "$38", discount: "26% Off", image: "assets/img/items/chocolate/chocolate_1.jpg", description: "Premium chocolate selection.", details: { "Type": "Chocolate Box", "Occasion": "Valentine" } },
  "chocolate_2": { title: "Heart Chocolate Box", category: "Chocolates", badge: "Romantic", price: "$28", oldPrice: "$42", discount: "24% Off", image: "assets/img/items/chocolate/chocolate_2.jpg", description: "Heart-shaped romantic chocolate set.", details: { "Shape": "Heart" } },
  "chocolate_3": { title: "Strawberry Chocolate Set", category: "Chocolates", badge: "Love", price: "$25", oldPrice: "$52", discount: "23% Off", image: "assets/img/items/chocolate/chocolate_3.jpg", description: "Chocolate-covered strawberries set.", details: { "Flavor": "Strawberry" } },
  "chocolate_4": { title: "Premium Chocolate Collection", category: "Chocolates", badge: "Sweet Box", price: "$30", oldPrice: "$45", discount: "22% Off", image: "assets/img/items/chocolate/chocolate_4.jpg", description: "Mixed premium chocolate collection.", details: { "Type": "Assorted", "Occasion": "Valentine" } },
  "chocolate_5": { title: "Luxury Valentine Chocolate", category: "Chocolates", badge: "Luxury", price: "$32", oldPrice: "$48", discount: "20% Off", image: "assets/img/items/chocolate/chocolate_5.jpg", description: "Luxury chocolate gift for Valentine.", details: { "Occasion": "Valentine" } }
};

// Helper for thumbnail (kept for future use)
function changeMainImage(thumb) {
  document.getElementById("detail-img-main").src = thumb.src;
  document.querySelectorAll('.details__thumb').forEach(t => t.classList.remove('active'));
  thumb.classList.add('active');
}

// Load product
const params = new URLSearchParams(window.location.search);
const id = params.get("id");
const product = flowerData[id];

if (product) {
  // Basic info
  document.getElementById("detail-title").textContent = product.title;
  const detailKurdish = document.getElementById("detail-kurdish-title");
  if (detailKurdish) detailKurdish.textContent = product.category;
  document.getElementById("detail-price").textContent = product.price;
  document.getElementById("detail-old-price").textContent = product.oldPrice || "";
  document.getElementById("detail-discount").textContent = product.discount || "";
  document.getElementById("detail-description").textContent = product.description;
  document.getElementById("detail-img-main").src = product.image;
  document.getElementById("detail-badge").textContent = product.badge || "Gift";
  document.getElementById("breadcrumb-name").textContent = product.title;

  // Single image mode (no thumbnails)
  const thumbsContainer = document.getElementById("detail-thumbnails");
  if (thumbsContainer) thumbsContainer.style.display = "none";

  // === BEAUTIFUL DETAIL BOX (bears full, chocolates cleaned) ===
  const tableContainer = document.getElementById("detail-info-table");
  if (tableContainer && product.details) {
    let rows = [];

    // Only show Category for bears/gifts
    if (product.category !== "Chocolates") {
      rows.push(`<tr><th>Category</th><td>${product.category}</td></tr>`);
    }

    // Add other details, but skip "Type" for chocolates
    Object.entries(product.details).forEach(([key, value]) => {
      if (product.category === "Chocolates" && key.toLowerCase() === "type") return;
      rows.push(`<tr><th>${key}</th><td>${value}</td></tr>`);
    });

    // Only render the box if there is something to show
    if (rows.length > 0) {
      const html = `
        <div class="detail-box">
          <table class="details__table gift-table">
            ${rows.join('')}
          </table>
        </div>`;
      tableContainer.innerHTML = html;
    } else {
      tableContainer.innerHTML = ""; // clean look for simple chocolates
    }
  }

// ====================== REVIEWS SYSTEM ======================
const currentProductId = new URLSearchParams(window.location.search).get("id") || "default";
const currentUser = JSON.parse(localStorage.getItem('lioraUser') || '{}');

function loadReviews() {
  loadReviewsDatabase(currentProductId);
}

function submitReview() {
  submitReviewDatabase(currentProductId);
}

function initStars() {
  const stars = document.querySelectorAll('.star-rating-input span');
  stars.forEach(star => {
    star.addEventListener('click', () => {
  const rating = parseInt(star.dataset.value || '0', 10);
  stars.forEach((s, index) => {
    if (index < rating) {
      s.classList.add('active');
    } else {
      s.classList.remove('active');
    }
  });
});
  });
}

function bindReviewSubmit() {
  const submitBtn = document.querySelector('.review-submit-btn');
  if (!submitBtn) return;
  submitBtn.removeEventListener('click', submitReview);
  submitBtn.addEventListener('click', submitReview);
}

function initReviewWidgets() {
  initStars();
  bindReviewSubmit();
  loadReviews();
}

window.loadReviews = loadReviews;
window.submitReview = submitReview;
window.initStars = initStars;
window.initReviewWidgets = initReviewWidgets;

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initReviewWidgets);
} else {
  initReviewWidgets();
}
  const relatedContainer = document.getElementById("related-products");
  if (relatedContainer) {
    relatedContainer.innerHTML = `
      <div class="product__item">
        <div class="product__banner">
          <a href="giftdetail.php?id=bear_2" class="product__images">
            <img src="assets/img/items/bear/bear_2.jpg" class="product__img default">
            <img src="assets/img/items/bear/bear_2.jpg" class="product__img hover">
          </a>
          <div class="product__badge light-pink">Valentine</div>
        </div>
        <div class="product__content">
          <span class="product__category">Gifts</span>
          <h3 class="product__title">Elegant Pink Dress Bear</h3>
          <div class="product__price flex"><span class="new__price">${flowerData["bear_2"].price}</span></div>
        </div>
      </div>
      <div class="product__item">
        <div class="product__banner">
          <a href="giftdetail.php?id=chocolate_2" class="product__images">
            <img src="assets/img/items/chocolate/chocolate_2.jpg" class="product__img default">
            <img src="assets/img/items/chocolate/chocolate_2.jpg" class="product__img hover">
          </a>
          <div class="product__badge light-orange">Romantic</div>
        </div>
        <div class="product__content">
          <span class="product__category">Chocolates</span>
          <h3 class="product__title">Heart Chocolate Box</h3>
          <div class="product__price flex"><span class="new__price">${flowerData["chocolate_2"].price}</span></div>
        </div>
      </div>
      <div class="product__item">
        <div class="product__banner">
          <a href="giftdetail.php?id=bear_6" class="product__images">
            <img src="assets/img/items/bear/bear_6.jpg" class="product__img default">
            <img src="assets/img/items/bear/bear_6.jpg" class="product__img hover">
          </a>
          <div class="product__badge light-pink">Sweet</div>
        </div>
        <div class="product__content">
          <span class="product__category">Gifts</span>
          <h3 class="product__title">Pink Love Bear</h3>
          <div class="product__price flex"><span class="new__price">${flowerData["bear_6"].price}</span></div>
        </div>
      </div>
      <div class="product__item">
        <div class="product__banner">
          <a href="giftdetail.php?id=chocolate_3" class="product__images">
            <img src="assets/img/items/chocolate/chocolate_3.jpg" class="product__img default">
            <img src="assets/img/items/chocolate/chocolate_3.jpg" class="product__img hover">
          </a>
          <div class="product__badge light-orange">Love</div>
        </div>
        <div class="product__content">
          <span class="product__category">Chocolates</span>
          <h3 class="product__title">Strawberry Chocolate Set</h3>
          <div class="product__price flex"><span class="new__price">${flowerData["chocolate_3"].price}</span></div>
        </div>
      </div>`;
  }
}
