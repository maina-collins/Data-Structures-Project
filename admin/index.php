<?php
session_start();
if (!isset($_SESSION["role"]) || $_SESSION["role"] != 1) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        background: #f5f6fa;
        font-family: Arial, sans-serif;
    }

    .sidebar {
        height: 100vh;
        background: #1a73e8;
        padding-top: 30px;
    }

    .sidebar a {
        color: white;
        display: block;
        padding: 15px 25px;
        font-size: 16px;
        text-decoration: none;
        font-weight: 500;
    }

    .sidebar a:hover {
        background: rgba(255,255,255,0.2);
        border-left: 4px solid #fff;
    }

    .dashboard-card {
        border-radius: 12px;
        transition: 0.2s;
    }

    .dashboard-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 3px 10px rgba(0,0,0,0.15);
    }
</style>
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-3 sidebar">
            <h3 class="text-white text-center mb-4">Admin Panel</h3>

            <a href="manage_users.php"><i class="bi bi-people"></i> Manage Users</a>
            <a href="manage_products.php"><i class="bi bi-box"></i> Manage Products</a>
            <a href="manage_categories.php"><i class="bi bi-tags"></i> Manage Categories</a>
            <a href="../logout.php"><i class="bi bi-door-open"></i> Logout</a>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 p-5">

            <h2>Welcome, <strong><?php echo $_SESSION["username"]; ?></strong></h2>
            <p class="text-muted mb-4">Manage your eCommerce platform here.</p>

            <div class="row">

                <div class="col-md-4 mb-4">
                    <a href="manage_users.php" style="text-decoration:none; color:black;">
                        <div class="card dashboard-card p-4 text-center">
                            <i class="bi bi-people-fill" style="font-size:45px; color:#1a73e8;"></i>
                            <h4 class="mt-3">Users</h4>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-4">
                    <a href="manage_products.php" style="text-decoration:none; color:black;">
                        <div class="card dashboard-card p-4 text-center">
                            <i class="bi bi-box-seam" style="font-size:45px; color:#ff8c00;"></i>
                            <h4 class="mt-3">Products</h4>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 mb-4">
                    <a href="manage_categories.php" style="text-decoration:none; color:black;">
                        <div class="card dashboard-card p-4 text-center">
                            <i class="bi bi-tags-fill" style="font-size:45px; color:#28a745;"></i>
                            <h4 class="mt-3">Categories</h4>
                        </div>
                    </a>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>
