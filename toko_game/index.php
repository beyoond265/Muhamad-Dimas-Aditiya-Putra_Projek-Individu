<?php 
include 'config/koneksi.php'; 
session_start();

$isLogin = isset($_SESSION['member_id']);
$memberNama = $isLogin ? $_SESSION['member_nama'] : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>GameStore.id - Toko Game Console</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
/* --- DROPDOWN USER --- */
.user-menu {
  position: relative;
  display: inline-block;
}

.user-btn {
  cursor: pointer;
  padding: 8px 14px;
  background: #333;
  color: #fff;
  border-radius: 6px;
}

.user-dropdown {
  display: none;
  position: absolute;
  right: 0;
  background: white;
  border: 1px solid #ddd;
  border-radius: 6px;
  margin-top: 5px;
  width: 160px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.user-dropdown a {
  display: block;
  padding: 10px;
  color: #333;
  text-decoration: none;
}

.user-dropdown a:hover {
  background: #f3f3f3;
}
</style>

</head>

<body>

  <!-- HEADER -->
  <header class="site-header">
    <div class="container header-flex">
      <h1 class="logo"><a href="index.php">🎮 GameStore.id</a></h1>

      <nav class="main-nav">
        <a href="index.php" class="active">Beranda</a>
        <a href="produk.php">Produk</a>
        <a href="about.php">Tentang</a>
        <a href="contact.php">Kontak</a>

        <?php if(!$isLogin): ?>

            <a href="member/login.php" class="btn-primary">Login Member</a>

        <?php else: ?>

          <!-- MENU USER -->
          <div class="user-menu">
              <span class="user-btn" id="userBtn">
                Halo, <?= htmlspecialchars($memberNama); ?> ▼
              </span>

              <div class="user-dropdown" id="userDropdown">
                <a href="member/dashboard.php">Dashboard Member</a>
                <a href="member/riwayat.php">Riwayat Pembelian</a>
                <a href="member/logout.php" style="color:red;">Logout</a>
              </div>
          </div>

        <?php endif; ?>

        <a href="admin/login.php" class="btn-admin">Admin</a>
      </nav>

    </div>
  </header>

  <!-- HERO -->
  <section class="hero">
    <h1>🎮 Temukan Konsol Impianmu</h1>
    <p>PlayStation, Nintendo, dan Xbox original dengan harga terbaik dan bergaransi resmi!</p>
    <a href="produk.php" class="btn-cta">Belanja Sekarang</a>
  </section>

  <!-- PRODUK TERBARU -->
  <main class="container produk-list">
    <h2>🔥 Produk Terbaru</h2>

    <div class="grid">
      <?php
      $res = $conn->query("SELECT * FROM produk ORDER BY id DESC LIMIT 6");
      if ($res && $res->num_rows > 0):
        while ($p = $res->fetch_assoc()):
      ?>
      <div class="card">

        <div class="img-wrap">
          <img src="assets/img/<?= htmlspecialchars($p['gambar']); ?>" 
               alt="<?= htmlspecialchars($p['nama']); ?>">
        </div>

        <div class="card-body">
          <h4><?= htmlspecialchars($p['nama']); ?></h4>
          <p class="price">Rp <?= number_format($p['harga'], 0, ',', '.'); ?></p>
          <a class="btn" href="detail.php?id=<?= $p['id']; ?>">Lihat Detail</a>
        </div>

      </div>
      <?php endwhile; else: ?>
        <p style="text-align:center;">Belum ada produk tersedia.</p>
      <?php endif; ?>
    </div>
  </main>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?= date('Y'); ?> GameStore.id | Toko Game Console Indonesia</p>
    </div>
  </footer>

<script>
document.getElementById("userBtn")?.addEventListener("click", function() {
    let box = document.getElementById("userDropdown");
    box.style.display = box.style.display === "block" ? "none" : "block";
});

document.addEventListener("click", function(e) {
    const wrap = document.querySelector(".user-menu");
    const drop = document.getElementById("userDropdown");
    if (!wrap.contains(e.target)) drop.style.display = "none";
});
</script>

</body>
</html>
