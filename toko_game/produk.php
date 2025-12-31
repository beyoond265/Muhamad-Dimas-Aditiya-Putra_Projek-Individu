<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Daftar Produk | GameStore.id</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body>
  <!-- HEADER -->
  <header class="site-header">
    <div class="container header-flex">
      <h1 class="logo"><a href="index.php">🎮 GameStore.id</a></h1>
      <nav class="main-nav">
        <a href="index.php">Beranda</a>
        <a href="produk.php" class="active">Produk</a>
        <a href="about.php">Tentang</a>
        <a href="contact.php">Kontak</a>
        <a href="admin/login.php" class="btn-admin">Admin</a>
      </nav>
    </div>
  </header>

  <!-- HERO -->
  <section class="hero small">
    <h1>🛍️ Semua Produk</h1>
    <p>Pilih konsol, game, dan aksesoris favoritmu!</p>
  </section>

  <!-- DAFTAR PRODUK -->
  <main class="container produk-list" style="padding: 50px 0;">
    <div class="grid">
      <?php
      $res = $conn->query("SELECT * FROM produk ORDER BY id DESC");
      if ($res && $res->num_rows > 0):
        while ($p = $res->fetch_assoc()):
      ?>
        <div class="card">
          <img src="assets/img/<?php echo htmlspecialchars($p['gambar']); ?>" 
               alt="<?php echo htmlspecialchars($p['nama']); ?>">
          <div class="card-body">
            <h4><?php echo htmlspecialchars($p['nama']); ?></h4>
            <p class="price">Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?></p>
            <a class="btn" href="detail.php?id=<?php echo $p['id']; ?>">Lihat Detail</a>
          </div>
        </div>
      <?php 
        endwhile;
      else:
        echo "<p style='text-align:center;'>Belum ada produk tersedia.</p>";
      endif;
      ?>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> <strong>GameStore.id</strong> | Toko Game Console Indonesia</p>
    </div>
  </footer>
</body>
</html>
