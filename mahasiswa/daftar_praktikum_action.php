<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['praktikum_id'])) {
    $mahasiswa_id = $_SESSION['user_id'];
    $praktikum_id = $_POST['praktikum_id'];

    $stmt = $conn->prepare("INSERT INTO pendaftaran (mahasiswa_id, praktikum_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $mahasiswa_id, $praktikum_id);
    if ($stmt->execute()) {
        header("Location: praktikum_katalog.php?status=sukses&pesan=Pendaftaran berhasil!");
    } else {
        header("Location: praktikum_katalog.php?status=gagal&pesan=Anda sudah terdaftar atau terjadi kesalahan.");
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: praktikum_katalog.php");
}
exit();
?>