<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { header('Location: /login.php'); exit; }
$users = $pdo->query('SELECT u.*, r.name as role_name FROM users u LEFT JOIN roles r ON u.role_id=r.id')->fetchAll(PDO::FETCH_ASSOC);
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Users</h2>
<table class="table">
<tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr>
<?php foreach($users as $u): ?>
<tr>
  <td><?=$u['id']?></td>
  <td><?=htmlspecialchars($u['username'])?></td>
  <td><?=htmlspecialchars($u['email'])?></td>
  <td><?=htmlspecialchars($u['role_name'])?></td>
  <td><a href="edit_user.php?id=<?=$u['id']?>">Edit</a> | <a href="delete_user.php?id=<?=$u['id']?>" onclick="return confirm('Delete?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>