const API_CART_URL = 'cart_action.php';
const API_CHECKOUT_URL = 'checkout_action.php';
const COUPON_STORAGE_KEY = 'liora_coupon';
const CHECKOUT_FREE_SHIPPING = 75;
const CHECKOUT_SHIPPING_COST = 10;
const CHECKOUT_VOLUME_DISCOUNT_MIN = 50;
const CHECKOUT_VOLUME_DISCOUNT_RATE = 0.10;

function canPayFullWithPoints(points) {
    return points >= 250;
}

function canPayHalfWithPoints(points) {
    return points >= 100;
}

// --- Credit Card Validation Logic ---

/**
 * Validates card number using Luhn Algorithm
 */
function validateLuhn(number) {
    let sum = 0;
    let shouldDouble = false;
    // Remove spaces or dashes
    number = number.replace(/\D/g, '');
    
    for (let i = number.length - 1; i >= 0; i--) {
        let digit = parseInt(number.charAt(i));

        if (shouldDouble) {
            if ((digit *= 2) > 9) digit -= 9;
        }

        sum += digit;
        shouldDouble = !shouldDouble;
    }
    return (sum % 10) === 0 && number.length >= 13;
}

function validateFixedCardNumber(number, digitCount = 16) {
    const digits = number.replace(/\D/g, '');
    return digits.length === digitCount;
}

/**
 * Validates expiry date (MM/YY)
 */
function validateExpiry(expiry) {
    // Native input type="month" format: YYYY-MM
    if (!/^\d{4}-\d{2}$/.test(expiry)) return false;
    
    const parts = expiry.split('-');
    const year = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10);
    
    if (month < 1 || month > 12) return false;
    
    const now = new Date();
    const currentYear = now.getFullYear();
    const currentMonth = now.getMonth() + 1;

    if (year < currentYear) return false;
    if (year === currentYear && month < currentMonth) return false;
    
    return true;
}

/**
 * Formats card number with spaces
 */
function formatCardNumber(value, maxDigits = 16) {
    const match = value.replace(/\D/g, '').slice(0, maxDigits);
    const parts = [];

    for (let i = 0, len = match.length; i < len; i += 4) {
        parts.push(match.substring(i, i + 4));
    }

    return parts.join(' ');
}

function syncCardNumberInput(form = document) {
    const cardNumberInput = form.querySelector('[data-card-number-input]');
    const cardNumberValue = form.querySelector('[data-card-number-value]');
    const cardNumber = cardNumberInput ? cardNumberInput.value.replace(/\D/g, '').slice(0, 16) : '';
    if (cardNumberValue) {
        cardNumberValue.value = cardNumber;
    }
    return cardNumber;
}

/**
 * Formats expiry date with slash
 */
function formatExpiry(value) {
    return value.replace(/\D/g, '')
                .replace(/^(\d{2})(\d)/, '$1/$2')
                .substr(0, 5);
}

/**
 * Formats delivery time as HH:MM AM/PM.
 */
function formatDeliveryTime(value) {
    let digits = String(value || '').replace(/\D/g, '').slice(0, 4);
    let period = String(value || '').replace(/[^amp]/gi, '').slice(0, 2).toUpperCase();
    
    // Validate Hours (max 12)
    if (digits.length >= 2) {
        let hours = parseInt(digits.slice(0, 2), 10);
        if (hours > 12) hours = 12;
        if (hours === 0 && digits.length === 2) hours = 1; // 00 is not valid, use 01
        digits = String(hours).padStart(2, '0') + digits.slice(2);
    }
    
    // Validate Minutes (max 60)
    if (digits.length === 4) {
        let mins = parseInt(digits.slice(2, 4), 10);
        if (mins > 60) mins = 60;
        digits = digits.slice(0, 2) + String(mins).padStart(2, '0');
    }

    let formatted = digits;

    if (digits.length > 2) {
        formatted = `${digits.slice(0, 2)}:${digits.slice(2)}`;
    }

    if (period) {
        // Ensure period starts with A or P
        if (period.length === 1 && !['A', 'P'].includes(period)) {
            period = '';
        } else if (period.length === 2) {
            if (period.startsWith('A')) period = 'AM';
            else if (period.startsWith('P')) period = 'PM';
            else period = '';
        }
        
        if (period) {
            formatted += ` ${period}`;
        }
    }

    return formatted.slice(0, 8);
}

