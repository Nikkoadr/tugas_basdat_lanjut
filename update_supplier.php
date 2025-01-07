<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_supplier = $_POST['nama_supplier'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];
        $query = "
            UPDATE supplier
            SET 
                nama_supplier = '$nama_supplier',
                kontak = '$kontak',
                alamat = '$alamat'
            WHERE 
                id = '$id'
        ";

        if ($conn->query($query)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Data Supplier berhasil diperbarui.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $conn->error
            ];
        }
    header('Location: data_supplier.php');
    exit();
} else {
    header('Location: data_supplier.php');
    exit();
}
