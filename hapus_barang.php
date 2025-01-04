<?php
include 'koneksi.php';

$id_barang = $_GET['id'];

$sql = "DELETE FROM barang WHERE id = $id_barang";

if ($conn->query($sql) === TRUE) {
    echo "Barang berhasil dihapus";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: data_barang.php");
exit();
?>