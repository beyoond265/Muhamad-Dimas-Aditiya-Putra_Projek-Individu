<?php
// config/koneksi.php
// koneksi aman, rapi & fleksibel

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'toko_game';

// ---- MODE ERROR ----
// true  = tampilkan error (saat development)
// false = sembunyikan error (production)
$devMode = true;

if ($devMode) {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
} else {
    mysqli_report(MYSQLI_REPORT_OFF);
}

// Membuat koneksi (OOP)
try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8");

    // Alias agar file lain tetap bekerja (jika memakai $koneksi)
    $koneksi = $conn;
    
    // Simpan ke global
    $GLOBALS['conn'] = $conn;
    $GLOBALS['koneksi'] = $koneksi;

} catch (Exception $e) {
    // Jika Dev Mode → tampilkan error
    if ($devMode) {
        die("Koneksi database gagal: " . $e->getMessage());
    } else {
        // Jika Production → tidak bocorkan informasi internal
        error_log("DB Error: " . $e->getMessage());
        die("Terjadi gangguan pada server.");
    }
}
?>
