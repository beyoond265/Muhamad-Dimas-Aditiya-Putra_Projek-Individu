<?php
session_start();
require "../config/koneksi.php";

// CEK LOGIN ADMIN
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}

// UPDATE STATUS TRANSAKSI
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];

    // Cek status saat ini
    $cek = $koneksi->query("SELECT status FROM transaksi WHERE id='$id'")->fetch_assoc();

    if ($cek['status'] === 'Batal oleh member' || $cek['status'] === 'selesai') {
        header("Location: riwayat_admin.php?update=0");
        exit;
    }

    $koneksi->query("UPDATE transaksi SET status='$status' WHERE id='$id'");
    header("Location: riwayat_admin.php?update=1");
    exit;
}

// QUERY TRANSAKSI
$data = $koneksi->query("
    SELECT 
        tr.id,
        tr.qty,
        tr.total_harga,
        tr.created_at,
        tr.status,
        p.nama AS produk,
        p.gambar,
        m.nama AS pembeli
    FROM transaksi tr
    LEFT JOIN produk p ON tr.produk_id = p.id
    LEFT JOIN member m ON tr.user_id = m.id_member
    ORDER BY tr.id DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Admin</title>
    <style>
        body { font-family: Arial; background: #eef1f5; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align:center; }
        th { background: #222; color: white; }
        img { width: 70px; border-radius: 7px; }

        .badge {
            padding: 6px 12px;
            color: white;
            font-size: 13px;
            border-radius: 5px;
            font-weight: bold;
            display:inline-block;
        }

        .pending { background: orange; }
        .diproses { background: blue; }
        .selesai { background: green; }
        .batal-oleh-member { background: red; }

        select, button { padding: 5px; font-size: 13px; }
        button { cursor: pointer; }

        .btn-back {
            background: #222;
            color: white;
            padding: 10px 15px;
            display: inline-block;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .btn-back:hover {
            background: #444;
        }

    </style>
</head>
<body>

<a href="index.php" class="btn-back">⬅ Kembali ke Dashboard</a>

<h2>📦 Riwayat Pesanan Pelanggan</h2>

<?php  
if (isset($_GET['update']) && $_GET['update'] == 1) {
    echo "<p style='color:green;'>Status transaksi berhasil diperbarui.</p>";
} elseif (isset($_GET['update']) && $_GET['update'] == 0) {
    echo "<p style='color:red;'>Transaksi sudah selesai/dibatalkan user, tidak dapat diubah.</p>";
}
?>

<table>
    <tr>
        <th>ID</th>
        <th>Pembeli</th>
        <th>Produk</th>
        <th>Qty</th>
        <th>Total Harga</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th>Aksi Admin</th>
    </tr>

    <?php while($row = $data->fetch_assoc()): 

        $status = strtolower($row['status']);
        $status_class = str_replace(" ", "-", $status);
    ?>

    <tr>

        <td><?= $row['id'] ?></td>
        <td><?= $row['pembeli'] ?></td>

        <td>
            <img src="../assets/img/<?= $row['gambar'] ?>"><br>
            <?= $row['produk'] ?>
        </td>

        <td><?= $row['qty'] ?></td>
        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
        <td><?= date('d-m-Y H:i', strtotime($row['created_at'])) ?></td>

        <td>
            <span class="badge <?= $status_class ?>">
                <?= ucfirst($row['status']) ?>
            </span>
        </td>

        <td>

        <?php if ($row['status'] == 'Batal oleh member'): ?>

            <em style="font-size:12px; color:red;">
                ❌ Tidak dapat diubah
            </em>

        <?php elseif ($row['status'] == 'selesai'): ?>

            <em style="font-size:12px; color:green; font-weight:bold;">
                ✔ Sudah selesai
            </em>

        <?php else: ?>

            <form method="POST">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">

                <select name="status">
                    <option value="pending" <?= $row['status']=='pending'?'selected':'' ?>>Pending</option>
                    <option value="diproses" <?= $row['status']=='diproses'?'selected':'' ?>>Diproses</option>
                    <option value="selesai">Selesai</option>
                </select>

                <button type="submit" name="update_status">Update</button>
            </form>

        <?php endif; ?>

        </td>

    </tr>

    <?php endwhile; ?>

</table>

</body>
</html>
