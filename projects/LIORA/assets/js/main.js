/*=============== LIORA MAIN.JS - FIXED & IMPROVED ===============*/
console.log("%c🌸 Liora JS loaded - buttons should now work!", "color:#c14e8f; font-weight:bold; font-size:16px");

// Prevent # links from scrolling to top
const hashActionLinks = document.querySelectorAll('a[href="#"], a[href="javascript:void(0)"]');
hashActionLinks.forEach(a => {
  const classes = a.className || '';
  if (classes.includes('action__btn') || classes.includes('share__btn') || classes.includes('cart__btn') || classes.includes('details__action-btn') || classes.includes('user-menu-btn') || classes.includes('btn--sm')) {
    a.href = 'javascript:void(0)';
  }
});

/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById("nav-menu");
const navToggle = document.getElementById("nav-toggle");
const navClose = document.getElementById("nav-close");

if (navToggle) navToggle.addEventListener("click", () => navMenu.classList.add("show-menu"));
if (navClose) navClose.addEventListener("click", () => navMenu.classList.remove("show-menu"));

const headerActionButtons = document.querySelectorAll('.header__action-btn');
headerActionButtons.forEach(btn => {
  btn.addEventListener('click', function (e) {
    const href = this.getAttribute('href');
    if (href && href !== '#' && href !== 'javascript:void(0)') {
      e.stopPropagation();
      window.location.href = href;
    }
  });
});

/*=============== TOAST NOTIFICATION ===============*/
function showToast(message) {
  const toast = document.createElement("div");
  toast.style.cssText = `position:fixed; bottom:25px; right:25px; background:#c14e8f; color:#fff; padding:14px 22px; border-radius:12px; box-shadow:0 10px 25px rgba(193,78,143,0.3); z-index:9999; font-weight:500; display:flex; align-items:center; gap:8px;`;
  toast.innerHTML = `🌸 ${message}`;
  document.body.appendChild(toast);

  setTimeout(() => {
    toast.style.transition = "all 0.4s ease";
    toast.style.transform = "translateY(30px)";
    toast.style.opacity = "0";
    setTimeout(() => toast.remove(), 400);
  }, 2800);
}

function copyTextToClipboard(text) {
  if (navigator.clipboard && window.isSecureContext) {
    return navigator.clipboard.writeText(text);
  }

  const textarea = document.createElement("textarea");
  textarea.value = text;
  textarea.setAttribute("readonly", "");
  textarea.style.position = "fixed";
  textarea.style.top = "-9999px";
  document.body.appendChild(textarea);
  textarea.select();

  const copied = document.execCommand("copy");
  textarea.remove();

  return copied ? Promise.resolve() : Promise.reject(new Error("Copy command failed"));
}

/*=============== HEADER COUNTS ===============*/
const MAIN_CART_API_URL = 'cart_action.php';
const MAIN_WISHLIST_API_URL = 'wishlist_action.php';
let serverCartCount = null;
let serverWishlistCount = null;

function updateHeaderCounts() {
  const cartCount = document.getElementById("cart-count");
  const wishlistCount = document.getElementById("wishlist-count");
  if (cartCount && serverCartCount !== null) {
    cartCount.textContent = serverCartCount;
    cartCount.style.display = serverCartCount > 0 ? "inline-flex" : "none";
  }
  if (wishlistCount && serverWishlistCount !== null) {
    wishlistCount.textContent = serverWishlistCount;
    wishlistCount.style.display = serverWishlistCount > 0 ? "inline-flex" : "none";
  }
}

function getCurrentPageProductSlug() {
  const params = new URLSearchParams(window.location.search);
  return params.get('id');
}

function getProductSlugFromCard(card) {
  if (!card) return null;
  const link = card.querySelector('a.product__images, a[href*="details.php?id="], a[href*="giftdetail.php?id="]');
  if (!link) return null;
  try {
    const url = new URL(link.href, window.location.origin);
    return url.searchParams.get('id');
  } catch (e) {
    return null;
  }
}

