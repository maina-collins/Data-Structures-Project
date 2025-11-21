<?php
session_start();

if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

foreach ($_POST['qty'] as $id => $qty) {
    $qty = (int)$qty;
    if ($qty > 0) {
        $_SESSION['cart'][$id] = $qty;
    }
}

header("Location: /jumia_clone/view_cart.php");
exit;

