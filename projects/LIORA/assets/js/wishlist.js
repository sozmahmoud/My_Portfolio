// ===============================
// WISHLIST CONFIGURATION
// ===============================
const WISHLIST_CONFIG = {
    API_URL: 'wishlist_action.php',
    STORAGE_KEY: 'liora_wishlist'
};

let wishlist = [];
const WISHLIST_FALLBACK_IMAGE = 'assets/img/first_page.jpg';
const PRODUCT_LINK_SELECTOR = 'a.product__images, a[href*="details.php?id="], a[href*="giftdetail.php?id="]';

const WISHLIST_STATIC_PRODUCTS = {
    62: { id: 62, title: 'Birthday Bouquet', category: 'Special Occasions', price: '$20', image: 'assets/img/items/roses/rose_1.jpg', link: 'details.php?id=rose-blue-sapphire' },
    63: { id: 63, title: 'Birthday Special', category: 'Special Occasions', price: '$20', image: 'assets/img/items/roses/rose_6.jpg', link: 'details.php?id=rose-peach-paradise' },
    64: { id: 64, title: 'Happy Birthday Mix', category: 'Special Occasions', price: '$19', image: 'assets/img/items/tulips/tulip_3.jpg', link: 'details.php?id=tulip-pure-white' },
    65: { id: 65, title: 'Birthday Joy', category: 'Special Occasions', price: '$19', image: 'assets/img/items/tulips/tulip_5.jpg', link: 'details.php?id=tulip-lavender' },
    66: { id: 66, title: 'Celebration Bundle', category: 'Special Occasions', price: '$28', image: 'assets/img/items/orchids/orchid_5.jpg', link: 'details.php?id=orchid-pink-champagne' },
    67: { id: 67, title: 'Grand Birthday', category: 'Special Occasions', price: '$30', image: 'assets/img/items/orchids/orchid_6.jpg', link: 'details.php?id=orchid-sunset-coral' },
    68: { id: 68, title: 'Birthday Elegance', category: 'Special Occasions', price: '$25', image: 'assets/img/items/lilys/lily_2.jpg', link: 'details.php?id=lily-sunset-orange' },
    69: { id: 69, title: 'Birthday Bliss', category: 'Special Occasions', price: '$27', image: 'assets/img/items/lilys/lily_9.jpg', link: 'details.php?id=lily-ocean-blue' },
    70: { id: 70, title: 'Birthday Premium', category: 'Special Occasions', price: '$25', image: 'assets/img/items/mixed/mixed_9.jpg', link: 'details.php?id=mixed-blush-blossom' },
    71: { id: 71, title: 'Birthday Star', category: 'Special Occasions', price: '$26', image: 'assets/img/items/daisies/prettybluedaisy.jpg', link: 'details.php?id=daisy-blue-magic' },
    72: { id: 72, title: 'Birthday Magic', category: 'Special Occasions', price: '$19', image: 'assets/img/items/daffodils/gorgousdaffoldils.jpg', link: 'details.php?id=daffodil-golden' },
    73: { id: 73, title: 'Birthday Perfection', category: 'Special Occasions', price: '$17', image: 'assets/img/items/buttercup/orangebuttercup.jpg', link: 'details.php?id=buttercup-sunset' },
    101: { id: 101, title: 'Cute Bear Gift Set', category: 'Gifts', price: '$25', image: 'assets/img/items/other/c6.jpg', link: 'giftdetail.php?id=gift-bear' },
    102: { id: 102, title: 'Mini Succulent Tray', category: 'Home', price: '$27', image: 'assets/img/items/other/c10.jpg', link: 'giftdetail.php?id=gift-succulent' },
    103: { id: 103, title: 'Mini Garden Gift', category: 'Gifts', price: '$28', image: 'assets/img/items/other/Mini Garden Gift.jpg', link: 'giftdetail.php?id=gift-garden' },
    104: { id: 104, title: 'Romantic Gift Box', category: 'Gift Box', price: '$28', image: 'assets/img/items/other/s2.jpg', link: 'giftdetail.php?id=gift-romantic-box' },
    105: { id: 105, title: 'Tea Time Basket', category: 'Gifts', price: '$30', image: 'assets/img/items/other/s3.jpg', link: 'giftdetail.php?id=gift-tea-basket' },
    106: { id: 106, title: 'Jewelry Gift Box', category: 'Jewelry', price: '$36', image: 'assets/img/items/other/s4.jpg', link: 'giftdetail.php?id=gift-jewelry' },
    107: { id: 107, title: 'Mug Gift Set', category: 'Gifts', price: '$42', image: 'assets/img/items/other/s7.jpg', link: 'giftdetail.php?id=gift-mug' }
};

