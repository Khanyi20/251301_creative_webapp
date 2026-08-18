<?php   
session_start();
require __DIR__ . '/../database/db.php';

    // check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

    // get user data using PDO
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // user not found, force logout
        session_destroy();
        header("Location: login_page.php");
        exit();
    }

    // handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login_page.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>user dashboard</title>
    <style>
        body { font-family: Arial; background: #eef8f9; text-align: center; padding: 50px; }
        .profile-card { max-width: 400px; margin: 0 auto; background: white; padding: 30px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .profile-img { width: 150px; height: 150px; border-radius: 50%; object-fit: cover; border: 4px solid #2ca6a4; }
        h2 { color: #0b3d5c; }
        .logout { color: #f2661f; text-decoration: none; display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>

    <div class="profile-card">
           <img src="uploads/<?php echo htmlspecialchars($user['profile_img'] ?? 'default.jpg') ?>" 
               alt="Profile" class="profile-img">
           <h2><?php echo htmlspecialchars($user['username'] ?? '') ?></h2>
           <p><?php echo htmlspecialchars($user['email'] ?? '') ?></p>
           <p>Joined: <?php echo htmlspecialchars(date('F j, Y', strtotime($user['created_at'] ?? 'now'))) ?></p>
        <a href="?logout=1" class="logout">Log out</a>
    </div>
    
</body>
</html>