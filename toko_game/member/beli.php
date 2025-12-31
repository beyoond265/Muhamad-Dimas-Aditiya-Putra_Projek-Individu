<?php
session_start();
include '../config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

// Validasi input
if (!isset($_POST['produk_id']) || !isset($_POST['qty'])) {
    die("Input tidak valid!");
}

$user_id   = $_SESSION['member_id'];
$produk_id = intval($_POST['produk_id']);
$qty       = intval($_POST['qty']);
$tanggal   = date('Y-m-d H:i:s');

// Minimal qty = 1
if ($qty < 1) $qty = 1;

// Cek produk
$stmt = $conn->prepare("SELECT * FROM produk WHERE id = ?");
$stmt->bind_param("i", $produk_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Produk tidak ditemukan!");
}

$produk = $result->fetch_assoc();
$harga = $produk['harga'];
$total_harga = $harga * $qty;

// Simpan transaksi
$stmt2 = $conn->prepare("
    INSERT INTO transaksi (user_id, produk_id, qty, total_harga, created_at)
    VALUES (?, ?, ?, ?, ?)
");
$stmt2->bind_param("iiids", $user_id, $produk_id, $qty, $total_harga, $tanggal);

if ($stmt2->execute()) {
    header("Location: dashboard.php?status=berhasil");
    exit;
} else {
    echo "Gagal memproses transaksi: " . $conn->error;
}
?>