async function mapProductSlugToId(slug) {
  if (!slug) return null;
  try {
    const response = await fetch(`map_product_id.php?id=${encodeURIComponent(slug)}`, { credentials: 'same-origin' });
    if (!response.ok) return null;
    const data = await response.json();
    return data.success && data.id ? Number(data.id) : null;
  } catch (e) {
    console.warn('Product slug mapping failed:', e);
    return null;
  }
}

async function resolveProductId(rawId, card) {
  if (rawId) {
    const numericValue = Number(rawId);
    if (!Number.isNaN(numericValue) && numericValue > 0) {
      return numericValue;
    }
  }

  const slug = getProductSlugFromCard(card) || getCurrentPageProductSlug();
  if (!slug) return null;
  return await mapProductSlugToId(slug);
}

async function refreshServerCartCount() {
  try {
    const response = await fetch(`${MAIN_CART_API_URL}?action=count`, { credentials: 'same-origin' });
    if (!response.ok) throw new Error('Cart count request failed');
    const data = await response.json();
    if (data.success) {
      serverCartCount = data.count || 0;
      updateHeaderCounts();
    }
  } catch (error) {
    console.warn('Unable to refresh server cart count:', error);
    serverCartCount = null;
  }
}

async function refreshServerWishlistCount() {
  try {
    const response = await fetch(`${MAIN_WISHLIST_API_URL}?action=count`, { credentials: 'same-origin' });
    if (!response.ok) throw new Error('Wishlist count request failed');
    const data = await response.json();
    if (data.success) {
      serverWishlistCount = data.count || 0;
      updateHeaderCounts();
    }
  } catch (error) {
    console.warn('Unable to refresh server wishlist count:', error);
    serverWishlistCount = null;
  }
}

