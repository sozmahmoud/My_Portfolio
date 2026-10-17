// ================================================================
// 🌷 LIORA — deliveryMap.js
// Real Leaflet Map + Animated Truck + Full Interactive Features
// ================================================================

let map, truckMarker, destinationMarker, routeLine;
let animationInterval = null;
let countdownInterval = null;
let isTracking = false;
let selectedNewDate = '';
let selectedNewSchedule = null;
let animationProgress = 0;
let orderCancelled = false;
let returningToWarehouse = false;
let returnProgress = 0;
const DELIVERY_ORDER = window.deliveryOrder || {};
const API_ORDER_URL = 'order_action.php';
const PREPARATION_WINDOW_MS = 60 * 60 * 1000;
const SLOW_DELIVERY_WINDOW_MS = 20 * 60 * 1000; // Slower movement (20 minutes)
const RETURN_SPEED_MS = 15000; // 15 seconds to return to warehouse
let readyConfirmed = false;
let readyPromptShown = false;
let arrivalConfirmed = false;
let arrivalPromptShown = false;
let pendingConfirmAction = null;
let deliveryMovementStartedAt = 0;

function getSavedDeliveryLocation() {
  try {
    return JSON.parse(localStorage.getItem('lioraDeliveryLocation') || 'null');
  } catch (error) {
    return null;
  }
}

// Route coordinates (Start at warehouse)
let ROUTE_COORDS = [
  [35.5699, 45.4524] // Warehouse (Sulaymaniyah, Twi Malik)
];

