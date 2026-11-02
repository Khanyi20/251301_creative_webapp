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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/deco-elements.css">
    <title>Marketplace</title>
</head>
<body>

<?php require __DIR__ . '/../includes/header.php'; ?>

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
    <main>  
    <div class="items-container">

        <section class="page-heading">
            <div>
                <h1>Marketplace</h1>
                <p>Discover items available for trade.</p>
            </div>

            <a href="add_item.php" class="button button-primary">
                + Add Item
            </a>
        </section>
        <div class="item-grid">
        <?php foreach ($items as $item): ?>
            <div class="item-card">

                <?php if (!empty($item['image_path'])): ?>

                    <img
                        src="../<?php echo htmlspecialchars($item['image_path']); ?>"
                        alt="<?php echo htmlspecialchars($item['item_name']); ?>"
                        class="item-card-image"
                    >

                <?php else: ?>

                    <div class="item-card-image item-card-placeholder">
                        No image
                    </div>

                <?php endif; ?>


                <div class="item-card-content">

                    <h2 class="item-card-title">
                        <?php echo htmlspecialchars($item['item_name']); ?>
                    </h2>

                    <p class="item-card-description">
                        <?php echo htmlspecialchars($item['description']); ?>
                    </p>

                    <p class="item-card-meta">
                        <?php echo htmlspecialchars($item['category']); ?>
                        ·
                        <?php echo htmlspecialchars($item['item_condition']); ?>
                    </p>

                    <p class="item-card-owner">
                        Posted by
                        <?php echo htmlspecialchars($item['username']); ?>
                    </p>

                    <a
                        href="item_details.php?id=<?php echo $item['id']; ?>"
                        class="button button-secondary"
                    >
                        View Item
                    </a>

                </div>

            </div>
            
        <?php endforeach; ?>
        </div>
    </div>
                </main>

</body>
</html>