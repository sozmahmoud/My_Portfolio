/**
 * ===================================
 * REVIEW SYSTEM HELPER - Shared Functions
 * Used by all product pages for database-driven reviews
 * ===================================
 */

window.lioraReviewRating = window.lioraReviewRating || 0;

function normalizeReviewStars() {
    document.querySelectorAll('.star-rating-input').forEach(container => {
        container.querySelectorAll('span').forEach((star, index) => {
            star.dataset.value = String(index + 1);
        });
    });
}

function getSelectedReviewRating() {
    normalizeReviewStars();

    const activeStars = document.querySelectorAll('.star-rating-input span.active');
    const activeRating = Array.from(activeStars).reduce((highest, star) => {
        const value = parseInt(star.dataset.value || '0', 10);
        return Number.isNaN(value) ? highest : Math.max(highest, value);
    }, 0);

    return activeRating || window.lioraReviewRating || 0;
}

function getCurrentReviewProductId() {
    const params = new URLSearchParams(window.location.search);
    return params.get('id') || params.get('product_id') || '';
}

function initReviewStarsHelper() {
    normalizeReviewStars();

    document.querySelectorAll('.star-rating-input span').forEach(star => {
        if (star.dataset.reviewBound === 'true') return;
        star.dataset.reviewBound = 'true';

        star.addEventListener('click', () => {
            const rating = parseInt(star.dataset.value || '0', 10);
            const stars = Array.from(star.closest('.star-rating-input').querySelectorAll('span'));
            window.lioraReviewRating = rating;
            stars.forEach((item, index) => {
                item.classList.toggle('active', index < rating);
            });
        });

        star.addEventListener('mouseenter', () => {
            const rating = parseInt(star.dataset.value || '0', 10);
            const stars = Array.from(star.closest('.star-rating-input').querySelectorAll('span'));
            stars.forEach((item, index) => {
                item.classList.toggle('hover', index < rating);
            });
        });

        star.addEventListener('mouseleave', () => {
            star.closest('.star-rating-input').querySelectorAll('span').forEach(item => {
                item.classList.remove('hover');
            });
        });
    });
}

// Get numeric product ID for database queries (async)
async function getNumericProductIdHelper(stringId) {
    if (!stringId) return null;
    if (/^\d+$/.test(String(stringId))) {
        return Number(stringId);
    }

    try {
        const response = await fetch(`map_product_id.php?id=${encodeURIComponent(stringId)}`);
        if (!response.ok) throw new Error('Failed to map product ID');
        const data = await response.json();
        return data.success ? Number(data.id) : null;
    } catch (error) {
        console.error('Error mapping product ID:', error);
        return null;
    }
}

// Escape HTML to prevent XSS
function escapeHtmlHelper(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

async function extractNumericProductIdFromItem(item) {
    const rawId = item.dataset.productId;
    if (rawId && /^\d+$/.test(rawId)) {
        return rawId;
    }

    const link = item.querySelector('a[href*="details.php?id="], a[href*="giftdetail.php?id="]');
    if (!link) return null;

    try {
        const url = new URL(link.href, window.location.origin);
        let idValue = url.searchParams.get('id') || url.searchParams.get('product_id');
        if (!idValue) return null;

        if (/^\d+$/.test(idValue)) {
            item.dataset.productId = idValue;
            return idValue;
        }

        const numeric = await getNumericProductIdHelper(idValue);
        if (numeric) {
            item.dataset.productId = String(numeric);
            return String(numeric);
        }
    } catch (error) {
        console.error('Unable to parse product item link:', error);
    }
    return null;
}

// Show toast notification (fallback if main.js not loaded)
function showToastHelper(message) {
    if (typeof showToast !== 'undefined') {
        showToast(message);
    } else {
        alert(message);
    }
}

// Submit review to database
async function submitReviewDatabase(productStringId) {
    const text = document.getElementById('review-text').value.trim();
    const rating = getSelectedReviewRating();
    
    if (!rating || !text) {
        showToastHelper('💕 Please add stars and write a review!');
        return;
    }
    
    if (!productStringId) {
        showToastHelper('❌ Unable to identify product. Please refresh the page.');
        return;
    }
    
    const productId = await getNumericProductIdHelper(productStringId);
    
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
            showToastHelper('🌷 Review posted! Thank you! 💖');
            document.getElementById('review-text').value = '';
            window.lioraReviewRating = 0;
            if (document.querySelector('.star-rating-input')) {
                document.querySelectorAll('.star-rating-input span').forEach(s => s.classList.remove('active'));
            }
            
            // Reload reviews after brief delay
            setTimeout(() => loadReviewsDatabase(productStringId), 500);
        } else {
            showToastHelper('❌ ' + (data.message || 'Error posting review'));
        }
    } catch (error) {
        console.error('Review submission error:', error);
        showToastHelper('❌ Error posting review. Please try again.');
    }
}

