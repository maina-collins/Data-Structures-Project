<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/session_check.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /login.php');
    exit;
}
$products = $pdo->query('SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id=c.id')->fetchAll(PDO::FETCH_ASSOC);
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Products</h2>
<p><a href="add_product.php">Add Product</a></p>
<table class="table">
  <tr><th>ID</th><th>Name</th><th>Category</th><th>Price</th><th>Actions</th></tr>
  <?php foreach($products as $p): ?>
    <tr>
      <td><?=$p['id']?></td>
      <td><?=htmlspecialchars($p['name'])?></td>
      <td><?=htmlspecialchars($p['category_name'])?></td>
      <td>$<?=number_format($p['price'],2)?></td>
      <td>
        <a href="edit_product.php?id=<?=$p['id']?>">Edit</a> |
        <a href="delete_product.php?id=<?=$p['id']?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>