const NUMERIC_TO_STATIC_ID = {
    2: 'rose-rainbow-romance', 4: 'rose-ruby-red', 6: 'rose-blush-pink',
    1: 'rose-blue-sapphire', 87: 'rose-rainbow-romance', 3: 'rose-golden-sunshine', 75: 'rose-ruby-red',
    5: 'rose-peach-paradise', 79: 'rose-blush-pink', 7: 'rose-pure-white', 8: 'rose-soft-pink',
    9: 'tulip-rainbow', 10: 'tulip-red-white', 11: 'tulip-pure-white', 12: 'tulip-lavender',
    13: 'tulip-ruby-red', 89: 'tulip-ruby-red', 14: 'tulip-blush-pink',
    15: 'lily-sunset-orange', 16: 'lily-pink-galaxy', 88: 'lily-pink-galaxy', 17: 'lily-blush-pink', 18: 'lily-white-heaven',
    19: 'lily-ocean-blue', 20: 'lily-pastel-dream',
    27: 'sunflower-classic', 100: 'sunflower-classic', 28: 'sunflower-sunny-basket', 29: 'sunflower-golden-vase',
    30: 'sunflower-giant-heart', 31: 'sunflower-elegant',
    45: 'daisy-golden', 46: 'daisy-pure-white', 47: 'daisy-soft-charm', 48: 'daisy-blue-magic',
    49: 'daisy-rosy-garden', 96: 'daisy-rosy-garden', 50: 'daisy-simple-white',
    21: 'orchid-purple-majesty', 22: 'orchid-pink-champagne', 23: 'orchid-sunset-coral',
    24: 'orchid-pink-cascade', 25: 'orchid-golden-sunrise', 26: 'orchid-ocean-breeze',
    51: 'minirose-crimson', 52: 'minirose-pinky-baby', 53: 'minirose-pretty-pink', 90: 'minirose-pretty-pink',
    54: 'minirose-ocean-peach', 55: 'minirose-golden-sunset', 56: 'minirose-fairy-white',
    40: 'buttercup-golden', 41: 'buttercup-cream', 42: 'buttercup-modern',
    43: 'buttercup-sunset', 44: 'buttercup-rosy',
    57: 'daffodil-baby', 58: 'daffodil-classic', 59: 'daffodil-golden', 98: 'daffodil-golden',
    60: 'daffodil-lavender', 61: 'daffodil-lightyellow',
    32: 'mixed-pink-garden', 33: 'mixed-sweet-blossom', 34: 'mixed-white-daisy',
    35: 'mixed-soft-pastel', 36: 'mixed-lavender-whisper', 37: 'mixed-spring-morning',
    38: 'mixed-blush-blossom', 94: 'mixed-blush-blossom', 39: 'mixed-white-elegance',
    108: 'vip-1', 109: 'vip-2', 110: 'vip-3', 111: 'vip-4', 112: 'vip-5', 113: 'vip-6', 114: 'vip-7',
    74: 'bear_1', 77: 'bear_2', 78: 'bear_3', 80: 'bear_6', 81: 'bear_7',
    82: 'chocolate_1', 83: 'chocolate_2', 84: 'chocolate_3', 76: 'chocolate_4', 85: 'chocolate_5',
    101: 'gift-bear', 102: 'gift-succulent', 103: 'gift-garden', 104: 'gift-romantic-box',
    105: 'gift-tea-basket', 106: 'gift-jewelry', 107: 'gift-mug'
};