// ================================================================
// MAP INITIALIZATION
// ================================================================
async function initMap() {
  try {
    const mapEl = document.getElementById('map');
    if (!mapEl) return;
    if (typeof L === 'undefined') {
      updateLocationText('LIORA Warehouse preview');
      updateDistanceText(0);
      console.warn('Leaflet is not available; showing the static delivery map preview.');
      return;
    }

    const warehousePos = [35.5699, 45.4524];
    let destinationPos = [35.5650, 45.4550]; // Default fallback in Sulaymaniyah
    const isGuestView = DELIVERY_ORDER.isGuestView || false;

    // For guest views, show warehouse as destination
    if (isGuestView) {
      destinationPos = warehousePos;
    } else if (DELIVERY_ORDER.address) {
      // Attempt to geocode destination address from the order
      const query = `${DELIVERY_ORDER.address}, ${DELIVERY_ORDER.city || ''}`;
      const geoUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}`;
      try {
        const geoRes = await fetch(geoUrl);
        const geoData = await geoRes.json();
        if (geoData && geoData.length > 0) {
          destinationPos = [parseFloat(geoData[0].lat), parseFloat(geoData[0].lon)];
        }
      } catch (e) {
        console.warn('Geocoding failed, using default destination', e);
      }
    }

    // Build a multi-point route for smoother animation (skip for guest view)
    if (!isGuestView) {
      ROUTE_COORDS = [
        warehousePos,
        [warehousePos[0] - 0.003, warehousePos[1] + 0.004],
        [(warehousePos[0] + destinationPos[0]) / 2, (warehousePos[1] + destinationPos[1]) / 2],
        [destinationPos[0] + 0.003, destinationPos[1] - 0.004],
        destinationPos
      ];
    } else {
      ROUTE_COORDS = [warehousePos];
    }

    map = L.map('map', {
      zoomControl: false,
      attributionControl: false,
      scrollWheelZoom: false,
      dragging: false,
      touchZoom: false,
      doubleClickZoom: false,
      boxZoom: false,
      keyboard: false
    }).setView(warehousePos, 14);

    setTimeout(() => {
      if (map) map.invalidateSize();
    }, 150);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
      maxZoom: 19,
      subdomains: 'abcd'
    }).addTo(map);

    // Warehouse marker
    const warehouseIcon = L.divIcon({
      className: '',
      html: `<div class="map-marker warehouse-marker">
               <div class="marker-pin">🏭</div>
               <div class="marker-label">LIORA Warehouse</div>
             </div>`,
      iconSize: [120, 60],
      iconAnchor: [60, 55]
    });
    L.marker(warehousePos, { icon: warehouseIcon }).addTo(map);

    // Destination marker (only for actual deliveries, not guest view)
    if (!isGuestView) {
      const homeIcon = L.divIcon({
        className: '',
        html: `<div class="map-marker home-marker">
                 <div class="marker-pin">🏠</div>
                 <div class="marker-label">${escapeHtml(DELIVERY_ORDER.address || 'Your Address')}</div>
               </div>`,
        iconSize: [120, 60],
        iconAnchor: [60, 55]
      });
      destinationMarker = L.marker(destinationPos, { icon: homeIcon }).addTo(map).bindPopup(`
        <div class="custom-popup">
          <b>🏠 Delivery Address</b><br>
          <small id="popup-address">${escapeHtml(DELIVERY_ORDER.address || 'Checkout address')}</small>
        </div>
      `);

      /* 
      // Map click handler disabled - User cannot change location after checkout
      map.on('click', async function(e) {
        if (orderCancelled) return;
        await updateDeliveryLocation(e.latlng);
      });
      */
    }

    // Route line (only for actual deliveries, not guest view)
    if (!isGuestView) {
      routeLine = L.polyline(ROUTE_COORDS, {
        color: '#e83e7c',
        weight: 5,
        opacity: 0.85,
        dashArray: '14, 10'
      }).addTo(map);

      // Truck marker
      const truckIcon = L.divIcon({
        className: '',
        html: buildTruckHtml(),
        iconSize: [64, 64],
        iconAnchor: [32, 32]
      });
      truckMarker = L.marker(warehousePos, { icon: truckIcon, zIndexOffset: 1000 }).addTo(map);

      map.fitBounds(routeLine.getBounds(), { padding: [60, 60] });
      
      // Initial texts
      updateLocationText('Departing from LIORA Warehouse');
      updateDistanceText(Math.round(map.distance(warehousePos, destinationPos)));

      animateTruck();
    } else {
      // Guest view - just center on warehouse
      map.setView(warehousePos, 14);
      updateLocationText('Welcome to LIORA Warehouse 🏭');
      updateDistanceText(0);
    }

    applyOrderDetailsToPage();
    injectMapStyles();

  } catch (err) {
    console.error('Map init error:', err);
  }
}

// ── Build truck icon HTML (uses PNG from uploads, falls back to emoji) ──
function buildTruckHtml() {
  return `<div class="truck-wrapper" id="truck-wrapper">
    <img 
      src="assets/img/truck_icon.png"
      onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
      width="64" height="64"
      alt="Delivery Truck"
      class="truck-img"
      id="truck-img"
    />
    <div class="truck-emoji-fallback" style="display:none;">🚚</div>
  </div>`;
}

function escapeHtml(value) {
  return String(value || '').replace(/[&<>"']/g, char => ({
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  }[char]));
}

async function updateDeliveryLocation(latlng) {
  if (!latlng) return;

  const newAddress = `Lat: ${latlng.lat.toFixed(4)}, Lng: ${latlng.lng.toFixed(4)}`;
  
  // 1. Update marker position
  if (destinationMarker) {
    destinationMarker.setLatLng(latlng);
    const popupAddr = document.getElementById('popup-address');
    if (popupAddr) popupAddr.textContent = newAddress;
  }

  // 2. Update route coords
  const warehousePos = [35.5699, 45.4524];
  const destinationPos = [latlng.lat, latlng.lng];
  
  ROUTE_COORDS = [
    warehousePos,
    [warehousePos[0] - 0.003, warehousePos[1] + 0.004],
    [(warehousePos[0] + destinationPos[0]) / 2, (warehousePos[1] + destinationPos[1]) / 2],
    [destinationPos[0] + 0.003, destinationPos[1] - 0.004],
    destinationPos
  ];

  // 3. Update route line
  if (routeLine) {
    routeLine.setLatLngs(ROUTE_COORDS);
  }

  // 4. Update the DB if we have an order ID
  if (DELIVERY_ORDER.id) {
    const form = new FormData();
    form.append('action', 'update_order_location');
    form.append('order_id', DELIVERY_ORDER.id);
    form.append('address', newAddress);

    try {
      const response = await fetch(API_ORDER_URL, {
        method: 'POST',
        credentials: 'same-origin',
        body: form
      });
      const data = await response.json();
      if (data.success) {
        showToast('📍 Delivery address updated! Sara is redirecting! 🚚', 'success');
        DELIVERY_ORDER.address = newAddress;
      }
    } catch (error) {
      console.warn('Update location failed:', error);
    }
  }

  // 5. Update localStorage for checkout persistence
  saveMapSelectionForCheckout(latlng);
}

function saveMapSelectionForCheckout(latlng) {
  if (!latlng) return;
  const savedLocation = getSavedDeliveryLocation();
  const address = `Selected delivery location (${latlng.lat.toFixed(5)}, ${latlng.lng.toFixed(5)})`;
  const location = {
    address,
    city: DELIVERY_ORDER.city || '',
    lat: latlng.lat,
    lng: latlng.lng,
    delivery_date: DELIVERY_ORDER.delivery_date || (savedLocation && savedLocation.delivery_date) || '',
    delivery_time: DELIVERY_ORDER.delivery_time || (savedLocation && savedLocation.delivery_time) || '',
    source: 'map',
    updatedAt: Date.now()
  };

  localStorage.setItem('lioraDeliveryLocation', JSON.stringify(location));
  showToast('📍 Checkout address updated from the map.', 'info');
}

function applyOrderDetailsToPage() {

  const dateEl = document.getElementById('original-date');
  if (dateEl && DELIVERY_ORDER.delivery_date) {
    dateEl.textContent = formatDisplayDate(DELIVERY_ORDER.delivery_date);
  }

  if (DELIVERY_ORDER.address) {
    localStorage.setItem('lioraDeliveryLocation', JSON.stringify({
      address: DELIVERY_ORDER.address,
      city: DELIVERY_ORDER.city || '',
      delivery_date: DELIVERY_ORDER.delivery_date || '',
      delivery_time: DELIVERY_ORDER.delivery_time || '',
      source: 'order',
      updatedAt: Date.now()
    }));
  }
}

// ── CSS injected into document for map markers ──
function injectMapStyles() {
  if (document.getElementById('map-injected-styles')) return;
  const s = document.createElement('style');
  s.id = 'map-injected-styles';
  s.textContent = `
    .map-marker { display:flex; flex-direction:column; align-items:center; }
    .marker-pin {
      font-size: 32px;
      filter: drop-shadow(0 4px 8px rgba(193,78,143,0.5));
      animation: markerBounce 2s ease-in-out infinite;
      cursor: default;
    }
    .marker-label {
      background: rgba(255,255,255,0.95);
      color: #c14e8f;
      font-size: 11px;
      font-weight: 700;
      border: 1.5px solid #f7c9dd;
      border-radius: 20px;
      padding: 2px 8px;
      white-space: nowrap;
      box-shadow: 0 2px 8px rgba(0,0,0,0.12);
      margin-top: 2px;
    }
    @keyframes markerBounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }
    .truck-wrapper {
      position: relative;
      display: flex; align-items: center; justify-content: center;
      width: 64px; height: 64px;
      animation: truckFloat 1.4s ease-in-out infinite;
    }
    .truck-img {
      width: 64px; height: 64px;
      filter: drop-shadow(0 6px 14px rgba(193,78,143,0.5));
      transition: transform 0.3s ease;
    }
    .truck-emoji-fallback {
      font-size: 42px;
      filter: drop-shadow(0 4px 10px rgba(193,78,143,0.5));
      align-items: center; justify-content: center;
      width: 64px; height: 64px;
    }
    @keyframes truckFloat {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }
    .truck-wrapper::after {
      content: '';
      position: absolute;
      bottom: -6px; left: 50%;
      transform: translateX(-50%);
      width: 28px; height: 7px;
      background: rgba(193,78,143,0.18);
      border-radius: 50%;
      animation: shadowPulse 1.4s ease-in-out infinite;
    }
    @keyframes shadowPulse {
      0%, 100% { transform: translateX(-50%) scale(1); opacity:0.3; }
      50% { transform: translateX(-50%) scale(1.3); opacity:0.1; }
    }
    .custom-popup {
      font-family: 'DM Sans', sans-serif;
      line-height: 1.5;
      text-align: center;
    }
    .custom-popup b { color:#c14e8f; }
    .leaflet-popup-content-wrapper {
      border-radius: 18px !important;
      box-shadow: 0 8px 30px rgba(0,0,0,0.15) !important;
      border: 2px solid #f7c9dd !important;
    }
    .leaflet-popup-tip {
      background: #fff !important;
    }
    
    /* Refund Overlay Styles */
    .refund-overlay {
      position: fixed;
      inset: 0;
      background: rgba(74, 31, 45, 0.85);
      backdrop-filter: blur(8px);
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: center;
      animation: fadeIn 0.4s ease;
    }
    .refund-content {
      background: #fff;
      padding: 3rem 2.75rem;
      border-radius: 26px;
      text-align: center;
      max-width: 430px;
      width: 90%;
      position: relative;
      box-shadow: 0 20px 50px rgba(0,0,0,0.3);
      border: 4px solid #fdebf3;
    }
    .refund-icon {
      font-size: 5rem;
      margin-bottom: 1.5rem;
      animation: heartBeat 1.5s infinite;
    }
    .refund-content h2 {
      color: #c94f84;
      margin-bottom: 0.75rem;
      font-size: 2rem;
      line-height: 1.2;
      letter-spacing: 0;
    }
    .refund-content p {
      color: #6d4a57;
      margin-bottom: 2rem;
      line-height: 1.65;
      font-size: 1.05rem;
    }
    .refund-content p b {
      color: #4f2635;
      font-size: 1.18rem;
    }
    .refund-details {
      background: #fff5f9;
      padding: 1rem 1.25rem;
      border-radius: 15px;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
      margin-bottom: 2rem;
      font-size: 0.95rem;
      color: #8a6272;
    }
    .btn--refund {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.55rem;
      background: #4f2635;
      color: #fff;
      min-width: 220px;
      min-height: 58px;
      padding: 0 2.25rem;
      border-radius: 18px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      font-weight: 800;
      font-size: 1rem;
      letter-spacing: 0;
      cursor: pointer;
      box-shadow: 0 16px 32px rgba(79, 38, 53, 0.2);
      transition: transform 0.22s ease, box-shadow 0.22s ease, background 0.22s ease;
    }
    .btn--refund::after {
      content: '→';
      width: 24px;
      height: 24px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.16);
      font-size: 1rem;
      line-height: 1;
    }
    .btn--refund:hover {
      background: #3d1f2b;
      transform: translateY(-3px);
      box-shadow: 0 20px 36px rgba(79, 38, 53, 0.26);
    }
    .btn--refund:active {
      transform: translateY(-1px);
      box-shadow: 0 12px 24px rgba(79, 38, 53, 0.22);
    }
    .refund-particles span {
      position: absolute;
      font-size: 1.5rem;
      animation: floatUp 3s infinite ease-in;
      opacity: 0;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes heartBeat {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.1); }
    }
    @keyframes floatUp {
      0% { transform: translateY(0) rotate(0deg); opacity: 0; }
      20% { opacity: 1; }
      100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
    }
  `;
  document.head.appendChild(s);
}

// ================================================================
// TRUCK ANIMATION
// ================================================================
function animateTruck() {
  if (animationInterval) clearInterval(animationInterval);
  if (orderCancelled || DELIVERY_ORDER.isGuestView) return;

  function update() {
    if (orderCancelled) {
      clearInterval(animationInterval);
      return;
    }

    const readyAt = getBouquetReadyTime();
    const now = new Date();
    const nowTime = now.getTime();

    if (nowTime < readyAt.getTime()) {
      animationProgress = 0;
      updateLocationText('Preparing your bouquet at LIORA Warehouse');
      updateDistanceFromTruckToDestination();
      return;
    }

    if (!readyConfirmed) {
      animationProgress = 0;
      updateLocationText('Your bouquet is ready for delivery');
      updateDistanceFromTruckToDestination();
      showDeliveryConfirm('Your bouquets are ready for delivery! 🌸', () => {
        readyConfirmed = true;
        deliveryMovementStartedAt = Date.now();
        saveDeliveryConfirmState('ready', true);
        saveDeliveryMovementStart(deliveryMovementStartedAt);
        hideDeliveryConfirm();
        showToast('✅ Delivery confirmed. The truck is moving slowly now.', 'success');
        animateTruck();
      }, 'ready');
      return;
    }

    if (!deliveryMovementStartedAt) {
      deliveryMovementStartedAt = nowTime;
      saveDeliveryMovementStart(deliveryMovementStartedAt);
    }

    const startTime = deliveryMovementStartedAt;
    const targetTime = startTime + SLOW_DELIVERY_WINDOW_MS;

    if (nowTime >= targetTime) {
      animationProgress = 1;
    } else {
      animationProgress = Math.max(0, Math.min(0.995, (nowTime - startTime) / SLOW_DELIVERY_WINDOW_MS));
    }

    // If it's already "Arrived" in DB, set to 1
    const s = String(DELIVERY_ORDER.status || '').toLowerCase();
    if (s === 'delivered' || s === 'completed' || s === 'arrived') {
       animationProgress = 1;
       arrivalConfirmed = true;
    }

    if (animationProgress >= 1) {
      animationProgress = 1;
      clearInterval(animationInterval);
      animationInterval = null;

      updateLocationText('🏠 Arriving at your address!');
      updateDistanceText(0);
      updateStepToDelivered();

      if (!arrivalConfirmed) {
        showDeliveryConfirm('Your bouquet has arrived! 🌷 Confirm delivery for', async () => {
          const marked = await markOrderAsArrived();
          if (!marked) {
            arrivalPromptShown = false;
            showToast('❌ Could not update your order. Please try Confirm again.', 'error');
            return;
          }

          arrivalConfirmed = true;
          saveDeliveryConfirmState('arrival', true);
          hideDeliveryConfirm();
          showToast('🎉 Your order arrived. My Account orders are now updated.', 'success');
          returnTruckToWarehouse();
        }, 'arrival');
      }
      return;
    }

    const totalSegments = ROUTE_COORDS.length - 1;
    const pos = animationProgress * totalSegments;
    const segIdx = Math.min(Math.floor(pos), totalSegments - 1);
    const segProg = pos - segIdx;

    const startCoord = ROUTE_COORDS[segIdx];
    const endCoord = ROUTE_COORDS[segIdx + 1] || ROUTE_COORDS[segIdx];
    const lat = startCoord[0] + (endCoord[0] - startCoord[0]) * segProg;
    const lng = startCoord[1] + (endCoord[1] - startCoord[1]) * segProg;

    if (truckMarker) {
      truckMarker.setLatLng([lat, lng]);

      const img = document.getElementById('truck-img');
      const angle = getBearing(startCoord[0], startCoord[1], endCoord[0], endCoord[1]);
      if (img) {
        if (angle > 180) {
          img.style.transform = 'scaleX(-1)';
        } else {
          img.style.transform = 'scaleX(1)';
        }
      }
    }

    if (map) {
      const dest = ROUTE_COORDS[ROUTE_COORDS.length - 1];
      const dist = Math.round(map.distance([lat, lng], dest));
      updateDistanceText(dist);
    }

    updateLocationByProgress(animationProgress);
  }

  update();
  // Update often enough that real-time movement still looks alive and gentle.
  animationInterval = setInterval(update, 250);
}

function getBearing(lat1, lng1, lat2, lng2) {
  lat1 = lat1 * Math.PI / 180;
  lng1 = lng1 * Math.PI / 180;
  lat2 = lat2 * Math.PI / 180;
  lng2 = lng2 * Math.PI / 180;
  const dLng = lng2 - lng1;
  const y = Math.sin(dLng) * Math.cos(lat2);
  const x = Math.cos(lat1) * Math.sin(lat2) - Math.sin(lat1) * Math.cos(lat2) * Math.cos(dLng);
  return (Math.atan2(y, x) * 180 / Math.PI + 360) % 360;
}

function updateLocationByProgress(p) {
  const locations = [
    [0.0, 'Near Central Flower Market 🌸'],
    [0.2, 'Passing Rose Garden District 🌹'],
    [0.4, 'Near Tulip Square 🌷'],
    [0.55, 'On Jasmine Boulevard 🌼'],
    [0.7, 'Approaching your neighborhood 🏘️'],
    [0.85, 'Just around the corner! 🎉'],
    [0.95, '🏠 Almost at your door!']
  ];
  let text = locations[0][1];
  for (const [threshold, label] of locations) {
    if (p >= threshold) text = label;
  }
  updateLocationText(text);
}

// ================================================================
// UI HELPERS
// ================================================================
function updateDistanceText(meters) {
  const el = document.getElementById('distance');
  if (!el) return;
  el.textContent = meters < 100 ? 'Arriving now!' : meters < 1000 ? `${meters}m away` : `${(meters / 1000).toFixed(1)}km away`;
}

function updateDistanceFromTruckToDestination() {
  if (!map || ROUTE_COORDS.length < 2) return;
  const truckLatLng = truckMarker ? truckMarker.getLatLng() : { lat: ROUTE_COORDS[0][0], lng: ROUTE_COORDS[0][1] };
  const dest = ROUTE_COORDS[ROUTE_COORDS.length - 1];
  const dist = Math.round(map.distance([truckLatLng.lat, truckLatLng.lng], dest));
  updateDistanceText(dist);
}

function updateLocationText(text) {
  const el = document.getElementById('current-location');
  if (el) el.textContent = text;
}

function updateStepToDelivered() {
  document.querySelectorAll('.step').forEach(s => {
    s.classList.remove('active');
    s.classList.add('completed');
  });
}

// ================================================================
// LIVE TRACK BUTTON
// ================================================================
function liveTrack() {
  if (isTracking || orderCancelled) return;
  isTracking = true;

  const btn = document.getElementById('live-track-btn');
  if (btn) {
    btn.innerHTML = '<span class="live-dot"></span> Tracking...';
    btn.disabled = true;
  }

  showToast('📡 Live tracking enabled! Watch Sara move! 🚚', 'success');

  if (truckMarker && map) {
    map.flyTo(truckMarker.getLatLng(), 16, { duration: 1.5 });
  }

  setTimeout(() => {
    isTracking = false;
    if (btn) {
      btn.innerHTML = '<span class="live-dot"></span> Live Track';
      btn.disabled = false;
    }
    if (map) map.flyTo([35.568, 45.453], 14, { duration: 1.2 });
  }, 6000);
}

// ================================================================
// COUNTDOWN TIMER
// ================================================================
function getDeliveryTarget() {
  const savedLocation = getSavedDeliveryLocation();
  const date = DELIVERY_ORDER.delivery_date || (savedLocation && savedLocation.delivery_date);
  const time = DELIVERY_ORDER.delivery_time || (savedLocation && savedLocation.delivery_time);
  const readyAt = getBouquetReadyTime();
  if (!date || !time) {
    return new Date(readyAt.getTime() + SLOW_DELIVERY_WINDOW_MS);
  }

  const target = new Date(`${date}T${String(time).slice(0, 5)}:00`);
  if (Number.isNaN(target.getTime())) {
    return new Date(readyAt.getTime() + SLOW_DELIVERY_WINDOW_MS);
  }
  if (target.getTime() <= readyAt.getTime()) {
    return new Date(readyAt.getTime() + SLOW_DELIVERY_WINDOW_MS);
  }
  return target;
}

function getBouquetReadyTime() {
  const createdAt = parseDateTime(DELIVERY_ORDER.created_at);
  if (createdAt) {
    return new Date(createdAt.getTime() + PREPARATION_WINDOW_MS);
  }
  return new Date(Date.now() + PREPARATION_WINDOW_MS);
}

function parseDateTime(value) {
  if (!value) return null;
  const normalized = String(value).trim().replace(' ', 'T');
  const hasTime = normalized.includes('T');
  const date = new Date(hasTime ? normalized : `${normalized}T00:00:00`);
  return Number.isNaN(date.getTime()) ? null : date;
}

function formatDisplayDate(dateValue) {
  const date = new Date(`${dateValue}T00:00:00`);
  if (Number.isNaN(date.getTime())) return dateValue || 'Today';
  return date.toLocaleDateString('en-US', { day: 'numeric', month: 'short', year: 'numeric' });
}

function formatEtaLabel(target) {
  const today = new Date();
  const targetDay = new Date(target.getFullYear(), target.getMonth(), target.getDate());
  const todayDay = new Date(today.getFullYear(), today.getMonth(), today.getDate());
  const diffDays = Math.round((targetDay - todayDay) / 86400000);
  const dayLabel = diffDays === 0 ? 'Today' : formatDisplayDate(target.toISOString().slice(0, 10));
  return `${dayLabel} • ${target.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false })}`;
}

function updateCountdownDisplay(totalSeconds, target) {
  const d = Math.floor(totalSeconds / 86400);
  const h = Math.floor((totalSeconds % 86400) / 3600);
  const m = Math.floor((totalSeconds % 3600) / 60);
  const s = totalSeconds % 60;

  const daysEl = document.getElementById('days');
  const hoursEl = document.getElementById('hours');
  const minutesEl = document.getElementById('minutes');
  const secondsEl = document.getElementById('seconds');

  if (daysEl) daysEl.textContent = String(d).padStart(2, '0');
  if (hoursEl) hoursEl.textContent = String(h).padStart(2, '0');
  if (minutesEl) minutesEl.textContent = String(m).padStart(2, '0');
  if (secondsEl) secondsEl.textContent = String(s).padStart(2, '0');

  const etaEl = document.getElementById('eta-time');
  if (etaEl) etaEl.textContent = formatEtaLabel(target);
}

function startCountdown() {
  if (countdownInterval) clearInterval(countdownInterval);
  if (DELIVERY_ORDER.isGuestView) return;
  const target = getDeliveryTarget();

  function tick() {
    if (orderCancelled) {
      clearInterval(countdownInterval);
      return;
    }
    const totalSeconds = Math.max(0, Math.floor((target.getTime() - Date.now()) / 1000));
    updateCountdownDisplay(totalSeconds, target);

    if (totalSeconds === 0) {
      clearInterval(countdownInterval);
      showToast('🎉 Your flowers have arrived! Enjoy your Ruby Red Romance 🌹', 'success');
    }
  }

  tick();
  countdownInterval = setInterval(tick, 1000);
}

// ================================================================
// MODALS
// ================================================================
function showRescheduleModal() {
  if (orderCancelled) { showToast('⚠️ This order has been cancelled.', 'error'); return; }
  const modal = document.getElementById('reschedule-modal');
  const container = document.getElementById('date-options');
  if (!modal || !container) return;

  const dates = generateDateOptions();
  container.innerHTML = dates.map((d, i) => `
    <div class="date-chip ${i === 0 ? 'selected' : ''}" onclick="selectDate(this, '${d.dateValue}', '${d.timeValue}', '${d.fullDate}')">
      <div class="date-chip__day">${d.day}</div>
      <div class="date-chip__date">${d.date}</div>
      <div class="date-chip__time">${d.time}</div>
    </div>
  `).join('');

  if (dates.length > 0) {
    selectedNewDate = dates[0].fullDate;
    selectedNewSchedule = {
      date: dates[0].dateValue,
      time: dates[0].timeValue,
      label: dates[0].fullDate
    };
  }
  openModal(modal);
}

function generateDateOptions() {
  const options = [];
  const today = new Date();
  const times = ['10:00 AM', '2:00 PM', '11:30 AM', '9:00 AM', '3:30 PM', '1:00 PM', '4:00 PM'];
  const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
  const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

  for (let i = 1; i <= 7; i++) {
    const d = new Date(today);
    d.setDate(today.getDate() + i);
    options.push({
      day: days[d.getDay()],
      date: `${months[d.getMonth()]} ${d.getDate()}`,
      time: times[i - 1],
      dateValue: d.toISOString().slice(0, 10),
      timeValue: convertTimeTo24Hour(times[i - 1]),
      fullDate: `${months[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`
    });
  }
  return options;
}

function convertTimeTo24Hour(timeLabel) {
  const match = String(timeLabel).match(/^(\d{1,2}):(\d{2})\s*(AM|PM)$/i);
  if (!match) return '10:00';
  let hours = parseInt(match[1], 10);
  const minutes = match[2];
  const meridiem = match[3].toUpperCase();
  if (meridiem === 'PM' && hours < 12) hours += 12;
  if (meridiem === 'AM' && hours === 12) hours = 0;
  return `${String(hours).padStart(2, '0')}:${minutes}`;
}

function selectDate(el, dateValue, timeValue, date) {
  document.querySelectorAll('.date-chip').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  selectedNewDate = date;
  selectedNewSchedule = {
    date: dateValue,
    time: timeValue,
    label: date
  };
}

async function confirmReschedule() {
  if (!selectedNewSchedule || !selectedNewSchedule.date || !selectedNewSchedule.time) {
    showToast('⚠️ Please select a date first', 'warning');
    return;
  }
  if (!DELIVERY_ORDER.id) {
    showToast('⚠️ No active order found to reschedule.', 'warning');
    return;
  }

  const form = new FormData();
  form.append('action', 'reschedule_order');
  form.append('order_id', DELIVERY_ORDER.id);
  form.append('delivery_date', selectedNewSchedule.date);
  form.append('delivery_time', selectedNewSchedule.time);

  try {
    const response = await fetch(API_ORDER_URL, {
      method: 'POST',
      credentials: 'same-origin',
      body: form
    });
    const data = await response.json();
    if (!data.success) {
      showToast(`❌ ${data.message || 'Could not reschedule delivery.'}`, 'error');
      return;
    }
  } catch (error) {
    console.warn('Reschedule failed:', error);
    showToast('❌ Could not reschedule delivery.', 'error');
    return;
  }

  hideModals();
  DELIVERY_ORDER.delivery_date = selectedNewSchedule.date;
  DELIVERY_ORDER.delivery_time = selectedNewSchedule.time;
  showToast(`✅ Delivery rescheduled to ${selectedNewSchedule.label} 🌷`, 'success');

  const dateEl = document.getElementById('original-date');
  if (dateEl) dateEl.textContent = selectedNewSchedule.label;

  const displayDateEl = document.getElementById('display-delivery-date');
  if (displayDateEl) displayDateEl.textContent = selectedNewSchedule.label;

  animationProgress = 0;
  animateTruck();
  startCountdown();
}

function showCallDriverModal() {
  if (orderCancelled) { showToast('⚠️ This order has been cancelled.', 'error'); return; }
  const modal = document.getElementById('call-modal');
  if (modal) openModal(modal);
}

function getDeliveryConfirmKey(type) {
  const orderId = DELIVERY_ORDER.id || DELIVERY_ORDER.order_number || 'preview';
  return `lioraDeliveryConfirm:${orderId}:${type}`;
}

function getDeliveryMovementKey() {
  const orderId = DELIVERY_ORDER.id || DELIVERY_ORDER.order_number || 'preview';
  return `lioraDeliveryMovementStartedAt:${orderId}`;
}

function loadDeliveryConfirmState() {
  const status = String(DELIVERY_ORDER.status || '').toLowerCase();
  try {
    readyConfirmed = localStorage.getItem(getDeliveryConfirmKey('ready')) === '1';
    arrivalConfirmed = localStorage.getItem(getDeliveryConfirmKey('arrival')) === '1';
    deliveryMovementStartedAt = Number(localStorage.getItem(getDeliveryMovementKey()) || 0);
  } catch (error) {
    readyConfirmed = false;
    arrivalConfirmed = false;
    deliveryMovementStartedAt = 0;
  }

  if (status === 'delivered' || status === 'completed' || status === 'arrived') {
    readyConfirmed = true;
    arrivalConfirmed = true;
  }
}

function saveDeliveryConfirmState(type, value) {
  try {
    localStorage.setItem(getDeliveryConfirmKey(type), value ? '1' : '0');
  } catch (error) {
    console.warn('Could not save delivery confirmation state:', error);
  }
}

function saveDeliveryMovementStart(startedAt) {
  try {
    localStorage.setItem(getDeliveryMovementKey(), String(startedAt));
  } catch (error) {
    console.warn('Could not save delivery movement start:', error);
  }
}

function showDeliveryConfirm(message, onConfirm, type) {
  if (type === 'ready' && readyPromptShown) return;
  if (type === 'arrival' && arrivalPromptShown) return;

  const modal = document.getElementById('delivery-confirm-modal');
  const messageEl = document.getElementById('delivery-confirm-message');
  const button = document.getElementById('delivery-confirm-button');
  if (!modal || !messageEl || !button) return;

  if (type === 'ready') readyPromptShown = true;
  if (type === 'arrival') arrivalPromptShown = true;

  const orderNum = DELIVERY_ORDER.order_number || 'your order';

  messageEl.textContent = `${message} #${orderNum}`;

  pendingConfirmAction = onConfirm;
  button.textContent = 'Confirm';
  button.onclick = () => {
    const action = pendingConfirmAction;
    if (typeof action === 'function') action();
  };
  openModal(modal);
}

function hideDeliveryConfirm() {
  const modal = document.getElementById('delivery-confirm-modal');
  if (modal) modal.classList.remove('open');
  pendingConfirmAction = null;
  document.body.style.overflow = '';
}

// ================================================================
// FAST WAREHOUSE RETURN ANIMATION
// ================================================================
async function markOrderAsArrived() {
  if (!DELIVERY_ORDER.id || DELIVERY_ORDER.isGuestView) return false;

  const form = new FormData();
  form.append('action', 'mark_delivered');
  form.append('order_id', DELIVERY_ORDER.id);

  try {
    const response = await fetch(API_ORDER_URL, {
      method: 'POST',
      credentials: 'same-origin',
      body: form
    });
    const data = await response.json();
    if (data.success) {
      console.log('Order marked as arrived:', data.message);
      DELIVERY_ORDER.status = data.status || 'arrived';
      return true;
    } else {
      console.warn('Failed to mark order as arrived:', data.message);
      return false;
    }
  } catch (error) {
    console.warn('Error marking order as arrived:', error);
    return false;
  }
}

function returnTruckToWarehouse() {
  if (!truckMarker || !map) return;

  returningToWarehouse = true;
  returnProgress = 0;

  const warehousePos = [35.5699, 45.4524];
  const currentLatLng = truckMarker.getLatLng();
  const currentPos = [currentLatLng.lat, currentLatLng.lng];

  // Create a direct fast route back to warehouse
  const returnRoute = [
    currentPos,
    [
      (currentPos[0] + warehousePos[0]) / 2,
      (currentPos[1] + warehousePos[1]) / 2
    ],
    warehousePos
  ];

  const returnStartTime = Date.now();
  const returnDuration = RETURN_SPEED_MS;

  function animateReturn() {
    if (!returningToWarehouse || !truckMarker) {
      returningToWarehouse = false;
      return;
    }

    const elapsed = Date.now() - returnStartTime;
    returnProgress = Math.min(1, elapsed / returnDuration);

    if (returnProgress >= 1) {
      // Arrived at warehouse
      if (truckMarker) {
        truckMarker.setLatLng(warehousePos);
      }
      updateLocationText('✅ Truck back at warehouse');
      updateDistanceText(0);
      returningToWarehouse = false;
      showToast('🏭 Truck has returned to the warehouse!', 'success');
      return;
    }

    // Interpolate truck position along return route
    const totalSegments = returnRoute.length - 1;
    const pos = returnProgress * totalSegments;
    const segIdx = Math.min(Math.floor(pos), totalSegments - 1);
    const segProg = pos - segIdx;

    const startCoord = returnRoute[segIdx];
    const endCoord = returnRoute[segIdx + 1] || returnRoute[segIdx];
    const lat = startCoord[0] + (endCoord[0] - startCoord[0]) * segProg;
    const lng = startCoord[1] + (endCoord[1] - startCoord[1]) * segProg;

    if (truckMarker) {
      truckMarker.setLatLng([lat, lng]);

      // Update truck direction
      const img = document.getElementById('truck-img');
      const angle = getBearing(startCoord[0], startCoord[1], endCoord[0], endCoord[1]);
      if (img) {
        if (angle > 180) {
          img.style.transform = 'scaleX(-1)';
        } else {
          img.style.transform = 'scaleX(1)';
        }
      }
    }

    // Update distance text
    const dist = Math.round(map.distance([lat, lng], warehousePos));
    updateDistanceText(dist);
    
    // Update location text during return
    if (returnProgress < 0.5) {
      updateLocationText('🚚 Truck heading back to warehouse...');
    } else {
      updateLocationText('🚚 Almost back at LIORA Warehouse');
    }

    // Continue animation
    requestAnimationFrame(animateReturn);
  }

  animateReturn();
}

function showCancelModal() {
  if (orderCancelled) { showToast('⚠️ This order is already cancelled.', 'error'); return; }
  const modal = document.getElementById('cancel-modal');
  if (modal) openModal(modal);
}

async function confirmCancel() {
  if (!DELIVERY_ORDER.id) {
    showToast('⚠️ No active order found to cancel.', 'warning');
    return;
  }

  const form = new FormData();
  form.append('action', 'cancel_order');
  form.append('order_id', DELIVERY_ORDER.id);

  try {
    const response = await fetch(API_ORDER_URL, {
      method: 'POST',
      credentials: 'same-origin',
      body: form
    });
    const data = await response.json();
    if (!data.success) {
      showToast(`❌ ${data.message || 'Could not cancel order.'}`, 'error');
      return;
    }
  } catch (error) {
    console.warn('Cancel failed:', error);
    showToast('❌ Could not cancel order.', 'error');
    return;
  }

  hideModals();
  orderCancelled = true;

  if (animationInterval) { clearInterval(animationInterval); animationInterval = null; }
  if (countdownInterval) { clearInterval(countdownInterval); countdownInterval = null; }

  document.querySelectorAll('.step').forEach(s => {
    s.classList.remove('active', 'completed');
    s.style.opacity = '0.4';
  });

  ['hours','minutes','seconds'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.textContent = '00';
  });

  const etaEl = document.getElementById('eta-time');
  if (etaEl) etaEl.textContent = 'Cancelled';

  updateLocationText('🚚 Truck returning to warehouse...');
  updateDistanceText(0);

  document.querySelectorAll('.option-btn--reschedule, .option-btn--call').forEach(btn => {
    btn.disabled = true;
    btn.style.opacity = '0.4';
  });

  showToast('✅ Order cancelled! Truck heading back 🚚', 'success');
  
  // Animate truck return to warehouse with fast movement
  returnTruckToWarehouse();
  
  // Show the refund animation after a brief delay
  setTimeout(() => showRefundAnimation(), 2000);
}

