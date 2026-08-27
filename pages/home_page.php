<?php

session_start();

require __DIR__ . '/../database/db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

// Get the logged-in user's data
$stmt = $conn->prepare(
    "SELECT id, username, email, password, created_at
     FROM users
     WHERE id = :id"
);

$stmt->execute([
    ':id' => $_SESSION['user_id']
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get items that belong to logged in user
$stmt = $conn->prepare(
    "SELECT *
    FROM items
    WHERE user_id = :user_id
    ORDER BY created_at DESC"
);

$stmt->execute([
    ':user_id' => $_SESSION['user_id']
]);

$my_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If the user doesn't exist, log them out
if (!$user) {
    session_destroy();
    header("Location: login_page.php");
    exit();
}

// Handle logout
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
    <link rel="stylesheet" href="../assets/css/dashboard.css">
     <title>user dashboard</title>
   
</head>
<body>

<?php
    require __DIR__ . '/../includes/header.php';
?>

    <main>

        <section class="dashboard-header">

            <div>
                <p class="dashboard-eyebrow">Student Marketplace</p>

                <h1>
                    Welcome back,
                    <?php echo htmlspecialchars($user['username']); ?>!
                </h1>

                <p>
                    Manage your items and keep track of your trades.
                </p>
            </div>

            <a href="add_item.php" class="button button-primary">
                + Add Item
            </a>

        </section>


        <section class="dashboard-stats">

            <div class="stat-card">
                

                <span class="stat-label">
                    No. of My Items = 
                </span>
                <span class="stat-number">
                    <?php echo count($my_items); ?>
                </span>

            </div>

            <div class="stat-card">
                <a href="trade_requests.php">
                    <span class="stat-number">
                        
                    </span>

                    <span class="stat-label">
                        Trade Requests
                    </span>
                </a>
            </div>

        </section>


        <section class="dashboard-items">

            <div class="section-heading">
                <div>
                    <h2>My Items</h2>
                    <p>Items you've added to the marketplace.</p>
                </div>
            </div>


            <?php if (empty($my_items)): ?>

                <div class="empty-state">

                    <h3>No items yet</h3>

                    <p>
                        You haven't added anything to the marketplace.
                    </p>

                    <a href="add_item.php" class="button button-primary">
                        Add Your First Item
                    </a>

                </div>

            <?php else: ?>

                <div class="item-grid">

                    <?php foreach ($my_items as $item): ?>

                        <article class="item-card">

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

                                <h3 class="item-card-title">
                                    <?php echo htmlspecialchars($item['item_name']); ?>
                                </h3>

                                <p class="item-card-meta">
                                    Status:
                                    <?php echo htmlspecialchars(ucfirst($item['status'])); ?>
                                </p>

                                <a
                                    href="item_details.php?id=<?php echo $item['id']; ?>"
                                    class="button button-secondary"
                                >
                                    View Item
                                </a>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>

    </main>

    <!-- <div class="profile-card">
           <img src="uploads/<?php echo htmlspecialchars($user['profile_img'] ?? 'default.jpg') ?>" 
               alt="Profile" class="profile-img">
           <h2><?php echo htmlspecialchars($user['username'] ?? '') ?></h2>
           <p><?php echo htmlspecialchars($user['email'] ?? '') ?></p>
           <p>Joined: <?php echo htmlspecialchars(date('F j, Y', strtotime($user['created_at'] ?? 'now'))) ?></p>
        <a href="?logout=1" class="logout">Log out</a>
    </div> -->
    
</body>
</html>