function getStaticProductForWishlist(id) {
    const numericId = Number(id);
    if (WISHLIST_STATIC_PRODUCTS[numericId]) {
        return WISHLIST_STATIC_PRODUCTS[numericId];
    }

    const staticId = NUMERIC_TO_STATIC_ID[numericId] || String(id);
    if (typeof masterCatalog !== 'undefined') {
        const product = masterCatalog.find(entry => String(entry.id) === String(staticId));
        if (product) {
            return product;
        }
    }

    return null;
}

function isNumericProductId(value) {
    return /^\d+$/.test(String(value || '').trim());
}

function getProductLink(scope) {
    if (!scope) return null;

    if (scope.matches?.(PRODUCT_LINK_SELECTOR)) {
        return scope;
    }

    return scope.querySelector?.(PRODUCT_LINK_SELECTOR) || null;
}

function getProductLinkSlug(scope) {
    const link = getProductLink(scope);
    if (!link) return null;

    try {
        const url = new URL(link.href || link.getAttribute('href'), window.location.origin);
        return url.searchParams.get('id');
    } catch (error) {
        return null;
    }
}

function getProductLinkHref(scope) {
    const link = getProductLink(scope);
    if (!link) return null;

    return link.getAttribute('href') || link.href || null;
}

function getCurrentPageProductLink() {
    const slug = getCurrentPageProductId();
    if (!slug) return null;

    const pageName = window.location.pathname.includes('giftdetail.php') ? 'giftdetail.php' : 'details.php';
    return `${pageName}?id=${slug}`;
}

function getProductIdFromCard(card) {
    if (!card) return null;

    if (card.dataset.wishlistId) {
        return card.dataset.wishlistId;
    }
    if (card.dataset.productId) {
        return card.dataset.productId;
    }
    if (card.dataset.id) {
        return card.dataset.id;
    }

    return getProductLinkSlug(card);
}

function getCurrentPageProductId() {
    const query = new URLSearchParams(window.location.search);
    return query.get('id');
}

function getProductSnapshot(card, productId) {
    const staticProduct = getStaticProductForWishlist(productId);
    const productLink = getProductLinkHref(card) || getCurrentPageProductLink();
    const title = card?.querySelector('.product__title')?.textContent?.trim()
        || document.getElementById('detail-title')?.textContent?.trim()
        || staticProduct?.title
        || staticProduct?.name
        || 'Product';
    const priceText = card?.querySelector('.new__price')?.textContent?.trim()
        || document.getElementById('detail-price')?.textContent?.trim()
        || staticProduct?.price
        || '';
    const image = card?.querySelector('.product__img.default')?.getAttribute('src')
        || card?.querySelector('img')?.getAttribute('src')
        || document.getElementById('detail-img-main')?.getAttribute('src')
        || staticProduct?.image
        || WISHLIST_FALLBACK_IMAGE;
    const category = card?.querySelector('.product__category')?.textContent?.trim()
        || document.getElementById('detail-kurdish-title')?.textContent?.trim()
        || staticProduct?.category
        || 'Gifts';

    return {
        id: productId,
        product_id: productId,
        title,
        name: title,
        price: priceText,
        image,
        category,
        link: productLink || staticProduct?.link || `details.php?id=${productId}`
    };
}

function findProductScope(element) {
    const current = element?.closest?.('.product__item, [data-product-id], [data-wishlist-id]');
    if (current) {
        return current;
    }

    return null;
}

function shouldAddWishlistButton(card) {
    if (!card || card.closest('#wishlist-items, #cart-items-container, .cart-items-section')) {
        return false;
    }

    if (card.querySelector('.fi-rs-heart, [aria-label="Add to Wishlist"], .wishlist__btn')) {
        return false;
    }

    return Boolean(getProductLink(card));
}

