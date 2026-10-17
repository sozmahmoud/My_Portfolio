/* admin.js - Admin Dashboard Logic */

document.addEventListener("DOMContentLoaded", function() {
    // Update live time
    function updateTime() {
        const now = new Date();
        const timeStr = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        const dateStr = now.toLocaleDateString([], { weekday: 'short', month: 'short', day: 'numeric' });
        const target = document.getElementById('live-time');
        if (target) target.innerHTML = `<span class="time">${timeStr}</span> <span class="date">${dateStr}</span> 🌸`;
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Initialize Charts
    initCharts();

    // Add active state to nav links based on hash
    window.addEventListener('hashchange', () => {
        const links = document.querySelectorAll('.nav-link');
        links.forEach(l => l.classList.remove('active'));
        const activeLink = document.querySelector(`.nav-link[href="${window.location.hash}"]`);
        if (activeLink) activeLink.classList.add('active');
    });
});

let globalChartData = null;
let productsChart = null;
let salesChart = null;

async function initCharts() {
    try {
        const response = await fetch('admin_data.php?action=stats');
        globalChartData = await response.json();

        // Render both charts with default timeframes
        renderSalesChart('weekly');
        renderProductsChart('weekly');

    } catch (error) {
        console.error('Failed to load chart data:', error);
    }
}

function renderSalesChart(timeframe) {
    const ctxSales = document.getElementById('salesChart').getContext('2d');
    const data = timeframe === 'weekly' ? globalChartData.weekly_sales : globalChartData.monthly_sales;
    
    if (salesChart) salesChart.destroy();

    const salesGradient = ctxSales.createLinearGradient(0, 0, 0, 400);
    salesGradient.addColorStop(0, 'rgba(193, 78, 143, 0.4)');
    salesGradient.addColorStop(1, 'rgba(193, 78, 143, 0)');

    salesChart = new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: data.map(d => d.label),
            datasets: [{
                label: 'Revenue ($)',
                data: data.map(d => d.value),
                borderColor: '#c14e8f',
                backgroundColor: salesGradient,
                fill: true,
                tension: 0.4,
                borderWidth: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#c14e8f',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#333',
                    bodyColor: '#666',
                    borderColor: '#c14e8f',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                    ticks: { callback: value => '$' + value }
                },
                x: { grid: { display: false } }
            }
        }
    });
}