/*=============== UNIVERSAL CLICK LISTENER ===============*/
document.addEventListener("click", async function (e) {
  const clickedHeaderAction = e.target.closest('.header__action-btn');
  const clickedHashAnchor = e.target.closest('a[href="#"], a[href="javascript:void(0)"]');
  const clickedIconOrButton = e.target.closest('.cart__btn, .share__btn, .details__action-btn, .action__btn');

  if (!clickedHeaderAction && (clickedHashAnchor || clickedIconOrButton)) {
    e.preventDefault();
  }

  // Cart and Wishlist handled by dedicated cart.js and wishlist.js files
  // Share menu
  const shareButton = e.target.closest(".share__btn");
  if (shareButton) {
    const card = shareButton.closest(".product__item");
    const menu = card ? card.querySelector(".share-menu") : null;

    if (menu) {
      const wasOpen = menu.classList.contains("active") || menu.classList.contains("open");
      document.querySelectorAll(".share-menu").forEach(m => {
        m.classList.remove("active", "open");
      });

      if (!wasOpen) {
        menu.classList.add("active", "open");
        shareButton.setAttribute("aria-expanded", "true");
      } else {
        shareButton.setAttribute("aria-expanded", "false");
      }
    }
    return;
  }

  const shareLink = e.target.closest(".share-link");
  if (shareLink) {
    e.preventDefault();
    const card = shareLink.closest(".product__item");

    if (card) {
      const title = card.querySelector(".product__title")?.innerText?.trim() || document.title;
      const productLink = card.querySelector('a.product__images, a[href*="details.php?id="], a[href*="giftdetail.php?id="]');
      const url = productLink ? new URL(productLink.getAttribute("href"), window.location.href).href : window.location.href;

      if (shareLink.classList.contains("fb")) {
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`, "_blank", "noopener,noreferrer");
      }
      if (shareLink.classList.contains("wa")) {
        window.open(`https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}`, "_blank", "noopener,noreferrer");
      }
      if (shareLink.classList.contains("copy")) {
        copyTextToClipboard(url)
          .then(() => showToast("Product link copied!"))
          .catch(() => showToast("Unable to copy link. Please try again."));
      }

      const menu = card.querySelector(".share-menu");
      if (menu) menu.classList.remove("active", "open");
      const button = card.querySelector(".share__btn");
      if (button) button.setAttribute("aria-expanded", "false");
    }
    return;
  }

  if (!e.target.closest(".share-menu")) {
    document.querySelectorAll(".share-menu").forEach(menu => menu.classList.remove("active", "open"));
    document.querySelectorAll(".share__btn[aria-expanded='true']").forEach(btn => btn.setAttribute("aria-expanded", "false"));
  }
});

/*=============== IMAGE GALLERY ===============*/
function imgGallery() {
  const mainImg = document.querySelector(".details__img");
  const smallImgs = document.querySelectorAll(".details__small-img");
  smallImgs.forEach(img => {
    img.addEventListener("click", () => { if (mainImg) mainImg.src = img.src; });
  });
}
imgGallery();

/*=============== REVIEWS & RATING SYSTEM ===============*/
let currentRating = 0;

function initMain() {
    refreshServerCartCount();
    refreshServerWishlistCount();
    const stars = document.querySelectorAll('#star-rating-input span');
    
    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const value = parseInt(this.dataset.value);
            highlightStars(value);
        });

        star.addEventListener('click', function() {
            currentRating = parseInt(this.dataset.value);
            highlightStars(currentRating);
            this.style.transform = 'scale(1.4)';
            setTimeout(() => this.style.transform = 'scale(1.25)', 150);
        });
    });

    const ratingContainer = document.getElementById('star-rating-input');
    if (ratingContainer) {
      ratingContainer.addEventListener('mouseleave', function() {
        highlightStars(currentRating);
      });
    }

    loadReviews();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMain);
} else {
    initMain();
}

function highlightStars(rating) {
    const stars = document.querySelectorAll('#star-rating-input span');
    stars.forEach(star => {
        const value = parseInt(star.dataset.value);
        if (value <= rating) {
            star.classList.add('active');
            star.style.color = '#ff69b4';
            star.style.textShadow = '0 0 12px rgba(255, 105, 180, 0.4)';
        } else {
            star.classList.remove('active');
            star.style.color = '#e0e0e0';
            star.style.textShadow = 'none';
        }
    });
}

function getSelectedReviewRating() {
    const stars = document.querySelectorAll('#star-rating-input span');

    stars.forEach((star, index) => {
        star.dataset.value = String(index + 1);
    });

    const activeRating = Array.from(stars).reduce((highest, star) => {
        if (!star.classList.contains('active')) return highest;
        const value = parseInt(star.dataset.value || '0', 10);
        return Number.isNaN(value) ? highest : Math.max(highest, value);
    }, 0);

    return activeRating || currentRating;
}

// Get current product ID (works for details.php and product-specific pages)
function getCurrentProductId() {
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('id');
    
    // If no ID in URL, try to get from data attribute or global variable
    if (!productId) {
        const productElement = document.querySelector('[data-product-id]');
        if (productElement) return productElement.dataset.productId;
    }
    
    return productId;
}

// Get numeric product ID for database queries (async)
async function getNumericProductId(stringId) {
    try {
        const response = await fetch(`map_product_id.php?id=${encodeURIComponent(stringId)}`);
        if (!response.ok) throw new Error('Failed to map product ID');
        const data = await response.json();
        return data.success ? data.id : null;
    } catch (error) {
        console.error('Error mapping product ID:', error);
        return null;
    }
}

async function submitReview() {
    const text = document.getElementById('review-text').value.trim();
    const rating = getSelectedReviewRating();
    
    if (!rating || !text) {
        showToast('💕 Please add stars and write a review!');
        return;
    }
    
    // Get product ID
    const productStringId = getCurrentProductId();
    if (!productStringId) {
        showToast('❌ Unable to identify product. Please refresh the page.');
        return;
    }
    
    const productId = await getNumericProductId(productStringId);
    if (!productId) {
        showToast('❌ Unable to identify product. Please refresh the page.');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('action', 'submit');
        formData.append('product_id', productId);
        formData.append('rating', rating);
        formData.append('comment', text);
        
        const response = await fetch('review_handler.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        if (data.success) {
            showToast('🌷 Review posted! Thank you! 💖');
            document.getElementById('review-text').value = '';
            currentRating = 0;
            highlightStars(0);
            
            // Reload reviews after brief delay
            setTimeout(() => loadReviews(), 500);
        } else {
            showToast('❌ ' + (data.message || 'Error posting review'));
        }
    } catch (error) {
        console.error('Review submission error:', error);
        showToast('❌ Error posting review. Please try again.');
    }
}

async function loadReviews() {
    const productStringId = getCurrentProductId();
    if (!productStringId) return;
    
    const productId = await getNumericProductId(productStringId);
    const reviewsList = document.getElementById('reviews-list');
    
    if (!reviewsList) return;
    
    try {
        const response = await fetch(`get_reviews.php?product_id=${productId}`);
        if (!response.ok) throw new Error('Failed to fetch reviews');
        
        const data = await response.json();
        
        if (data.success && data.reviews.length > 0) {
            reviewsList.innerHTML = data.reviews.map(review => `
                <div class="review-item">
                    <div class="review-header">
                        <strong class="review-author">${escapeHtml(review.username)}</strong>
                        <span class="review-date">${review.date}</span>
                    </div>
                    <div class="review-stars">
                        ${'⭐'.repeat(review.rating)}<span class="rating-number">${review.rating}/5</span>
                    </div>
                    <p class="review-comment">${escapeHtml(review.comment)}</p>
                </div>
            `).join('');
        } else {
            reviewsList.innerHTML = '<p class="no-reviews">📝 No reviews yet. Be the first to review! 🌸</p>';
        }
    } catch (error) {
        console.error('Error loading reviews:', error);
        reviewsList.innerHTML = '<p class="no-reviews">Unable to load reviews. Please try again later.</p>';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/*=============== SWIPERS ===============*/
document.querySelectorAll(".categories__container").forEach(container => {
  new Swiper(container, {
    spaceBetween: 24,
    loop: true,
    navigation: {
      nextEl: container.querySelector(".swiper-button-next"),
      prevEl: container.querySelector(".swiper-button-prev")
    },
    breakpoints: {
      350: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      992: { slidesPerView: 4 },
      1200: { slidesPerView: 5 },
      1400: { slidesPerView: 6 }
    }
  });
});

document.querySelectorAll(".new__container").forEach(container => {
  new Swiper(container, {
    spaceBetween: 24,
    loop: true,
    navigation: {
      nextEl: container.querySelector(".swiper-button-next"),
      prevEl: container.querySelector(".swiper-button-prev")
    },
    breakpoints: {
      768: { slidesPerView: 2 },
      992: { slidesPerView: 4 },
      1400: { slidesPerView: 4 }
    }
  });
});

/*=============== PRODUCTS TABS ===============*/
document.querySelectorAll("[data-target]").forEach(tab => {
  tab.addEventListener("click", () => {
    document.querySelectorAll("[content]").forEach(c => c.classList.remove("active-tab"));
    const target = document.querySelector(tab.dataset.target);
    if (target) target.classList.add("active-tab");

    document.querySelectorAll("[data-target]").forEach(t => t.classList.remove("active-tab"));
    tab.classList.add("active-tab");
  });
});

/*=============== CHATBOT FUNCTIONALITY (FIXED - Moved outside click listener) ===============*/
document.addEventListener('DOMContentLoaded', function () {
  const chatWindow = document.getElementById('chat-window');
  const userInput = document.getElementById('user-input');
  const sendBtn = document.getElementById('send-btn');
  const lioraWelcomeMessage = "Hello! I'm Liora, your AI florist. 🌸 Tell me the occasion, style, or feeling you want to create, and I'll help you find the perfect flowers. 🌷";

  if (!chatWindow || !userInput || !sendBtn) return;

  // Load history on startup
  loadChatHistory();

  async function loadChatHistory() {
    const historyList = document.getElementById('chat-history-list');
    try {
      const response = await fetch('get_chat_history.php');
      const data = await response.json();
      if (data.success && data.history.length > 0) {
        chatWindow.innerHTML = ''; // Clear welcome or placeholder
        if (historyList) historyList.innerHTML = ''; // Clear empty state
        
        data.history.forEach(chat => {
          // 1. Add to active chat window
          if (chat.role === 'user') {
            addUserMessage(chat.message);
          } else {
            // Clean up product tags for historical display
            let cleanMsg = chat.message.replace(/\[PRODUCT:\d+\]/g, '').trim();
            addBotMessage(cleanMsg);
            
            // Render historical product cards
            if (chat.products && chat.products.length > 0) {
              const productContainer = document.createElement('div');
              productContainer.className = 'chat-products-grid';
              
              chat.products.forEach(product => {
                productContainer.innerHTML += renderChatProductCard(product);
              });
              
              chatWindow.appendChild(productContainer);
              chatWindow.scrollTop = chatWindow.scrollHeight;
            }
          }

          // 2. Add to history list section
          if (historyList) {
            const historyItem = document.createElement('div');
            historyItem.className = 'chat-history-item';
            
            const roleLabel = chat.role === 'user' ? 'You' : 'Liora';
            const roleClass = chat.role === 'user' ? 'role-user' : 'role-bot';
            
            // Clean message for history list too
            let listMsg = chat.message.replace(/\[PRODUCT:\d+\]/g, '').trim();
            if (listMsg.length > 150) listMsg = listMsg.substring(0, 147) + '...';

            historyItem.innerHTML = `
              <span class="history-role ${roleClass}">${roleLabel}</span>
              <p class="history-message">${listMsg}</p>
              <span class="history-time">${chat.timestamp || ''}</span>
            `;
            historyList.prepend(historyItem); // Latest at top
          }
        });
      } else {
        // Handle non-logged-in users or no history
        if (!data.success && data.message && data.message.includes('Not logged in')) {
          // User not logged in - show login prompt
          addBotMessage("Hi! 🌸 I'm Liora, your AI florist assistant. To chat with me and get personalized flower recommendations, please <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>log in</a> or <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>create an account</a> first!");
          
          // Hide chat history section for non-logged-in users
          const chatHistoryContainer = document.querySelector('.chat-history-container');
          if (chatHistoryContainer) {
            chatHistoryContainer.style.display = 'none';
          }
          
          // Disable input for non-logged-in users
          userInput.disabled = true;
          userInput.placeholder = "Please log in to chat with Liora";
          sendBtn.disabled = true;
        } else {
          // Default welcome if no history but logged in
          addBotMessage(lioraWelcomeMessage);
        }
      }
    } catch (err) {
      console.error("History load error:", err);
      // Fallback for non-logged-in users
      addBotMessage("Hi! 🌸 I'm Liora, your AI florist assistant. To chat with me and get personalized flower recommendations, please <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>log in</a> or <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>create an account</a> first!");
      
      // Disable input for non-logged-in users
      userInput.disabled = true;
      userInput.placeholder = "Please log in to chat with Liora";
      sendBtn.disabled = true;
    }
  }

  function addBotMessage(text) {
    const msg = document.createElement('div');
    msg.className = 'message bot-message';
    msg.innerHTML = text; // Changed to innerHTML to support markdown-like response if needed
    chatWindow.appendChild(msg);
    chatWindow.scrollTop = chatWindow.scrollHeight;
    return msg;
  }

  function addUserMessage(text) {
    const msg = document.createElement('div');
    msg.className = 'message user-message';
    msg.textContent = text;
    chatWindow.appendChild(msg);
    chatWindow.scrollTop = chatWindow.scrollHeight;
  }

  function showTypingIndicator() {
    const msg = document.createElement('div');
    msg.className = 'message bot-message typing';
    msg.id = 'typing-indicator';
    msg.innerHTML = '<span></span><span></span><span></span>';
    chatWindow.appendChild(msg);
    chatWindow.scrollTop = chatWindow.scrollHeight;
  }

  function removeTypingIndicator() {
    const indicator = document.getElementById('typing-indicator');
    if (indicator) indicator.remove();
  }

  async function sendMessage() {
    const text = userInput.value.trim();
    if (!text) return;

    // Check if user is logged in
    if (!window.isLoggedIn) {
      addBotMessage("Please <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>log in</a> or <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>create an account</a> to chat with Liora! 🌸");
      return;
    }

    addUserMessage(text);
    userInput.value = '';
    
    // Update History List (User Message)
    const historyList = document.getElementById('chat-history-list');
    if (historyList) {
      if (historyList.querySelector('.empty-history')) historyList.innerHTML = '';
      const historyItem = document.createElement('div');
      historyItem.className = 'chat-history-item';
      historyItem.innerHTML = `
        <span class="history-role role-user">You</span>
        <p class="history-message">${text}</p>
        <span class="history-time">Just now</span>
      `;
      historyList.prepend(historyItem);
    }

    // Disable input and button
    userInput.disabled = true;
    sendBtn.disabled = true;

    showTypingIndicator();

    try {
      const response = await fetch('gemini_bridge.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ message: text })
      });

      const data = await response.json();
      removeTypingIndicator();

      if (data.success) {
        // Clean up [PRODUCT:id] tags from the text
        let cleanReply = data.reply.replace(/\[PRODUCT:\d+\]/g, '').trim();
        if (cleanReply) {
          addBotMessage(cleanReply);
          
          // Update History List (Bot Reply)
          if (historyList) {
            const historyItem = document.createElement('div');
            historyItem.className = 'chat-history-item';
            historyItem.innerHTML = `
              <span class="history-role role-bot">Liora</span>
              <p class="history-message">${cleanReply.length > 150 ? cleanReply.substring(0, 147) + '...' : cleanReply}</p>
              <span class="history-time">Just now</span>
            `;
            historyList.prepend(historyItem);
          }
        }

        // Show product cards if any
        if (data.products && data.products.length > 0) {
          const productContainer = document.createElement('div');
          productContainer.className = 'chat-products-grid';
          
          data.products.forEach(product => {
            productContainer.innerHTML += renderChatProductCard(product);
          });
          
          chatWindow.appendChild(productContainer);
          chatWindow.scrollTop = chatWindow.scrollHeight;
        }
      } else {
        // Handle specific error messages
        if (data.message && data.message.includes('Please log in')) {
          addBotMessage("Hi! 🌸 I'm Liora, your AI florist assistant. To chat with me and get personalized flower recommendations, please <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>log in</a> or <a href='login-register.php' style='color: #d86f9a; text-decoration: underline;'>create an account</a> first!");
        } else if (data.message && data.message.includes('API Key not configured')) {
          addBotMessage("Hi! 🌸 It looks like the OpenAI API Key hasn't been set up yet. Please open <b>config.php</b> and replace the placeholder with your actual OpenAI API Key.");
        } else {
          addBotMessage("I'm sorry, I'm having trouble connecting right now. 🌸 Please try again later.");
          console.error("AI Error:", data.message, data.details || '', data.curl_error || '');
        }
      }
    } catch (error) {
      removeTypingIndicator();
      addBotMessage("Oops! Something went wrong. 🌷");
      console.error("Fetch error:", error);
    } finally {
      userInput.disabled = false;
      sendBtn.disabled = false;
      userInput.focus();
    }
  }

  function renderChatProductCard(p) {
    const saleBadge = p.sale_price && p.sale_price < p.price ? 
      `<div class="product__badge light-orange">Sale</div>` : '';
    
    const priceHTML = p.sale_price && p.sale_price < p.price ? 
      `<span class="new__price">$${parseFloat(p.sale_price).toFixed(2)}</span>
       <span class="old__price">$${parseFloat(p.price).toFixed(2)}</span>` :
      `<span class="new__price">$${parseFloat(p.price).toFixed(2)}</span>`;

    const linkHref = p.link ? p.link : `details.php?id=${p.slug || p.id}`;

    return `
      <div class="product__item chat-product-card" data-product-id="${p.id}">
        <div class="product__banner">
          <a href="${linkHref}" class="product__images">
            <img src="${p.image_url}" alt="${p.name}" class="product__img default" />
          </a>
          ${saleBadge}
        </div>
        <div class="product__content">
          <span class="product__category">${p.category}</span>
          <a href="${linkHref}">
            <h3 class="product__title">${p.name}</h3>
          </a>
          <p class="chat-product-desc">${p.description || ''}</p>
          <div class="product__price flex">
            ${priceHTML}
          </div>
          <a href="javascript:void(0)" class="action__btn cart__btn" aria-label="Add To Cart" onclick="addToCart(${p.id})">
            <i class="fi fi-rs-shopping-bag-add"></i>
          </a>
        </div>
      </div>
    `;
  }

  sendBtn.addEventListener('click', sendMessage);
  userInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') sendMessage();
  });

  // Clear History Button
  const clearHistoryBtn = document.getElementById('clear-history-btn');
  if (clearHistoryBtn) {
    clearHistoryBtn.addEventListener('click', async function() {
      if (confirm('Are you sure you want to clear all chat history? This action cannot be undone.')) {
        try {
          const response = await fetch('get_chat_history.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' }
          });
          
          if (response.ok) {
            // Clear the history list
            const historyList = document.getElementById('chat-history-list');
            if (historyList) {
              historyList.innerHTML = '<div class="empty-history"><p>No chat history yet. Start a conversation above! 🌸</p></div>';
            }
            
            // Clear the chat window and add welcome message
            chatWindow.innerHTML = '';
            addBotMessage(lioraWelcomeMessage);
            
            // Show success message
            showToast('Chat history cleared successfully!');
          } else {
            showToast('Failed to clear chat history. Please try again.');
          }
        } catch (error) {
          console.error('Clear history error:', error);
          showToast('Failed to clear chat history. Please try again.');
        }
      }
    });
  }

});

/*=============== REMINDER NOTIFICATION SYSTEM ===============*/
document.addEventListener("DOMContentLoaded", function () {
  // Check if we're on the homepage (index.php)
  const isHomepage = window.location.pathname.includes('index.php') || 
                     window.location.pathname === '/' ||
                     window.location.pathname.endsWith('/');
  
  if (!isHomepage) return;

  // Check if notification already shown in this session
  if (sessionStorage.getItem('reminderNotificationShown')) {
    return;
  }

  // Fetch reminders for today
  async function loadReminderNotifications() {
    try {
      const response = await fetch('get_reminder_notifications.php', {
        method: 'GET',
        credentials: 'same-origin'
      });

      const data = await response.json();

      if (!data.success || !data.reminders || data.reminders.length === 0) {
        return;
      }

      // Show the notification popup
      showReminderNotification(data.reminders);
      sessionStorage.setItem('reminderNotificationShown', 'true');
    } catch (error) {
      console.error("Error loading reminder notifications:", error);
    }
  }

  function showReminderNotification(reminders) {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.className = 'reminder-notification-overlay';

    // Create notification box
    const box = document.createElement('div');
    box.className = 'reminder-notification-box';

    // Title with emoji
    const title = document.createElement('div');
    title.className = 'reminder-notification-title';
    title.innerHTML = '🎉 Today\'s Special Moments! 🌸';

    // Items container
    const itemsContainer = document.createElement('div');
    itemsContainer.className = 'reminder-notification-items';

    // Add each reminder
    const emojis = ['🎂', '💕', '🎓', '💐', '🎁', '🌹', '🎊', '🌻', '🦋', '💖', '🌷', '🌺'];
    reminders.forEach((reminder, index) => {
      const item = document.createElement('div');
      item.className = 'reminder-notification-item';
      
      const emoji = emojis[index % emojis.length];
      item.innerHTML = `<div class="reminder-notification-item-title">${emoji} ${escapeHtmlNotification(reminder.title)}</div>`;
      
      itemsContainer.appendChild(item);
    });

    // Buttons container
    const buttonsContainer = document.createElement('div');
    buttonsContainer.className = 'reminder-notification-buttons';

    // OK button
    const okBtn = document.createElement('button');
    okBtn.className = 'reminder-notification-btn reminder-notification-btn-primary';
    okBtn.textContent = 'Got it! ✨';
    okBtn.addEventListener('click', () => {
      overlay.style.animation = 'fadeOut 0.3s ease';
      setTimeout(() => overlay.remove(), 300);
    });

    // Close button (X)
    const closeBtn = document.createElement('button');
    closeBtn.className = 'reminder-notification-close';
    closeBtn.innerHTML = '✕';
    closeBtn.addEventListener('click', () => {
      overlay.style.animation = 'fadeOut 0.3s ease';
      setTimeout(() => overlay.remove(), 300);
    });

    buttonsContainer.appendChild(okBtn);

    // Assemble notification box
    box.appendChild(closeBtn);
    box.appendChild(title);
    box.appendChild(itemsContainer);
    box.appendChild(buttonsContainer);

    overlay.appendChild(box);

    // Add to page with slight delay for smooth animation
    document.body.appendChild(overlay);

    // Close on outside click
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) {
        overlay.style.animation = 'fadeOut 0.3s ease';
        setTimeout(() => overlay.remove(), 300);
      }
    });
  }

  function escapeHtmlNotification(text) {
    const map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
  }

  // Load and display reminders after page content is ready
  setTimeout(() => {
    loadReminderNotifications();
  }, 500);
});

/*=============== FINAL INIT ===============*/
console.log("%c✅ All systems loaded successfully!", "color:#10b981; font-weight:bold");

/*=============== PRICE SORTING (ULTRA ACTIVE REFRESH VERSION) ===============*/
function initSorting() {
  console.log("🌸 initSorting() called");
  const sortSelect = document.getElementById('price-sort');
  if (!sortSelect) {
    console.log("⚠️ Sort dropdown not found on this page.");
    return;
  }

  const urlParams = new URLSearchParams(window.location.search);
  const currentSort = urlParams.get('sort');

  // 1. Apply sorting if parameter exists in URL
  if (currentSort && currentSort !== 'default') {
    sortSelect.value = currentSort;
    console.log("🔍 Applying sort: " + currentSort);
    
    const containers = document.querySelectorAll('.products__container');
    if (containers.length === 0) console.log("⚠️ No .products__container found.");
    
    containers.forEach(container => {
      // Get all children that look like product items
      const items = Array.from(container.children).filter(child => 
        child.classList.contains('product__item') || child.querySelector('.new__price') || child.getAttribute('data-price')
      );

      console.log("📦 Found " + items.length + " items to sort in container.");
      if (items.length < 2) return;

      items.sort((a, b) => {
        // Fallback chain for price: data-price attr -> .new__price text -> 0
        let pA = parseFloat(a.getAttribute('data-price'));
        if (isNaN(pA)) {
          const text = a.querySelector('.new__price')?.textContent || '0';
          pA = parseFloat(text.replace(/[^0-9.]/g, '')) || 0;
        }

        let pB = parseFloat(b.getAttribute('data-price'));
        if (isNaN(pB)) {
          const text = b.querySelector('.new__price')?.textContent || '0';
          pB = parseFloat(text.replace(/[^0-9.]/g, '')) || 0;
        }
        
        return currentSort === 'low-to-high' ? pA - pB : pB - pA;
      });

      // Clear container temporarily to ensure clean re-order (optional but safer)
      // items.forEach(item => container.removeChild(item)); 
      
      // Physically re-order in the DOM by appending in new order
      items.forEach(item => container.appendChild(item));
    });
  }

  // 2. Handle selection change
  sortSelect.addEventListener('change', function() {
    const val = this.value;
    const url = new URL(window.location.href);
    
    // Update URL parameter
    if (val === 'default' || !val) {
      url.searchParams.delete('sort');
    } else {
      url.searchParams.set('sort', val);
    }
    
    // Visual feedback
    document.body.style.opacity = '0.3';
    
    console.log("🔄 Refreshing to: " + url.toString());
    window.location.href = url.toString();
  });
}

// Global initialization
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initSorting);
} else {
  initSorting();
}
