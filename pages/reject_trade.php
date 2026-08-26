<?php

session_start();

require __DIR__ . '/../database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

if (!isset($_POST['request_id']) || !is_numeric($_POST['request_id'])) {
    header("Location: trade_requests.php");
    exit();
}

$request_id = (int) $_POST['request_id'];
$user_id = (int) $_SESSION['user_id'];

// Check if the trade request exists and belongs to the logged-in user
$stmt = $conn->prepare(
    "SELECT 
        trade_requests.id ,
        trade_requests.status,
        items.user_id AS owner_id
        
    FROM trade_requests
    INNER JOIN items ON trade_requests.item_id = items.id
    WHERE trade_requests.id = :request_id "
);

$stmt->execute([':request_id' => $request_id]);

$request = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$request) {
    header("Location: trade_requests.php");
    exit();
}

if ((int) $request['owner_id'] !== $user_id) {
    header("Location: trade_requests.php");
    exit();
}

// Only allow rejecting pending requests
if ($request['status'] !== 'pending') {
    header("Location: trade_requests.php");
    exit();
}

// Update the trade request status to 'rejected'
$stmt = $conn->prepare(
    "UPDATE trade_requests
    SET status = 'rejected'
    WHERE id = :request_id"
);

$stmt->execute([':request_id' => $request_id]);

header("Location: trade_requests.php");
exit();

?>