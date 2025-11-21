<?php
session_start();
function require_role($role_name) {
    if(!isset($_SESSION['user'])) {
        header('Location: /login.php');
        exit;
    }
    if($_SESSION['user']['role'] !== $role_name) {
        // simple role check; adjust logic for multiple roles
        header('HTTP/1.1 403 Forbidden');
        echo 'Access denied.';
        exit;
    }
}
?>