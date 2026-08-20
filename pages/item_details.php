<?php

session_start();

require __DIR__ . '/../database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

// make sure an item ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid item ID.";
    exit();
}

$item_id = (int)$_GET['id'];

// Fetch item details from the database
$stmt = $conn->prepare(
    "SELECT 
        items.id,
        items.item_name,
        items.description,
        items.category,
        items.item_condition,
        items.image_path,
        items.status,
        items.created_at,
        items.user_id,
        users.username
    FROM items
    INNER JOIN users ON items.user_id = users.id
    WHERE items.id = :id"
);
$stmt->bindParam(':id', $item_id, PDO::PARAM_INT);
$stmt->execute();
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    echo "Item not found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        
        <?php echo htmlspecialchars($item['item_name']); ?>

    </title>
</head>
<body>

    <p>
        <a href="marketplace.php">Back to Marketplace</a>
    </p>

    <main>


        <?php if (!empty($item['image_path'])): ?>

            <img
                src="../<?php echo htmlspecialchars($item['image_path']); ?>"
                alt="<?php echo htmlspecialchars($item['item_name']); ?>"
                width="400"
            >

        <?php endif; ?>

        <h1><?php echo htmlspecialchars($item['item_name']); ?></h1>

        <p>
            <strong>Posted by:</strong> 
            <?php echo htmlspecialchars($item['username']); ?>
        </p>

        <p>
            <strong>Category:</strong> 
            <?php echo htmlspecialchars($item['category']); ?>
        </p>

        <p>
            <strong>Condition:</strong> 
            <?php echo htmlspecialchars($item['item_condition']); ?>
        </p>

        <p>
            <strong>Description:</strong> 
            
        </p>

        <p>
            <?php echo nl2br(htmlspecialchars($item['description'])); ?>
        </p>

        <p>
            <strong>Status:</strong> 
            <?php echo htmlspecialchars($item['status']); ?>
        </p>

        <p>
            <strong>Listed:</strong> 
            <?php echo htmlspecialchars($item['created_at']); ?>
        </p>

        <?php if ($item['user_id'] == $_SESSION['user_id']): ?>

        <form method="POST" action="delete_item.php">
            <input
                type="hidden"
                name="item_id"
                value="<?php echo $item['id']; ?>"
            >

            <button type="submit">
                Delete Item
            </button>
        </form>

        <?php else: ?>

            <button type="button">
                Request Trade
            </button>

        <?php endif; ?>

    </main>
    
</body>
</html>