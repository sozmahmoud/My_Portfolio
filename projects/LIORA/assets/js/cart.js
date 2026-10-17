const CONFIG = {
    API_URL: 'cart_action.php',
    FREE_SHIPPING: 75,
    DISCOUNT_MIN: 50,
    DISCOUNT_PERCENT: 0.10,
    SHIPPING_COST: 10,
    STORAGE_KEY: 'liora_cart'
};

let cart = [];
let useServerCart = true;
let appliedCouponCode = null; // Global variable to store the applied coupon code
const CART_FALLBACK_IMAGE = 'assets/img/first_page.jpg';
const COUPON_STORAGE_KEY = 'liora_coupon';

// ========== INIT ==========
document.addEventListener('DOMContentLoaded', async function() {
    // Load applied coupon from storage
    appliedCouponCode = localStorage.getItem(COUPON_STORAGE_KEY) || null;
    if (appliedCouponCode) {
        const couponInput = document.getElementById('coupon-input');
        if (couponInput) couponInput.value = appliedCouponCode;
    }
    
    await loadCart();
    updateBadge();
    setupAddButtons();

    if (document.getElementById('cart-items-container')) {
        renderCart();
    }
});

// ========== API HELPERS ==========
async function cartApiFetch(data) {
    try {
        const response = await fetch(CONFIG.API_URL, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json'
            },
            body: data
        });

        if (!response.ok) {
            const body = await response.text();
            throw new Error('Network response was not ok: ' + response.status + ' ' + body);
        }

        try {
            return await response.json();
        } catch (error) {
            console.warn('Cart API JSON parse failed:', error);
            useServerCart = false;
            return null;
        }
    } catch (error) {
        console.warn('Cart API unavailable:', error);
        useServerCart = false;
        return null;
    }
}

function appendProductSnapshot(form, source) {
    if (!source) return;
    form.append('name', source.name || source.title || 'Product');
    form.append('price', parseFloat(String(source.price || 0).replace(/[^0-9.]/g, '')) || 0);
    
    // Ensure image path is properly captured
    let imageUrl = source.image || source.image_url || source.img || '';
    if (imageUrl && !imageUrl.startsWith('http') && !imageUrl.startsWith('/')) {
        // If it's a relative path, ensure it's correct
        if (!imageUrl.startsWith('assets/')) {
            imageUrl = 'assets/img/' + imageUrl.replace('assets/img/', '');
        }
    }
    form.append('image', imageUrl);
    
    form.append('category', source.category || 'Flowers');
    form.append('link', source.link || source.href || '');
    if (source.product_type) form.append('product_type', source.product_type);
    if (source.variant) form.append('variant', source.variant);
    const options = normalizeOptions(source.options);
    if (options.length) {
        form.append('options', JSON.stringify(options));
    }
    if (source.set_quantity) {
        form.append('set_quantity', '1');
    }
}

function normalizeOptions(options) {
    if (!options) return [];

    let parsed = options;
    if (typeof options === 'string') {
        try {
            parsed = JSON.parse(options);
        } catch (error) {
            return [];
        }
    }

    if (!Array.isArray(parsed) && typeof parsed === 'object') {
        parsed = Object.entries(parsed).map(([label, value]) => ({ label, value }));
    }

    if (!Array.isArray(parsed)) return [];

    return parsed
        .map(option => ({
            label: String(option.label || option.name || '').trim(),
            value: String(option.value || option.text || '').trim()
        }))
        .filter(option => option.label && option.value);
}

function getDetailInfoValue(labels) {
    const wantedLabels = Array.isArray(labels) ? labels : [labels];
    const rows = document.querySelectorAll('#detail-info-table tr');

    for (const row of rows) {
        const key = row.querySelector('th')?.textContent?.trim();
        const value = row.querySelector('td')?.textContent?.trim();
        if (key && value && wantedLabels.some(label => key.toLowerCase() === String(label).toLowerCase())) {
            return value;
        }
    }

    return '';
}

