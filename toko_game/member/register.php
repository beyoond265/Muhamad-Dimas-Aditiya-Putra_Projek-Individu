<?php
session_start();
include("../config/koneksi.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $telepon  = trim($_POST['telepon']);
    $alamat   = trim($_POST['alamat']);
    $tanggal  = date('Y-m-d');

    // cek email apakah sudah terdaftar
    $cek = $conn->query("SELECT * FROM member WHERE email='$email' LIMIT 1");

    if ($cek->num_rows > 0) {
        $message = '<div class="error">❌ Email sudah digunakan!</div>';
    } else {

        // password hash
        $pwHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "
            INSERT INTO member (nama, email, password, telepon, alamat, tanggal_daftar)
            VALUES ('$nama', '$email', '$pwHash', '$telepon', '$alamat', '$tanggal')
        ";

        if ($conn->query($sql)) {
            $message = '<div class="success">✔ Registrasi berhasil! Silakan login.</div>';
        } else {
            $message = '<div class="error">❌ Registrasi gagal! Coba lagi.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Daftar Member - GameStore.id</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    body {
        background: linear-gradient(135deg, #1e1e1e, #d63031);
        color: #fff;
        font-family: 'Poppins', sans-serif;
    }

    .register-box {
        background: #fff;
        color: #333;
        border-radius: 15px;
        max-width: 430px;
        margin: 80px auto;
        padding: 35px 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        text-align: center;
    }

    .register-box h2 {
        color: #d63031;
        margin-bottom: 20px;
    }

    input, textarea {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ccc;
        margin-bottom: 15px;
        font-size: 15px;
        transition: 0.2s;
    }

    textarea {
        resize: none;
        height: 70px;
    }

    input:focus, textarea:focus {
        border-color: #d63031;
        outline: none;
    }

    button {
        width: 100%;
        background: #d63031;
        color: #fff;
        padding: 12px;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 5px;
    }

    button:hover {
        background: #b91c1c;
    }

    .error {
        background: #ffdddd;
        padding: 10px;
        border-left: 4px solid #d63031;
        color: #a10000;
        margin-bottom: 15px;
        border-radius: 6px;
    }

    .success {
        background: #ddffea;
        padding: 10px;
        border-left: 4px solid #00b34a;
        color: #0d6b2f;
        margin-bottom: 15px;
        border-radius: 6px;
    }

    a {
        color: #d63031;
        text-decoration: none;
        font-weight: 600;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

</head>
<body>

<div class="register-box">
    <h2>Daftar Member</h2>

    <?= $message ?>

    <form method="POST">
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email Aktif" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="telepon" placeholder="Nomor Telepon" required>
        <textarea name="alamat" placeholder="Alamat Lengkap" required></textarea>

        <button type="submit">DAFTAR SEKARANG</button>
    </form>

    <p style="margin-top:15px;">
        Sudah punya akun? <a href="login.php">Login</a>
    </p>
    <p><a href="../index.php">⬅ Kembali ke Beranda</a></p>

</div>

</body>
</html>