function isValidDeliveryTimeDisplay(value) {
    return /^(0[1-9]|1[0-2]):([0-5][0-9]|60) (AM|PM)$/i.test(String(value || '').trim());
}

async function fetchCart() {
    try {
        const response = await fetch(`${API_CART_URL}?action=get`, { credentials: 'same-origin' });
        if (!response.ok) {
            const body = await response.text();
            throw new Error('Unable to load cart: ' + response.status + ' ' + body);
        }
        const data = await response.json();
        return data && data.success ? data.items : [];
    } catch (error) {
        console.warn('Checkout cart load failed:', error);
        return [];
    }
}

async function getExistingPoints() {
    try {
        const response = await fetch(`${API_CHECKOUT_URL}?action=get_points`, { credentials: 'same-origin' });
        if (!response.ok) {
            throw new Error('Unable to get points');
        }
        const data = await response.json();
        if (data && data.success) {
            return {
                points: data.points || 0,
                tier: data.tier || {},
                rewards: data.rewards || []
            };
        }
        return { points: 0, tier: {}, rewards: [] };
    } catch (error) {
        console.warn('Get points failed:', error);
        return { points: 0, tier: {}, rewards: [] };
    }
}

function subtotalFrom(items) {
    return items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
}

function getCouponDiscountRate(code) {
    if (!code) return 0;
    const normalized = code.trim().toUpperCase();
    switch (normalized) {
        case 'LOVE10':
            return 0.10;
        case 'SPRING15':
            return 0.15;
        case 'SUMMER20':
            return 0.20;
        default:
            return 0;
    }
}

function getShippingCost(subtotal) {
    return subtotal >= CHECKOUT_FREE_SHIPPING ? 0 : CHECKOUT_SHIPPING_COST;
}

function getVolumeDiscount(subtotal) {
    return subtotal >= CHECKOUT_VOLUME_DISCOUNT_MIN ? subtotal * CHECKOUT_VOLUME_DISCOUNT_RATE : 0;
}

function getSelectedPaymentMethod() {
    return document.querySelector('input[name="payment_method"]:checked')?.value || 'Credit Card (Visa)';
}

function getRewardPointsInputValue() {
    const input = document.getElementById('checkout-redeem-points');
    if (!input || getSelectedPaymentMethod() !== 'Reward Points') {
        return 0;
    }

    const value = input.value.trim();
    return /^\d+$/.test(value) ? parseInt(value, 10) : 0;
}

function syncRewardPointsDetails() {
    const details = document.getElementById('reward-points-details');
    if (!details) return;
    details.style.display = getSelectedPaymentMethod() === 'Reward Points' ? 'block' : 'none';
}

function escapeCheckoutHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, character => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    }[character]));
}

