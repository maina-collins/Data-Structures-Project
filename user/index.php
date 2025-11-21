<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard</title>

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f0f4ff;
        margin: 0;
    }

    /* Top Navbar */
    .navbar {
        width: 100%;
        background: #0b63e5;
        color: white;
        padding: 15px 40px;
        display: flex;
        justify-content: space-between;
        align-items: left;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .navbar .logo {
        font-size: 24px;
        font-weight: bold;
    }

    .navbar a {
        color: white;
        margin-left: 25px;
        font-size: 18px;
        text-decoration: none;
        font-weight: 500;
    }

    .container {
        width: 80%;
        margin: 50px auto;
    }

    h2 {
        font-size: 28px;
        margin-bottom: 20px;
    }

    .dashboard-box {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        width: 300px;
        text-align: center;
        margin-bottom: 25px;
        transition: 0.3s;
    }

    .dashboard-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .dashboard-box a {
        text-decoration: none;
        font-size: 20px;
        font-weight: bold;
        color: #0b63e5;
    }

   .grid {
    display: flex;
    flex-direction: column;
    align-items: left;
    gap: 10px;
}


</style>
</head>

<body>

<!-- Navbar -->
<div class="navbar">
    <div class="logo">Shoply</div>
    <div>
        <a href="../index.php">Home</a>
        <a href="../shop.php">Shop</a>
        <a href="cart.php">Cart</a>
        <a href="../logout.php" style="font-weight:bold">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Welcome, <strong><?= htmlspecialchars($username); ?></strong></h2>

    <div class="grid">

        <div class="dashboard-box">
            <a href="products.php">Browse Products</a>
        </div>

        <div class="dashboard-box">
            <a href="cart.php">My Cart</a>
        </div>

        <div class="dashboard-box" style="background:#ffe4e4;">
            <a href="../logout.php" style="color:#d80000;">Logout</a>
        </div>

    </div>
</div>

</body>
</html>
