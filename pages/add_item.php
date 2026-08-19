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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $item_name = trim($_POST['item_name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $item_condition = trim($_POST['item_condition'] ?? '');

    // Validate inputs
    if (empty($item_name)) $errors[] = "Item name is required";
    if (empty($description)) $errors[] = "Description is required";
    if (empty($category)) $errors[] = "Category is required";
    if (empty($item_condition)) $errors[] = "Item condition is required";

    // If no errors, save to database
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO items (user_id, item_name, description, category, item_condition) 
                VALUES (:user_id, :item_name, :description, :category, :item_condition)");
            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':item_name' => $item_name,
                ':description' => $description,
                ':category' => $category,
                ':item_condition' => $item_condition
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

    <form method="POST" action="">
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
        <button type="submit">Add Item</button>
    </form>

    </p><a href="home_page.php">Back to Home</a></p>
    
</body>
</html>