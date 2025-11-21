<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/includes/db.php";   // <-- FIXED

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($username) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {

        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->rowCount() > 0) {
            $message = "Email or username already exists.";
        } else {

            $hashed = password_hash($password, PASSWORD_DEFAULT);

            // Insert customer (role_id = 3)
            $stmt = $pdo->prepare("
                INSERT INTO users (username, email, password, role_id)
                VALUES (?, ?, ?, 3)
            ");

            if ($stmt->execute([$username, $email, $hashed])) {
                header("Location: login.php?registered=1");
                exit;
            } else {
                $message = "Registration failed.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Jumia Clone</title>

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

<h2>Create Account</h2>

<?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email Address" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>

<p style="margin-top:15px; text-align:center;">
Already have an account? <a href="login.php">Login</a>
</p>

</div>

</body>
</html>
