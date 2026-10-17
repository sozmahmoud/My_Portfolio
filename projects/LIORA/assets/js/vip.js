// ============================================================
// VIP DATA — ONLY these 7 flowers
// ============================================================
const flowerData = {

  "vip-1": {
    title: "Tulip Mix Color",
    category: "VIP Bouquets",
    badge: "VIP",
    price: "$42",
    oldPrice: "$45",
    discount: "15% Off",
    image: "assets/img/items/vip/vip_1.jpg",
    images: ["assets/img/items/vip/vip_1.jpg"],
    description: "A luxurious mix of colorful tulips arranged in a premium VIP bouquet. Bright, elegant, and perfect for making a grand impression.",
    details: {
      "Flower Type": "Tulips",
      "Color": "Mixed Colors",
      "Stems": "30 stems",
      "Freshness": "6–8 days",
      "Occasion": "VIP Gift, Celebration",
      "Fragrance": "Fresh & light",
    }
  },

  "vip-2": {
    title: "Tulips Bouquet",
    category: "VIP Bouquets",
    badge: "VIP",
    price: "$45",
    oldPrice: "$48",
    discount: "16% Off",
    image: "assets/img/items/vip/vip_2.jpg",
    images: ["assets/img/items/vip/vip_2.jpg"],
    description: "Elegant VIP tulips bouquet designed for high-end gifting and premium occasions.",
    details: {
      "Flower Type": "Tulips",
      "Color": "Pink & White",
      "Stems": "28 stems",
      "Freshness": "6–8 days",
      "Occasion": "Luxury Gift",
      "Fragrance": "Soft floral",
    }
  },

  "vip-3": {
    title: "White Tulips Luxury",
    category: "VIP Bouquets",
    badge: "VIP",
    price: "$48",
    oldPrice: "$50",
    discount: "16% Off",
    image: "assets/img/items/vip/vip_3.jpg",
    images: ["assets/img/items/vip/vip_3.jpg"],
    description: "Premium white tulips arranged in a luxurious VIP style bouquet for elegant tastes.",
    details: {
      "Flower Type": "Tulips",
      "Color": "White",
      "Stems": "32 stems",
      "Freshness": "7–9 days",
      "Occasion": "Wedding, Luxury",
      "Fragrance": "Clean & fresh",
    }
  },

  "vip-4": {
    title: "Pink VIP Flowers",
    category: "VIP Bouquets",
    badge: "VIP",
    price: "$46",
    oldPrice: "$52",
    discount: "13% Off",
    image: "assets/img/items/vip/vip_4.jpg",
    images: ["assets/img/items/vip/vip_4.jpg"],
    description: "Soft pink premium VIP bouquet crafted for romantic and high-end occasions.",
    details: {
      "Flower Type": "Mixed Flowers",
      "Color": "Pink",
      "Stems": "35 stems",
      "Freshness": "6–8 days",
      "Occasion": "Romantic, VIP",
      "Fragrance": "Sweet floral",
    }
  },

  "vip-5": {
    title: "Mini Rose Pink VIP",
    category: "VIP Bouquets",
    badge: "VIP",
    price: "$50",
    oldPrice: "$55",
    discount: "12% Off",
    image: "assets/img/items/vip/vip_5.jpg",
    images: ["assets/img/items/vip/vip_5.jpg"],
    description: "High-end mini rose bouquet with soft pink tones and elegant premium wrapping.",
    details: {
      "Flower Type": "Mini Roses",
      "Color": "Pink",
      "Stems": "40 stems",
      "Freshness": "6–8 days",
      "Occasion": "Luxury Gift",
      "Fragrance": "Rich & floral",
    }
  },

  "vip-6": {
    title: "White Lily VIP Flowers",
    category: "VIP Bouquets",
    badge: "VIP",
    price: "$50",
    oldPrice: "$58",
    discount: "14% Off",
    image: "assets/img/items/vip/vip_6.jpg",
    images: ["assets/img/items/vip/vip_6.jpg"],
    description: "Premium white lilies arranged in an elegant VIP bouquet with sophisticated presentation.",
    details: {
      "Flower Type": "Lilies",
      "Color": "White",
      "Stems": "20 stems",
      "Freshness": "7–10 days",
      "Occasion": "Elegant, Luxury",
      "Fragrance": "Strong & sweet",
    }
  },

  "vip-7": {
    title: "Ultimate VIP Flowers",
    category: "VIP Bouquets",
    badge: "VIP",
    price: "$48",
    oldPrice: "$50",
    discount: "16% Off",
    image: "assets/img/items/vip/vip_7.jpg",
    images: ["assets/img/items/vip/vip_7.jpg"],
    description: "A complete premium VIP bouquet combining elegance, luxury, and style.",
    details: {
      "Flower Type": "Mixed Premium",
      "Color": "Mixed",
      "Stems": "45 stems",
      "Freshness": "6–9 days",
      "Occasion": "VIP, Exclusive",
      "Fragrance": "Rich floral",
    }
  }
};

