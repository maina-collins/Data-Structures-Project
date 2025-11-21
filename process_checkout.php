<?php
session_start();
require_once __DIR__ . '/includes/db.php';

if (!$_SESSION['cart']) {
    header("Location: cart.php");
    exit;
}

$fullname = trim($_POST['fullname']);
$email    = trim($_POST['email']);
$phone    = trim($_POST['phone']);
$address  = trim($_POST['address']);

$cart = $_SESSION['cart'];

// Insert order
$stmt = $pdo->prepare("INSERT INTO orders (fullname, email, phone, address, created_at) VALUES (?,?,?,?,NOW())");
$stmt->execute([$fullname, $email, $phone, $address]);

$order_id = $pdo->lastInsertId();

// Insert order items
foreach ($cart as $product_id => $qty) {
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?,?,?)");
    $stmt->execute([$order_id, $product_id, $qty]);
}

// Clear cart
unset($_SESSION['cart']);

// Redirect
header("Location: order_success.php?order_id=".$order_id);
exit;
