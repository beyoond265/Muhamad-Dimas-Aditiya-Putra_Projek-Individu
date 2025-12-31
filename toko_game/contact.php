<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Kontak Kami | GameStore.id</title>
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
        <a href="about.php">Tentang</a>
        <a href="contact.php" class="active">Kontak</a>
        <a href="admin/login.php" class="btn-admin">Admin</a>
      </nav>
    </div>
  </header>

  <!-- HERO SECTION -->
  <section class="hero small">
    <h1>Hubungi Kami</h1>
    <p>Kami siap membantu pertanyaan dan kebutuhan gaming kamu!</p>
  </section>

  <!-- FORM KONTAK -->
  <main class="container" style="padding: 60px 0;">
    <div class="contact-grid">
      <!-- Info Kontak -->
      <div class="contact-info">
        <h2>Informasi Kontak</h2>
        <p>📞 Telepon: <strong>0812-3456-7890</strong></p>
        <p>📧 Email: <strong>support@gamestore.id</strong></p>
        <p>📍 Alamat: Jalan bulak indah No. 1, Jakarta</p>
        <p>🕒 Jam Operasional: Senin - Sabtu, 09:00 - 18:00 WIB</p>
      </div>

      <!-- Formulir -->
      <div class="contact-form">
        <h2>Kirim Pesan</h2>
        <form action="" method="post">
          <label>Nama</label>
          <input type="text" name="nama" required placeholder="Nama lengkap kamu">

          <label>Email</label>
          <input type="email" name="email" required placeholder="Alamat email aktif">

          <label>Pesan</label>
          <textarea name="pesan" rows="5" required placeholder="Tulis pesanmu di sini..."></textarea>

          <button type="submit" class="btn-cta">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </main>

  <!-- MAPS -->
  <section class="map-section">
    <h2>Lokasi Kami</h2>
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.3061830148124!2d106.82014667499316!3d-6.219083693768341!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e924a7f0a9%3A0x503f9c3f2c44a00!2sJakarta!5e0!3m2!1sid!2sid!4v1697869452363!5m2!1sid!2sid" 
      width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
  </section>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> GameStore.id | Toko Game Console Indonesia</p>
    </div>
  </footer>
</body>
</html>
