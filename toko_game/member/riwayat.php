<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['member_id'];

$query = mysqli_query($conn, "
    SELECT transaksi.*, produk.nama, produk.gambar
    FROM transaksi
    JOIN produk ON transaksi.produk_id = produk.id
    WHERE transaksi.user_id = '$user_id'
    ORDER BY transaksi.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pembelian</title>
    <style>
        body{
            font-family: Arial;
            background: #f4f4f4;
            padding: 20px;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            background: white;
            overflow: hidden;
        }

        table tr th{
            background: #333;
            color: white;
            padding: 10px;
        }

        table td{
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        img.produk-img{
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .status-badge{
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            color: white;
            text-transform: capitalize;
        }
        
        .pending{ background: orange; }
        .diproses{ background: blue; }
        .selesai{ background: green; }
        .batal-oleh-member{ background: red; }

        .cancel-btn{
            background: red;
            padding: 6px 10px;
            color: white;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
        }

        .cancel-btn:hover{ background: darkred; }

        .back-btn{
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background: #222;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .back-btn:hover{ background: black; }

    </style>
</head>
<body>

<h2>Riwayat Pembelian Anda</h2>

<table>
<tr>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Tanggal</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php while($row = mysqli_fetch_assoc($query)) { 
    
    // pastikan lowercase status
    $status = strtolower($row['status']);

    // styling fix
    $class = str_replace(" ", "-", $status);
?>

<tr>
    <td>
        <img class="produk-img" src="../assets/img/<?= $row['gambar'] ?>" alt=""><br>
        <?= $row['nama'] ?>
    </td>

    <td><?= $row['qty'] ?></td>

    <td>Rp <?= number_format($row['total_harga'],0,',','.') ?></td>

    <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>

    <td>
        <span class="status-badge <?= $class ?>">
            <?= ($status == 'batal oleh member') ? 'Batal oleh Member' : ucfirst($row['status']); ?>
        </span>
    </td>

    <td>
        <?php if($status == 'pending' || $status == 'diproses') { ?>
            <a href="transaksi_batal.php?id=<?= $row['id'] ?>" 
               class="cancel-btn"
               onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                Batalkan
            </a>
        <?php } else { ?>
            -
        <?php } ?>
    </td>

</tr>

<?php } ?>

</table>

<a class="back-btn" href="dashboard.php">← Kembali</a>

</body>
</html>