function collectDetailCartOptions() {
    const options = [];

    document.querySelectorAll('[data-cart-option]:checked').forEach(input => {
        options.push({
            label: input.dataset.cartOption,
            value: input.value
        });
    });

    const productType = getDetailInfoValue(['Flower Type', 'Type', 'Shape']) ||
        document.getElementById('detail-kurdish-title')?.textContent?.trim() ||
        '';
    const variant = getDetailInfoValue(['Color', 'Size', 'Flavor']) || '';

    if (productType) {
        options.unshift({ label: 'Product Type', value: productType });
    }
    if (variant) {
        options.push({ label: 'Variant', value: variant });
    }

    return normalizeOptions(options);
}

function renderOptionTags(options) {
    const normalized = normalizeOptions(options);
    if (!normalized.length) return '';

    return `<div class="item-options">${normalized.map(option => (
        `<span class="option-tag">${escapeHTML(option.label)}: ${escapeHTML(option.value)}</span>`
    )).join('')}</div>`;
}

function getProductLinkHref(scope) {
    if (!scope) return null;

    const selector = 'a.product__images, a[href*="details.php?id="], a[href*="giftdetail.php?id="]';
    const link = scope.matches?.(selector) ? scope : scope.querySelector?.(selector);
    return link ? (link.getAttribute('href') || link.href || null) : null;
}

function getCurrentPageProductLink() {
    const slug = new URLSearchParams(window.location.search).get('id');
    if (!slug) return null;

    const pageName = window.location.pathname.includes('giftdetail.php') ? 'giftdetail.php' : 'details.php';
    return `${pageName}?id=${encodeURIComponent(slug)}`;
}

async function loadCart() {
    const local = loadLocalCart();
    const form = new FormData();
    form.append('action', 'get');

    const data = await cartApiFetch(form);
    if (data && data.success) {
        cart = data.items || [];
        return;
    }

    cart = local;
}

function normalizeCartItem(item) {
    const productId = Number(item.product_id || item.id);
    const quantity = Math.max(1, parseInt(item.quantity, 10) || 1);
    const price = parseFloat(String(item.price).replace(/[^0-9.]/g, '')) || 0;

    return {
        ...item,
        id: productId,
        product_id: productId,
        quantity,
        price,
        name: item.name || item.title || 'Product',
        image: item.image || item.image_url || item.img || CART_FALLBACK_IMAGE,
        category: item.category || 'Flowers',
        product_type: item.product_type || '',
        variant: item.variant || '',
        options: normalizeOptions(item.options),
        link: item.link || item.href || `details.php?id=${encodeURIComponent(productId)}`
    };
}

function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    }[char]));
}

function loadLocalCart() {
    try {
        return JSON.parse(localStorage.getItem(CONFIG.STORAGE_KEY)) || [];
    } catch (e) {
        return [];
    }
}

function saveLocalCart() {
    try {
        localStorage.setItem(CONFIG.STORAGE_KEY, JSON.stringify(cart));
    } catch (e) {
        // ignore
    }
}

async function mapProductSlugToId(slug) {
    if (!slug) return null;
    if (/^\d+$/.test(String(slug))) {
        return Number(slug);
    }

    try {
        const response = await fetch(`map_product_id.php?id=${encodeURIComponent(slug)}`, { credentials: 'same-origin' });
        if (!response.ok) return null;
        const result = await response.json();
        return result.success && result.id ? Number(result.id) : null;
    } catch (error) {
        console.warn('Product slug mapping failed:', error);
        return null;
    }
}

