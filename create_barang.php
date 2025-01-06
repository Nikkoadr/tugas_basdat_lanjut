<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_inventaris = $_POST['kode_inventaris'];
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $tahun_pembelian = $_POST['tahun_pembelian'];
    $jumlah = $_POST['jumlah'];
    $id_supplier = $_POST['id_supplier'];
    $id_user = $_SESSION['user']['id'];

    $query = "INSERT INTO barang (kode_inventaris, nama_barang, id_kategori, tahun_pembelian, jumlah, id_supplier, id_user) 
            VALUES ('$kode_inventaris', '$nama_barang', '$id_kategori', '$tahun_pembelian', '$jumlah', '$id_supplier', '$id_user')";

    if ($conn->query($query) === TRUE) {
        header('Location: data_barang.php');
        exit();
    } else {
        $error = "Gagal menambahkan barang: " . $conn->error;
    }
}

?>