// ============================================================
// ALL PRODUCTS — VIP
// ============================================================
const allProducts = Object.keys(flowerData).map(id => {
  const f = flowerData[id];
  return {
    id,
    title: f.title,
    price: f.price,
    oldPrice: f.oldPrice,
    image: f.image,
    image2: f.image,
    badge: f.badge,
    category: f.category
  };
});

// ============================================================
// INIT — read ?id= from URL and render page
// ============================================================
const params = new URLSearchParams(window.location.search);
const currentId = params.get("id") || "vip-1";
const flower = flowerData[currentId] || flowerData["vip-1"];

// Update content
document.getElementById("breadcrumb-name").textContent = flower.title;
document.title = flower.title + " — Liora";

document.getElementById("detail-title").textContent       = flower.title;
document.getElementById("detail-price").textContent       = flower.price;
document.getElementById("detail-old-price").textContent   = flower.oldPrice;
document.getElementById("detail-discount").textContent    = flower.discount;
document.getElementById("detail-description").textContent = flower.description;
document.getElementById("detail-badge").textContent       = flower.badge;

// Main image
const mainImg = document.getElementById("detail-img-main");
mainImg.src = flower.images[0];
mainImg.alt = flower.title;

// Remove thumbnails (single image only)
const thumbContainer = document.getElementById("detail-thumbnails");
thumbContainer.innerHTML = "";

// Info table
const infoTable = document.getElementById("detail-info-table");
let tableHTML = '<table class="flower-info-table"><tbody>';
for (const [key, val] of Object.entries(flower.details)) {
  tableHTML += `<tr><td class="info-key">${key}</td><td class="info-val">${val}</td></tr>`;
}
tableHTML += '</tbody></table>';
infoTable.innerHTML = tableHTML;

// ====================== REVIEWS SYSTEM ======================
let currentProductId = new URLSearchParams(window.location.search).get("id") || "default";
const currentUser = JSON.parse(localStorage.getItem('lioraUser')) || {};

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
// Auto initialize reviews
function initReviewWidgets() {
    initStars();
    loadReviews();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReviewWidgets);
} else {
    initReviewWidgets();
}

// Related products
const relatedContainer = document.getElementById("related-products");
relatedContainer.innerHTML = "";

const related = allProducts.filter(p => p.id !== currentId).slice(0, 4);

related.forEach(p => {
  const badgeClasses = ["light-pink", "light-green", "light-orange", "light-blue"];
  const randomBadge  = badgeClasses[Math.floor(Math.random() * badgeClasses.length)];

  relatedContainer.innerHTML += `
    <div class="product__item">
      <div class="product__banner">
        <a href="details.php?id=${p.id}" class="product__images">
          <img src="${p.image}" class="product__img default" />
          <img src="${p.image2}" class="product__img hover" />
        </a>
        <div class="product__badge ${randomBadge}">${p.badge}</div>
      </div>
      <div class="product__content">
        <span class="product__category">${p.category}</span>
        <a href="details.php?id=${p.id}">
          <h3 class="product__title">${p.title}</h3>
        </a>
        <div class="product__price flex">
          <span class="new__price">${p.price}</span>
          <span class="old__price">${p.oldPrice}</span>
        </div>
      </div>
    </div>
  `;
});
