<?php
session_start();
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'mahasiswa') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file_laporan"])) {
    $modul_id = $_POST['modul_id'];
    $praktikum_id = $_POST['praktikum_id'];
    $mahasiswa_id = $_SESSION['user_id'];
    $file = $_FILES["file_laporan"];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/../../uploads/laporan/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

        $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
        $unique_filename = "laporan_{$mahasiswa_id}_{$modul_id}_" . time() . "." . $file_extension;
        $target_file = $target_dir . $unique_filename;

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO laporan (modul_id, mahasiswa_id, file_laporan) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $modul_id, $mahasiswa_id, $unique_filename);
            $stmt->execute();
        }
    }
    header("Location: praktikum_detail.php?id=$praktikum_id");
    exit();
}
header("Location: dashboard.php");
exit();
?>