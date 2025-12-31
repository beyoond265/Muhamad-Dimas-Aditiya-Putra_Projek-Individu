<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['member_id'];
$transaksi_id = $_GET['id'];

// Update transaksi menjadi batal tetapi tetap terlihat di admin
mysqli_query($conn, "
    UPDATE transaksi 
    SET status='Batal oleh member'
    WHERE id='$transaksi_id' AND user_id='$user_id'
");

// Redirect ke riwayat member
header("Location: riwayat.php");
exit;
?>