function ensureWishlistButton(card) {
    if (!shouldAddWishlistButton(card)) {
        return;
    }

    const banner = card.querySelector('.product__banner');
    if (!banner) {
        return;
    }

    let actions = banner.querySelector('.product__actions');
    if (!actions) {
        actions = document.createElement('div');
        actions.className = 'product__actions';
        banner.appendChild(actions);
    }

    const button = document.createElement('a');
    button.href = 'javascript:void(0)';
    button.className = 'action__btn wishlist__btn';
    button.setAttribute('aria-label', 'Add to Wishlist');
    button.innerHTML = '<i class="fi fi-rs-heart"></i>';
    actions.insertBefore(button, actions.firstChild);
}

function ensureWishlistButtons(root = document) {
    if (!root) return;

    if (root.matches?.('.product__item')) {
        ensureWishlistButton(root);
    }

    root.querySelectorAll?.('.product__item').forEach(card => {
        ensureWishlistButton(card);
    });
}

function findProductById(productId) {
    if (!productId || typeof masterCatalog === 'undefined') {
        return null;
    }
    return masterCatalog.find(item => String(item.id) === String(productId)) || null;
}

function getSlugFromCard(card) {
    return getProductLinkSlug(card);
}

async function mapProductSlugToId(slug) {
    if (!slug) return null;
    if (isNumericProductId(slug)) {
        return Number(slug);
    }

    try {
        const response = await fetch(`map_product_id.php?id=${encodeURIComponent(slug)}`, { credentials: 'same-origin' });
        if (!response.ok) return null;
        const data = await response.json();
        return data.success && data.id ? Number(data.id) : null;
    } catch (error) {
        console.warn('Wishlist product slug mapping failed:', error);
        return null;
    }
}

async function resolveProductId(productId, card = null) {
    const rawProductId = productId || getProductIdFromCard(card);
    if (isNumericProductId(rawProductId)) {
        return Number(rawProductId);
    }

    const slug = rawProductId || getSlugFromCard(card) || getCurrentPageProductId();
    if (!slug) return null;

    const numericId = await mapProductSlugToId(slug);
    if (numericId && card && !card.dataset.productId) {
        card.dataset.wishlistId = String(numericId);
    }

    return numericId;
}

async function ensureCardWishlistId(card) {
    if (!card || card.dataset.wishlistId || isNumericProductId(card.dataset.productId)) {
        return;
    }

    const numericId = await resolveProductId(getProductIdFromCard(card), card);
    if (numericId) {
        card.dataset.wishlistId = String(numericId);
    }
}

function hydrateWishlistProductIds(root = document) {
    root.querySelectorAll?.('.product__item').forEach(card => {
        ensureCardWishlistId(card);
    });
}

function observeWishlistProductCards() {
    if (!window.MutationObserver || !document.body) return;

    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            mutation.addedNodes.forEach(node => {
                if (!(node instanceof Element)) return;
                if (node.matches?.('.product__item')) {
                    ensureWishlistButton(node);
                    ensureCardWishlistId(node);
                }
                ensureWishlistButtons(node);
                hydrateWishlistProductIds(node);
            });
        });
    });

    observer.observe(document.body, { childList: true, subtree: true });
}

