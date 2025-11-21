<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/db.php";   // <-- FIXED (same as register.php)

session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Simple + safe query (NO JOIN = NO ERRORS)
    $stmt = $pdo->prepare("SELECT id, username, password, role_id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"]  = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"]     = $user["role_id"];

        // Redirect by role
        if ($user["role_id"] == 1) {
            header("Location: admin/index.php");
        } 
        elseif ($user["role_id"] == 2) {
            header("Location: seller/index.php");
        }
        else {
            header("Location: user/index.php");
        }
        exit;

    } else {
        $message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Jumia Clone</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    display: flex;
    justify-content: center;
    padding-top: 60px;
}
.container {
    width: 350px;
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 0 10px #00000020;
}
input {
    width: 100%;
    padding: 10px;
    margin-top: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
button {
    width: 100%;
    padding: 10px;
    background: #ff9900;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    color: white;
    cursor: pointer;
    margin-top: 15px;
}
button:hover {
    background: #e68a00;
}
.error {
    color: red;
    margin-bottom: 10px;
    text-align: center;
}
</style>

</head>
<body>

<div class="container">

<h2>Login</h2>

<?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>

<form method="POST">
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<p style="margin-top: 15px; text-align:center;">
Don't have an account? <a href="register.php">Register</a>
</p>

</div>

</body>
</html>