async function renderCheckout() {
    const container = document.getElementById('checkout-items');
    const subtotalEl = document.getElementById('checkout-subtotal');
    const totalEl = document.getElementById('checkout-total');
    const rewardsEl = document.getElementById('checkout-rewards');
    const discountEl = document.getElementById('checkout-discount');
    const shippingEl = document.getElementById('checkout-shipping');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const availablePointsEl = document.getElementById('checkout-available-points');

    if (!container || !subtotalEl || !totalEl || !rewardsEl || !discountEl) return;

    const cartItems = await fetchCart();
    const pointsData = await getExistingPoints();
    const availablePoints = pointsData.points || 0;
    const couponCode = localStorage.getItem(COUPON_STORAGE_KEY) || '';
    const couponRate = getCouponDiscountRate(couponCode);

    container.innerHTML = '';

    if (cartItems.length === 0) {
        container.innerHTML = `
      <p class="checkout-empty">Your cart is empty. Please add items before checkout.</p>
    `;
        subtotalEl.textContent = '$0.00';
        rewardsEl.textContent = '-$0.00';
        discountEl.textContent = '-$0.00';
        if (shippingEl) shippingEl.textContent = '$0.00';
        totalEl.textContent = '$0.00';
        if (placeOrderBtn) placeOrderBtn.disabled = true;
        return;
    }

    let subtotal = 0;
    cartItems.forEach(item => {
        const itemTotal = item.price * item.quantity;
        const itemName = escapeCheckoutHtml(item.name);
        const itemImage = escapeCheckoutHtml(item.image || 'assets/img/items/roses/rose_1.jpg');
        subtotal += itemTotal;

        container.innerHTML += `
      <div class="order-item">
        <img src="${itemImage}" class="order-item__img" alt="${itemName}" />
        <div class="order-item__info">
          <h3 class="order-item__name">${itemName}</h3>
          <p class="order-item__qty">Qty ${item.quantity}</p>
        </div>
        <span class="order-item__price">$${itemTotal.toFixed(2)}</span>
      </div>
    `;
    });

    const couponDiscount = subtotal * couponRate;
    const volumeDiscount = getVolumeDiscount(subtotal);
    const shipping = getShippingCost(subtotal);

    // Update available points display
    if (availablePointsEl) {
        availablePointsEl.textContent = availablePoints;
    }

    // Payment method logic for Reward Points is now simpler

    const couponInput = document.getElementById('checkout-coupon-code');
    if (couponInput) {
        couponInput.value = couponCode;
    }

    // Totals will be updated by payment method selection

    // Initial totals calculation
    syncRewardPointsDetails();
    updateCheckoutTotals(subtotal, getRewardPointsInputValue(), couponDiscount + volumeDiscount, shipping, availablePoints);

    // Listen for payment method changes to update totals and visibility
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', () => {
            syncRewardPointsDetails();
            updateCheckoutTotals(subtotal, getRewardPointsInputValue(), couponDiscount + volumeDiscount, shipping, availablePoints);
            
            // Toggle details sections
            const cardDetails = document.getElementById('card-details');
            const paypalDetails = document.getElementById('paypal-details');
            
            if (cardDetails) cardDetails.style.display = (radio.value === 'Credit Card (Visa)') ? 'block' : 'none';
            if (paypalDetails) paypalDetails.style.display = (radio.value === 'PayPal') ? 'block' : 'none';
        });
    });

    const rewardInput = document.getElementById('checkout-redeem-points');
    if (rewardInput) {
        rewardInput.addEventListener('input', () => {
            const digitsOnly = rewardInput.value.replace(/\D/g, '');
            if (rewardInput.value !== digitsOnly) {
                rewardInput.value = digitsOnly;
            }

            const maxPoints = parseInt(rewardInput.max, 10) || availablePoints;
            const enteredPoints = parseInt(rewardInput.value, 10);
            if (enteredPoints > maxPoints) {
                rewardInput.value = String(maxPoints);
            }

            updateCheckoutTotals(subtotal, getRewardPointsInputValue(), couponDiscount + volumeDiscount, shipping, availablePoints);
        });
    }

    if (placeOrderBtn) placeOrderBtn.disabled = false;
}

