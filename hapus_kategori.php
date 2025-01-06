<?php
session_start();
include 'koneksi.php';

$id_kategori = $_GET['id'];

$sql = "DELETE FROM kategori WHERE id = $id_kategori";

if ($conn->query($sql) === TRUE) {
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Kategori berhasil dihapus.'
    ];
} else {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'message' => 'Error: ' . $conn->error
    ];
}

$conn->close();
header("Location: data_kategori.php");
exit();
?>
