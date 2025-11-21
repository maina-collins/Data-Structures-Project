<?php
session_start();
unset($_SESSION['cart']);
header("Location: /jumia_clone/view_cart.php");
exit;
