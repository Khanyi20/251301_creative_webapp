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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="../assets/css/deco-elements.css">

    <title>Trade or Drop | Home</title>
   
</head>
<body class="dashboard-page">
    <?php require __DIR__ . '/../includes/deco-circles.php'; ?>
    <header class="home-hero__header">
        <a href="home_page.php" class="home-brand" aria-label="Trade or Drop home">
            <img src="../assets/Frame 55 4.svg" alt="Trade or Drop logo" class="home-brand__logo">
            <span>Trade or Drop</span>
        </a>

        <nav class="home-hero__nav" aria-label="Main navigation">
            <a href="home_page.php" aria-current="page">Home</a>
            <a href="marketplace.php">Marketplace</a>
            <a href="add_item.php">Add Item</a>
            <a href="trade_requests.php">Trade Requests</a>
            <a href="logout.php" class="nav-logout">Logout</a>
        </nav>
    </header>

    <section class="home-hero" aria-labelledby="home-hero-title">
        <img
            class="home-hero__image"
            src="../assets/aDm5mK7VlwYKIEsilQw8-Et3BF-adjusted.jpg"
            alt="Home hero image"
            fetchpriority="high"
        >
        <div class="home-hero__shade" aria-hidden="true"></div>

        <div class="home-hero__content">
            <h1 id="home-hero-title">What is Trade or Drop?</h1>
            <p class="home-hero__description">
                This is a student app dedicated to creating a strong community
                by providing a platform where students can trade items they
                don't need. With a twist of ranking best to weirdest items,
                you can become the lead No. 1 on the ranking stage.
            </p>
            <a href="marketplace.php" class="home-hero__button">Join Us</a>
        </div>
    </section>

    <main class="dashboard-main">

        <section class="dashboard-header">

            <div>
                <p class="dashboard-eyebrow">Your dashboard</p>

                <h1>
                    Welcome back,
                    <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>!
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