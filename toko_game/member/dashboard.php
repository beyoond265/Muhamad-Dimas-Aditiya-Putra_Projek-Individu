<?php
session_start();
include '../config/koneksi.php';

// Cek login
if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$nama = $_SESSION['member_nama'];
$id_member = $_SESSION['member_id'];

// Ambil jumlah transaksi
$q_transaksi = $conn->query("SELECT COUNT(*) AS total FROM transaksi WHERE user_id='$id_member'");
$data_trx = $q_transaksi->fetch_assoc();
$total_transaksi = $data_trx['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Member</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(to bottom right, #9EE7FF, #C9DBFF);
            padding: 30px;
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: auto;
            animation: fadeIn 0.4s ease;
        }

        .header-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin-bottom: 25px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.12);
        }

        .header-box h2 {
            margin: 10px 0;
            color: #333;
            font-size: 26px;
        }

        .header-box p {
            color: #666;
            font-size: 15px;
        }

        .info-stat {
            background: #4CAF50;
            padding: 12px;
            color: white;
            font-size: 14px;
            border-radius: 8px;
            width: fit-content;
            margin: 15px auto 0 auto;
        }

        .menu-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0,0,0,0.12);
        }

        .menu-card h3 {
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .menu-btn {
            display: block;
            padding: 12px;
            background: #0078FF;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 12px;
            font-size: 15px;
            transition: 0.2s ease;
        }

        .menu-btn:hover {
            background: #005ecc;
        }

        .logout-btn {
            background: red !important;
        }

        .logout-btn:hover {
            background: darkred !important;
        }

        .back-btn {
            background: #222;
            margin-top: 18px;
        }

        .back-btn:hover {
            background: #111;
        }

        @keyframes fadeIn{
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Welcome Section -->
    <div class="header-box">
        <h2>Selamat Datang, <?= ucfirst($nama) ?> 👋</h2>
        <p>Senang melihatmu kembali! Ayo cek aktivitas belanjamu.</p>

        <div class="info-stat">
            Total Transaksi Anda: <strong><?= $total_transaksi ?></strong> pesanan
        </div>
    </div>

    <!-- Menu -->
    <div class="menu-card">
        <h3>Menu Member</h3>

        <a class="menu-btn" href="riwayat.php">📄 Riwayat Pembelian</a>
        <a class="menu-btn" href="../produk.php">🛍 Belanja Produk</a>
        <a class="menu-btn logout-btn" href="logout.php">🚪 Logout</a>
        <a class="menu-btn back-btn" href="../index.php">🏠 Kembali ke Dashboard Web</a>
    </div>

</div>

</body>
</html>
