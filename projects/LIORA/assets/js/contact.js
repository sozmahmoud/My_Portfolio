document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contact-support-form");
  const notice = document.getElementById("contact-form-notice");

  if (!form || !notice) return;

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    if (!form.checkValidity()) {
      form.reportValidity();
      return;
    }

    const submitButton = form.querySelector("button[type='submit']");
    const originalText = submitButton ? submitButton.textContent : "";
    if (submitButton) {
      submitButton.disabled = true;
      submitButton.textContent = "Sending...";
    }

    notice.className = "contact-form-notice";
    notice.textContent = "";

    try {
      const response = await fetch("contact_action.php", {
        method: "POST",
        body: new FormData(form),
        credentials: "same-origin"
      });
      const data = await response.json();

      notice.classList.add(data.success ? "is-success" : "is-error");
      notice.textContent = data.message || "Something went wrong.";

      if (data.success) {
        form.reset();
      }
    } catch (error) {
      notice.classList.add("is-error");
      notice.textContent = "Connection error. Please try again.";
    } finally {
      if (submitButton) {
        submitButton.disabled = false;
        submitButton.textContent = originalText;
      }
    }
  });
});
