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

// Get trade requests made by the logged-in user
$stmt = $conn->prepare(
    "SELECT
        trade_requests.id AS request_id,
        trade_requests.status,
        trade_requests.created_at,
        items.id AS item_id,
        items.item_name,
        items.image_path,
        users.username AS owner_username
     FROM trade_requests
     INNER JOIN items ON trade_requests.item_id = items.id
        INNER JOIN users ON items.user_id = users.id
     WHERE trade_requests.requester_id = :user_id
     ORDER BY trade_requests.created_at DESC"
);
$stmt->execute([':user_id' => $user_id]);

$outgoing_requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/trade-request.css">
    <title>Trade Requests</title>
</head>
<body>
<?php require __DIR__ . '/../includes/header.php'; ?>
    <main>

        <div class="page-heading">
            <div>
                <h1>Trade Requests</h1>
                
            </div>
            
        </div>
        

        <section class="requests-section">
        <h2>Incoming Requests</h2>

        <div class="requests-lists">
        <?php if (empty($incoming_requests)): ?>
            <p>No incoming trade requests.</p>

            <?php else: ?>
                <?php foreach ($incoming_requests as $request): ?>
                    <article class="request-card">
                        <?php if (!empty($request['image_path'])): ?>
                            <img
                                src="../<?php echo htmlspecialchars($request['image_path']); ?>"
                                alt="<?php echo htmlspecialchars($request['item_name']); ?>"
                                width="200"
                            >
                        <?php endif; ?>

                        <div class="request-info">
                        <h3><?php echo htmlspecialchars($request['item_name']); ?></h3>
                        <p>
                            <strong>Requested by::</strong> 
                            <?php echo htmlspecialchars($request['requester_username']); ?>
                        </p>
                        <p>
                            <span class="request-status <?php echo strtolower($request['status']); ?>">
                            <strong>Status:</strong> 
                            <?php echo htmlspecialchars($request['status']); ?>
                            </span>
                        </p>
                        <p>
                            <strong>Requested on:</strong> 
                            <?php echo htmlspecialchars($request['created_at']); ?>
                        </p>
                        </div>


                    <div class="request-actions">
                        <form action="accept_trade.php" method="POST">
                            <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                            <button type="submit">
                                Accept
                            </button>
                        </form>

                        <form action="reject_trade.php" method="POST">
                            <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                            <button type="submit">
                                Reject
                            </button>
                        </form>
                    </div>
                    </article>

                        </hr>
                <?php endforeach; ?>
        <?php endif; ?>
        </div>

        </section>

        <section class="requests-section">
            <h2>My Outgoing Requests</h2>

            <div class="requests-list">
            <?php if (empty($outgoing_requests)): ?>
                <p>No outgoing trade requests.</p>
            <?php else: ?>
                <?php foreach ($outgoing_requests as $request): ?>
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
                            <strong>Owner:</strong> 
                            <?php echo htmlspecialchars($request['owner_username']); ?>
                        </p>
                        <p>
                            <strong>Status:</strong> 
                            <?php echo htmlspecialchars($request['status']); ?>
                        </p>
                        <p>
                            <strong>Requested on:</strong> 
                            <?php echo htmlspecialchars($request['created_at']); ?>
                        </p>
                    </article>

                    </hr>
                <?php endforeach; ?>
            <?php endif; ?>
            </div>

        </section>

    </main>
    
</body>
</html>