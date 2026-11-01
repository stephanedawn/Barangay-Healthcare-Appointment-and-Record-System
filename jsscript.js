// ================== FULL JAVASCRIPT FUNCTIONALITY ==================
let users = JSON.parse(localStorage.getItem('users'));

// Initialize default users and save to localStorage if it's the first time
if (!users) {
  users = [
    { username: "admin", password: "admin123", role: "admin" },
    { username: "patient", password: "patient123", role: "patient" }
  ];
  localStorage.setItem('users', JSON.stringify(users));
}

// Show signup form
function showSignup() {
  document.getElementById("loginForm").style.display = "none";
  document.getElementById("signupForm").style.display = "block";
}

// Show login form
function showLogin() {
  document.getElementById("signupForm").style.display = "none";
  document.getElementById("loginForm").style.display = "block";
}

// Toggle password visibility
function togglePassword(inputId, iconId) {
  const pass = document.getElementById(inputId);
  const eye = document.getElementById(iconId);

  if (pass.type === "password") {
    pass.type = "text";
    eye.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    pass.type = "password";
    eye.classList.replace("fa-eye-slash", "fa-eye");
  }
}

// Signup function
function signup() {
  let username = document.getElementById("signupUsername").value;
  let password = document.getElementById("signupPassword").value;
  let confirm = document.getElementById("confirmPassword").value;
  let role = document.getElementById("signupRole").value;

  if (!username || !password || !confirm || !role) {
    showToast("Fill all fields", "error");
    return;
  }

  if (password !== confirm) {
    showToast("Passwords do not match", "error");
    return;
  }

  if (users.find(u => u.username === username)) {
    showToast("Username already exists", "error");
    return;
  }

  users.push({ username, password, role });
  localStorage.setItem('users', JSON.stringify(users));
  showToast("Account Created Successfully!");
  showLogin();
}

// Login function
async function login() {
    const loginForm = document.getElementById('loginForm');
    const formData = new FormData(loginForm);

    // Append values from elements that don't have a name attribute
    formData.append('username', document.getElementById('loginUsername').value);
    formData.append('password', document.getElementById('loginPassword').value);
    formData.append('role', document.getElementById('loginRole').value);

    try {
        const response = await fetch('php/login.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            showToast(result.message);
            // Store user info in session storage to persist login
            sessionStorage.setItem('loggedInUser', JSON.stringify({ username: formData.get('username'), role: result.role }));

            // Redirect based on role
            if (result.role === "admin") {
                window.location.href = "admin-dashboard.html";
            } else {
                window.location.href = "patient-dashboard.html";
            }
        } else {
            showToast(result.message, true); // Show error toast
        }
    } catch (error) {
        console.error('Error:', error);
        showToast('An error occurred during login. Please check the console.', true);
    }
}

// Logout function
function logout() {
  sessionStorage.removeItem('loggedInUser');
  // Redirect back to the login page (index.html)
  window.location.href = "index.html";
}

function showToast(message, isError = false) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.className = isError ? 'toast show error' : 'toast show';
  setTimeout(() => toast.className = 'toast', 3000);
}

// ======= DASHBOARD SECTION NAVIGATION =======
function showPatient(sectionId, el) {
  document.querySelectorAll('#patientDashboard .section').forEach(sec => sec.classList.remove('active'));
  document.getElementById(sectionId).classList.add('active');
  document.querySelectorAll('#patientDashboard .sidebar a').forEach(a => a.classList.remove('active-link'));
  el.classList.add('active-link');

  // Reload dashboard data on every navigation to ensure counts are always up-to-date
}

function showAdmin(sectionId, el) {
  document.querySelectorAll('#adminDashboard .section').forEach(sec => sec.classList.remove('active'));
  document.getElementById(sectionId).classList.add('active');
  
  // Add active link highlighting
  document.querySelectorAll('#adminDashboard .sidebar a').forEach(a => a.classList.remove('active-link'));
  el.classList.add('active-link');

  // Load master dashboard if that section is selected
  // Always reload dashboard counts to reflect latest changes from other users (e.g., patient submissions)
  loadAdminDashboard();

  if (sectionId === 'masterDashboard') {
    loadMasterDashboard();
  }
  if (sectionId === 'adminAppointments') {
    loadAdminAppointments();
  }
}

// ======= DATA STORAGE =======
let appointments = JSON.parse(localStorage.getItem('appointments') || '[]');
let fpRecords = JSON.parse(localStorage.getItem('fpRecords') || '[]');
let immunizationRecords = JSON.parse(localStorage.getItem('immunizationRecords') || '[]');
let prenatalRecords = JSON.parse(localStorage.getItem('prenatalRecords') || '[]');

// ======= SUBMIT FORMS =======
function submitAppointment(button) {
  if (button.disabled) return;
  
  // Disable button to prevent double submission
  button.dis
}