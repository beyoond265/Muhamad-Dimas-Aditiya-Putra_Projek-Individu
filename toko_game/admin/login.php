<?php
session_start();

// Jika admin sudah login → langsung ke dashboard
if (!empty($_SESSION['is_admin'])) {
    header("Location: index.php");
    exit;
}

$err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // credential default
    $admin_user = "admin";
    $admin_pass = "12345678";

    if ($username === $admin_user && $password === $admin_pass) {
        
        // buat session admin
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_nama'] = "Administrator";
        
        header("Location: index.php");
        exit;
    } else {
        $err = "❌ Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Login Admin - GameStore.id</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #d63031, #1e1e1e);
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
  </style>
</head>

<body>
  <div class="login-box">
    <h2>Login Admin</h2>

    <?php if ($err): ?>
      <div class="error"><?= $err ?></div>
    <?php endif; ?>

    <form method="post">
      <input type="text" name="username" placeholder="Username Admin" required autocomplete="off">
      <input type="password" name="password" placeholder="Password Admin" required>
      <button class="btn" type="submit">Masuk</button>
    </form>

    <p style="margin-top:15px;">⬅️ <a href="../index.php">Kembali ke Beranda</a></p>
  </div>
</body>
</html>
