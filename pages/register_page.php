
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration</title>
  <link rel="stylesheet" href="../css/login.css">
  <link rel="stylesheet" href="../css/register.css">
</head>
<body>

  <div class="phone">

    <!-- decorative background circles -->
    <span class="circle c-orange c-top-left"></span>
    <span class="circle c-yellow c-top-mid"></span>
    <span class="circle c-blue c-top-right"></span>
    <span class="circle c-green c-mid-left"></span>
    <span class="circle c-gray c-mid-right"></span>
    <span class="circle c-orange r-pw-right"></span>
    <span class="circle c-blue r-lower-left"></span>
    <span class="circle c-yellow c-bottom-left2"></span>
    <span class="circle c-gray c-bottom-mid"></span>
    <span class="circle c-green r-bottom-right"></span>

    <div class="content">

      <button type="button" class="back-btn" id="backBtn">
        <span class="chevron">&lsaquo;</span> Back
      </button>

      <header class="intro">
        <h1>Registration</h1>
        <p>Start your first exchange by joining the community.</p>
      </header>

      <form id="registerForm" class="login-form" action="#" method="POST" novalidate>

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
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Your email"
            autocomplete="email"
            required
          >
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Your Password"
            autocomplete="new-password"
            required
          >
        </div>

        <div class="field">
          <label for="confirmPassword">Confirm Password</label>
          <input
            type="password"
            id="confirmPassword"
            name="confirmPassword"
            placeholder="Confirm your password"
            autocomplete="new-password"
            required
          >
        </div>

        <p class="error-msg" id="errorMsg" aria-live="polite"></p>

        <div class="links-row links-row-inline">
          <span class="muted-text">
            Already have an account?
            <a href="index.php" class="link">Login</a>
          </span>
        </div>

        <button type="submit" class="submit-btn" id="submitBtn">Register</button>

      </form>

    </div>
  </div>

  <script src="register.js"></script>
</body>
</html>