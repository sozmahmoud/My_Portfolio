// ===== LOGIN & REGISTER VALIDATION =====

// Select forms
const loginForm = document.getElementById("login-form");
const registerForm = document.getElementById("register-form");
const showForgotPasswordBtn = document.getElementById("show-forgot-password");

// ================= LOGIN =================
if (loginForm) {
  const loginBtn = loginForm.querySelector('button.auth-btn');

  loginForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    // Prevent double submission if already loading
    if (loginBtn && loginBtn.disabled) return;

    const email = loginForm.querySelector('input[name="email"]').value.trim();
    const password = loginForm.querySelector('input[name="password"]').value.trim();
    const messageEl = document.getElementById("login-message");

    // Client-side validation
    if (!email || !password) {
      messageEl.textContent = "🌸 Please fill in all fields!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    if (!validateEmail(email)) {
      messageEl.textContent = "💌 Please enter a valid email!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    if (password.length < 6) {
      messageEl.textContent = "🔒 Password must be at least 6 characters!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    // Set loading state
    if (loginBtn) {
      loginBtn.disabled = true;
      loginBtn.innerHTML = 'Logging in... <span class="loading-spinner">💖</span>';
    }

    // Send to backend
    const formData = new FormData();
    formData.append("action", "login");
    formData.append("email", email);
    formData.append("password", password);

    try {
      const response = await fetch("auth_handler.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin"
      });

      const data = await response.json();

      if (data.success) {
        if (data.user) {
          const user = {
            id: data.user.id,
            username: data.user.username || data.user.name || "",
            name: data.user.name || data.user.username || "",
            email: data.user.email || "",
            firstName: data.user.firstName || ""
          };
          localStorage.setItem("lioraUser", JSON.stringify(user));
        }

        messageEl.textContent = data.message;
        messageEl.style.color = "#27ae60";
        // Redirect to home after 1 second
        setTimeout(() => {
          window.location.href = "index.php";
        }, 1000);
      } else {
        messageEl.textContent = data.message;
        messageEl.style.color = "#e74c3c";
        // Reset button
        if (loginBtn) {
          loginBtn.disabled = false;
          loginBtn.textContent = "Login 💖";
        }
      }
    } catch (error) {
      messageEl.textContent = "❌ Connection error. Please try again.";
      messageEl.style.color = "#e74c3c";
      // Reset button
      if (loginBtn) {
        loginBtn.disabled = false;
        loginBtn.textContent = "Login 💖";
      }
    }
  });
}

// ================= FORGOT PASSWORD =================
const forgotPasswordForm = document.getElementById("forgot-password-form");
const backToLoginBtn = document.getElementById("back-to-login");

if (showForgotPasswordBtn && loginForm && forgotPasswordForm) {
  showForgotPasswordBtn.addEventListener("click", function (e) {
    e.preventDefault();
    loginForm.hidden = true;
    forgotPasswordForm.hidden = false;
    
    // Auto-fill email if already typed in login
    const loginEmail = loginForm.querySelector('input[name="email"]').value.trim();
    const resetEmailInput = forgotPasswordForm.querySelector('input[name="resetEmail"]');
    if (loginEmail && resetEmailInput) {
      resetEmailInput.value = loginEmail;
    }
    if (resetEmailInput) resetEmailInput.focus();
  });
}

if (backToLoginBtn && loginForm && forgotPasswordForm) {
  backToLoginBtn.addEventListener("click", function (e) {
    e.preventDefault();
    forgotPasswordForm.hidden = true;
    loginForm.hidden = false;
    document.getElementById("forgot-password-message").textContent = "";
  });
}

if (forgotPasswordForm) {
  forgotPasswordForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    
    const email = forgotPasswordForm.querySelector('input[name="resetEmail"]').value.trim();
    const messageEl = document.getElementById("forgot-password-message");
    const submitBtn = document.getElementById("forgot-submit-btn");

    if (!email) {
      messageEl.textContent = "🌸 Please enter your email!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    if (!validateEmail(email)) {
      messageEl.textContent = "💌 Please enter a valid email!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    // Loading state
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = "Sending... 💌";
    }

    const formData = new FormData();
    formData.append('action', 'forgot_password');
    formData.append('email', email);

    try {
      const response = await fetch('auth_handler.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      });
      const data = await response.json();
      
      messageEl.textContent = data.message;
      messageEl.style.color = data.success ? '#27ae60' : '#e74c3c';
      
      if (!data.success && submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = "Send Reset Link 🌷";
      }
    } catch (error) {
      messageEl.textContent = '❌ Connection error. Please try again.';
      messageEl.style.color = '#e74c3c';
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = "Send Reset Link 🌷";
      }
    }
  });
}

// ================= REGISTER =================
if (registerForm) {
  const registerBtn = registerForm.querySelector('button.auth-btn');

  registerForm.addEventListener("submit", async function (e) {
    e.preventDefault();
    
    // Prevent double submission if already loading
    if (registerBtn && registerBtn.disabled) return;

    const username = registerForm.querySelector('input[name="username"]').value.trim();
    const email = registerForm.querySelector('input[name="email"]').value.trim();
    const password = registerForm.querySelector('input[name="password"]').value.trim();
    const confirmPassword = registerForm.querySelector('input[name="confirmPassword"]').value.trim();
    const messageEl = document.getElementById("register-message");

    // Client-side validation
    if (!username || !email || !password || !confirmPassword) {
      messageEl.textContent = "🌸 Please fill in all fields!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    if (username.length < 3) {
      messageEl.textContent = "👤 Username must be at least 3 characters!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    if (!validateEmail(email)) {
      messageEl.textContent = "💌 Invalid email format!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    if (password.length < 6) {
      messageEl.textContent = "🔒 Password must be at least 6 characters!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    if (password !== confirmPassword) {
      messageEl.textContent = "❌ Passwords do not match!";
      messageEl.style.color = "#e74c3c";
      return;
    }

    // Set loading state
    if (registerBtn) {
      registerBtn.disabled = true;
      registerBtn.innerHTML = 'Registering... <span class="loading-spinner">✨</span>';
    }

    // Send to backend
    const formData = new FormData();
    formData.append("action", "register");
    formData.append("username", username);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("confirmPassword", confirmPassword);

    try {
      const response = await fetch("auth_handler.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin"
      });

      const data = await response.json();

      if (data.success) {
        messageEl.textContent = data.message;
        messageEl.style.color = "#27ae60";
        // Clear form
        registerForm.reset();
        // Redirect to login after 1.5 seconds
        setTimeout(() => {
          window.location.href = "login-register.php";
        }, 1500);
      } else {
        messageEl.textContent = data.message;
        messageEl.style.color = "#e74c3c";
        // Reset button
        if (registerBtn) {
          registerBtn.disabled = false;
          registerBtn.textContent = "Register 🌼";
        }
      }
    } catch (error) {
      messageEl.textContent = "❌ Connection error. Please try again.";
      messageEl.style.color = "#e74c3c";
      // Reset button
      if (registerBtn) {
        registerBtn.disabled = false;
        registerBtn.textContent = "Register 🌼";
      }
    }
  });
}

// ================= EMAIL VALIDATION =================
function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email);
}
