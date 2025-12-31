<?php
session_start();
require "../config/koneksi.php";

$id = $_GET['id'];
$ambil = $koneksi->query("SELECT * FROM member WHERE id_member='$id'");
$data = $ambil->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan");
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];

    $koneksi->query("
        UPDATE member
        SET nama='$nama', email='$email', telepon='$telepon', alamat='$alamat'
        WHERE id_member='$id'
    ");

    header("Location: member.php?msg=edit");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Member</title>
    <style>
        body{
            font-family: Arial;
            background: #eef3f7;
            padding: 30px;
        }

        .container{
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 3px 10px rgba(0,0,0,0.15);
            animation: fadeIn 0.4s ease;
        }

        h2{
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label{
            font-weight: bold;
            font-size: 14px;
        }

        input, textarea{
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #bbb;
            border-radius: 6px;
            font-size: 14px;
        }

        textarea{
            height: 80px;
            resize: vertical;
        }

        button{
            display: block;
            width: 100%;
            padding: 12px;
            background: #007bff;
            border: none;
            font-size: 16px;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover{
            background: #005fcc;
        }

        .link-btn{
            display: block;
            width: 100%;
            text-align: center;
            padding: 10px;
            margin-top: 12px;
            border-radius: 6px;
            font-size: 14px;
            text-decoration: none;
            color: white;
            transition: 0.2s;
        }

        .back-member{
            background: #6c757d;
        }

        .back-member:hover{
            background: #5a6268;
        }

        .back-dashboard{
            background: #28a745;
        }

        .back-dashboard:hover{
            background: #1e7e34;
        }

        @keyframes fadeIn{
            from{ opacity:0; transform: translateY(-10px); }
            to{ opacity:1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Data Member</h2>

    <form method="POST">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" value="<?= $data['nama'] ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= $data['email'] ?>" required>

        <label>No. Telepon</label>
        <input type="number" name="telepon" value="<?= $data['telepon'] ?>" required>

        <label>Alamat</label>
        <textarea name="alamat" required><?= $data['alamat'] ?></textarea>

        <button type="submit" name="submit">✔ Simpan Perubahan</button>
    </form>

    <a class="link-btn back-member" href="member.php">← Kembali ke daftar member</a>
    <a class="link-btn back-dashboard" href="index.php">🏠 Kembali ke Dashboard Admin</a>
</div>

</body>
</html>
