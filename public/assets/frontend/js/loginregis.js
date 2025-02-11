// Fungsi untuk toggle password
function setupTogglePassword(inputId, toggleId) {
  const passwordInput = document.getElementById(inputId);
  const togglePassword = document.getElementById(toggleId);

  togglePassword.addEventListener('click', function () {
    // Toggle the type attribute
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

    // Toggle the icon class
    this.classList.toggle('bxs-lock-alt');
    this.classList.toggle('bxs-lock-open-alt');
  });
}

// Tambahkan event listener untuk setiap input password
setupTogglePassword('password_login', 'togglePassword_login');
setupTogglePassword('password_register', 'togglePassword_register');
// setupTogglePassword('password_confirmation', 'togglePassword_confirmation');

// Untuk toggle register dan login
const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click', () => {
  container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
  container.classList.remove('active');
});
