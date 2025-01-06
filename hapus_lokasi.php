<?php
session_start();
include 'koneksi.php';

$id_lokasi = $_GET['id'];

$sql = "DELETE FROM lokasi WHERE id = $id_lokasi";

if ($conn->query($sql) === TRUE) {
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Lokasi berhasil dihapus.'
    ];
} else {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'message' => 'Error: ' . $conn->error
    ];
}

$conn->close();
header("Location: data_lokasi.php");
exit();
?>
