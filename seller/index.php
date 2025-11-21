<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] != 2) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Seller Dashboard</title>
<style>
body { font-family: Arial; padding: 20px; }
.card { padding:15px; margin:10px 0; border:1px solid #ccc; width:300px; }
a { text-decoration:none; color:#007bff; }
</style>
</head>
<body>

<h1>Seller Dashboard</h1>
<p>Welcome, <strong><?php echo $_SESSION["username"]; ?></strong></p>

<div class="card"><a href="../seller/add_product.php">Add Product</a></div>
<div class="card"><a href="../seller/manage_products.php">Manage Your Products</a></div>
<div class="card"><a href="../logout.php">Logout</a></div>

</body>
</html>
