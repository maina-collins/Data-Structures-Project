<?php
session_start();
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$cart = $_SESSION['cart'] ?? [];

if (!$cart) {
    echo "<p>Your cart is empty. <a href='products.php'>Continue shopping</a></p>";
    require_once __DIR__ . '/includes/footer.php';
    exit;
}

// Fetch product details
$ids = array_keys($cart);
$in  = str_repeat('?,', count($ids)-1) . '?';
$stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($in)");
$stmt->execute($ids);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($products as $p) {
    $total += $p['price'] * $cart[$p['id']];
}
?>

<h2>Checkout</h2>

<form method="post" action="process_checkout.php" class="checkout-form">

  <h3>Billing Information</h3>
  <label>Full Name</label>
  <input type="text" name="fullname" required>

  <label>Email</label>
  <input type="email" name="email" required>

  <label>Phone Number</label>
  <input type="text" name="phone" required>

  <label>Address</label>
  <textarea name="address" required></textarea>

  <h3>Your Order</h3>
  <table class="table">
    <tr><th>Product</th><th>Qty</th><th>Total</th></tr>
    <?php foreach ($products as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= $cart[$p['id']] ?></td>
        <td>$<?= number_format($p['price'] * $cart[$p['id']],2) ?></td>
      </tr>
    <?php endforeach; ?>
    <tr>
      <td colspan="2"><strong>Grand Total</strong></td>
      <td><strong>$<?= number_format($total,2) ?></strong></td>
    </tr>
  </table>

  <button type="submit" class="btn checkout-btn">Place Order</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