async function resolveProductId(rawId, card) {
    if (rawId) {
        const numericValue = Number(rawId);
        if (Number.isInteger(numericValue) && numericValue > 0) {
            return numericValue;
        }
    }

    const slug = rawId || card?.dataset?.productId || card?.dataset?.id;
    if (!slug) {
        const link = card?.querySelector('a[href*="details.php?id"], a[href*="giftdetail.php?id"]');
        if (link) {
            try {
                const url = new URL(link.href, window.location.origin);
                return await mapProductSlugToId(url.searchParams.get('id'));
            } catch (error) {
                return null;
            }
        }
        return null;
    }

    return await mapProductSlugToId(slug);
}

// ========== CART ACTIONS ==========
async function addToCart(source) {
    if (source && typeof source === 'object' && !(source instanceof Element)) {
        const productId = await resolveProductId(source.product_id || source.id, null);
        const productName = source.name || source.title || 'Product';
        const quantity = Math.min(99, Math.max(1, parseInt(source.quantity, 10) || 1));
        const options = normalizeOptions(source.options);

        if (!productId || Number.isNaN(productId)) {
            showMessage('Product missing ID, cannot add to cart.');
            return;
        }

        if (useServerCart) {
            const form = new FormData();
            form.append('action', 'add');
            form.append('product_id', productId);
            form.append('quantity', quantity);
            appendProductSnapshot(form, source);

            const result = await cartApiFetch(form);
            if (result && result.success) {
                cart = result.items || cart;
                updateBadge(result.total_items);
                showMessage(productName + ' added to cart! 🌷');
                renderCart();
                return;
            }
        }

        const existing = cart.find(item => Number(item.product_id || item.id) === productId);
        if (existing) {
            existing.quantity = source.set_quantity ? quantity : Math.min(99, existing.quantity + quantity);
            existing.options = options;
            existing.product_type = source.product_type || existing.product_type || '';
            existing.variant = source.variant || existing.variant || '';
        } else {
            cart.push({
                id: productId,
                product_id: productId,
                name: productName,
                price: parseFloat(String(source.price || 0).replace(/[^0-9.]/g, '')) || 0,
                quantity,
                image: source.image || source.image_url || source.img || '',
                category: source.category || 'flowers',
                product_type: source.product_type || '',
                variant: source.variant || '',
                options,
                link: source.link || source.href || `details.php?id=${encodeURIComponent(productId)}`
            });
        }
        saveLocalCart();
        updateBadge();
        showMessage(productName + ' added to cart! 🌷');
        renderCart();
        return;
    }

    const button = source;
    const card = button?.closest?.('.product__item');
    const detailsAction = button?.closest?.('.details__action');
    if (!card) {
        if (!detailsAction) {
            showMessage('Could not identify product info.');
            return;
        }

        const urlParams = new URLSearchParams(window.location.search);
        const rawProductId = urlParams.get('id') || document.querySelector('[data-product-id]')?.dataset.productId;
        const productId = await resolveProductId(rawProductId, null);
        const productName = document.getElementById('detail-title')?.textContent?.trim() || 'Product';
        const quantity = 1;
        const detailOptions = collectDetailCartOptions();

        if (!productId || Number.isNaN(productId)) {
            showMessage('Product missing ID, cannot add to cart.');
            return;
        }

        await addToCart({
            id: productId,
            title: productName,
            price: document.getElementById('detail-price')?.textContent || 0,
            img: document.getElementById('detail-img-main')?.getAttribute('src') || '',
            category: document.getElementById('detail-kurdish-title')?.textContent || 'Flowers',
            quantity,
            options: detailOptions,
            product_type: getDetailInfoValue(['Flower Type', 'Type', 'Shape']) || '',
            variant: getDetailInfoValue(['Color', 'Size', 'Flavor']) || '',
            link: getCurrentPageProductLink(),
            set_quantity: true
        });
        return;
    }

    const rawId = card.dataset.productId || card.dataset.id;
    const productId = await resolveProductId(rawId, card);
    const quantity = 1;
    const productName = card.querySelector('.product__title')?.textContent?.trim() || 'Product';

    if (!productId || Number.isNaN(productId)) {
        showMessage('Product missing ID, cannot add to cart.');
        return;
    }

    if (useServerCart) {
        const form = new FormData();
        form.append('action', 'add');
        form.append('product_id', productId);
        form.append('quantity', quantity);
        
        // Capture product details from card
        const productName = card.querySelector('.product__title')?.textContent?.trim() || 'Product';
        const priceText = card.dataset.price || card.querySelector('.new__price')?.textContent || '0';
        const priceValue = parseFloat(String(priceText).replace(/[^\d.]/g, '')) || 0;
        const imgElement = card.querySelector('img.product__img.default') || card.querySelector('img.product__img') || card.querySelector('img');
        const imageUrl = imgElement?.getAttribute('src') || imgElement?.src || '';
        const category = card.querySelector('.product__category')?.textContent?.trim() || 'Flowers';
        const linkHref = getProductLinkHref(card);
        
        appendProductSnapshot(form, {
            name: productName,
            price: priceValue,
            image: imageUrl,
            category: category,
            link: linkHref
        });

        const result = await cartApiFetch(form);
        if (result && result.success) {
            cart = result.items || cart;
            updateBadge(result.total_items);
            showMessage(productName + ' added to cart! 🌷');
            renderCart();
            return;
        }
    }

    const existing = cart.find(item => Number(item.product_id || item.id) === productId);
    if (existing) {
        existing.quantity = Math.min(99, existing.quantity + quantity);
    } else {
        const priceText = card.dataset.price || card.querySelector('.new__price')?.textContent || '0';
        const priceValue = parseFloat(String(priceText).replace(/[^\d.]/g, '')) || 0;
        const imgElement = card.querySelector('img.product__img.default') || card.querySelector('img.product__img') || card.querySelector('img');
        const image = imgElement?.getAttribute('src') || imgElement?.src || '';
        const category = card.querySelector('.product__category')?.textContent?.trim() || 'Flowers';

        cart.push({
            id: productId,
            product_id: productId,
            name: productName,
            price: priceValue,
            quantity: quantity,
            image: image,
            category: category,
            link: getProductLinkHref(card) || `details.php?id=${encodeURIComponent(productId)}`
        });
    }
    saveLocalCart();
    updateBadge();
    showMessage(productName + ' added to cart! 🌷');
    renderCart();
}

