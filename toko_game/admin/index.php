<?php
session_start();
require '../config/koneksi.php';

// CEK SESSION ADMIN
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}

// TOTAL PRODUK
$totalProduk = $conn->query("SELECT COUNT(*) AS jml FROM produk")->fetch_assoc()['jml'] ?? 0;

// TOTAL MEMBER
$totalMember = $conn->query("SELECT COUNT(*) AS jml FROM member")->fetch_assoc()['jml'] ?? 0;

// TOTAL TRANSAKSI BULAN INI (SELESAI)
$totalBulanIni = $conn->query("
    SELECT SUM(total_harga) AS total 
    FROM transaksi 
    WHERE MONTH(created_at)=MONTH(CURDATE())
    AND YEAR(created_at)=YEAR(CURDATE())
    AND status='Selesai'
")->fetch_assoc()['total'] ?? 0;

// DATA PRODUK
$res = $conn->query("SELECT * FROM produk ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin - GameStore</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
    background:#f1f2f6;
    font-family:'Poppins',sans-serif;
    margin:0;
}
header {
    background:#d63031;
    color:white;
    padding:20px;
    text-align:center;
    font-size:22px;
}
.container {
    max-width:1100px;
    margin:25px auto;
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 4px 14px rgba(0,0,0,.1);
}
.stats {
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
    margin-bottom:25px;
}
.stat-box {
    background:#d63031;
    color:white;
    padding:15px;
    border-radius:10px;
    text-align:center;
}
.stat-box p {
    font-size:26px;
    font-weight:bold;
    margin:5px 0 0;
}
.nav {
    display:flex;
    gap:10px;
    margin-bottom:25px;
    flex-wrap:wrap;
}
.nav a {
    background:black;
    color:white;
    padding:10px 14px;
    border-radius:6px;
    text-decoration:none;
    font-weight:600;
}
.nav a:hover {
    opacity:.85;
}
table {
    width:100%;
    border-collapse:collapse;
}
th,td {
    border:1px solid #ddd;
    padding:10px;
}
th {
    background:#eee;
}
.btn {
    padding:6px 10px;
    font-size:12px;
    border-radius:4px;
    color:white;
    text-decoration:none;
}
.edit { background:#0d6efd; }
.hapus { background:#b91c1c; }
footer {
    text-align:center;
    margin:30px 0;
    font-size:13px;
    color:gray;
}
</style>
</head>

<body>

<header>
    🕹️ Dashboard Admin - GameStore  
    <br>
    <small>Selamat datang, <b><?= htmlspecialchars($_SESSION['admin_nama']) ?></b></small>
</header>

<div class="container">

<div class="stats">
    <div class="stat-box">
        <h4>Total Produk</h4>
        <p><?= $totalProduk ?></p>
    </div>
    <div class="stat-box">
        <h4>Total Member</h4>
        <p><?= $totalMember ?></p>
    </div>
    <div class="stat-box">
        <h4>Penjualan Bulan Ini</h4>
        <p>Rp <?= number_format($totalBulanIni,0,',','.') ?></p>
    </div>
</div>

<div class="nav">
    <a href="member.php">Kelola Member</a>
    <a href="riwayat_admin.php">Riwayat Transaksi</a>
    <a href="laporan_bulanan.php">Laporan Bulanan</a>
    <a href="logout.php" style="background:#b91c1c">Logout</a>
</div>

<h2>Kelola Produk</h2>
<br>
<a href="tambah.php" class="btn edit">+ Tambah Produk</a>
<br><br>

<table>
<tr>
    <th>ID</th>
    <th>Nama Produk</th>
    <th>Kategori</th>
    <th>Harga</th>
    <th>Aksi</th>
</tr>

<?php while ($p = $res->fetch_assoc()): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= htmlspecialchars($p['nama']) ?></td>
    <td><?= htmlspecialchars($p['kategori']) ?></td>
    <td>Rp <?= number_format($p['harga'],0,',','.') ?></td>
    <td>
        <a href="edit.php?id=<?= $p['id'] ?>" class="btn edit">Edit</a>
        <a href="hapus.php?id=<?= $p['id'] ?>" class="btn hapus"
           onclick="return confirm('Yakin ingin menghapus produk ini?')">
           Hapus
        </a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</div>

<footer>
© <?= date('Y') ?> GameStore Admin Panel
</footer>

</body>
</html>
