<?php
require_once __DIR__ . '/../config.php';

$action = $_REQUEST['action'] ?? '';
$praktikum_id = $_REQUEST['praktikum_id'] ?? 0;
$modul_id = $_REQUEST['modul_id'] ?? 0;

function handleFileUpload($file) {
    if ($file && $file['error'] === UPLOAD_ERR_OK) {
        $target_dir = __DIR__ . "/../../uploads/materi/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = time() . '_' . basename($file["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            return $filename;
        }
    }
    return null;
}

// CREATE & UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_modul'];
    $deskripsi = $_POST['deskripsi'];
    $filename = handleFileUpload($_FILES['file_materi'] ?? null);

    if ($action === 'create') {
        $stmt = $conn->prepare("INSERT INTO modul (praktikum_id, nama_modul, deskripsi, file_materi) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $praktikum_id, $nama, $deskripsi, $filename);
        $stmt->execute();
    } elseif ($action === 'update' && $modul_id > 0) {
        if ($filename) { // Jika ada file baru diupload
            $stmt = $conn->prepare("UPDATE modul SET nama_modul=?, deskripsi=?, file_materi=? WHERE id=?");
            $stmt->bind_param("sssi", $nama, $deskripsi, $filename, $modul_id);
        } else { // Jika tidak ada file baru
            $stmt = $conn->prepare("UPDATE modul SET nama_modul=?, deskripsi=? WHERE id=?");
            $stmt->bind_param("ssi", $nama, $deskripsi, $modul_id);
        }
        $stmt->execute();
    }
}

// DELETE
if ($action === 'delete' && $modul_id > 0) {
    $stmt = $conn->prepare("DELETE FROM modul WHERE id=?");
    $stmt->bind_param("i", $modul_id);
    $stmt->execute();
}

header("Location: modul_manage.php?praktikum_id=" . $praktikum_id . "&status=sukses&pesan=Aksi berhasil dijalankan!");
exit();