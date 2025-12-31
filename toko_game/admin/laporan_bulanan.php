<?php
session_start();
require "../config/koneksi.php";

// Cek login admin
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}

// Ambil bulan & tahun
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Ambil transaksi SELESAI
$data = $koneksi->query("
    SELECT 
        tr.qty,
        tr.total_harga,
        tr.created_at,
        p.nama AS produk,
        m.nama AS pembeli
    FROM transaksi tr
    JOIN produk p ON tr.produk_id = p.id
    JOIN member m ON tr.user_id = m.id_member
    WHERE 
        tr.status = 'selesai'
        AND MONTH(tr.created_at) = '$bulan'
        AND YEAR(tr.created_at) = '$tahun'
    ORDER BY tr.created_at DESC
");

// Hitung total pendapatan
$total_query = $koneksi->query("
    SELECT SUM(total_harga) AS total
    FROM transaksi
    WHERE 
        status = 'selesai'
        AND MONTH(created_at) = '$bulan'
        AND YEAR(created_at) = '$tahun'
");
$total = $total_query->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Bulanan</title>
    <style>
        body {
            font-family: Arial;
            background: #eef1f5;
            padding: 20px;
        }

        h2 {
            margin-bottom: 10px;
        }

        .filter {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        select, button {
            padding: 6px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #222;
            color: white;
        }

        .total-box {
            margin-top: 15px;
            background: white;
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 16px;
            background: #444;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-btn:hover {
            background: black;
        }
    </style>
</head>
<body>

<h2>📊 Laporan Penjualan Bulanan</h2>

<div class="filter">
    <form method="GET">
        <label>Bulan:</label>
        <select name="bulan">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                $val = str_pad($i, 2, "0", STR_PAD_LEFT);
                $selected = ($bulan == $val) ? "selected" : "";
                echo "<option value='$val' $selected>$val</option>";
            }
            ?>
        </select>

        <label>Tahun:</label>
        <select name="tahun">
            <?php
            for ($i = 2023; $i <= 2030; $i++) {
                $selected = ($tahun == $i) ? "selected" : "";
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>
        </select>

        <button type="submit">Tampilkan</button>
    </form>
</div>

<table>
    <tr>
        <th>No</th>
        <th>Pembeli</th>
        <th>Produk</th>
        <th>Qty</th>
        <th>Total Harga</th>
        <th>Tanggal</th>
    </tr>

<?php if ($data->num_rows > 0): 
    $no = 1;
    while ($row = $data->fetch_assoc()):
?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $row['pembeli'] ?></td>
        <td><?= $row['produk'] ?></td>
        <td><?= $row['qty'] ?></td>
        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
        <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
    </tr>
<?php endwhile; else: ?>
    <tr>
        <td colspan="6">Tidak ada transaksi selesai pada bulan ini.</td>
    </tr>
<?php endif; ?>
</table>

<div class="total-box">
    <strong>Total Pendapatan Bulan <?= $bulan ?>/<?= $tahun ?>:</strong>
    Rp <?= number_format($total ? $total : 0, 0, ',', '.') ?>
</div>

<a class="back-btn" href="dashboard_admin.php">← Kembali ke Dashboard Admin</a>

</body>
</html>
