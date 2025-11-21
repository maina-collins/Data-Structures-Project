<?php
require_once __DIR__ . '/includes/db.php';
session_start();
if(!isset($_SESSION['user'])) { header('Location: /login.php'); exit; }
$user_id = $_SESSION['user']['id'];
$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    if(!$username || !$email) $errors[] = 'Username and email required.';
    if(empty($errors)) {
        if(!empty($_POST['password'])) {
            $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $pdo->prepare('UPDATE users SET username=?, email=?, password=? WHERE id=?')->execute([$username,$email,$hash,$user_id]);
        } else {
            $pdo->prepare('UPDATE users SET username=?, email=? WHERE id=?')->execute([$username,$email,$user_id]);
        }
        // refresh session info
        $stmt = $pdo->prepare('SELECT u.*, r.name as role_name FROM users u LEFT JOIN roles r ON u.role_id=r.id WHERE u.id=?');
        $stmt->execute([$user_id]);
        $u = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['user'] = ['id'=>$u['id'],'username'=>$u['username'],'email'=>$u['email'],'role'=>$u['role_name']];
        $errors[] = 'Profile updated.';
    }
}
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$u = $stmt->fetch(PDO::FETCH_ASSOC);
require_once __DIR__ . '/includes/header.php';
?>
<h2>Your Profile</h2>
<?php if($errors): ?><div class="errors"><?=htmlspecialchars($errors[0])?></div><?php endif; ?>
<form method="post">
  <label>Username<br><input name="username" value="<?=htmlspecialchars($u['username'])?>" required></label><br>
  <label>Email<br><input type="email" name="email" value="<?=htmlspecialchars($u['email'])?>" required></label><br>
  <label>New Password (leave blank to keep)<br><input type="password" name="password"></label><br>
  <button type="submit">Save</button>
</form>
<?php require_once __DIR__ . '/includes/footer.php'; ?>