async function removeFromCart(id) {
    id = Number(id);
    if (useServerCart) {
        const form = new FormData();
        form.append('action', 'remove');
        form.append('product_id', id);

        const result = await cartApiFetch(form);
        if (result && result.success) {
            cart = result.items || [];
            updateBadge(result.total_items);
            renderCart();
            showMessage('Item removed 🗑️');
            return;
        }
    }

    cart = cart.filter(item => Number(item.product_id || item.id) !== id);
    saveLocalCart();
    updateBadge();
    renderCart();
    showMessage('Item removed 🗑️');
}

async function changeQty(id, change) {
    id = Number(id);
    const item = cart.find(item => Number(item.product_id || item.id) === id);
    if (!item) return;

    const newQty = item.quantity + change;
    if (newQty < 1) {
        removeFromCart(id);
        return;
    }

    if (useServerCart) {
        const form = new FormData();
        form.append('action', 'update');
        form.append('product_id', id);
        form.append('quantity', newQty);

        const result = await cartApiFetch(form);
        if (result && result.success) {
            cart = result.items || cart;
            updateBadge(result.total_items);
            renderCart();
            return;
        }
    }

    item.quantity = Math.min(newQty, 99);
    saveLocalCart();
    updateBadge();
    renderCart();
}

async function setQty(id, newQty) {
    id = Number(id);
    newQty = parseInt(newQty, 10);
    if (Number.isNaN(newQty) || newQty < 1) {
        removeFromCart(id);
        return;
    }

    if (useServerCart) {
        const form = new FormData();
        form.append('action', 'update');
        form.append('product_id', id);
        form.append('quantity', newQty);

        const result = await cartApiFetch(form);
        if (result && result.success) {
            cart = result.items || cart;
            updateBadge(result.total_items);
            renderCart();
            return;
        }
    }

    const item = cart.find(item => Number(item.product_id || item.id) === id);
    if (!item) return;

    item.quantity = Math.min(newQty, 99);
    saveLocalCart();
    updateBadge();
    renderCart();
}

