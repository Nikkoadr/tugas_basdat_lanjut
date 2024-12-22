<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Gudang</title>
</head>
<body>
    <h1>Selamat datang di Sistem Manajemen Gudang</h1>
    <a href="logout.php">Logout</a>
    <a href="items.php">Kelola Barang</a>
</body>
</html>