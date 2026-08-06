<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../trade_or_drop/css/login.css">

    <title>Login</title>
</head>
<body>
    <!-- <?php
    echo '<div class="login-container">';
    echo '<h2>Login</h2>';
    echo '<p>Don’t miss out on the best trades. Join and lets get trading.<br/>
    Please enter your username and password to log in.</p>';

    echo '<form action="../actions/login_action.php" method="post">';
    echo '<label class="form-username" for="username">Username:</label>';
    echo '<input type="text" id="username" name="username" required><br/>';
    echo '<label class="form-password" for="password">Password:</label><br/>';
    echo '<input type="password" id="password" name="password" required><br/>';
    echo '<button type="submit">Login</button>';
    echo '</form>';
    echo '</div>';
    ?> -->
<!--</body>
</html> -->




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log In</title>
  <link rel="stylesheet" href="../css/login.css">
</head>
<body>

  <div class="phone">

    <!-- decorative background circles -->
    <span class="circle c-orange c-top-left"></span>
    <span class="circle c-yellow c-top-mid"></span>
    <span class="circle c-blue c-top-right"></span>
    <span class="circle c-green c-mid-left"></span>
    <span class="circle c-gray c-mid-right"></span>
    <span class="circle c-orange c-lower-right"></span>
    <span class="circle c-blue c-bottom-left"></span>
    <span class="circle c-yellow c-bottom-left2"></span>
    <span class="circle c-gray c-bottom-mid"></span>
    <span class="circle c-green c-bottom-right"></span>

    <div class="content">

      <button type="button" class="back-btn" id="backBtn">
        <span class="chevron">&lsaquo;</span> Back
      </button>

      <header class="intro">
        <h1>Log In</h1>
        <p>Don't miss out on the best trades. Join and lets get trading.</p>
      </header>

      <form id="loginForm" class="login-form" action="#" method="POST" novalidate>

        <div class="field">
          <label for="username">Username</label>
          <input
            type="text"
            id="username"
            name="username"
            placeholder="Your Username"
            autocomplete="username"
            required
          >
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Your password"
            autocomplete="current-password"
            required
          >
        </div>

        <p class="error-msg" id="errorMsg" aria-live="polite"></p>

        <div class="links-row">
          <span class="muted-text">
            If you don't have an account with us
            <a href="register.php" class="link">Register</a>
          </span>
          <a href="forgot-password.php" class="link forgot-link">Forgot password</a>
        </div>

        <button type="submit" class="submit-btn" id="submitBtn">Log In</button>

      </form>

    </div>
  </div>

  <script src="../js/login.js"></script>
</body>
</html>