async function clearCart() {
    if (cart.length === 0) return;
    if (!confirm('Clear your cart? 🌸')) return;

    // Clear coupon when clearing cart
    appliedCouponCode = null;
    localStorage.removeItem(COUPON_STORAGE_KEY);
    const couponInput = document.getElementById('coupon-input');
    if (couponInput) couponInput.value = '';
    const couponMsg = document.getElementById('coupon-message');
    if (couponMsg) couponMsg.textContent = '';

    if (useServerCart) {
        const form = new FormData();
        form.append('action', 'clear');
        const result = await cartApiFetch(form);
        if (result && result.success) {
            cart = result.items || [];
            updateBadge(result.total_items);
            renderCart();
            showMessage('Cart cleared! 🌱');
            return;
        }
    }

    cart = [];
    saveLocalCart();
    updateBadge();
    renderCart();
    showMessage('Cart cleared! 🌱');
}

function renderCart() {
    const container = document.getElementById('cart-items-container');
    const emptyMsg = document.getElementById('empty-cart-message');
    const cartContent = document.getElementById('cart-content');

    if (!container) return;

    cart = cart.map(normalizeCartItem).filter(item => item.id > 0);

    if (cart.length === 0) {
        if (emptyMsg) emptyMsg.style.display = 'block';
        if (cartContent) cartContent.style.display = 'none';
        updateTotals(0, 0, 0, 0);
        return;
    }

if (emptyMsg) emptyMsg.style.display = 'none';
    if (cartContent) cartContent.style.display = 'block';

    let html = '';
    let subtotal = 0; // Initialize subtotal

    cart.forEach((item) => {
        const productId = item.product_id || item.id;
        const productPrice = item.price;
        const itemTotal = productPrice * item.quantity;
        subtotal += itemTotal;
        const productName = escapeHTML(item.name);
        const productImage = escapeHTML(item.image);
        const productCategory = escapeHTML(item.category);
        const productLink = escapeHTML(item.link || `details.php?id=${encodeURIComponent(productId)}`);
        const fallbackImage = escapeHTML(CART_FALLBACK_IMAGE);
        const productOptions = renderOptionTags(item.options);

        html += `
<div class="product__item">
  <div class="product__banner">
    <a href="${productLink}" class="product__images">
      <img src="${productImage}" class="product__img default" alt="${productName}" onerror="this.onerror=null;this.src='${fallbackImage}';">
      <img src="${productImage}" class="product__img hover" alt="${productName}" onerror="this.onerror=null;this.src='${fallbackImage}';">
    </a>
    <div class="product__actions">
      <button type="button" onclick="removeFromCart('${productId}')" class="action__btn">
        <i class="fi fi-rs-trash"></i>
      </button>
    </div>
  </div>
  <div class="product__content">
    <span class="product__category">${productCategory}</span>
    <h3 class="product__title">${productName}</h3>
    ${productOptions}
    <div class="product__price flex">
      <span class="new__price">$${productPrice.toFixed(2)}</span>
    </div>
    <div class="quantity-control">
      <button type="button" onclick="changeQty('${productId}', -1)" class="qty-btn">-</button>
      <span class="qty-val" id="qty-${productId}">${item.quantity}</span>
      <button type="button" onclick="changeQty('${productId}', 1)" class="qty-btn">+</button>
    </div>
    <div class="product__price flex" style="margin-top:6px;">
      <span class="new__price">$${itemTotal.toFixed(2)}</span>
    </div>
  </div>
</div>
`;
    });

    container.innerHTML = html;
 
    // Valid coupon discount rates
    const couponDiscounts = {
        'LOVE10': 0.10,   // 10% discount
        'SPRING15': 0.15, // 15% discount
        'SUMMER20': 0.20  // 20% discount
    };

    // Existing volume-based discount
    const volumeDiscount = subtotal >= CONFIG.DISCOUNT_MIN ? subtotal * CONFIG.DISCOUNT_PERCENT : 0;

    // Coupon discount logic
    let couponDiscount = 0;
    if (appliedCouponCode && couponDiscounts[appliedCouponCode]) {
        couponDiscount = subtotal * couponDiscounts[appliedCouponCode];
    }

    const totalDiscount = volumeDiscount + couponDiscount; // Combine all discounts
    const shipping = subtotal >= CONFIG.FREE_SHIPPING ? 0 : CONFIG.SHIPPING_COST;
    const rewards = 0; // Reward deduction not applied automatically on the cart summary
    const total = subtotal - totalDiscount - rewards + shipping;

    updateTotals(subtotal, totalDiscount, shipping, rewards, total);
    updateProgress(subtotal);
}

