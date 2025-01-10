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
    $stok = $_POST['stok'];
    $id_supplier = $_POST['id_supplier'];
    $id_user = $_SESSION['user']['id'];
    $gambar = null;

    if ($kode_inventaris && $nama_barang && $id_kategori && $tahun_pembelian && $stok && $id_supplier) {
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $folder = 'upload/';
            $nama_file = basename($_FILES['gambar']['name']);
            $target = $folder . $nama_file;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                $gambar = $nama_file;
            } else {
                $_SESSION['flash_message'] = [
                    'type' => 'danger',
                    'message' => 'Gagal mengunggah gambar.'
                ];
                header('Location: data_barang.php');
                exit();
            }
        }

        $query = "
            UPDATE barang
            SET 
                nama_barang = '$nama_barang',
                id_kategori = $id_kategori,
                tahun_pembelian = '$tahun_pembelian',
                jumlah = $stok,
                id_supplier = $id_supplier,
                id_user = $id_user";

        if ($gambar !== null) {
            $query .= ", gambar = '$gambar'";
        }

        $query .= " WHERE kode_inventaris = '$kode_inventaris'";

        if ($conn->query($query)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Data barang berhasil diperbarui.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Semua inputan harus diisi.'
        ];
    }
    header('Location: data_barang.php');
    exit();
} else {
    header('Location: data_barang.php');
    exit();
}
