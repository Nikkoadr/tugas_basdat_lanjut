<?php
session_start();
include 'koneksi.php';

$id_barang = $_GET['id'];

$sql = "DELETE FROM barang WHERE id = $id_barang";

if ($conn->query($sql) === TRUE) {
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Barang berhasil dihapus.'
    ];
} else {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'message' => 'Error: ' . $conn->error
    ];
}

$conn->close();
header("Location: data_barang.php");
exit();
?>