function updateCheckoutTotals(subtotal, redeemPoints, cartDiscount = 0, shipping = 0, availablePoints = 0) {
    const subtotalEl = document.getElementById('checkout-subtotal');
    const totalEl = document.getElementById('checkout-total');
    const rewardsEl = document.getElementById('checkout-rewards');
    const shippingEl = document.getElementById('checkout-shipping');

    let rewardDiscount = 0;
    if (getSelectedPaymentMethod() === 'Reward Points' && availablePoints >= 100 && redeemPoints > 0 && redeemPoints <= availablePoints) {
        rewardDiscount = Math.min(redeemPoints * 0.05, Math.max(subtotal - cartDiscount, 0));
    }
    
    const total = Math.max(subtotal - rewardDiscount - cartDiscount + shipping, 0);

    if (subtotalEl) subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
    if (document.getElementById('checkout-discount')) document.getElementById('checkout-discount').textContent = `-$${cartDiscount.toFixed(2)}`;
    if (rewardsEl) rewardsEl.textContent = `-$${rewardDiscount.toFixed(2)}`;
    if (shippingEl) shippingEl.textContent = shipping <= 0 ? 'Free' : `$${shipping.toFixed(2)}`;
    if (totalEl) totalEl.textContent = `$${total.toFixed(2)}`;
}

// initializeRewardsUI removed as points redemption is now a payment method

function initializeTextareaLineLimits() {
    document.querySelectorAll('textarea[data-max-lines]').forEach(textarea => {
        const maxLines = parseInt(textarea.dataset.maxLines, 10);

        if (!maxLines) return;

        textarea.addEventListener('input', () => {
            const lines = textarea.value.split(/\r?\n/);

            if (lines.length > maxLines) {
                textarea.value = lines.slice(0, maxLines).join('\n');
            }
        });
    });
}

function getSavedDeliveryLocation() {
    try {
        return JSON.parse(localStorage.getItem('lioraDeliveryLocation') || 'null');
    } catch (error) {
        return null;
    }
}

function saveCheckoutDeliveryLocation(form) {
    if (!form) return;
    const addressInput = form.querySelector('[name="address"]');
    const cityInput = form.querySelector('[name="city"]');
    const dateInput = form.querySelector('[name="delivery_date"]');
    const timeInput = form.querySelector('[name="delivery_time"]');
    if (!addressInput || !addressInput.value.trim()) return;

    const location = {
        address: addressInput.value.trim(),
        city: cityInput ? cityInput.value.trim() : '',
        delivery_date: dateInput ? dateInput.value : '',
        delivery_time: timeInput ? timeInput.value : '',
        source: 'checkout',
        updatedAt: Date.now()
    };
    localStorage.setItem('lioraDeliveryLocation', JSON.stringify(location));
}

function applySavedDeliveryLocation() {
    const form = document.getElementById('checkout-form');
    if (!form) return;

    const saved = getSavedDeliveryLocation();
    if (!saved || !saved.address) return;

    const addressInput = form.querySelector('[name="address"]');
    const cityInput = form.querySelector('[name="city"]');

    if (addressInput && (addressInput.value.trim() === '' || saved.source === 'map')) {
        addressInput.value = saved.address;
        addressInput.dispatchEvent(new Event('input', { bubbles: true }));
    }

    if (cityInput && saved.city && (cityInput.value.trim() === '' || saved.source === 'map')) {
        cityInput.value = saved.city;
        cityInput.dispatchEvent(new Event('input', { bubbles: true }));
    }
}

function initializeDeliverySync() {
    const form = document.getElementById('checkout-form');
    if (!form) return;

    applySavedDeliveryLocation();

    ['address', 'city', 'delivery_date', 'delivery_time'].forEach(name => {
        const input = form.querySelector(`[name="${name}"]`);
        if (!input) return;
        input.addEventListener('input', () => saveCheckoutDeliveryLocation(form));
        input.addEventListener('change', () => saveCheckoutDeliveryLocation(form));
    });

    window.addEventListener('storage', event => {
        if (event.key === 'lioraDeliveryLocation') {
            applySavedDeliveryLocation();
        }
    });
}

