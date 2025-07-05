<?php
// Cegah duplikasi constant
if (!defined('DB_SERVER')) define('DB_SERVER', '127.0.0.1');
if (!defined('DB_USERNAME')) define('DB_USERNAME', 'root');
if (!defined('DB_PASSWORD')) define('DB_PASSWORD', '');
if (!defined('DB_NAME')) define('DB_NAME', 'pengumpulantugas');

// Cek apakah koneksi belum dibuat
if (!isset($conn)) {
    // Membuat koneksi ke database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi ke database gagal: " . $conn->connect_error);
    }
}
?>
