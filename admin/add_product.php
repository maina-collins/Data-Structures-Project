<?php if(session_status()===PHP_SESSION_NONE) session_start(); ?>
<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if(!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['admin','seller'])) {
    header('Location: /login.php');
    exit;
}
$cats = $pdo->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);
$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST') {
    // Basic image validation
    if(!empty($_FILES['image']['name'])){
        $check = getimagesize($_FILES['image']['tmp_name']);
        if($check === false){
            die('Uploaded file is not an image.');
        }
        if($_FILES['image']['size'] > 2 * 1024 * 1024){
            die('Image size exceeds 2MB.');
        }
        $allowed = ['jpg','jpeg','png','gif'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if(!in_array($ext, $allowed)){
            die('Invalid image format.');
        }
    }

    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $desc = $_POST['description'] ?? '';
    $cat = $_POST['category_id'] ?? null;
    $image_name = null;
    if(!empty($_FILES['image']['name'])) {
        $image_name = time().'_'.basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . '/../uploads/' . $image_name);
    }
    $stmt = $pdo->prepare('INSERT INTO products (category_id,name,description,price,image) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$cat,$name,$desc,$price,$image_name]);
    header('Location: manage_products.php');
    exit;
}
require_once __DIR__ . '/../includes/header.php';
?>
<h2>Add Product</h2>
<form method="post" enctype="multipart/form-data">
  <label>Name<br><input name="name" required></label><br>
  <label>Price<br><input name="price" type="number" step="0.01" required></label><br>
  <label>Category<br>
    <select name="category_id">
      <option value="">--</option>
      <?php foreach($cats as $c): ?>
        <option value="<?=$c['id']?>"><?=htmlspecialchars($c['name'])?></option>
      <?php endforeach; ?>
    </select>
  </label><br>
  <label>Image<br><input id="image" type="file" id="image" name="image"></label><br>
<img id="image_preview" src="/jumia_clone/assets/images/placeholder.png" style="display:block;max-width:200px;margin-top:8px;border-radius:4px">
  <label>Description<br><textarea name="description"></textarea></label><br>
  <button type="submit">Save</button>
</form>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>