<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Make sure BASE_URL exists
if (!defined('BASE_URL')) define('BASE_URL', '/jumia_clone/');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Shoply</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
</head>
<body>

<header class="site-header">
  <div class="container">

    <div style="display:flex;align-items:center;gap:18px;">
      <h1><a href="<?= BASE_URL ?>index.php">Shoply</a></h1>

      <form class="search" action="<?= BASE_URL ?>products.php" method="get" style="margin:0;">
        <input type="search" name="search" placeholder="Search products, brands and categories">
      </form>
    </div>

    <nav class="nav">
      <a href="<?= BASE_URL ?>index.php">Home</a>
      <a href="<?= BASE_URL ?>products.php">Shop</a>
      <a href="<?= BASE_URL ?>view_cart.php">Cart</a>

      <?php if(isset($_SESSION['user'])): ?>
        <a href="<?= BASE_URL ?>profile.php">Hi, <?= htmlspecialchars($_SESSION['user']['username']) ?></a>

        <?php if($_SESSION['user']['role']=='admin'): ?>
          <a href="<?= BASE_URL ?>admin/dashboard.php">Admin</a>
        <?php endif; ?>

        <a href="<?= BASE_URL ?>logout.php">Logout</a>

      <?php else: ?>
        <a href="<?= BASE_URL ?>login.php">Login</a>
        <a href="<?= BASE_URL ?>register.php">Register</a>
      <?php endif; ?>
    </nav>

  </div>
</header>

<main class="container">
