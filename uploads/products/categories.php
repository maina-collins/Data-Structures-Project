<?php
require_once 'config.php';
require_once 'includes/db.php';

$page_title = "Categories";
include 'includes/header.php';

// Fetch categories
try {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("<p style='color:red;'>Error loading categories: " . htmlspecialchars($e->getMessage()) . "</p>");
}
?>

<h2>Product Categories</h2>

<?php if (empty($categories)): ?>
    <p>No categories available.</p>
<?php else: ?>
    <div style="
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
        margin-top: 20px;
    ">
        <?php foreach ($categories as $cat): ?>
            <a href="<?php echo BASE_URL; ?>products.php?category_id=<?php echo $cat['id']; ?>"
               style="
                    display:block;
                    padding:15px;
                    border:1px solid #ddd;
                    border-radius:8px;
                    background:#fafafa;
                    text-align:center;
                    font-size:18px;
                    text-decoration:none;
                    color:#333;
                    transition:0.2s;
                "
               onmouseover="this.style.background='#eee'"
               onmouseout="this.style.background='#fafafa'">
                <?php echo htmlspecialchars($cat['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