function initializeDeliveryTimeMinimum() {
    const form = document.getElementById('checkout-form');
    if (!form) return;

    const dateInput = form.querySelector('[name="delivery_date"]');
    const timeInput = form.querySelector('[name="delivery_time"]');
    if (!dateInput || !timeInput) return;

    const pad = value => String(value).padStart(2, '0');
    const formatDate = date => `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`;
    const formatDisplayTime = date => {
        const hours24 = date.getHours();
        const minutes = pad(date.getMinutes());
        const period = hours24 >= 12 ? 'PM' : 'AM';
        const hours12 = hours24 % 12 || 12;
        return `${pad(hours12)}:${minutes} ${period}`;
    };

    const updateMinimumTime = () => {
        const oneHourLater = new Date();
        oneHourLater.setHours(oneHourLater.getHours() + 1);
        oneHourLater.setSeconds(0, 0); // Clear seconds and milliseconds to avoid validation mismatch

        const minimumDate = formatDate(oneHourLater);

        dateInput.min = minimumDate;
        if (!dateInput.value || dateInput.value < minimumDate) {
            dateInput.value = minimumDate;
        }

        if (!timeInput.value.trim()) {
            timeInput.value = formatDisplayTime(oneHourLater);
        }

        saveCheckoutDeliveryLocation(form);
    };

    updateMinimumTime();
    dateInput.addEventListener('change', updateMinimumTime);
}

function parseDeliveryTime(value) {
    const match = String(value || '').trim().match(/^(0[1-9]|1[0-2]):([0-5][0-9]|60) (am|pm)$/i);
    if (!match) return null;

    let hours = parseInt(match[1], 10);
    const minutes = parseInt(match[2], 10);
    const period = match[3].toLowerCase();

    if (hours < 1 || hours > 12 || minutes < 0 || minutes > 60) return null;
    if (period === 'pm' && hours !== 12) hours += 12;
    if (period === 'am' && hours === 12) hours = 0;

    if (minutes === 60) {
        hours = (hours + 1) % 24;
    }

    return {
        hours,
        minutes: minutes === 60 ? 0 : minutes,
        value: `${String(hours).padStart(2, '0')}:${String(minutes === 60 ? 0 : minutes).padStart(2, '0')}`
    };
}

function getDeliveryScheduleValidation(form) {
    const dateInput = form ? form.querySelector('[name="delivery_date"]') : null;
    const timeInput = form ? form.querySelector('[name="delivery_time"]') : null;
    if (!dateInput || !timeInput) {
        return { valid: true, normalizedTime: '' };
    }

    const parsedTime = parseDeliveryTime(timeInput.value);
    if (!parsedTime) {
        return {
            valid: false,
            message: 'Please write delivery time like 12:59 PM. Hours must be 01-12, minutes 01-60, and use AM or PM.',
            normalizedTime: ''
        };
    }

    const selectedDate = new Date(`${dateInput.value}T${parsedTime.value}:00`);
    const minimumDate = new Date();
    minimumDate.setHours(minimumDate.getHours() + 1);
    minimumDate.setSeconds(0, 0); // Clear seconds and milliseconds for minute-level comparison

    if (Number.isNaN(selectedDate.getTime())) {
        return {
            valid: false,
            message: 'Invalid date or time format.',
            normalizedTime: parsedTime.value
        };
    }

    if (selectedDate < minimumDate) {
        const isPastToday = selectedDate < new Date();
        let msg = 'Invalid delivery time. You must schedule the delivery at least one hour from now.';
        if (isPastToday) {
            msg = 'This time has already passed for today. Please choose a future time (or change the date to tomorrow if you meant midnight).';
        }
        
        return {
            valid: false,
            message: msg,
            normalizedTime: parsedTime.value
        };
    }

    return { valid: true, normalizedTime: parsedTime.value };
}

