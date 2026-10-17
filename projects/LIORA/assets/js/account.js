// ================= ACCOUNTS ACTION PHP ENDPOINT =================
const API_ACCOUNTS_URL = 'accounts_action.php';

async function parseJsonResponse(response) {
  const responseText = await response.text();
  if (!response.ok) {
    throw new Error(`HTTP ${response.status}: ${responseText}`);
  }

  try {
    return JSON.parse(responseText);
  } catch (error) {
    throw new Error(`Invalid JSON response: ${responseText}`);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  const storedUser = localStorage.getItem("lioraUser");
  let user = null;
  try {
    user = storedUser ? JSON.parse(storedUser) : null;
  } catch (error) {
    localStorage.removeItem("lioraUser");
  }
  const serverLoggedIn = window.isLoggedIn === true || window.isLoggedIn === 'true';
  const accountUser = serverLoggedIn && window.accountUser ? window.accountUser : user;

  if (serverLoggedIn && !user && window.accountUser) {
    localStorage.setItem("lioraUser", JSON.stringify(window.accountUser));
  }

  const popup = document.getElementById("login-popup");
  const btn = document.getElementById("go-login-btn");

  // ================= PROTECTION =================
  if (!serverLoggedIn && !user) {
    if (popup) {
      popup.style.display = "flex";

      if (btn) {
        btn.addEventListener("click", () => {
          window.location.href = "login-register.php";
        });
      }
    }
    return; // STOP everything else
  }

  // ================= SHOW USER DATA =================
  const activeUser = accountUser || user || {};
  const dashboardTitle = document.querySelector("#dashboard .tab__header");
  if (dashboardTitle) {
    dashboardTitle.textContent = `Hello ${activeUser.firstName || activeUser.username || 'Guest'}`;
  }

  // ================= TAB SWITCHING =================
  const tabs = document.querySelectorAll(".account__tab");
  const contents = document.querySelectorAll(".tab__content");

  function activateAccountTab(target) {
    const targetTab = Array.from(tabs).find(tab => tab.getAttribute("data-target") === target);
    if (!targetTab) return;

    tabs.forEach(t => t.classList.remove("active-tab"));
    contents.forEach(c => c.classList.remove("active-tab"));

    targetTab.classList.add("active-tab");
    const section = target.startsWith('#') ? document.getElementById(target.slice(1)) : document.querySelector(target);
    if (section) section.classList.add("active-tab");

    if (target === '#orders' && typeof window.refreshOrdersList === 'function') {
      window.refreshOrdersList();
    }

    if (target === '#reward-points' && typeof window.refreshRewardPoints === 'function') {
      window.refreshRewardPoints();
    }

    if (target === '#account-search-history' && typeof window.refreshSearchHistory === 'function') {
      window.refreshSearchHistory();
    }
  }

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {
      const target = tab.getAttribute("data-target");
      if (target) activateAccountTab(target);
    });
  });

  document.querySelectorAll(".account-jump[data-target]").forEach(link => {
    link.addEventListener("click", () => {
      activateAccountTab(link.getAttribute("data-target"));
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });

  // ================= AUTO-ACTIVATE TAB FROM URL & REFRESH =================
  const urlParams = new URLSearchParams(window.location.search);
  const requestedTab = urlParams.get('tab');
  const shouldRefresh = urlParams.get('refresh') === '1';
  const shouldLoadOrders = requestedTab === 'orders';
  const shouldLoadRewards = requestedTab === 'reward-points';
  const shouldLoadSearchHistory = requestedTab === 'search-history' || requestedTab === 'account-search-history' || requestedTab === 'search-history-tab';

  if (requestedTab) {
    const targetTab = Array.from(tabs).find(tab => {
      const target = tab.getAttribute('data-target');
      return target === `#${requestedTab}` || ((requestedTab === 'search-history' || requestedTab === 'search-history-tab') && target === '#account-search-history');
    });

    if (targetTab) {
      activateAccountTab(targetTab.getAttribute("data-target"));
    }
  }

  if (shouldLoadOrders && typeof window.refreshOrdersList === 'function') {
    setTimeout(() => {
      window.refreshOrdersList();
      if (shouldRefresh) {
        showToast("✅ Order list updated!");
      }
    }, 500);
  }

  if (shouldLoadRewards && typeof window.refreshRewardPoints === 'function') {
    window.refreshRewardPoints();
  }

  // ================= LOGOUT =================
  const logoutTab = Array.from(tabs).find(tab => 
    tab.textContent.toLowerCase().trim().includes("logout")
  );

  if (logoutTab) {
    logoutTab.addEventListener("click", () => {
      localStorage.removeItem("lioraUser");
      if (typeof logout === "function") {
        logout();
      } else {
        localStorage.removeItem("lioraUser");
        const formData = new FormData();
        formData.append("action", "logout");
        fetch("auth_handler.php", {
          method: "POST",
          credentials: "same-origin",
          body: formData
        }).finally(() => {
          window.location.href = "index.php";
        });
      }
    });
  }

  // ================= DELETE ORDER =================
  const ordersTbody = document.getElementById("orders-tbody");
  const noOrdersMsg = document.getElementById("no-orders");

  async function postAccountAction(formData) {
    const response = await fetch(API_ACCOUNTS_URL, {
      method: "POST",
      credentials: "same-origin",
      cache: 'no-store',
      headers: {
        "Accept": "application/json"
      },
      body: formData
    });

    return parseJsonResponse(response);
  }

  if (ordersTbody) {
    ordersTbody.addEventListener("click", async function (e) {
      const deleteBtn = e.target.closest(".delete__order");
      if (!deleteBtn) return;

      const row = deleteBtn.closest("tr");
      const orderId = row.getAttribute("data-order-id");

      if (confirm("🗑️ Are you sure you want to remove this order?")) {
        deleteBtn.disabled = true;

        try {
          const formData = new FormData();
          formData.append("action", "delete_order");
          formData.append("order_id", orderId);

          const data = await postAccountAction(formData);
          if (!data.success) {
            showToast("❌ " + (data.message || "Could not remove order."));
            deleteBtn.disabled = false;
            return;
          }
        } catch (error) {
          console.error("Order delete error:", error);
          showToast("❌ Error removing order. Please try again.");
          deleteBtn.disabled = false;
          return;
        }

        row.remove();

        // Check if no orders left
        if (!ordersTbody.querySelector("tr[data-order-id]")) {
          ordersTbody.innerHTML = '<tr><td colspan="5" class="account-empty-row">No active orders. New paid orders will appear here after checkout.</td></tr>';
          if (noOrdersMsg) noOrdersMsg.style.display = "block";
        }
        showToast("✅ Order removed successfully.");
      }
    });
  }

  // ================= SHOW TOAST MESSAGE =================
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

// ================= UPDATE PROFILE (USING PHP ENDPOINT) =================
   const profileForm = document.querySelector("#update-profile form, #profile-form");

   if (profileForm) {
     const firstNameInput = profileForm.querySelector('input[name="first_name"]');
     const lastNameInput  = profileForm.querySelector('input[name="last_name"]');
     const usernameInput  = profileForm.querySelector('input[name="username"]');
     const emailInput     = profileForm.querySelector('input[name="email"]');
     const passwordInput  = profileForm.querySelector('input[name="new_password"]');

    // Prefill safely
    if (firstNameInput) firstNameInput.value = activeUser.firstName || "";
    if (lastNameInput)  lastNameInput.value  = activeUser.lastName  || "";
    if (usernameInput)  usernameInput.value  = activeUser.username  || "";
    if (emailInput)     emailInput.value     = activeUser.email     || "";

    profileForm.addEventListener("submit", async function (e) {
      e.preventDefault();

      const firstName = firstNameInput ? firstNameInput.value.trim() : "";
      const lastName  = lastNameInput  ? lastNameInput.value.trim()  : "";
      const username  = usernameInput  ? usernameInput.value.trim()  : "";
      const email     = emailInput     ? emailInput.value.trim()     : "";
      const password  = passwordInput  ? passwordInput.value : "";

      if (!username || !email) {
        showToast("⚠️ Username and email are required!");
        return;
      }

      // Call PHP endpoint for server-side update
      try {
        const formData = new FormData();
        formData.append('action', 'update_profile');
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        formData.append('username', username);
        formData.append('email', email);
        if (password) {
            formData.append('new_password', password);
        }

        const data = await postAccountAction(formData);

        if (data.success) {
          // Update localStorage as backup
          let currentUser = {};
          try {
            currentUser = JSON.parse(localStorage.getItem("lioraUser")) || {};
          } catch (error) {
            currentUser = {};
          }
          const updatedUser = { 
            ...currentUser, 
            firstName, 
            lastName, 
            username, 
            email 
          };
          localStorage.setItem("lioraUser", JSON.stringify(updatedUser));

          showToast("✅ " + (data.message || "Profile updated successfully!"));
          
          // Update dashboard title live
          if (dashboardTitle) {
            dashboardTitle.textContent = `Hello ${firstName || username}`;
          }

          // Clear password field
          if (passwordInput) passwordInput.value = "";
        } else {
          showToast("❌ " + (data.message || 'Failed to update profile'));
        }
      } catch (error) {
        console.error('Profile update error:', error);
        showToast("❌ Error updating profile. Please try again.");
      }
    });
   }

  // ================= REFRESH ORDERS LIST (called after checkout) =================
  window.refreshOrdersList = async function() {
    const ordersTbody = document.getElementById('orders-tbody');
    if (!ordersTbody) return;

    try {
      const formData = new FormData();
      formData.append('action', 'get_orders');

      const data = await postAccountAction(formData);
      if (!data.success || !data.orders) {
        console.warn('Failed to refresh orders:', data.message);
        return;
      }

      // Clear the table so stale rows / cached no-orders messages are removed
      ordersTbody.innerHTML = '';

      if (data.orders.length === 0) {
        ordersTbody.innerHTML = '<tr><td colspan="5" class="account-empty-row">No active orders. New paid orders will appear here after checkout.</td></tr>';
        return;
      }

      // Add new orders
      data.orders.forEach(order => {
        const status = String(order.status || '');
        const displayStatus = status ? status.charAt(0).toUpperCase() + status.slice(1) : 'Pending';
        const orderNumber = escapeHtml(order.order_number);
        const formattedDate = escapeHtml(order.formatted_date);
        const deleteButton = order.editable ? `
            <button class="delete__order" title="Remove Order">
              <i class="fi fi-rs-trash"></i>
            </button>
        ` : '';
        const tr = document.createElement('tr');
        tr.setAttribute('data-order-id', order.id);
        tr.innerHTML = `
          <td><strong>#${orderNumber}</strong></td>
          <td>${formattedDate}</td>
          <td><span class="account-status account-status--${escapeHtml(status.toLowerCase())}">${escapeHtml(displayStatus)}</span></td>
          <td><strong>$${parseFloat(order.total).toFixed(2)}</strong></td>
          <td>
            <div class="account-row-actions">
              <a href="order_details.php?order_id=${order.id}" class="view__order">View</a>
              <a href="deliveryMap.php?order_id=${order.id}" class="view__order view__order--track">Track</a>
              ${deleteButton}
            </div>
          </td>
        `;
        ordersTbody.appendChild(tr);
      });
    } catch (error) {
      console.error('Error refreshing orders:', error);
    }
  };

  window.refreshRewardPoints = async function() {
    const pointsEl = document.getElementById('account-reward-points');
    const ordersEl = document.getElementById('account-reward-orders');
    if (!pointsEl) return;

    try {
      const formData = new FormData();
      formData.append('action', 'get_rewards_summary');
      const data = await postAccountAction(formData);
      if (data && data.success) {
        pointsEl.textContent = String(parseInt(data.total_points, 10) || 0);
        window.userRewardPoints = parseInt(data.total_points, 10) || 0;

        if (ordersEl) {
          if (!data.orders || data.orders.length === 0) {
            ordersEl.innerHTML = '<p class="account-rewards__empty">Paid orders will appear here with the points they earned.</p>';
          } else {
            ordersEl.innerHTML = '<h3>Point History</h3>' + data.orders.map(order => `
              <div class="account-reward-order">
                <div>
                  <strong>#${escapeHtml(order.order_number)}</strong>
                  <span>${escapeHtml(order.formatted_date)} · $${parseFloat(order.total).toFixed(2)}</span>
                </div>
                <p>+${parseInt(order.points_earned, 10) || 0} points</p>
              </div>
            `).join('');
          }
        }
      }
    } catch (error) {
      console.error('Error refreshing reward points:', error);
    }
  };

  if (shouldLoadOrders && typeof window.refreshOrdersList === 'function') {
    setTimeout(() => {
      window.refreshOrdersList();
      if (shouldRefresh) {
        showToast("✅ Order list updated!");
      }
    }, 100);
  }

  if (shouldLoadRewards && typeof window.refreshRewardPoints === 'function') {
    window.refreshRewardPoints();
  }

  // ================= SEARCH HISTORY =================
  function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    }[char]));
  }

  async function postSearchHistoryAction(action, query = '') {
    const payload = new URLSearchParams();
    payload.append('action', action);
    if (query) payload.append('query', query);

    const response = await fetch('search_history.php', {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'Accept': 'application/json'
      },
      body: payload
    });

    return parseJsonResponse(response);
  }

  window.refreshSearchHistory = async function() {
    const historyListEl = document.getElementById('account-search-history-list');
    if (!historyListEl) return;

    try {
      const response = await fetch('search_history.php?action=fetch', {
        method: 'GET',
        credentials: 'same-origin'
      });
      const data = await response.json();
      
      if (data && data.success) {
        if (!data.history || data.history.length === 0) {
          historyListEl.innerHTML = '<p class="account-rewards__empty">No search history found 🔍</p>';
          return;
        }

        historyListEl.innerHTML = data.history.map(query => {
          const safeQuery = escapeHtml(query);
          return `
          <div class="account-search-item">
            <div class="account-search-item__query">
              <i class="fi fi-rs-search"></i>
              <span>${safeQuery}</span>
            </div>
            <div class="account-search-item__actions">
              <a href="search.php?q=${encodeURIComponent(query)}" class="view__order">Search Again</a>
              <button class="delete-history-item" data-query="${safeQuery}" title="Remove search">
                <i class="fi fi-rs-trash"></i>
              </button>
            </div>
          </div>
        `;
        }).join('');

        // Attach delete event to items
        historyListEl.querySelectorAll('.delete-history-item').forEach(btn => {
          btn.addEventListener('click', async function() {
            const query = this.dataset.query;
            if (typeof removeSearchHistory === 'function') {
              await removeSearchHistory(query);
            } else {
              await postSearchHistoryAction('remove', query);
              await window.refreshSearchHistory();
            }
            showToast("Removed search item");
          });
        });
      }
    } catch (error) {
      console.error('Error refreshing search history:', error);
      historyListEl.innerHTML = '<p class="error-text">Failed to load history.</p>';
    }
  };

  const clearAllBtn = document.getElementById('clear-all-history');
  if (clearAllBtn) {
    clearAllBtn.addEventListener('click', async function() {
      if (!confirm("Are you sure you want to clear your entire search history?")) return;
      
      try {
        if (typeof clearAllSearchHistory === 'function') {
          await clearAllSearchHistory();
        } else {
          await postSearchHistoryAction('clear_all');
          await window.refreshSearchHistory();
        }
        showToast("Search history cleared!");
      } catch (error) {
        console.error('Clear search history error:', error);
        showToast("Could not clear search history.");
      }
    });
  }

  if (shouldLoadSearchHistory && typeof window.refreshSearchHistory === 'function') {
    window.refreshSearchHistory();
  }
});
