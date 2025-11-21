<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { header('Location: /login.php'); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$cat = null;
if($id) {
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    $cat = $stmt->fetch(PDO::FETCH_ASSOC);
}
if($_SERVER['REQUEST_METHOD']==='POST') {
    $name = $_POST['name'] ?? '';
    $desc = $_POST['description'] ?? '';
    if($id) {
        $pdo->prepare('UPDATE categories SET name=?, description=? WHERE id=?')->execute([$name,$desc,$id]);
    } else {
        $pdo->prepare('INSERT INTO categories (name,description) VALUES (?,?)')->execute([$name,$desc]);
    }
    header('Location: manage_categories.php'); exit;
}
require_once __DIR__ . '/../includes/header.php';
?>
<h2><?= $id ? 'Edit' : 'Add' ?> Category</h2>
<form method="post">
  <label>Name<br><input name="name" value="<?= $cat ? htmlspecialchars($cat['name']) : ''?>" required></label><br>
  <label>Description<br><textarea name="description"><?= $cat ? htmlspecialchars($cat['description']) : ''?></textarea></label><br>
  <button type="submit">Save</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>