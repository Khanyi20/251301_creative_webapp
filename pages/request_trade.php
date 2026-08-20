<?php

session_start();

require __DIR__ . '/../database/db.php';


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
$requester_id = (int) $_SESSION['user_id'];

// Get the item
$stmt = $conn->prepare(
    "SELECT id, user_id, status
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

// User cannot request their own item
if ((int) $item['user_id'] === $requester_id) {
    header("Location: item_details.php?id=" . $item_id);
    exit();
}

// Item must be available
if ($item['status'] !== 'available') {
    header("Location: item_details.php?id=" . $item_id);
    exit();
}

// Check whether this user already requested this item
$stmt = $conn->prepare(
    "SELECT id
     FROM trade_requests
     WHERE requester_id = :requester_id
     AND item_id = :item_id
     AND status = 'pending'"
);

$stmt->execute([
    ':requester_id' => $requester_id,
    ':item_id' => $item_id
]);

$existing_request = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existing_request) {
    header("Location: item_details.php?id=" . $item_id);
    exit();
}

// Create the trade request
$stmt = $conn->prepare(
    "INSERT INTO trade_requests
     (requester_id, item_id, status)
     VALUES
     (:requester_id, :item_id, 'pending')"
);

$stmt->execute([
    ':requester_id' => $requester_id,
    ':item_id' => $item_id
]);

header("Location: item_details.php?id=" . $item_id);
exit();