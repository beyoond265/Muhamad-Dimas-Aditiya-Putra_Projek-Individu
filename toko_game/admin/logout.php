<?php
session_start();

// Hapus semua session yang tersimpan
$_SESSION = [];

// Hapus cookie session kalau ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 3600, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

// Destroy session sepenuhnya
session_destroy();

// Redirect ke login admin
header('Location: login.php');
exit;
