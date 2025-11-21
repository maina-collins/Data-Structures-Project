<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { header('Location: /login.php'); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$roles = $pdo->query('SELECT * FROM roles')->fetchAll(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']==='POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $role_id = $_POST['role_id'] ?? 3;
    if(!empty($_POST['password'])) {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $pdo->prepare('UPDATE users SET username=?, email=?, role_id=?, password=? WHERE id=?')->execute([$username,$email,$role_id,$hash,$id]);
    } else {
        $pdo->prepare('UPDATE users SET username=?, email=?, role_id=? WHERE id=?')->execute([$username,$email,$role_id,$id]);
    }
    header('Location: manage_users.php'); exit;
}
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Edit User</h2>
<form method="post">
  <label>Username<br><input name="username" value="<?=htmlspecialchars($user['username'])?>" required></label><br>
  <label>Email<br><input name="email" value="<?=htmlspecialchars($user['email'])?>" required></label><br>
  <label>Role<br><select name="role_id"><?php foreach($roles as $r): ?><option value="<?=$r['id']?>" <?= $user['role_id']==$r['id'] ? 'selected' : ''?>><?=htmlspecialchars($r['name'])?></option><?php endforeach;?></select></label><br>
  <label>Password (leave blank to keep)<br><input type="password" name="password"></label><br>
  <button type="submit">Save</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>