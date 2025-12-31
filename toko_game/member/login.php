<?php
session_start();
require_once '../config/koneksi.php';

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim($_POST['password']);

    // Ambil data user
    $q = $conn->query("SELECT * FROM member WHERE email='$email' LIMIT 1");

    if ($q && $q->num_rows > 0) {
        $user = $q->fetch_assoc();

        // Verifikasi password hash
        if (password_verify($password, $user['password'])) {

            $_SESSION['member_id']  = $user['id_member'];
            $_SESSION['member_nama'] = $user['nama'];

            // ⛔ TIDAK MASUK DASHBOARD LAGI
            // ⭕ LANGSUNG BALIK KE HOME
            header("Location: ../index.php");
            exit;

        } else {
            $err = "❌ Password salah!";
        }
    } else {
        $err = "❌ Email tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login Member - GameStore.id</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #1e1e1e, #d63031);
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }

    .login-box {
      background: #fff;
      color: #333;
      border-radius: 15px;
      max-width: 400px;
      margin: 100px auto;
      padding: 40px 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.3);
      text-align: center;
    }

    .login-box h2 {
      margin-bottom: 20px;
      color: #d63031;
    }

    .login-box input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-bottom: 15px;
      font-size: 15px;
      transition: 0.2s;
    }

    .login-box input:focus {
      border-color: #d63031;
      outline: none;
    }

    .login-box .btn {
      width: 100%;
      background: #d63031;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .login-box .btn:hover {
      background: #b91c1c;
    }

    .error {
      background: #ffdddd;
      color: #a10000;
      border-left: 4px solid #d63031;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      font-size: 14px;
    }

    .login-box p a {
      color: #d63031;
      text-decoration: none;
      font-weight: 600;
    }

    .login-box p a:hover {
      text-decoration: underline;
    }

  </style>
</head>

<body>
  <div class="login-box">
    <h2>Login Member</h2>

    <?php if ($err): ?>
      <div class="error"><?= $err ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="email" name="email" placeholder="Masukkan Email" required autocomplete="off">
      <input type="password" name="password" placeholder="Masukkan Password" required>
      <button class="btn" type="submit">Masuk</button>
    </form>

    <p style="margin-top:15px;"><a href="register.php">Belum punya akun? Daftar →</a></p>
    <p style="margin-top:15px;">⬅️ <a href="../index.php">Kembali</a></p>
  </div>
</body>
</html>
