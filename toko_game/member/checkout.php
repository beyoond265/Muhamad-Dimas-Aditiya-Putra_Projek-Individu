<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['member_id'])) { exit("Not allowed"); }

$user_id = $_SESSION['member_id'];

// ambil cart
$cart = $conn->query("
    SELECT * FROM cart WHERE user_id = $user_id
");

if ($cart->num_rows == 0) {
    die("Keranjang kosong!");
}

$invoice = "INV-" . time(); // invoice unik

while ($c = $cart->fetch_assoc()) {
    $p = $conn->query("SELECT * FROM produk WHERE id=" . $c['produk_id'])->fetch_assoc();
    $total = $p['harga'] * $c['qty'];    

    $conn->query("
        INSERT INTO transaksi (user_id, produk_id, qty, total_harga, created_at, invoice_id)
        VALUES ('$user_id', '{$c['produk_id']}', '{$c['qty']}', '$total', NOW(), '$invoice')
    ");
}

// kosongkan cart
$conn->query("DELETE FROM cart WHERE user_id='$user_id'");

header("Location: invoice.php?inv=$invoice");
exit;
?>
