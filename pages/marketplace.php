<?php 

session_start();

require __DIR__ . '/../database/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

//get all items from the database
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
            users.username
            
        FROM items
        INNER JOIN users 
            ON items.user_id = users.id
        WHERE items.status = 'available'
        ORDER BY items.created_at DESC"
        );
    $stmt->execute();
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace</title>
</head>
<body>
    <h1>Marketplace</h1>
    <p>Find something interesting to trade</p>

    <p>
        
        <a href="home_page.php">Back to Dashboard</a> | 
        <a href="add_item.php">Add New Item</a> | 
        <a href="home_page.php?logout=true">Logout</a>
    </p>

    <?php if (empty($items)): ?>
        <p>No items available for trade at the moment.</p>
    <?php endif; ?>

    <div class="items-container">
        <?php foreach ($items as $item): ?>
            <div class="item-card">

                <?php if (!empty($item['image_path'])): ?>

                    <img
                        src="../<?php echo htmlspecialchars($item['image_path']); ?>"
                        alt="<?php echo htmlspecialchars($item['item_name']); ?>"
                        width="200"
                    >

                <?php endif; ?>
                <h2><?php echo htmlspecialchars($item['item_name']); ?></h2>
                <p>
                    <strong>Description:</strong> 
                    <?php echo htmlspecialchars($item['description']); ?>
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
                    <strong>Posted by:</strong> 
                    <?php echo htmlspecialchars($item['username']); ?>
                </p>
                <p>
                    <strong>Status:</strong> 
                    <?php echo htmlspecialchars($item['status']); ?>
                </p>
                <!-- <?php if (!empty($item['image_path'])): ?>
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['item_name']); ?>" style="max-width: 200px;">
                <?php endif; ?> -->
            </div>
            <a href="item_details.php?id=<?php echo $item['id']; ?>">
                View Item
            </a>
        <?php endforeach; ?>
    </div>

</body>
</html>