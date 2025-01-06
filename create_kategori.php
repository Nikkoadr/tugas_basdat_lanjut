<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_kategori = $_POST['nama_kategori'];


    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";

    if ($conn->query($query) === TRUE) {
        header('Location: data_kategori.php');
        $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Kategori berhasil ditambahkan.'
    ];
        exit();
    } else {
        $error = "Gagal menambahkan Kategori: " . $conn->error;
    }
}

?>