function toggleSalesTimeframe(timeframe) {
    // Find the chart-toggle container in the sales chart section
    const salesContainer = document.querySelector('.charts-row .chart-container:first-child');
    const toggleContainer = salesContainer.querySelector('.chart-toggle');
    
    if (!toggleContainer) {
        console.error('Sales chart toggle container not found');
        return;
    }
    
    // Update button active states based on timeframe
    const btns = toggleContainer.querySelectorAll('button');
    btns.forEach(btn => {
        const btnTimeframe = btn.textContent.toLowerCase().includes('week') ? 'weekly' : 'monthly';
        if (btnTimeframe === timeframe) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
    
    // Render the chart with the selected timeframe
    renderSalesChart(timeframe);
}

function renderProductsChart(timeframe) {
    const ctxProducts = document.getElementById('productsChart').getContext('2d');
    const data = timeframe === 'weekly' ? globalChartData.top_weekly : globalChartData.top_monthly;
    
    if (productsChart) productsChart.destroy();

    if (data.length === 0) {
        // Show empty state if no sales
        const ctx = ctxProducts;
        ctx.font = "14px 'Outfit'";
        ctx.fillStyle = "#666";
        ctx.textAlign = "center";
        ctx.fillText("No sales data yet 🌸", ctx.canvas.width / 2, ctx.canvas.height / 2);
        return;
    }

    productsChart = new Chart(ctxProducts, {
        type: 'doughnut',
        data: {
            labels: data.map(p => p.name),
            datasets: [{
                data: data.map(p => p.sold),
                backgroundColor: [
                    '#c14e8f', '#ff85b3', '#ffb6d9', '#ffd6e7', '#fce4ec'
                ],
                hoverOffset: 15,
                borderWidth: 5,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { 
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, family: "'Outfit', sans-serif" }
                    } 
                }
            },
            cutout: '70%',
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
}

function toggleProductTimeframe(timeframe) {
    // Find the chart-toggle container in the products chart section (more specific)
    const productsContainer = document.querySelector('.charts-row .chart-container:last-child');
    const toggleContainer = productsContainer ? productsContainer.querySelector('.chart-toggle') : null;
    
    if (!toggleContainer) {
        console.error('Products chart toggle container not found');
        return;
    }
    
    // Update button active states based on timeframe
    const btns = toggleContainer.querySelectorAll('button');
    btns.forEach(btn => {
        const btnTimeframe = btn.textContent.toLowerCase().includes('week') ? 'weekly' : 'monthly';
        if (btnTimeframe === timeframe) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
    
    // Render the chart with the selected timeframe
    renderProductsChart(timeframe);
}

// Action Handlers
async function postAction(action, data) {
    const formData = new FormData();
    formData.append('action', action);
    for (const key in data) {
        formData.append(key, data[key]);
    }

    try {
        const response = await fetch('admin_action.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();
        
        if (result.success) {
            showToast("success", result.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast("error", result.message);
        }
    } catch (error) {
        showToast("error", "Something went wrong.");
    }
}

function handleUser(type, id) {
    const action = type === 'approve' ? 'approve_user' : 'reject_user';
    const confirmMsg = type === 'approve' ? "Approve this user?" : "Reject and delete this user?";
    if (confirm(confirmMsg)) {
        postAction(action, { id });
    }
}

function handleOrder(type, id) {
    if (type === 'accept') {
        if (confirm("Accept this order and mark as paid?")) {
            postAction('update_order_status', { id, status: 'paid' });
        }
    }
}

function updateOrderStatus(id, status) {
    postAction('update_order_status', { id, status });
}

function deleteUser(id) {
    if (confirm("Are you sure you want to delete this user? All their data will be removed.")) {
        postAction('delete_user', { id });
    }
}

function deleteOrder(id) {
    if (confirm("Cancel this order? Record will be preserved for history.")) {
        postAction('delete_order', { id });
    }
}

function addProduct() {
    const name = prompt("Product Name:");
    if (!name) return;
    const price = prompt("Price ($):");
    if (!price) return;
    const stock = prompt("Stock Quantity:");
    if (!stock) return;
    const category = prompt("Category (e.g. Roses, Lilies):");
    if (!category) return;
    const image_url = prompt("Image URL (relative to root):", "assets/img/products/product-1.jpg");
    if (!image_url) return;

    postAction('add_product', { name, price, stock, category, image_url });
}

function editReview(id, currentComment, currentRating) {
    const newComment = prompt("Edit Review Comment:", currentComment);
    if (newComment === null) return;
    
    const newRating = prompt("Edit Rating (1-5):", currentRating);
    if (newRating === null) return;

    postAction('edit_review', { id, comment: newComment, rating: newRating });
}

function editProduct(id, currentName, currentPrice, currentStock) {
    const newName = prompt("Edit Product Name:", currentName);
    if (newName === null) return;
    
    const newPrice = prompt("Edit Price ($):", currentPrice);
    if (newPrice === null) return;

    const newStock = prompt("Edit Stock Quantity:", currentStock);
    if (newStock === null) return;

    postAction('update_product', { id, name: newName, price: newPrice, stock: newStock });
}

function deleteProduct(id) {
    if (confirm("Permanently delete this product?")) {
        postAction('delete_product', { id });
    }
}

function deleteReview(id) {
    if (confirm("Permanently delete this review?")) {
        postAction('delete_review', { id });
    }
}

function updateSupportStatus(id, status) {
    postAction('update_support_status', { id, status });
}

function deleteSupportMessage(id) {
    if (confirm("Permanently delete this support message?")) {
        postAction('delete_support_message', { id });
    }
}

function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `toast toast--${type}`;
    toast.innerHTML = `
        <div class="toast__icon">${type === 'success' ? '🌸' : '⚠️'}</div>
        <div class="toast__message">${message}</div>
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

async function logout() {
    const formData = new FormData();
    formData.append("action", "logout");

    try {
      const response = await fetch("auth_handler.php", {
        method: "POST",
        body: formData
      });

      const data = await response.json();
      if (data.success) {
        window.location.href = "index.php";
      }
    } catch (error) {
      window.location.href = "index.php";
    }
}