function updateTotals(subtotal, discount, shipping, rewards, total) {
    const setText = (id, text) => {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    };

    setText('summary-subtotal', '$' + subtotal.toFixed(2));
    setText('summary-discount', '-$' + discount.toFixed(2));
    setText('summary-shipping', shipping === 0 ? 'FREE 🚚' : '$' + shipping.toFixed(2));
    setText('summary-rewards', '-$' + rewards.toFixed(2));
    setText('summary-total', '$' + total.toFixed(2));

    const discountRow = document.getElementById('discount-row');
    if (discountRow) discountRow.style.display = discount > 0 ? 'table-row' : 'none';
}

function updateProgress(subtotal) {
    const bar = document.getElementById('progress-fill');
    const text = document.getElementById('progress-text');

    if (!bar || !text) return;

    if (subtotal >= CONFIG.FREE_SHIPPING) {
        bar.style.width = '100%';
        bar.style.background = '#4caf50';
        text.textContent = '✅ FREE shipping unlocked!';
    } else {
        const needed = CONFIG.FREE_SHIPPING - subtotal;
        const pct = Math.min((subtotal / CONFIG.FREE_SHIPPING) * 100, 100);
        bar.style.width = pct + '%';
        bar.style.background = '#e89bc2';
        text.textContent = 'Add $' + needed.toFixed(2) + ' more for FREE shipping';
    }
}

function goCheckout(e) {
    if (cart.length === 0) {
        e.preventDefault();
        showMessage('Your cart is empty! Add flowers first 🌸');
        return false;
    }
    return true;
}

function applyCoupon() {
    const couponInput = document.getElementById('coupon-input');
    const couponCode = couponInput?.value.trim().toUpperCase();
    const message = document.getElementById('coupon-message');
    if (!message) return;

    // Reset previous coupon state
    appliedCouponCode = null;
    localStorage.removeItem(COUPON_STORAGE_KEY);
    message.style.color = ''; // Reset message color

    // Valid coupon codes
    const validCoupons = {
        'LOVE10': 0.10,  // 10% discount
        'SPRING15': 0.15, // 15% discount
        'SUMMER20': 0.20  // 20% discount
    };

    if (validCoupons[couponCode]) {
        message.textContent = `Coupon applied! ${(validCoupons[couponCode] * 100).toFixed(0)}% discount 🌸`;
        appliedCouponCode = couponCode;
        localStorage.setItem(COUPON_STORAGE_KEY, couponCode); // Store coupon code
        message.style.color = 'green'; // Visual feedback for success
    } else {
        message.textContent = 'Invalid coupon code';
        message.style.color = 'red'; // Visual feedback for error
    }
    renderCart(); // Re-render the cart to apply or remove the discount
}

