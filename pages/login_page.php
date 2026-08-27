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
    <link rel="stylesheet" href="../assets/css/auth.css">
    <title>User Login</title>
    
</head>
<body>
    <main class="auth-page">
        
        <div class="top-heading">
        <h1> Login</h1>
        <p>Don't miss out on the best trades. Join and lets get trading.</p>
        </div>
    <div class="form-box">

        <div class="auth-heading">
        <h2>Welcome Back</h2>
        </div>


        <?php if (isset($_SESSION['success'])): ?>
            <div class="message message-success"> <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <?php if (!empty($error)): ?>
            <div class="message message-error"> <?php echo htmlspecialchars($error); ?></div>
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
        
        <div class="auth-footer">
            Don't have an account? <a href="register_page.php">Create an account</a>
        </div>
    </div>
    </main>
</body>
</html>