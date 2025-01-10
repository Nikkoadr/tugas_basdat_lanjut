<?php
session_start();
include 'koneksi.php';
include 'fungsi.php';

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
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $folder = 'upload/';
        $nama_file = basename($_FILES['gambar']['name']);
        $target = $folder . $nama_file;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
            $gambar = $nama_file;
        } else {
            die("Gagal mengunggah gambar.");
        }
    }
    $result = tambahBarang($kode_inventaris, $nama_barang, $id_kategori, $tahun_pembelian, $jumlah, $id_supplier, $gambar, $id_user);

    if ($result['status'] === 'success') {
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'message' => $result['message']
        ];
        header('Location: data_barang.php');
        exit();
    } else {
        $error = $result['message'];
    }
}
?>