// Load and display reviews from database
async function loadReviewsDatabase(productStringId) {
    if (!productStringId) return;
    
    const productId = await getNumericProductIdHelper(productStringId);
    const reviewsList = document.getElementById('reviews-list');
    
    if (!reviewsList) return;
    
    // Load rating summary first
    loadRatingSummary(productStringId);
    
    try {
        const response = await fetch(`get_reviews.php?product_id=${productId}`);
        if (!response.ok) throw new Error('Failed to fetch reviews');
        
        const data = await response.json();
        
        if (data.success && data.reviews.length > 0) {
            reviewsList.innerHTML = data.reviews.map(review => `
                <div class="review-item">
                    <div class="review-header">
                        <span class="review-label">Customer review</span>
                        <span class="review-date">${review.date}</span>
                    </div>
                    <div class="review-stars">
                        ${renderStars(review.rating)}<span class="rating-number">${review.rating}/5</span>
                    </div>
                    <p class="review-comment">${escapeHtmlHelper(review.comment)}</p>
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

function initReviewPageFallback() {
    const summaryContainer = document.getElementById('rating-summary-container');
    const reviewsList = document.getElementById('reviews-list');
    const productId = getCurrentReviewProductId();

    if (!productId || (!summaryContainer && !reviewsList)) return;

    initReviewStarsHelper();

    if (typeof window.submitReview !== 'function') {
        window.submitReview = function () {
            submitReviewDatabase(productId);
        };
    }

    if (typeof window.loadReviews !== 'function') {
        window.loadReviews = function () {
            loadReviewsDatabase(productId);
        };
        window.loadReviews();
    } else if (summaryContainer && summaryContainer.children.length === 0) {
        loadRatingSummary(productId);
    }
}

// Function to render stars HTML
function renderStars(rating) {
    let stars = '';
    const roundedRating = Math.round(rating);
    for (let i = 1; i <= 5; i++) {
        if (i <= roundedRating) {
            stars += '<i class="fi fi-rs-star star-filled"></i>';
        } else {
            stars += '<i class="fi fi-rs-star star-empty"></i>';
        }
    }
    return stars;
}

// Load rating summary and breakdown
async function loadRatingSummary(productStringId) {
    const summaryContainer = document.getElementById('rating-summary-container');
    if (!summaryContainer) return;

    try {
        const response = await fetch(`get_rating_summary.php?product_id=${encodeURIComponent(productStringId)}`);
        const data = await response.json();

        if (data.success && data.total > 0) {
            let breakdownHTML = '';
            for (let i = 5; i >= 1; i--) {
                const count = data.breakdown[i] || 0;
                const percentage = (count / data.total) * 100;
                breakdownHTML += `
                    <div class="rating-breakdown-item">
                        <span class="star-label">${i} <i class="fi fi-rs-star"></i></span>
                        <div class="rating-progress-bar">
                            <div class="rating-progress-fill" style="width: ${percentage}%"></div>
                        </div>
                        <span class="star-count">(${count})</span>
                    </div>
                `;
            }

            summaryContainer.innerHTML = `
                <div class="rating-summary-box">
                    <div class="overall-rating-box">
                        <span class="overall-score">${data.average}</span>
                        <div class="overall-stars">${renderStars(data.average)}</div>
                        <span class="total-reviews-text">Based on ${data.total} reviews</span>
                    </div>
                    <div class="rating-breakdown-list">
                        ${breakdownHTML}
                    </div>
                </div>
            `;
        } else {
            summaryContainer.innerHTML = `
                <div class="rating-summary-box empty">
                    <div class="overall-rating-box">
                        <span class="overall-score">0.0</span>
                        <div class="overall-stars">${renderStars(0)}</div>
                        <span class="total-reviews-text">No reviews yet</span>
                    </div>
                    <p class="cute-rating-note">Be the first to share your love for these flowers! 🌸</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error loading rating summary:', error);
    }
}

// Load ratings for all product items on the page
async function loadAllProductItemRatings() {
    const productItems = Array.from(document.querySelectorAll('.product__item'));
    if (productItems.length === 0) return;

    const productIdMap = {};
    const numericIds = [];

    for (const item of productItems) {
        const numericId = await extractNumericProductIdFromItem(item);
        if (numericId) {
            productIdMap[numericId] = productIdMap[numericId] || [];
            productIdMap[numericId].push(item);
            if (!numericIds.includes(numericId)) {
                numericIds.push(numericId);
            }
        }
    }

    if (numericIds.length === 0) {
        productItems.forEach(item => {
            const ratingContainer = ensureRatingContainer(item);
            if (ratingContainer) ratingContainer.innerHTML = renderStars(0);
        });
        return;
    }

    try {
        const response = await fetch(`get_batch_ratings.php?ids=${numericIds.join(',')}`);
        const data = await response.json();

        productItems.forEach(item => {
            const ratingContainer = ensureRatingContainer(item);
            if (!ratingContainer) return;

            const productId = item.dataset.productId;
            const ratingData = productId ? data.ratings?.[productId] : null;
            if (ratingData && ratingData.total > 0) {
                ratingContainer.innerHTML = renderStars(ratingData.average);
            } else {
                ratingContainer.innerHTML = renderStars(0);
            }
        });
    } catch (error) {
        console.error('Error loading batch ratings:', error);
        productItems.forEach(item => {
            const ratingContainer = ensureRatingContainer(item);
            if (ratingContainer) ratingContainer.innerHTML = renderStars(0);
        });
    }
}

function ensureRatingContainer(item) {
    let ratingContainer = item.querySelector('.product__rating');
    if (!ratingContainer) {
        const content = item.querySelector('.product__content');
        if (!content) return null;

        const productTitle = content.querySelector('.product__title');
        let titleLink = null;

        if (productTitle) {
            titleLink = productTitle.closest('a');
        }

        ratingContainer = document.createElement('div');
        ratingContainer.className = 'product__rating';

        if (titleLink) {
            titleLink.after(ratingContainer);
        } else if (productTitle) {
            productTitle.after(ratingContainer);
        } else {
            content.prepend(ratingContainer);
        }
    }

    return ratingContainer;
}

// Auto-load product ratings on page load
document.addEventListener('DOMContentLoaded', () => {
    initReviewPageFallback();
    loadAllProductItemRatings();
    
    // Also observe for dynamic changes (like sorting or related products)
    const observer = new MutationObserver(() => {
        // Debounce if needed, but for now just call
        loadAllProductItemRatings();
    });
    
    const productsContainer = document.querySelector('.products__container');
    if (productsContainer) {
        observer.observe(productsContainer, { childList: true });
    }
    
    const relatedContainer = document.getElementById('related-products');
    if (relatedContainer) {
        observer.observe(relatedContainer, { childList: true });
    }
});
