<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/header.php';

$search = $_GET['search'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 12;
$offset = ($page - 1) * $limit;

$where = '';
$params = [];

if ($search) {
    $where = "WHERE name LIKE ? OR description LIKE ?";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM products $where");
$stmt->execute($params);
$total = $stmt->fetchColumn();
$pages = max(1, ceil($total / $limit));

$sql = "SELECT * FROM products $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>Products</h2>

<form method="get" style="margin-top:10px;">
  <input type="text" name="search" value="<?=htmlspecialchars($search)?>" placeholder="Search products..." style="width:60%;">
  <button type="submit">Search</button>
</form>

<div class="product-list">
<?php foreach($products as $p): ?>
  <div class="product-card">
    <img src="<?= $p['image'] ? '/jumia_clone/uploads/products/'.htmlspecialchars($p['image']) : '/jumia_clone/assets/images/placeholder.png' ?>" alt="<?=htmlspecialchars($p['name'])?>">
    <div class="meta">
      <h3><?=htmlspecialchars($p['name'])?></h3>
      <p class="desc"><?=htmlspecialchars(substr($p['description'],0,180))?>...</p>
      <div style="display:flex;align-items:center;justify-content:space-between;margin-top:10px;">
        <div>
          <span class="badge">$<?=number_format($p['price'],2)?></span>
        </div>
        <div class="actions">
          <a href="/jumia_clone/product.php?id=<?=$p['id']?>">View</a>
          <form method="post" action="/jumia_clone/add_to_cart.php" style="display:inline-block;margin:0;">
            <input type="hidden" name="product_id" value="<?=$p['id']?>">
            <input type="hidden" name="quantity" value="1">
            <button type="submit">Add to Cart</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<div class="pagination" style="margin-top:18px;">
<?php for($i=1;$i<=$pages;$i++): ?>
  <a href="?search=<?=urlencode($search)?>&page=<?=$i?>" class="<?= $i==$page?'active':'' ?>"><?=$i?></a>
<?php endfor; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
