<?php
include '../config/koneksi.php';

$inv = $_GET['inv'];

$data = $conn->query("
    SELECT transaksi.*, produk.nama, produk.harga
    FROM transaksi 
    JOIN produk ON produk.id = transaksi.produk_id
    WHERE invoice_id='$inv'
");

?>
<h2>INVOICE <?= $inv ?></h2>

<table border="1" cellpadding="10">
<tr>
    <th>Produk</th>
    <th>Qty</th>
    <th>Harga</th>
    <th>Total</th>
</tr>

<?php 
$grand = 0;
while($t = $data->fetch_assoc()) {
    $grand += $t['total_harga'];
?>
<tr>
    <td><?= $t['nama'] ?></td>
    <td><?= $t['qty'] ?></td>
    <td><?= number_format($t['harga']) ?></td>
    <td><?= number_format($t['total_harga']) ?></td>
</tr>
<?php } ?>

</table>
<h3>Total Bayar: Rp <?= number_format($grand) ?></h3>