function normalizeWishlistItems(items) {
    if (!Array.isArray(items)) {
        return [];
    }

    return items.map(item => {
        // If already full product object, return as-is
        if (item && typeof item === 'object' && ('product_id' in item || 'id' in item) && ('title' in item || 'name' in item)) {
            const id = item.product_id || item.id;
            const staticProduct = getStaticProductForWishlist(id);
            const source = staticProduct || item;
            const price = typeof source.price === 'number' ? `$${source.price.toFixed(2)}` : source.price;
            return {
                ...item,
                id,
                product_id: id,
                title: source.title || source.name || item.title || item.name || 'Product',
                image: source.image || item.image || WISHLIST_FALLBACK_IMAGE,
                category: source.category || item.category || 'Flowers',
                price: price || '',
                link: source.link || `details.php?id=${id}`
            };
        }

        // If it's just a product ID (number or string), map to full product data
        const id = String(item);
        const staticProduct = getStaticProductForWishlist(id);
        if (staticProduct) {
            return {
                id,
                product_id: id,
                title: staticProduct.title || staticProduct.name || id,
                price: staticProduct.price || '',
                image: staticProduct.image || WISHLIST_FALLBACK_IMAGE,
                category: staticProduct.category || 'Flowers',
                link: staticProduct.link || `details.php?id=${id}`
            };
        }
        
        // Try to find in masterCatalog
        const catalog = typeof masterCatalog !== 'undefined' ? masterCatalog : null;
        let product = null;
        
        if (catalog) {
            // Try exact ID match first
            product = catalog.find(entry => String(entry.id) === id);
            // Also try matching without prefix (e.g., "rose-blue-sapphire" vs "rose-blue-sapphire")
            if (!product) {
                product = catalog.find(entry => entry.id === id);
            }
        }
        
        if (product) {
            return {
                id: product.id,
                product_id: product.id,
                title: product.title || product.name || id,
                price: product.price || '',
                image: product.image || WISHLIST_FALLBACK_IMAGE,
                category: product.category || 'Flowers',
                link: product.link || `details.php?id=${product.id}`
            };
        }

        // Fallback: try to fetch from backend or use default
        return {
            id,
            title: id,
            price: '',
            image: WISHLIST_FALLBACK_IMAGE,
            category: 'Product',
            link: `details.php?id=${id}`
        };
    });
}

async function ensureCatalogLoaded() {
    if (typeof masterCatalog !== 'undefined') {
        return;
    }

    return new Promise(resolve => {
        window.addEventListener('load', () => {
            resolve();
        });
        setTimeout(resolve, 3000);
    });
}

async function wishlistApiFetch(formData) {
    try {
        const response = await fetch(WISHLIST_CONFIG.API_URL, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json'
            },
            body: formData
        });

        const responseText = await response.text();
        if (!response.ok) {
            console.warn('Wishlist API HTTP error:', response.status, responseText);
            return null;
        }

        if (!responseText) {
            console.warn('Wishlist API returned empty response.');
            return null;
        }

        try {
            return JSON.parse(responseText);
        } catch (error) {
            console.warn('Wishlist API parse error:', error, responseText);
            return null;
        }
    } catch (error) {
        console.warn('Wishlist API error:', error);
        return null;
    }
}

async function loadWishlist() {
    const formData = new FormData();
    formData.append('action', 'get');

    const data = await wishlistApiFetch(formData);
    if (data && data.success) {
        wishlist = normalizeWishlistItems(data.items || []);
    } else {
        const stored = localStorage.getItem(WISHLIST_CONFIG.STORAGE_KEY);
        wishlist = stored ? normalizeWishlistItems(JSON.parse(stored)) : [];
    }
}

function renderWishlist() {
    const container = document.getElementById('wishlist-items');
    const emptyBox = document.getElementById('wishlist-empty');
    const actions = document.getElementById('wishlist-actions');

    if (!container) return;

    container.innerHTML = '';

    if (wishlist.length === 0) {
        if (emptyBox) emptyBox.style.display = 'block';
        if (actions) actions.style.display = 'none';
        return;
    }

    if (emptyBox) emptyBox.style.display = 'none';
    if (actions) actions.style.display = 'flex';

    wishlist.forEach(item => {
        const image = item.image || item.image_url || WISHLIST_FALLBACK_IMAGE;
        container.innerHTML += `
            <div class="product__item" data-product-id="${item.id}">
                <div class="product__banner">
                    <a href="${item.link || `details.php?id=${item.id}`}" class="product__images">
                        <img src="${image}" class="product__img default" alt="${item.title}">
                        <img src="${image}" class="product__img hover" alt="${item.title}">
                    </a>
                    <div class="product__actions">
                        <a href="javascript:void(0)" class="remove__btn wishlist-remove-btn" data-product-id="${item.id}" aria-label="Remove from Wishlist">
                            <i class="fi fi-rs-trash"></i>
                        </a>
                    </div>
                </div>
                <div class="product__content">
                    <span class="product__category">${item.category || 'Flowers'}</span>
                    <h3 class="product__title">${item.title}</h3>
                    <div class="product__price flex">
                        <span class="new__price">${item.price || ''}</span>
                    </div>
                    <button type="button" class="action__btn cart__btn add-to-cart" data-product-id="${item.id}" aria-label="Add to cart">
                        <i class="fi fi-rs-shopping-bag-add"></i>
                    </button>
                </div>
            </div>
        `;
    });
}

