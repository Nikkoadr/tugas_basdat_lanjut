<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_ruangan = $_POST['nama_ruangan'];
    $lokasi = $_POST['lokasi'];
        $query = "
            UPDATE lokasi
            SET 
                nama_ruangan = '$nama_ruangan',
                lokasi = '$lokasi'
            WHERE 
                id = '$id'
        ";

        if ($conn->query($query)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Data lokasi berhasil diperbarui.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $conn->error
            ];
        }
    header('Location: data_lokasi.php');
    exit();
} else {
    header('Location: data_lokasi.php');
    exit();
}
