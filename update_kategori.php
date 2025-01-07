<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_kategori = $_POST['nama_kategori'];
        $query = "
            UPDATE kategori
            SET 
                nama_kategori = '$nama_kategori'
            WHERE 
                id = '$id'
        ";

        if ($conn->query($query)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Data Kategori berhasil diperbarui.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $conn->error
            ];
        }
    header('Location: data_kategori.php');
    exit();
} else {
    header('Location: data_kategori.php');
    exit();
}