function updateWishlistCountDisplay(totalItems = wishlist.length) {
    const wishlistCount = document.getElementById('wishlist-count');
    if (wishlistCount) {
        wishlistCount.textContent = totalItems;
        wishlistCount.style.display = totalItems > 0 ? 'inline-flex' : 'none';
    }
}

function syncLocalWishlist(items) {
    localStorage.setItem(WISHLIST_CONFIG.STORAGE_KEY, JSON.stringify(items));
}

function appendWishlistSnapshot(formData, item) {
    if (!item) return;
    formData.append('name', item.name || item.title || 'Product');
    formData.append('price', parseFloat(String(item.price || 0).replace(/[^0-9.]/g, '')) || 0);
    formData.append('image', item.image || item.image_url || '');
    formData.append('category', item.category || 'Flowers');
    formData.append('link', item.link || '');
}

function getProductSlugFromHref(href) {
    if (!href) return null;
    try {
        const url = new URL(href, window.location.origin);
        return url.searchParams.get('id');
    } catch (error) {
        return null;
    }
}

function idsMatch(candidate, rawProductId, numericProductId) {
    if (candidate === null || typeof candidate === 'undefined') {
        return false;
    }

    const candidateText = String(candidate);
    const rawText = rawProductId === null || typeof rawProductId === 'undefined' ? '' : String(rawProductId);
    if (rawText && candidateText === rawText) {
        return true;
    }

    return isNumericProductId(candidateText)
        && Number(candidateText) === Number(numericProductId);
}

function findWishlistItemForCart(rawProductId, numericProductId, card) {
    return wishlist.find(item => {
        const itemSlug = getProductSlugFromHref(item.link);
        const candidates = [
            item.product_id,
            item.id,
            itemSlug
        ];

        return candidates.some(candidate => idsMatch(candidate, rawProductId, numericProductId));
    }) || null;
}

function getWishlistTransferSnapshot(card, rawProductId, numericProductId) {
    const wishlistItem = findWishlistItemForCart(rawProductId, numericProductId, card);
    const cardSnapshot = getProductSnapshot(card, numericProductId);
    const source = wishlistItem || cardSnapshot;

    return {
        ...source,
        id: numericProductId,
        product_id: numericProductId,
        name: source.name || source.title || cardSnapshot.name || 'Product',
        title: source.title || source.name || cardSnapshot.title || 'Product',
        price: source.price || cardSnapshot.price || 0,
        image: source.image || source.image_url || cardSnapshot.image || WISHLIST_FALLBACK_IMAGE,
        image_url: source.image_url || source.image || cardSnapshot.image || WISHLIST_FALLBACK_IMAGE,
        category: source.category || cardSnapshot.category || 'Flowers',
        link: source.link || cardSnapshot.link || `details.php?id=${numericProductId}`
    };
}

async function updateWishlist(action, productId, snapshot = null) {
    const numericId = Number(productId);
    if (!numericId || Number.isNaN(numericId) || numericId <= 0) {
        showWishlistMessage('Product not identified.');
        return null;
    }

    const formData = new FormData();
    formData.append('action', action);
    formData.append('product_id', numericId);
    appendWishlistSnapshot(formData, snapshot);

    const data = await wishlistApiFetch(formData);
    if (!data || !data.success) {
        showWishlistMessage((data && data.message) ? data.message : 'Unable to update wishlist.');
        return null;
    }

    wishlist = normalizeWishlistItems(data.items || []);
    syncLocalWishlist(wishlist);
    if (document.getElementById('wishlist-items')) {
        renderWishlist();
    }
    updateWishlistCountDisplay(data.total_items ?? wishlist.length);
    if (typeof refreshServerWishlistCount === 'function') {
        refreshServerWishlistCount();
    }
    return data;
}

