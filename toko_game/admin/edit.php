<?php
session_start();
if(!isset($_SESSION['is_admin'])) header('Location: login.php');
include '../config/koneksi.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$res = $conn->query("SELECT * FROM produk WHERE id=$id");
$p = $res->fetch_assoc();
if (!$p) { echo "Produk tidak ditemukan"; exit; }
$msg ='';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];
  $harga = (int)$_POST['harga'];

  $gambar = $p['gambar'];
  if (!empty($_FILES['gambar']['name'])) {
    $namafile = time()."_".preg_replace('/[^a-z0-9\-_\.]/i','',$_FILES['gambar']['name']);
    $target = "../assets/img/".$namafile;
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) $gambar = $namafile;
  }

  $stmt = $conn->prepare("UPDATE produk SET nama=?, kategori=?, deskripsi=?, harga=?, gambar=? WHERE id=?");
  $stmt->bind_param("sssisi", $nama,$kategori,$deskripsi,$harga,$gambar,$id);
  if ($stmt->execute()) $msg = "Produk diperbarui.";
  else $msg = "Gagal: ".$conn->error;
  // refresh data
  $res = $conn->query("SELECT * FROM produk WHERE id=$id");
  $p = $res->fetch_assoc();
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Edit Produk</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="container" style="padding:30px 0;">
  <h2>Edit Produk</h2>
  <?php if($msg) echo "<p style='color:green;'>$msg</p>"; ?>
  <form method="post" enctype="multipart/form-data" style="max-width:600px;">
    <label>Nama</label><input name="nama" value="<?php echo htmlspecialchars($p['nama']); ?>" required style="width:100%;padding:8px;margin:6px 0;">
    <label>Kategori</label><input name="kategori" value="<?php echo htmlspecialchars($p['kategori']); ?>" required style="width:100%;padding:8px;margin:6px 0;">
    <label>Harga (angka)</label><input name="harga" value="<?php echo (int)$p['harga']; ?>" required type="number" style="width:100%;padding:8px;margin:6px 0;">
    <label>Deskripsi</label><textarea name="deskripsi" style="width:100%;padding:8px;margin:6px 0;"><?php echo htmlspecialchars($p['deskripsi']); ?></textarea>
    <label>Ganti Gambar (opsional)</label><input type="file" name="gambar" accept="image/*" style="margin:6px 0;">
    <p>Gambar saat ini: <img src="../assets/img/<?php echo htmlspecialchars($p['gambar']); ?>" style="height:60px;vertical-align:middle;border-radius:6px"></p>
    <button class="btn" type="submit">Update</button>
  </form>
  <p style="margin-top:12px;"><a href="index.php">Kembali</a></p>
</div>
</body></html>
