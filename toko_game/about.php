<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Tentang Kami | GameStore.id</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>

<body>
  <!-- HEADER -->
  <header class="site-header">
    <div class="container header-flex">
      <h1 class="logo"><a href="index.php">🎮 GameStore.id</a></h1>
      <nav class="main-nav">
        <a href="index.php">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="about.php" class="active">Tentang</a>
        <a href="contact.php">Kontak</a>
        <a href="admin/login.php" class="btn-admin">Admin</a>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section class="hero small">
    <h1>Tentang GameStore.id</h1>
    <p>Toko Game Online Terpercaya di Indonesia</p>
  </section>

  <!-- KONTEN UTAMA -->
  <main class="container" style="padding: 50px 0;">
    <div class="about-section">
      <img src="assets/img/store.jpg" alt="Toko GameStore" class="about-img">
      <div class="about-text">
        <h2>Kenapa Memilih Kami?</h2>
        <p>
          GameStore.id adalah toko online yang menyediakan berbagai <strong>konsol, game, dan aksesoris original</strong>
          seperti PlayStation, Nintendo, dan Xbox dengan harga terbaik serta bergaransi resmi.
        </p>
        <p>
          Kami berdiri sejak <strong>2020</strong> dan berkomitmen memberikan pengalaman belanja game yang mudah, cepat, dan aman.
          Semua produk dikirim langsung dari distributor resmi dan dapat dikembalikan jika ada kerusakan.
        </p>
        <p>
          Alamat kami berada di <strong>Jakarta</strong>, dan kamu dapat menghubungi kami lewat halaman <a href="contact.php">Kontak</a>.
        </p>
      </div>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> GameStore.id | Toko Game Console Indonesia</p>
    </div>
  </footer>
</body>
</html>