function showRefundAnimation() {
  const overlay = document.createElement('div');
  const refundAmount = Number.parseFloat(DELIVERY_ORDER.total || 0);
  const refundId = DELIVERY_ORDER.order_number ? String(DELIVERY_ORDER.order_number).replace(/[^a-z0-9]/gi, '').slice(-8) : Math.floor(Math.random() * 100000);
  overlay.className = 'refund-overlay';
  overlay.innerHTML = `
    <div class="refund-content">
      <div class="refund-icon">🌸</div>
      <h2>Refund Confirmed</h2>
      <p>Your checkout payment of <b>$${refundAmount.toFixed(2)}</b> has been refunded to the same payment method.</p>
      <div class="refund-details">
        <span>Status: <b>Success</b></span>
        <span>Refund ID: <b>RFND-${refundId}</b></span>
      </div>
      <button class="btn btn--refund" onclick="this.parentElement.parentElement.remove()">View tracking</button>
      <div class="refund-particles"></div>
    </div>
  `;
  document.body.appendChild(overlay);
  
  // Add some sparkles
  const particles = overlay.querySelector('.refund-particles');
  for (let i = 0; i < 15; i++) {
    const p = document.createElement('span');
    p.textContent = ['💖', '✨', '🌸', '🌷'][Math.floor(Math.random() * 4)];
    p.style.left = Math.random() * 100 + '%';
    p.style.top = Math.random() * 100 + '%';
    p.style.animationDelay = Math.random() * 2 + 's';
    particles.appendChild(p);
  }
}