function saveLocalWishlistItem(action, item) {
    const stored = localStorage.getItem(WISHLIST_CONFIG.STORAGE_KEY);
    let localItems = stored ? normalizeWishlistItems(JSON.parse(stored)) : [];
    const id = String(item.product_id || item.id);

    if (action === 'remove') {
        localItems = localItems.filter(entry => String(entry.product_id || entry.id) !== id);
    } else {
        const existingIndex = localItems.findIndex(entry => String(entry.product_id || entry.id) === id);
        if (existingIndex >= 0) {
            localItems.splice(existingIndex, 1);
        } else {
            localItems.push(item);
        }
    }

    localStorage.setItem(WISHLIST_CONFIG.STORAGE_KEY, JSON.stringify(localItems));
    wishlist = localItems;
}

async function clearWishlist() {
    if (wishlist.length === 0) {
        return;
    }

    const previousWishlist = [...wishlist];
    wishlist = [];
    syncLocalWishlist(wishlist);
    renderWishlist();
    updateWishlistCountDisplay(0);

    const formData = new FormData();
    formData.append('action', 'clear');

    const data = await wishlistApiFetch(formData);
    if (data && data.success) {
        wishlist = [];
        syncLocalWishlist(wishlist);
        renderWishlist();
        updateWishlistCountDisplay(data.total_items ?? 0);
        if (typeof refreshServerWishlistCount === 'function') {
            refreshServerWishlistCount();
        }
        showWishlistMessage('Wishlist cleared.');
        return;
    }

    wishlist = previousWishlist;
    syncLocalWishlist(wishlist);
    renderWishlist();
    updateWishlistCountDisplay(wishlist.length);
    showWishlistMessage((data && data.message) ? data.message : 'Unable to clear wishlist.');
}

async function toggleWishlist(productId) {
    const data = await updateWishlist('toggle', productId);
    if (!data) return;
    const message = data.action === 'added' ? 'Added to wishlist! ❤️' : 'Removed from wishlist';
    showWishlistMessage(message);
}

function showWishlistMessage(message) {
    // If global showToast from main.js or showMessage from cart.js exists, use them for consistency
    if (typeof showToast === 'function') {
        showToast(message);
        return;
    }
    if (typeof showMessage === 'function') {
        showMessage(message);
        return;
    }

    const toast = document.getElementById('toast');
    if (toast) {
        toast.textContent = message;
        toast.style.display = 'block';
        toast.style.opacity = '1';
        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.style.display = 'none', 300);
        }, 2500);
    } else {
        // Create a small cute floating toast if no other system is found
        const div = document.createElement('div');
        div.style.cssText = 'position:fixed; bottom:25px; right:25px; background:#c14e8f; color:white; padding:12px 22px; border-radius:12px; z-index:9999; box-shadow:0 10px 25px rgba(193,78,143,0.3); font-weight:500; display:flex; align-items:center; gap:8px; transition: all 0.4s ease;';
        div.innerHTML = `❤️ ${message}`;
        document.body.appendChild(div);
        
        setTimeout(() => {
            div.style.opacity = '0';
            div.style.transform = 'translateY(20px)';
            setTimeout(() => div.remove(), 400);
        }, 2500);
    }
}

window.addEventListener('load', async () => {
    await ensureCatalogLoaded();
    ensureWishlistButtons();
    hydrateWishlistProductIds();
    observeWishlistProductCards();
    await loadWishlist();
    if (document.getElementById('wishlist-items')) {
        renderWishlist();
    }
});

