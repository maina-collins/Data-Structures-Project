<?php
require_once 'includes/db.php';
require_once 'includes/header.php';

// Load categories
$stmtCat = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

// Handle category filtering
$categoryFilter = "";
$params = [];

if (isset($_GET['category_id']) && is_numeric($_GET['category_id'])) {
    $categoryFilter = "WHERE category_id = ?";
    $params[] = $_GET['category_id'];
}

// Fetch products
$stmtProd = $pdo->prepare("SELECT * FROM products $categoryFilter ORDER BY created_at DESC");
$stmtProd->execute($params);
$products = $stmtProd->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Categories</h2>

<div style="
    display: flex;
    gap: 15px;
    margin-bottom: 25px;
    flex-wrap: wrap;
">
    <?php foreach ($categories as $cat): ?>
        <a href="index.php?category_id=<?php echo $cat['id']; ?>"
           style="
                padding: 10px 18px;
                background: #fafafa;
                border:1px solid #ddd;
                border-radius:8px;
                text-decoration:none;
                color:#333;
                transition:0.2s;
            "
           onmouseover="this.style.background='#eee'"
           onmouseout="this.style.background='#fafafa'">

            <?php echo htmlspecialchars($cat['name']); ?>
        </a>
    <?php endforeach; ?>

    <!-- Reset / Show all -->
    <a href="index.php"
       style="
            padding: 10px 18px;
            background:#FF9900;
            color:white;
            border-radius:8px;
            text-decoration:none;
        ">
        All Products
    </a>
</div>

<h2>
    <?php echo isset($_GET['category_id']) ? "Filtered Products" : "All Products"; ?>
</h2>

<div style="
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
    margin-top:20px;
">
    <?php if (empty($products)): ?>
        <p>No products available.</p>
    <?php else: ?>
        <?php foreach ($products as $p): ?>
        <div style="
            border:1px solid #ddd;
            border-radius:8px;
            background:#fff;
            padding:12px;
            text-align:center;
        ">
            <a href="product.php?id=<?php echo $p['id']; ?>" style="text-decoration:none; color:#333;">
                <img src="uploads/products/<?php echo htmlspecialchars($p['image']); ?>"
                     alt="<?php echo htmlspecialchars($p['name']); ?>"
                     style="width:100%; height:220px; object-fit:cover; border-radius:6px;">

                <h3 style="font-size:18px; margin-top:10px;">
                    <?php echo htmlspecialchars($p['name']); ?>
                </h3>

                <p style="color:#E67E22; font-weight:bold;">
                    $<?php echo number_format($p['price'], 2); ?>
                </p>
            </a>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