function openModal(modal) {
  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function hideModals() {
  document.querySelectorAll('.liora-modal:not(#delivery-confirm-modal)').forEach(m => m.classList.remove('open'));
  document.body.style.overflow = '';
}

function showToast(message, type = 'success') {
  const toast = document.getElementById('toast');
  const text = document.getElementById('toast-text');
  const icon = document.getElementById('toast-icon');

  if (!toast || !text) return;

  const icons = { success: '🌷', error: '❌', warning: '⚠️', info: '📍' };
  if (icon) icon.textContent = icons[type] || '🌷';
  text.innerHTML = message;
  toast.className = `delivery-notification ${type} show`;
  toast.style.display = 'flex';

  if (toast._timeout) clearTimeout(toast._timeout);
  toast._timeout = setTimeout(() => closeToast(), 5000);
}

function closeToast() {
  const toast = document.getElementById('toast');
  if (!toast) return;
  toast.classList.remove('show');
  setTimeout(() => { toast.style.display = 'none'; }, 350);
}

document.addEventListener('keydown', e => {
  if (e.key === 'Escape') hideModals();
});

document.addEventListener('DOMContentLoaded', () => {
  loadDeliveryConfirmState();
  initMap();
  startCountdown();

  const userMenuBtn = document.querySelector('.user-menu-btn');
  if (userMenuBtn) {
    userMenuBtn.addEventListener('click', e => {
      e.preventDefault();
      const dropdown = document.querySelector('.user-dropdown');
      if (dropdown) dropdown.classList.toggle('show');
    });
  }
});

window.addEventListener('beforeunload', () => {
  if (animationInterval) clearInterval(animationInterval);
  if (countdownInterval) clearInterval(countdownInterval);
});
