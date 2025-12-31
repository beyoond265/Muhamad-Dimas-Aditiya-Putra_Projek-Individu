<?php
session_start();
if(!isset($_SESSION['is_admin'])) header('Location: login.php');
include '../config/koneksi.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id) {
  // optional: hapus file gambar dari folder jika bukan default.png
  $res = $conn->query("SELECT gambar FROM produk WHERE id=$id");
  if ($res->num_rows) {
    $g = $res->fetch_assoc()['gambar'];
    if ($g && $g != 'default.png' && file_exists("../assets/img/".$g)) unlink("../assets/img/".$g);
  }
  $conn->query("DELETE FROM produk WHERE id=$id");
}
header('Location: index.php');
