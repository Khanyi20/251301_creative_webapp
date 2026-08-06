document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('registerForm');
  const usernameInput = document.getElementById('username');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const confirmInput = document.getElementById('confirmPassword');
  const errorMsg = document.getElementById('errorMsg');
  const backBtn = document.getElementById('backBtn');

  const allInputs = [usernameInput, emailInput, passwordInput, confirmInput];

  function clearInvalid() {
    allInputs.forEach(function (input) {
      input.classList.remove('invalid');
    });
  }

  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    clearInvalid();
    let message = '';

    if (!usernameInput.value.trim()) {
      message = 'Please enter a username.';
      usernameInput.classList.add('invalid');
    } else if (!emailInput.value.trim() || !emailPattern.test(emailInput.value.trim())) {
      message = 'Please enter a valid email address.';
      emailInput.classList.add('invalid');
    } else if (!passwordInput.value.trim() || passwordInput.value.trim().length < 6) {
      message = 'Password must be at least 6 characters.';
      passwordInput.classList.add('invalid');
    } else if (confirmInput.value.trim() !== passwordInput.value.trim()) {
      message = 'Passwords do not match.';
      confirmInput.classList.add('invalid');
    }

    if (message) {
      errorMsg.textContent = message;
      return;
    }

    errorMsg.textContent = '';

    
    console.log('Form is valid. Ready to submit to a backend:', {
      username: usernameInput.value.trim(),
      email: emailInput.value.trim(),
      password: passwordInput.value.trim(),
    });
  });

  allInputs.forEach(function (input) {
    input.addEventListener('input', function () {
      input.classList.remove('invalid');
      errorMsg.textContent = '';
    });
  });

  backBtn.addEventListener('click', function () {
    if (window.history.length > 1) {
      window.history.back();
    } else {
      console.log('Back pressed — no previous page in history.');
    }
  });
});