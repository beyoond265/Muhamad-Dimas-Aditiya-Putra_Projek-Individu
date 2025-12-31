<?php 
include 'config/koneksi.php';
session_start();

// STATUS LOGIN
$isLogin = isset($_SESSION['member_id']);
$id_member = $isLogin ? $_SESSION['member_id'] : 0;

// Ambil produk
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$res = $conn->query("SELECT * FROM produk WHERE id = $id");
$p = $res->fetch_assoc();

if (!$p) {
  echo "<p style='text-align:center; padding:50px;'>Produk tidak ditemukan.</p>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($p['nama']); ?> | GameStore.id</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
/* POPUP */
.popup-bg {
  display:none;
  position: fixed;
  left:0; top:0;
  width:100%; height:100%;
  background: rgba(0,0,0,0.5);
  justify-content:center;
  align-items:center;
  z-index: 999;
}

.popup-box {
  background:white;
  padding:20px;
  width:300px;
  text-align:center;
  border-radius:10px;
}

.popup-btn {
  padding:10px 15px;
  background:blue;
  color:white;
  border-radius:6px;
  text-decoration:none;
}

.popup-btn:hover {
  background:darkblue;
}
</style>

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
    <h1>🕹️ Detail Produk</h1>
    <p>Lihat informasi lengkap tentang produk pilihanmu</p>
  </section>

  <!-- DETAIL -->
  <main class="container detail-section" style="padding: 60px 0;">
    <div class="detail-card">

      <div class="detail-image">
        <img src="assets/img/<?php echo htmlspecialchars($p['gambar']); ?>" 
             alt="<?php echo htmlspecialchars($p['nama']); ?>">
      </div>

      <div class="detail-info">
        <h2><?php echo htmlspecialchars($p['nama']); ?></h2>
        <p class="price">Rp <?php echo number_format($p['harga'], 0, ',', '.'); ?></p>
        <p><strong>Kategori:</strong> <?php echo htmlspecialchars($p['kategori']); ?></p>
        <p class="desc"><?php echo nl2br(htmlspecialchars($p['deskripsi'])); ?></p>

        <!-- TOMBOL BELI -->
        <?php if(!$isLogin): ?>

          <button class="btn btn-beli" onclick="showPopupLogin()">
            Beli Sekarang
          </button>

        <?php else: ?>

          <!-- FIX NAMA INPUT -->
          <form action="member/beli.php" method="POST">
              <input type="hidden" name="produk_id" value="<?= $p['id']; ?>">
              
              <label>Jumlah:</label>
              <input type="number" name="qty" value="1" min="1" required 
                     style="padding:10px; width:90%; margin-bottom:10px;">
              
              <button type="submit" class="btn btn-beli">Beli Sekarang</button>
          </form>

        <?php endif; ?>

        <a href="produk.php" class="btn btn-back">← Kembali ke Produk</a>
      </div>

    </div>
  </main>

  <!-- POPUP LOGIN -->
  <div class="popup-bg" id="popupLogin">
      <div class="popup-box">
        <h3>Anda belum login</h3>
        <p>Silakan login untuk melakukan pembelian.</p>
        <a href="member/login.php" class="popup-btn">Login Sekarang</a>
        <br><br>
        <a href="#" onclick="closePopup()" style="color:red;">Tutup</a>
      </div>
  </div>

<script>
function showPopupLogin() {
    document.getElementById("popupLogin").style.display = "flex";
}

function closePopup() {
    document.getElementById("popupLogin").style.display = "none";
}
</script>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container">
      <p>&copy; <?php echo date('Y'); ?> GameStore.id | Toko Game Console Indonesia</p>
    </div>
  </footer>

</body>
</html>