function proceedToCheckout() {
    if (cart.length === 0) {
        showMessage('Your cart is empty!');
        return false;
    }
    window.location.href = 'checkout.php';
}

function updateBadge(forcedCount = null) {
    const count = (forcedCount !== null && !isNaN(forcedCount)) 
        ? Number(forcedCount) 
        : cart.reduce((sum, item) => sum + (parseInt(item.quantity, 10) || 0), 0);

    const badges = document.querySelectorAll('.cart-badge, #cart-count, .header__action-btn .count');
    badges.forEach(badge => {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline-flex' : 'none';
    });

    if (typeof serverCartCount !== 'undefined') {
        window.serverCartCount = count;
    }

    animateCart();
}

function animateCart() {
    const icon = document.querySelector('a[href="cart.php"]');
    if (icon) {
        icon.style.transform = 'scale(1.3)';
        setTimeout(() => icon.style.transform = 'scale(1)', 200);
    }
}

function showMessage(msg) {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.textContent = msg;
        toast.style.display = 'block';
        toast.style.opacity = '1';
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.style.display = 'none', 300);
        }, 2500);
    } else {
        const div = document.createElement('div');
        div.style.cssText = 'position:fixed; top:20px; right:20px; background:#c14e8f; color:white; padding:15px 20px; border-radius:10px; z-index:9999; box-shadow:0 4px 15px rgba(0,0,0,0.2);';
        div.textContent = msg;
        document.body.appendChild(div);
        setTimeout(() => div.remove(), 3000);
    }
}

function setupAddButtons() {
     // Handle buttons with explicit class or data attribute
     const buttons = document.querySelectorAll('.add-to-cart-btn, [data-add-cart], [data-detail-cart]');
     buttons.forEach(btn => {
         if (btn.dataset.cartBound === 'true') return;
         btn.dataset.cartBound = 'true';
         btn.addEventListener('click', function(e) {
             e.preventDefault();
             addToCart(this);
         });
     });
     
     // Also handle .cart__btn on product listing pages, excluding wishlist page add-to-cart buttons
     const cartButtons = document.querySelectorAll('.product__item .cart__btn:not(.add-to-cart)');
     cartButtons.forEach(btn => {
         if (btn.dataset.cartBound === 'true') return;
         btn.dataset.cartBound = 'true';
         btn.addEventListener('click', async function(e) {
             e.preventDefault();
             e.stopPropagation();
             await addToCart(this);
         });
     });
 }

document.addEventListener('click', async function(e) {
    // PREVENT cart actions on wishlist elements
    if (e.target.closest('#wishlist-items, #wishlist-actions, .wishlist-clear-btn, .add-to-cart')) {
        return;
    }

    // PREVENT cart actions on heart icon or wishlist buttons
    if (e.target.closest('i.fi-rs-heart, [aria-label="Add to Wishlist"], .wishlist__btn')) {
        return;
    }

    // Handle Clear Cart Button specifically - ensures cart and wishlist remain separate systems
    const clearCartBtn = e.target.closest('.cart-clear-btn, #clear-cart-btn');
    if (clearCartBtn) {
        e.preventDefault();
        e.stopImmediatePropagation();
        await clearCart();
        return;
    }

    const cartTrigger = e.target.closest('.cart__btn, [data-add-cart], [data-detail-cart]');
    if (!cartTrigger) return;

    if (cartTrigger.closest('#wishlist-items')) {
        return;
    }

    if (cartTrigger.dataset.cartBound === 'true' && !cartTrigger.closest('.details__action')) {
        return;
    }

    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    await addToCart(cartTrigger);
});

window.LioraCart = {
    add: addToCart,
    remove: removeFromCart,
    clear: clearCart,
    updateBadge: updateBadge,
    getCount: () => cart.reduce((s, i) => s + i.quantity, 0),
    getItems: () => [...cart]
};
