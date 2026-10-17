document.addEventListener("DOMContentLoaded", function () {

  const months = document.querySelectorAll(".calendar__month-title");
  const popup = document.getElementById("mini-calendar");
  const miniDays = document.getElementById("mini-days");
  const miniTitle = document.getElementById("mini-title");
  const closeBtn = document.getElementById("close-mini");
  const okBtn = document.getElementById("ok-mini");
  const historyList = document.getElementById("calendar-history-list");
  const clearHistoryBtn = document.getElementById("clear-history");

  // Form elements
  const eventForm = document.getElementById("event-form");
  const eventNameInput = document.getElementById("event-name");
  const eventDateInput = document.getElementById("event-date");
  const eventTypeInput = document.getElementById("event-type");

  let selectedDay = null;
  let currentMonth = "";
  let specialDates = [];

  const API_URL = "special_dates_action.php";

  const daysInMonth = {
    January: 31,
    February: 28,
    March: 31,
    April: 30,
    May: 31,
    June: 30,
    July: 31,
    August: 31,
    September: 30,
    October: 31,
    November: 30,
    December: 31
  };

  const monthNames = ["January", "February", "March", "April", "May", "June",
                      "July", "August", "September", "October", "November", "December"];

  // ================= DATABASE FUNCTIONS =================
  async function requestSpecialDates(action, data = {}) {
    const formData = new FormData();
    formData.append("action", action);

    Object.keys(data).forEach(key => {
      formData.append(key, data[key]);
    });

    const response = await fetch(API_URL, {
      method: "POST",
      body: formData,
      credentials: "same-origin"
    });

    return response.json();
  }

  function escapeHtml(value) {
    const div = document.createElement("div");
    div.textContent = value || "";
    return div.innerHTML;
  }

  function getDateParts(eventDate) {
    const parts = (eventDate || "").split("-");
    if (parts.length !== 3) {
      return null;
    }

    const monthIndex = parseInt(parts[1], 10) - 1;
    const day = parseInt(parts[2], 10);

    if (monthIndex < 0 || monthIndex > 11 || !day) {
      return null;
    }

    return {
      month: monthNames[monthIndex],
      day: day
    };
  }

  function setSpecialDates(items) {
    specialDates = Array.isArray(items) ? items : [];
    renderHistory();
    highlightSavedDates();
  }

  async function loadSpecialDates() {
    try {
      const data = await requestSpecialDates("get");

      if (!data.success) {
        historyList.innerHTML = '<p class="calendar__history-empty">Please log in to save and load your special moments 🌸</p>';
        clearHistoryBtn.style.display = "none";
        return;
      }

      setSpecialDates(data.items);
    } catch (error) {
      console.error("Calendar load error:", error);
      historyList.innerHTML = '<p class="calendar__history-empty">Could not load your special moments right now.</p>';
      clearHistoryBtn.style.display = "none";
    }
  }

  async function addToHistory(eventName, eventDate, occasionType = "Special Moment") {
    const data = await requestSpecialDates("add", {
      event_name: eventName || "Special Moment",
      event_date: eventDate,
      occasion_type: occasionType
    });

    if (!data.success) {
      alert(data.message || "Could not save your special moment.");
      return false;
    }

    setSpecialDates(data.items);
    return true;
  }

  async function removeFromHistory(id) {
    const data = await requestSpecialDates("remove", { id: id });

    if (!data.success) {
      alert(data.message || "Could not remove your special moment.");
      return;
    }

    setSpecialDates(data.items);
  }

  async function clearAllHistory() {
    const data = await requestSpecialDates("clear");

    if (!data.success) {
      alert(data.message || "Could not clear your flower moments history.");
      return;
    }

    setSpecialDates([]);
  }

  function renderHistory() {
    if (specialDates.length === 0) {
      historyList.innerHTML = '<p class="calendar__history-empty">No special moments selected yet 🌸 Click on any day to add one!</p>';
      clearHistoryBtn.style.display = "none";
      return;
    }

    clearHistoryBtn.style.display = "inline-block";

    let html = "";
    specialDates.forEach(item => {
      html += `
        <div class="calendar__history-item" data-id="${item.id}">
          <div class="calendar__history-info">
            <span class="calendar__history-date">📅 ${escapeHtml(item.dateString)}</span>
            <span class="calendar__history-name">${escapeHtml(item.eventName)}</span>
            <span class="calendar__history-badge">${escapeHtml(item.eventType || "Special Moment")}</span>
          </div>
          <button class="calendar__history-delete" title="Remove this moment">🗑️</button>
        </div>
      `;
    });

    historyList.innerHTML = html;

    document.querySelectorAll(".calendar__history-delete").forEach(btn => {
      btn.addEventListener("click", (e) => {
        const item = e.target.closest(".calendar__history-item");
        const id = parseInt(item.dataset.id, 10);
        removeFromHistory(id);
      });
    });
  }

  function buildDateFromMonthDay(monthName, day) {
    const year = new Date().getFullYear();
    const monthNumber = monthNames.indexOf(monthName) + 1;

    if (monthNumber <= 0 || !day) {
      return "";
    }

    return year + "-" + String(monthNumber).padStart(2, "0") + "-" + String(day).padStart(2, "0");
  }

  // ================= FORM SUBMIT - HIGHLIGHT ON CALENDAR =================
  eventForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const eventName = eventNameInput.value.trim();
    const eventDate = eventDateInput.value; // format: YYYY-MM-DD
    const eventType = eventTypeInput.value;

    if (!eventDate) {
      alert("Please select a date! 📅");
      return;
    }

    const saved = await addToHistory(eventName, eventDate, eventType);
    if (!saved) {
      return;
    }

    eventForm.reset();
    alert("🌸 Special moment saved! Check your calendar and history below.");
  });

  function highlightSavedDates() {
    document.querySelectorAll(".calendar__mini span").forEach(day => {
      day.classList.remove("selected");
    });

    specialDates.forEach(item => {
      const dateParts = getDateParts(item.eventDate);
      if (dateParts) {
        highlightDateOnCalendar(dateParts.month, dateParts.day);
      }
    });
  }

  function highlightDateOnCalendar(monthName, day) {
    // Find the card for this month
    const cards = document.querySelectorAll(".calendar__card");
    cards.forEach(card => {
      const cardMonth = card.dataset.month;
      if (cardMonth === monthName) {
        const days = card.querySelectorAll(".calendar__mini span");
        days.forEach(d => {
          if (parseInt(d.textContent, 10) === day) {
            d.classList.add("selected");
          }
        });
      }
    });
  }

  function dateExists(monthName, day) {
    return specialDates.some(item => {
      const dateParts = getDateParts(item.eventDate);
      return dateParts && dateParts.month === monthName && dateParts.day === day;
    });
  }

  // ================= OPEN CALENDAR POPUP =================
  months.forEach(month => {
    month.addEventListener("click", () => {
      currentMonth = month.textContent.replace("🌸", "").trim();
      miniTitle.textContent = currentMonth + " 🌷";

      miniDays.innerHTML = "";
      selectedDay = null;

      const totalDays = daysInMonth[currentMonth];

      for (let i = 1; i <= totalDays; i++) {
        const day = document.createElement("span");
        day.textContent = i;

        if (dateExists(currentMonth, i)) {
          day.classList.add("selected");
        }

        day.addEventListener("click", async () => {
          const eventDate = buildDateFromMonthDay(currentMonth, i);
          
          // Toggle logic: if already selected, REMOVE it; otherwise ADD it
          if (day.classList.contains("selected")) {
            // Toggle OFF - remove from specialDates and remove highlight
            const existingItem = specialDates.find(item => item.eventDate === eventDate);
            if (existingItem) {
              day.classList.add("disabled"); // Disable to prevent double-clicks
              await removeFromHistory(existingItem.id);
              day.classList.remove("selected"); // Remove the visual highlight
              day.classList.remove("disabled");
            }
          } else {
            // Toggle ON - add to specialDates and add highlight
            day.classList.add("disabled");
            await addToHistory("Selected from Calendar", eventDate);
            day.classList.add("selected"); // Add the visual highlight
            day.classList.remove("disabled");
          }
        });

        miniDays.appendChild(day);
      }

      popup.style.display = "flex";
    });
  });

  // ================= OK BUTTON - SAVE AND CLOSE =================
  okBtn.addEventListener("click", () => {
    // Close the popup - all changes are saved immediately on day click
    popup.style.display = "none";
  });

  // ================= CLOSE BUTTON =================
  closeBtn.addEventListener("click", () => {
    popup.style.display = "none";
  });

  // ================= CLICK OUTSIDE TO CLOSE =================
  popup.addEventListener("click", (e) => {
    if (e.target === popup) {
      popup.style.display = "none";
    }
  });

  // ================= OUTSIDE MINI CALENDAR CLICK =================
  document.querySelectorAll(".calendar__mini span").forEach(day => {
    day.addEventListener("click", async () => {
      const card = day.closest(".calendar__card");
      const monthTitle = card.dataset.month;
      const dayNumber = parseInt(day.textContent, 10);
      const eventDate = buildDateFromMonthDay(monthTitle, dayNumber);

      // Toggle logic: if date exists, remove it; otherwise add it
      const existingItem = specialDates.find(item => item.eventDate === eventDate);
      
      if (existingItem) {
        // Date already exists - REMOVE it
        await removeFromHistory(existingItem.id);
      } else {
        // Date doesn't exist - ADD it
        await addToHistory("Quick Select", eventDate);
      }
    });
  });

  // ================= CLEAR HISTORY BUTTON =================
  clearHistoryBtn.addEventListener("click", () => {
    if (confirm("Are you sure you want to clear all your flower moments history? 🌸")) {
      clearAllHistory();
    }
  });

  loadSpecialDates();

});