async function placeOrder() {
    const placeOrderBtn = document.getElementById('place-order-btn');
    const checkoutForm = document.getElementById('checkout-form');

    if (!placeOrderBtn || placeOrderBtn.disabled) return;

    if (checkoutForm && !checkoutForm.reportValidity()) {
        return;
    }

    // Explicit checks for mandatory fields to provide clear alerts
    const phoneInput = checkoutForm.querySelector('[name="phone"]');
    const emailInput = checkoutForm.querySelector('[name="email"]');
    const dateInput = checkoutForm.querySelector('[name="delivery_date"]');
    const timeInput = checkoutForm.querySelector('[name="delivery_time"]');

    if (!phoneInput.value.trim()) { alert('Please enter your phone number.'); return; }
    if (!emailInput.value.trim()) { alert('Please enter your email address.'); return; }
    if (!dateInput.value.trim()) { alert('Please choose a delivery date.'); return; }
    if (!timeInput.value.trim()) { alert('Please choose a delivery time.'); return; }

    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (!selectedPayment) {
        alert('Please select a payment method.');
        return;
    }

    const originalText = placeOrderBtn.textContent;
    placeOrderBtn.disabled = true;
    placeOrderBtn.textContent = 'Processing...';

    try {
        const deliveryValidation = getDeliveryScheduleValidation(checkoutForm);
        if (!deliveryValidation.valid) {
            alert(deliveryValidation.message);
            return;
        }

        const phone = checkoutForm.querySelector('[name="phone"]').value;
        if (!/^\d{11}$/.test(phone)) {
            alert('Please enter a valid Iraqi phone number with exactly 11 digits.');
            return;
        }

        const selectedPayment = document.querySelector('input[name="payment_method"]:checked');

        if (selectedPayment && selectedPayment.value === 'Reward Points') {
            const rewardInput = checkoutForm.querySelector('[name="redeem_points"]');
            const rewardPoints = rewardInput ? rewardInput.value.trim() : '';
            const maxPoints = rewardInput ? parseInt(rewardInput.max, 10) : 0;

            if (!/^\d+$/.test(rewardPoints) || parseInt(rewardPoints, 10) <= 0) {
                alert('Please enter reward points as a whole number only.');
                return;
            }

            if (maxPoints > 0 && parseInt(rewardPoints, 10) > maxPoints) {
                alert('You cannot spend more reward points than you have.');
                return;
            }
        }
        
        if (selectedPayment && selectedPayment.value === 'Credit Card (Visa)') {
            const cardNumber = syncCardNumberInput(checkoutForm);
            const cardExpiry = checkoutForm.querySelector('[name="card_expiry"]').value;
            const cardCvv = checkoutForm.querySelector('[name="card_cvv"]').value;
            const cardName = checkoutForm.querySelector('[name="card_name"]').value;

            if (!/^(visa|visacard)$/i.test(cardName.trim())) {
                alert('Cardholder Name must be visa or visacard.');
                return;
            }
            if (!validateFixedCardNumber(cardNumber, 16)) {
                alert('Please enter a valid 16-digit card number.');
                return;
            }
            if (!cardNumber.startsWith('4')) {
                alert('Visa card number must start with 4.');
                return;
            }
            if (!validateExpiry(cardExpiry)) {
                alert('Please select a valid expiry date in the future.');
                return;
            }
            if (!/^\d{3}$/.test(cardCvv)) {
                alert('Please enter a valid 3-digit CVV.');
                return;
            }
        }

        if (selectedPayment && selectedPayment.value === 'PayPal') {
            const paypalCardNumber = checkoutForm.querySelector('[name="paypal_email"]').value;

            if (!validateFixedCardNumber(paypalCardNumber, 16)) {
                alert('Please enter a valid 16-digit PayPal card number.');
                return;
            }
        }

        const form = new FormData(checkoutForm);
        form.set('action', 'checkout');
        form.set('delivery_time', deliveryValidation.normalizedTime);
        if (selectedPayment) {
            form.set('payment_method', selectedPayment.value);
        }
        saveCheckoutDeliveryLocation(checkoutForm);

        placeOrderBtn.textContent = 'Placing Order...';

        const response = await fetch(API_CHECKOUT_URL, {
            method: 'POST',
            credentials: 'same-origin',
            cache: 'no-store',
            headers: {
                'Accept': 'application/json'
            },
            body: form
        });

        if (!response.ok) {
            const body = await response.text();
            throw new Error('Checkout request failed: ' + response.status + ' ' + body);
        }

        const data = await response.json();
        if (data && data.success) {
            localStorage.removeItem('liora_cart');
            localStorage.removeItem(COUPON_STORAGE_KEY);
            window.location.href = 'success.php?order_number=' + data.order_number + '&id=' + data.order_id;
            return;
        }

        alert((data && data.message) ? data.message : 'Unable to place your order.');
    } catch (error) {
        console.warn('Checkout request failed:', error);
        alert('Unexpected error while placing order.');
    } finally {
        placeOrderBtn.disabled = false;
        placeOrderBtn.textContent = originalText || 'Place Order';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    initializeTextareaLineLimits();
    initializeDeliverySync();
    initializeDeliveryTimeMinimum();
    renderCheckout();
    const checkoutForm = document.getElementById('checkout-form');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const cardDetails = document.getElementById('card-details');
    const paypalDetails = document.getElementById('paypal-details');

    if (cardDetails) cardDetails.style.display = 'block';
    if (paypalDetails) paypalDetails.style.display = 'none';

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            placeOrder();
        });
    }

    // --- Real-time Formatting Listeners ---
    const cardInput = document.querySelector('[data-card-number-input]');
    if (cardInput) {
        cardInput.addEventListener('input', (e) => {
            const formattedValue = formatCardNumber(e.target.value, 16);
            e.target.value = formattedValue;
            syncCardNumberInput(checkoutForm || document);
            e.target.setSelectionRange(formattedValue.length, formattedValue.length);
        });
    }

    const paypalCardInput = document.querySelector('[name="paypal_email"]');
    if (paypalCardInput) {
        paypalCardInput.addEventListener('input', (e) => {
            const cursor = e.target.selectionStart;
            const originalLength = e.target.value.length;
            e.target.value = formatCardNumber(e.target.value, 16);
            const newLength = e.target.value.length;
            const cursorOffset = newLength - originalLength;
            e.target.setSelectionRange(cursor + cursorOffset, cursor + cursorOffset);
        });
    }

    // Expiry input formatting (no longer needed for type="month")
    /*
    const expiryInput = document.querySelector('[name="card_expiry"]');
    if (expiryInput) {
        expiryInput.addEventListener('input', (e) => {
            e.target.value = formatExpiry(e.target.value);
        });
    }
    */

    const deliveryTimeInput = document.querySelector('[name="delivery_time"]');
    if (deliveryTimeInput) {
        deliveryTimeInput.addEventListener('input', (e) => {
            e.target.value = formatDeliveryTime(e.target.value);
            e.target.setCustomValidity(
                e.target.value.trim() && !isValidDeliveryTimeDisplay(e.target.value)
                    ? 'Use HH:MM AM/PM. Hours 01-12, minutes 01-60.'
                    : ''
            );
        });

        deliveryTimeInput.addEventListener('blur', (e) => {
            if (e.target.value.trim() && !isValidDeliveryTimeDisplay(e.target.value)) {
                e.target.setCustomValidity('Use HH:MM AM/PM. Hours 01-12, minutes 01-60.');
            } else {
                e.target.setCustomValidity('');
            }
        });
    }

    const cvvInput = document.querySelector('[name="card_cvv"]');
    if (cvvInput) {
        cvvInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').substr(0, 3);
        });
    }

    // No custom JS needed for native month picker as we use CSS overlay trick


    const phoneInput = document.querySelector('[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '').substr(0, 11);
        });
    }
});
