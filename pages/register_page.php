<?php
session_start();
require __DIR__ . '/../database/db.php';

$errors = [];
$username = $email = "";

// check if form was submitted

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    //validate inputs

    $errors = [];
    if (empty($username)) $errors[] = "Username is required";
    if (empty($email)) $errors[] = "Email is required";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
    if ($password !== $confirm) $errors[] = "Passwords do not match";

    // handle profile image upload

    $profile_img = 'default.jpg';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $new_name = uniqid() . '.' . $ext;
            $target = 'uploads/' . $new_name;

            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target)) {
                $profile_img = $new_name;
            }
        } else {
            $errors[] = "Only JPG, PNG, and GIF files are allowed";
        }
    }

    // If no errors, save to database
    if (empty($errors)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, profile_img) VALUES (:username, :email, :password, :profile_img)");
            $stmt->execute([
                ':username' => $username,
                ':email' => $email,
                ':password' => $hashed,
                ':profile_img' => $profile_img
            ]);

            $_SESSION['success'] = "Registration successful! Please log in.";
            header("Location: login_page.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $errors[] = "Username or email already exists";
            } else {
                $errors[] = "Registration failed: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Register</title>
    <style>
        body {
            font-family: Arial;
            background: #eef8f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-box {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .form-box h2 {
            color: #0b3d5c;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #40616f;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #cfe6e9;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-group input[type="file"] {
            padding: 8px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: #2ca6a4;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn:hover {
            background: #1b8a88;
        }

        .error {
            color: #e0495b;
            font-size: 14px;
            margin: 10px 0;
        }

        .success {
            color: #2ca6a4;
            font-size: 14px;
            margin: 10px 0;
        }

        .link {
            text-align: center;
            margin-top: 15px;
        }

        .link a {
            color: #12678a;
        }
    </style>
</head>

<body>

    <div class="form-box">
        <h2>Register</h2>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $err) { echo htmlspecialchars($err) . "<br>"; } ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Username *</label>
                <input type="text" name="username" required value=" <?php echo htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" required value=" <?php echo htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Password (min 6 characters) *</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password *</label>
                <input type="password" name="confirm_password" required>
            </div>
            <div class="form-group">
                <label>Profile Picture (JPG, PNG, GIF) </label>
                <input type="file" name="profile_image" accept="image/*">
            </div>
            <button type="submit" class="btn">Create Account </button>
        </form>

        <div class="link">
            Already have an account? <a href="login_page.php">Log in</a>
        </div>
    </div>

</body>

</html>