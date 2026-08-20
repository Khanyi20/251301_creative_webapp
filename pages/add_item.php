<?php 

session_start();

require __DIR__ . '/../database/db.php';

// for only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$errors = [];
$item_name = "";
$description = "";
$category = "";
$item_condition = "";
$image_path = null;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $item_name = trim($_POST['item_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $item_condition = trim($_POST['item_condition'] ?? '');
    $image_path = trim($_POST['image_path'] ?? '');

    // Validate inputs
    if (empty($item_name)) $errors[] = "Item name is required";
    if (empty($description)) $errors[] = "Description is required";
    if (empty($category)) $errors[] = "Category is required";
    if (empty($item_condition)) $errors[] = "Item condition is required";

    if (isset($_FILES['item_image']) && $_FILES['item_image']['error'] !== UPLOAD_ERR_NO_FILE) {

    if ($_FILES['item_image']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "There was a problem uploading the image.";
    } else {

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $extension = strtolower(
            pathinfo($_FILES['item_image']['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($extension, $allowed_extensions, true)) {

            $errors[] = "Only JPG, JPEG, PNG, GIF, and WEBP images are allowed.";

        } else {

            $new_filename = uniqid('item_', true) . '.' . $extension;

            $upload_directory = __DIR__ . '/../uploads/items/';
            $upload_path = $upload_directory . $new_filename;

            if (move_uploaded_file(
                $_FILES['item_image']['tmp_name'],
                $upload_path
            )) {

                $image_path = 'uploads/items/' . $new_filename;

            } else {

                $errors[] = "Could not save the uploaded image.";

            }
        }
    }
}

    // If no errors, save to database
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO items (user_id, item_name, description, category, item_condition, image_path) 
                VALUES (:user_id, :item_name, :description, :category, :item_condition, :image_path)");
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':item_name' => $item_name,
                ':description' => $description,
                ':category' => $category,
                ':item_condition' => $item_condition,
                ':image_path' => $image_path
            ]);

            $_SESSION['success'] = "Item added successfully!";
            header("Location: home_page.php");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Failed to add item: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List new item</title>
</head>
<body></body>
    <h1>List a New Item</h1>

    <?php if (!empty($errors)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="" enctype="multipart/form-data">
        <div>
            <label for="item_name">Item Name</label>
            <input type="text" id="item_name" name="item_name" required value="<?php echo htmlspecialchars($item_name); ?>">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>
        <div>
            <label for="category">Category</label>
            <input type="text" id="category" name="category" required value="<?php echo htmlspecialchars($category); ?>">
        </div>
        <div>
            <label for="item_condition">Item Condition</label>
            <input type="text" id="item_condition" name="item_condition" required value="<?php echo htmlspecialchars($item_condition); ?>">
        </div>
        <div>
            <label for="item_image">Upload Image</label>
            <input type="file" id="item_image" name="item_image" accept=".jpg,.jpeg,.png,.gif,.webp">
        </div>
        <button type="submit">Add Item</button>
    </form>

    </p><a href="home_page.php">Back to Home</a></p>
    
</body>
</html>