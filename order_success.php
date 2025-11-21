<?php
require_once __DIR__ . '/includes/header.php';

$order_id = $_GET['order_id'] ?? 0;
?>

<h2>Order Successful</h2>
<p>Your order has been placed successfully!</p>
<p><strong>Order ID:</strong> <?= htmlspecialchars($order_id) ?></p>

<a href="index.php" class="btn">Return Home</a>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
