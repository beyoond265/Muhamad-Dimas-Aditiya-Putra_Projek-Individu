<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['member_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['member_id'];

$data = $conn->query("
    SELECT cart.id AS cart_id, produk.nama, produk.harga, produk.gambar, cart.qty
    FROM cart 
    JOIN produk ON produk.id = cart.produk_id
    WHERE cart.user_id = $user_id
");
?>
<h2>Keranjang Belanja</h2>

<table border="1" cellpadding="10">
<tr>
  <th>Produk</th>
  <th>Qty</th>
  <th>Harga</th>
  <th>Total</th>
  <th>Aksi</th>
</tr>

<?php 
$total = 0;
while ($c = $data->fetch_assoc()) { 
    $sub = $c['harga'] * $c['qty'];
    $total += $sub;
?>
<tr>
  <td><?= $c['nama'] ?></td>
  <td><?= $c['qty'] ?></td>
  <td><?= number_format($c['harga']) ?></td>
  <td><?= number_format($sub) ?></td>
  <td><a href="hapus_cart.php?id=<?= $c['cart_id'] ?>">Hapus</a></td>
</tr>
<?php } ?>
</table>

<h3>Total: Rp <?= number_format($total) ?></h3>

<a href="checkout.php" class="btn btn-success">Checkout</a>
