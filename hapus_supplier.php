<?php
session_start();
include 'koneksi.php';

$id_supplier = $_GET['id'];

$sql = "DELETE FROM supplier WHERE id = $id_supplier";

if ($conn->query($sql) === TRUE) {
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'Supplier berhasil dihapus.'
    ];
} else {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'message' => 'Error: ' . $conn->error
    ];
}

$conn->close();
header("Location: data_supplier.php");
exit();
?>
