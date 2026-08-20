<?php

session_start();

require __DIR__ . '/../database/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

// Fetch trade requests where the logged-in user is the owner of the item
$stmt = $conn->prepare(
    "SELECT 
        trade_requests.id AS request_id,
        trade_requests.status,
        trade_requests.created_at,
        users.username AS requester_username,
        items.id AS item_id,
        items.item_name,
        items.image_path
        
    FROM trade_requests
    INNER JOIN items ON trade_requests.item_id = items.id
    INNER JOIN users ON trade_requests.requester_id = users.id
    WHERE items.user_id = :user_id
    ORDER BY trade_requests.created_at DESC"
);
$stmt->execute([':user_id' => $user_id]);

$incoming_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Requests</title>
</head>
<body>

    <main>

        <h1>Trade Requests</h1>
        <h2>Incoming Requests</h2>

        <?php if (empty($incoming_requests)): ?>
            <p>No incoming trade requests.</p>

            <?php else: ?>
                <?php foreach ($incoming_requests as $request): ?>
                    <article>
                        <?php if (!empty($request['image_path'])): ?>
                            <img
                                src="../<?php echo htmlspecialchars($request['image_path']); ?>"
                                alt="<?php echo htmlspecialchars($request['item_name']); ?>"
                                width="200"
                            >
                        <?php endif; ?>
                        <h3><?php echo htmlspecialchars($request['item_name']); ?></h3>
                        <p>
                            <strong>Requested by::</strong> 
                            <?php echo htmlspecialchars($request['requester_username']); ?>
                        </p>
                        <p>
                            <strong>Status:</strong> 
                            <?php echo htmlspecialchars($request['status']); ?>
                        </p>
                        <p>
                            <strong>Requested on:</strong> 
                            <?php echo htmlspecialchars($request['created_at']); ?>
                        </p>

                        <button type= "button">
                            Accept
                        </button>

                        <button type= "button">
                            Reject
                        </button>
                    </article>

                        </hr>
                <?php endforeach; ?>
        <?php endif; ?>

    </main>
    
</body>
</html>