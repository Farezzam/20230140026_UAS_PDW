<?php
require_once __DIR__ . '/../config.php';

$action = $_REQUEST['action'] ?? '';
$id = $_REQUEST['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = $_POST['kode_praktikum'];
    $nama = $_POST['nama_praktikum'];
    $deskripsi = $_POST['deskripsi'];

    if ($action === 'create') {
        $stmt = $conn->prepare("INSERT INTO mata_praktikum (kode_praktikum, nama_praktikum, deskripsi) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $kode, $nama, $deskripsi);
        $stmt->execute();
    } elseif ($action === 'update' && $id > 0) {
        $stmt = $conn->prepare("UPDATE mata_praktikum SET kode_praktikum=?, nama_praktikum=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("sssi", $kode, $nama, $deskripsi, $id);
        $stmt->execute();
    }
}

if ($action === 'delete' && $id > 0) {
    $stmt = $conn->prepare("DELETE FROM mata_praktikum WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: praktikum_manage.php");
exit();