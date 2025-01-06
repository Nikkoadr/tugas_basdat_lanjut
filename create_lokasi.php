<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_ruangan = $_POST['nama_ruangan'];
    $lokasi = $_POST['lokasi'];


    $query = "INSERT INTO lokasi (nama_ruangan, lokasi) Values ('$nama_ruangan', '$lokasi')";

    if ($conn->query($query) === TRUE) {
        header('Location: data_lokasi.php');
        $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Lokasi berhasil ditambahkan.'
    ];
        exit();
    } else {
        $error = "Gagal menambahkan Lokasi: " . $conn->error;
    }
}

?>