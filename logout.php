<?php
session_start();
include 'config.php';

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Redirect ke halaman login
header("Location: ../login.php");
exit;
?>