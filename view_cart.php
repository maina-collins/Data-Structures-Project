<?php
require_once __DIR__ . '/includes/db.php';
session_start();
require_once __DIR__ . '/includes/header.php';

$cart = $_SESSION['cart'] ?? [];
$products = [];
$total = 0.0;

if ($cart) {
    $ids = array_keys($cart);
    $in  = str_repeat('?,', count($ids) - 1) . '?';

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($in)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $p) {
        $total += $p['price'] * $cart[$p['id']];
    }
}
?>

<h2>Your Cart</h2>

<?php if (!$products): ?>
    <p>Your cart is empty. 
        <a href="/jumia_clone/index.php">Continue shopping</a>
    </p>

<?php else: ?>

<style>
.cart-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}
.cart-table th, .cart-table td {
    padding: 12px;
    border-bottom: 1px solid #ccc;
}
.cart-table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}
.total-row td {
    font-size: 18px;
    font-weight: bold;
}
.qty-box {
    width: 60px;
    padding: 5px;
}
.remove-btn {
    background: red;
    color: #fff;
    padding: 6px 10px;
    border-radius: 5px;
    text-decoration: none;
}
</style>

<form method="post" action="/jumia_clone/update_cart.php">

<table class="cart-table">
<tr>
    <th>Product</th>
    <th>Image</th>
    <th>Qty</th>
    <th>Price</th>
    <th>Action</th>
</tr>

<?php foreach ($products as $p): ?>
    <tr>
        <td><?= htmlspecialchars($p['name']) ?></td>

        <td>
            <img src="/jumia_clone/products/uploads/<?= htmlspecialchars($p['image']) ?>"
                 alt="<?= htmlspecialchars($p['name']) ?>">
        </td>

        <td>
            <input type="number" class="qty-box" name="qty[<?= $p['id'] ?>]"
                   value="<?= $cart[$p['id']] ?>" min="1">
        </td>

        <td>$<?= number_format($p['price'] * $cart[$p['id']], 2) ?></td>

        <td>
            <a href="/jumia_clone/remove_item.php?id=<?= $p['id'] ?>" class="remove-btn">Remove</a>
        </td>
    </tr>
<?php endforeach; ?>

<tr class="total-row">
    <td colspan="3">Total</td>
    <td>$<?= number_format($total, 2) ?></td>
    <td></td>
</tr>

</table>

<button type="submit">Update Cart</button>
</form>

<br>

<a href="/jumia_clone/clear_cart.php" class="remove-btn">Clear Cart</a>
<br><br>

<form method="post" action="/jumia_clone/checkout.php">
    <button type="submit">Proceed to Checkout</button>
</form>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
