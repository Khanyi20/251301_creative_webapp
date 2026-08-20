<?php

session_start();

require __DIR__ . '/../database/db.php';

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

// Make sure an item ID was submitted
if (!isset($_POST['item_id']) || !is_numeric($_POST['item_id'])) {
    header("Location: marketplace.php");
    exit();
}

$item_id = (int) $_POST['item_id'];

// Find the item
$stmt = $conn->prepare(
    "SELECT id, user_id, image_path
     FROM items
     WHERE id = :id"
);

$stmt->execute([
    ':id' => $item_id
]);

$item = $stmt->fetch(PDO::FETCH_ASSOC);

// Item doesn't exist
if (!$item) {
    header("Location: marketplace.php");
    exit();
}

// Make sure the logged-in user owns this item
if ((int) $item['user_id'] !== (int) $_SESSION['user_id']) {
    header("Location: item_details.php?id=" . $item_id);
    exit();
}

// Delete the database record
$stmt = $conn->prepare(
    "DELETE FROM items
     WHERE id = :id
     AND user_id = :user_id"
);

$stmt->execute([
    ':id' => $item_id,
    ':user_id' => $_SESSION['user_id']
]);

// Delete the image file if one exists
if (!empty($item['image_path'])) {

    $image_file = __DIR__ . '/../' . $item['image_path'];

    if (file_exists($image_file)) {
        unlink($image_file);
    }
}

// Return to marketplace
header("Location: marketplace.php");
exit();