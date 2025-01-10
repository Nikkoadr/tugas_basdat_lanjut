<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_barang = $_POST['id_barang'];
    $id_lokasi = $_POST['id_lokasi'];
    $jumlah = $_POST['jumlah'];
    $transaksi = $_POST['transaksi'];
    $keterangan = $_POST['keterangan'];

    $query = "SELECT jumlah FROM barang WHERE id = '$id_barang'";
    $result = $conn->query($query);
    $barang = $result->fetch_assoc();

    if ($transaksi == 'keluar' && $barang['jumlah'] < $jumlah) {
        $_SESSION['error'] = "Stok barang tidak cukup!";
    } else {
        if ($transaksi == 'kembali') {
            $query_keluar = "SELECT SUM(jumlah) AS total_keluar FROM transaksi 
                             WHERE id_barang = '$id_barang' AND jenis_transaksi = 'keluar'";
            $result_keluar = $conn->query($query_keluar);
            $data_keluar = $result_keluar->fetch_assoc();
            $total_keluar = $data_keluar['total_keluar'] ?? 0;

            $query_kembali = "SELECT SUM(jumlah) AS total_kembali FROM transaksi 
                              WHERE id_barang = '$id_barang' AND jenis_transaksi = 'kembali'";
            $result_kembali = $conn->query($query_kembali);
            $data_kembali = $result_kembali->fetch_assoc();
            $total_kembali = $data_kembali['total_kembali'] ?? 0;

            $sisa_boleh_kembali = $total_keluar - $total_kembali;

            if ($jumlah > $sisa_boleh_kembali) {
                $_SESSION['error'] = "Jumlah barang yang dikembalikan tidak boleh lebih dari $sisa_boleh_kembali.";
            }
        }

        if (!isset($_SESSION['error'])) {
            if ($transaksi == 'keluar') {
                $new_stok = $barang['jumlah'] - $jumlah;
            } elseif ($transaksi == 'kembali') {
                $new_stok = $barang['jumlah'] + $jumlah;
            }

            $update_query = "UPDATE barang SET jumlah = '$new_stok' WHERE id = '$id_barang'";
            $conn->query($update_query);

            $tanggal = date('Y-m-d');
            $insert_query = "INSERT INTO transaksi (id_barang, jenis_transaksi, jumlah, tanggal, keterangan, id_lokasi) 
                            VALUES ('$id_barang', '$transaksi', '$jumlah', '$tanggal', '$keterangan', '$id_lokasi')";
            $conn->query($insert_query);

            $_SESSION['success'] = "Transaksi berhasil!";
        }
    }
}

header('Location: data_transaksi.php');
exit();