document.addEventListener('click', async function (e) {
    const wishlistTrigger = e.target.closest('i.fi-rs-heart, [aria-label="Add to Wishlist"], .details__action-btn');
    if (wishlistTrigger) {
        const actionElement = wishlistTrigger.matches('i.fi-rs-heart') ? wishlistTrigger.closest('a, button') : wishlistTrigger;
        if (actionElement && actionElement.classList.contains('cart__btn')) {
            return;
        }
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        const isDetailPageWishlist = Boolean(
            actionElement?.closest?.('.details__action') &&
            !actionElement.closest('.product__item')
        );
        const card = isDetailPageWishlist ? null : findProductScope(wishlistTrigger);
        const rawProductId = isDetailPageWishlist
            ? getCurrentPageProductId()
            : (getProductIdFromCard(card || wishlistTrigger) || getCurrentPageProductId());
        const productId = await resolveProductId(rawProductId, card);
        if (!productId) {
            showWishlistMessage('Unable to identify product.');
            return;
        }
        const snapshot = getProductSnapshot(card, productId);
        const data = await updateWishlist('toggle', productId, snapshot);
        if (data) {
            const message = data.action === 'added' ? (snapshot.title + ' added to wishlist! ❤️') : 'Removed from wishlist';
            showWishlistMessage(message);
            return;
        }

        saveLocalWishlistItem('toggle', snapshot);
        showWishlistMessage(snapshot.title + ' added to wishlist! ❤️');
        return;
    }

    const removeBtn = e.target.closest('.remove__btn, .remove-item, .wishlist-remove-btn');
    if (removeBtn) {
        e.preventDefault();
        const productId = removeBtn.dataset.productId;
        if (!productId) {
            showWishlistMessage('Unable to identify product.');
            return;
        }
        await updateWishlist('remove', productId);
        return;
    }

    const clearBtn = e.target.closest('#clear-wishlist-btn, .wishlist-clear-btn');
    if (clearBtn) {
        e.preventDefault();
        e.stopImmediatePropagation();
        await clearWishlist();
        return;
    }

    const addToCartBtn = e.target.closest('.add-to-cart');
    if (addToCartBtn) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const card = addToCartBtn.closest('.product__item');
        const rawProductId = addToCartBtn.dataset.productId || getProductIdFromCard(card);
        if (!rawProductId) {
            showWishlistMessage('Unable to identify product.');
            return;
        }

        const productId = await resolveProductId(rawProductId, card);
        if (!productId) {
            showWishlistMessage('Unable to identify product.');
            return;
        }
        const transferSnapshot = getWishlistTransferSnapshot(card, rawProductId, productId);

        const cartFormData = new FormData();
        cartFormData.append('action', 'add');
        cartFormData.append('product_id', productId);
        cartFormData.append('quantity', 1);
        appendWishlistSnapshot(cartFormData, transferSnapshot);

        try {
            const response = await fetch('cart_action.php', {
                method: 'POST',
                credentials: 'same-origin',
                body: cartFormData,
                headers: {
                    'Accept': 'application/json'
                }
            });

            let cartData = null;
            try {
                cartData = await response.json();
            } catch (parseError) {
                console.error('Cart response parse failed:', parseError);
                showWishlistMessage('Unable to add to cart.');
                return;
            }

            if (!response.ok || !cartData) {
                const message = cartData && cartData.message ? cartData.message : 'Unable to add to cart.';
                showWishlistMessage(message);
                return;
            }

            if (cartData.success) {
                if (window.LioraCart && typeof window.LioraCart.updateBadge === 'function') {
                    window.LioraCart.updateBadge(cartData.total_items);
                } else if (typeof refreshServerCartCount === 'function') {
                    refreshServerCartCount();
                }

                showWishlistMessage('Added to cart!');
                return;
            }

            showWishlistMessage(cartData.message || 'Unable to add to cart.');
        } catch (error) {
            console.error('Cart request failed:', error);
            showWishlistMessage('Unable to add to cart.');
        }
        return;
    }
});
