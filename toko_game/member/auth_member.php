<?php
session_start();

// jika user belum login atau bukan member
if (!isset($_SESSION['is_member']) || $_SESSION['is_member'] !== true) {
    header("Location: ../login.php");
    exit;
}
?>
