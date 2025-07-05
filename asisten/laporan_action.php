<?php
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_laporan = $_POST['id_laporan'];
    $nilai = $_POST['nilai'];
    $feedback = $_POST['feedback'];

    $stmt = $conn->prepare("UPDATE laporan SET nilai=?, feedback=? WHERE id=?");
    $stmt->bind_param("dsi", $nilai, $feedback, $id_laporan);
    $stmt->execute();
}

header("Location: laporan_masuk.php");
exit();