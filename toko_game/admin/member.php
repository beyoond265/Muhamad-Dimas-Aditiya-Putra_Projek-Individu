<?php
session_start();
require "../config/koneksi.php";

// CEK LOGIN ADMIN
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: login.php");
    exit;
}

// Hapus member
if (isset($_GET['hapus'])) {
    $hapus_id = $_GET['hapus'];
    
    // Hapus transaksi user jika ada
    $koneksi->query("DELETE FROM transaksi WHERE user_id='$hapus_id'");
    
    // Hapus data member
    $koneksi->query("DELETE FROM member WHERE id_member='$hapus_id'");
    
    header("Location: member.php?msg=hapus");
    exit;
}

// Ambil semua member
$data = $koneksi->query("
    SELECT * FROM member ORDER BY id_member DESC
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Member</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef3f7;
            padding: 25px;
        }

        .container{
            background: white;
            padding: 25px;
            border-radius: 10px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0px 3px 10px rgba(0,0,0,0.12);
            animation: fadeIn 0.4s ease;
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }

        .alert{
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .success{
            background: #c8facc;
            border: 1px solid #56c75f;
        }

        .danger{
            background: #ffd4d4;
            border: 1px solid #ff6464;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 8px;
        }

        th {
            background: #222;
            color: white;
            padding: 12px;
            font-size: 14px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        tr:hover {
            background: #f7f7f7;
        }

        .actions a {
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
        }

        .btn-edit {
            background: #228be6;
            color: white;
        }

        .btn-edit:hover {
            background: #1b6dbc;
        }

        .btn-hapus {
            background: #e03131;
            color: white;
        }

        .btn-hapus:hover {
            background: #b32020;
        }

        .btn-dashboard {
            background: #28a745;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .btn-dashboard:hover {
            background: #1d7a33;
        }

        @keyframes fadeIn {
            from { opacity:0; transform: translateY(-10px); }
            to { opacity:1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Kelola Data Member</h2>

    <a href="index.php" class="btn-dashboard">🏠 Kembali ke Dashboard</a>

    <?php if(isset($_GET['msg'])): ?>
        <?php if($_GET['msg'] == "hapus"): ?>
            <div class="alert danger">Member berhasil dihapus beserta transaksi terkait!</div>
        <?php elseif($_GET['msg'] == "edit"): ?>
            <div class="alert success">Data member berhasil diperbarui!</div>
        <?php endif; ?>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Member</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php while($row = $data->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id_member'] ?></td>
            <td><?= $row['nama'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['telepon'] ?></td>
            <td><?= $row['alamat'] ?></td>

            <td class="actions">
                <a class="btn-edit" href="member_edit.php?id=<?= $row['id_member'] ?>">Edit</a>
                &nbsp;
                <a class="btn-hapus"
                href="?hapus=<?= $row['id_member'] ?>"
                onclick="return confirm('Yakin ingin menghapus member ini beserta transaksi mereka?')">
                    Hapus
                </a>
            </td>

        </tr>
        <?php endwhile; ?>

    </table>

</div>

</body>
</html>
