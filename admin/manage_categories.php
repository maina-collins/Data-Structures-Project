<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { header('Location: /login.php'); exit; }
$cats = $pdo->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Categories</h2>
<p><a href="edit_category.php">Add Category</a></p>
<table class="table">
<?php foreach($cats as $c): ?>
  <tr><td><?=htmlspecialchars($c['name'])?></td><td><a href="edit_category.php?id=<?=$c['id']?>">Edit</a> | <a href="delete_category.php?id=<?=$c['id']?>" onclick="return confirm('Delete?')">Delete</a></td></tr>
<?php endforeach; ?>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>