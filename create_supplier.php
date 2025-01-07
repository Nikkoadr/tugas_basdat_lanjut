<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_supplier = $_POST['nama_supplier'];
    $lokasi = $_POST['kontak'];
    $alamat = $_POST['alamat'];


    $query = "INSERT INTO supplier (nama_supplier, kontak ,alamat) Values ('$nama_supplier', '$lokasi', '$alamat')";

    if ($conn->query($query) === TRUE) {
        header('Location: data_supplier.php');
        $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Supplier berhasil ditambahkan.'
    ];
        exit();
    } else {
        $error = "Gagal menambahkan Supplier: " . $conn->error;
    }
}

?>