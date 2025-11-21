<?php
require_once __DIR__.'/includes/db.php';
require_once __DIR__.'/includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category_name 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE p.id = ?
");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$p) {
    echo '<p>Product not found.</p>';
    require_once __DIR__.'/includes/footer.php';
    exit;
}
?>

<style>
.product-page {
    display: flex;
    gap: 40px;
    align-items: flex-start;
    margin-top: 30px;
}

.product-page img {
    width: 380px;
    height: 380px;
    object-fit: cover;          /* RESIZES CLEANLY */
    border-radius: 10px;
    border: 1px solid #ddd;
}

.product-details h2 {
    margin: 0 0 10px 0;
}

.product-details .price {
    font-size: 22px;
    color: #e67e22;
    margin-bottom: 15px;
    font-weight: bold;
}

.product-details button {
    margin-top: 15px;
    background: #ff9900;
    padding: 10px 18px;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
}

.product-details button:hover {
    background: #e68a00;
}
</style>

<div class="product-page">

    <!-- PRODUCT IMAGE -->
    <img src="/jumia_clone/uploads/products/<?= htmlspecialchars($p['image']) ?>"
         alt="<?= htmlspecialchars($p['name']) ?>">

    <!-- PRODUCT INFO -->
    <div class="product-details">
        <h2><?= htmlspecialchars($p['name']) ?></h2>

        <p class="price">$<?= number_format($p['price'], 2) ?></p>

        <p><?= nl2br(htmlspecialchars($p['description'])) ?></p>

        <p><strong>Category:</strong> <?= htmlspecialchars($p['category_name']) ?></p>

        <!-- ADD TO CART -->
        <form method="post" action="/jumia_clone/add_to_cart.php">
            <input type="hidden" name="product_id" value="<?= $p['id'] ?>">

            <label>Quantity:
                <input type="number" name="quantity" value="1" min="1">
            </label>

            <button type="submit">Add to Cart</button>
        </form>
    </div>

</div>

<?php require_once __DIR__.'/includes/footer.php'; ?>
