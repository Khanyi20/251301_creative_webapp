<?php 
session_start();
require __DIR__ . '/../database/db.php';

$error = "";
$identifier = "";

// if already logged in, go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: home_page.php");
    exit();
}

    // handle login form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = trim($_POST['username']);
    $password = $_POST['password'];
    
    // look up user by username/email using PDO
    $stmt = $conn->prepare(
        "SELECT id, username, password 
        FROM users 
        WHERE username = :identifier OR email = :identifier");
    $stmt->execute([':identifier' => $identifier]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // verify password
        if ($user && password_verify($password, $user['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header("Location: home_page.php");
        exit();

    } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        body { font-family: Arial; background: #eef8f9; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .form-box { background: white; padding: 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 350px; }
        .form-box h2 { color: #0b3d5c; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #40616f; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #cfe6e9; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
        .btn { width: 100%; padding: 12px; background: #f2661f; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer; }
        .btn:hover { background: #d4550a; }
        .error { color: #e0495b; font-size: 14px; margin: 10px 0; }
        .success { color: #2ca6a4; font-size: 14px; margin: 10px 0; }
        .link { text-align: center; margin-top: 15px; }
        .link a { color: #12678a; }
    </style>
</head>
<body>
    
    <div class="form-box">
        <h2>Welcome Back</h2>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="error"> <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Username or Email *</label>
                <input type="text" name="username" required value="<?php echo htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn">Log In </button>
        </form>
        
        <div class="link">
            Don't have an account? <a href="register_page.php">Create an account</a>
        </div>
    </div>

</body>
</html>