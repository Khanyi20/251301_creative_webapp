<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href= "../assets/css/style.css">
    <title>Document</title>
</head>
<body>

<header class="site-header">
    <nav class="main-nav">

    <a href="home_page.php" class="logo">Trade or Drop</a>

    <div class="nav-links">
        <a href="home_page.php">Home</a>
        <a href="marketplace.php">Marketplace</a>
        <a href="add_item.php">Add Item</a>
        <a href="trade_requests.php">Trade Requests</a>
        <a href="logout.php">Logout</a>
    </div>
    </nav>

</header>
    
</body>
</html>



