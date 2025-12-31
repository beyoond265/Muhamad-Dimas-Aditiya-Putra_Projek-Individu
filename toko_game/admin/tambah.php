<?php
session_start();
if (!isset($_SESSION['is_admin'])) {
  header('Location: login.php');
  exit;
}

include '../config/koneksi.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = trim($_POST['nama']);
  $kategori = trim($_POST['kategori']);
  $deskripsi = trim($_POST['deskripsi']);
  $harga = (int)$_POST['harga'];

  // Default gambar jika tidak upload
  $gambar = 'default.png';

  // Upload gambar jika ada
  if (!empty($_FILES['gambar']['name'])) {
    $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
    $namafile = time() . "_" . preg_replace('/[^a-z0-9\-_\.]/i', '', $_FILES['gambar']['name']);
    $target = "../assets/img/" . $namafile;

    // Validasi ekstensi file
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (in_array($ext, $allowed)) {
      if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
        $gambar = $namafile;
      }
    }
  }

  // Simpan ke database
  $stmt = $conn->prepare("INSERT INTO produk (nama, kategori, deskripsi, harga, gambar) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssds", $nama, $kategori, $deskripsi, $harga, $gambar);

  if ($stmt->execute()) {
    $msg = "✅ Produk <strong>$nama</strong> berhasil ditambahkan!";
  } else {
    $msg = "❌ Gagal menambah produk: " . htmlspecialchars($conn->error);
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tambah Produk - GameStore.id</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      background: #f7f7f7;
      font-family: 'Poppins', sans-serif;
    }

    .form-box {
      background: #fff;
      max-width: 700px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    h2 {
      color: #d63031;
      text-align: center;
      margin-bottom: 25px;
    }

    label {
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 10px;
      font-size: 15px;
    }

    .btn {
      width: 100%;
      background: #d63031;
      color: #fff;
      padding: 12px;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      background: #b91c1c;
    }

    .message {
      text-align: center;
      font-weight: 500;
      margin-bottom: 15px;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 15px;
      color: #333;
      text-decoration: none;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Tambah Produk Baru</h2>

    <?php if ($msg): ?>
      <p class="message"><?= $msg; ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <label>Nama Produk</label>
      <input type="text" name="nama" required placeholder="Masukkan nama produk">

      <label>Kategori</label>
      <input type="text" name="kategori" required placeholder="Contoh: PlayStation, Nintendo, Xbox">

      <label>Harga (Rp)</label>
      <input type="number" name="harga" required placeholder="Masukkan harga produk">

      <label>Deskripsi</label>
      <textarea name="deskripsi" rows="4" placeholder="Deskripsi produk..."></textarea>

      <label>Gambar Produk</label>
      <input type="file" name="gambar" accept="image/*">

      <button type="submit" class="btn">💾 Simpan Produk</button>
    </form>

    <a href="index.php" class="back-link">← Kembali ke Dashboard</a>
  </div>
</body>
</html>
