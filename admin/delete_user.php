<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') { header('Location: /login.php'); exit; }
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$id]);
header('Location: manage_users.php'); exit;
?>