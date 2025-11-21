<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// Get product ID and quantity
$id  = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$qty = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

// If no valid ID → go back to shop
if ($id <= 0) { 
    header('Location: /jumia_clone/index.php'); 
    exit; 
}

// Create cart if empty
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add or update quantity
if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $qty;
} else {
    $_SESSION['cart'][$id] = $qty;
}

// Redirect correctly to cart page
header('Location: /jumia_clone/view_cart.php');
exit;
?>
