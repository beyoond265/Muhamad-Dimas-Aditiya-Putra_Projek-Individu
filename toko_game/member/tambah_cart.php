<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['member_id'];
$produk_id = intval($_POST['produk_id']);
$qty = intval($_POST['qty']);

// Cek apakah produk sudah ada di cart → update qty
$cek = $conn->query("SELECT * FROM cart WHERE user_id='$user_id' AND produk_id='$produk_id'");
if ($cek->num_rows > 0) {
    $conn->query("UPDATE cart SET qty = qty + $qty WHERE user_id='$user_id' AND produk_id='$produk_id'");
} else {
    $conn->query("INSERT INTO cart (user_id, produk_id, qty, created_at)
                  VALUES ('$user_id', '$produk_id', '$qty', NOW())");
}

header("Location: cart.php?status=added");
exit;
?>
