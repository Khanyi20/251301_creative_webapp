document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('loginForm');
  const usernameInput = document.getElementById('username');
  const passwordInput = document.getElementById('password');
  const errorMsg = document.getElementById('errorMsg');
  const backBtn = document.getElementById('backBtn');

 
  form.addEventListener('submit', function (e) {
    e.preventDefault();

    let message = '';
    usernameInput.classList.remove('invalid');
    passwordInput.classList.remove('invalid');

    if (!usernameInput.value.trim()) {
      message = 'Please enter your username.';
      usernameInput.classList.add('invalid');
    } else if (!passwordInput.value.trim()) {
      message = 'Please enter your password.';
      passwordInput.classList.add('invalid');
    } else if (passwordInput.value.trim().length < 6) {
      message = 'Password must be at least 6 characters.';
      passwordInput.classList.add('invalid');
    }

    if (message) {
      errorMsg.textContent = message;
      return;
    }

    errorMsg.textContent = '';

   
    console.log('Form is valid. Ready to submit to a backend:', {
      username: usernameInput.value.trim(),
      password: passwordInput.value.trim(),
    });
  });

 
  [usernameInput, passwordInput].forEach(function (input) {
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