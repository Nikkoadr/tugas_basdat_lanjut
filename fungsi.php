<?php
function tambahBarang($kode_inventaris, $nama_barang, $id_kategori, $tahun_pembelian, $jumlah, $id_supplier, $id_user) {
    global $conn;

    $query = "INSERT INTO barang (kode_inventaris, nama_barang, id_kategori, tahun_pembelian, jumlah, id_supplier, id_user) 
            VALUES ('$kode_inventaris', '$nama_barang', '$id_kategori', '$tahun_pembelian', '$jumlah', '$id_supplier', '$id_user')";

    if ($conn->query($query) === TRUE) {
        return [
            'status' => 'success',
            'message' => 'Barang berhasil ditambahkan.'
        ];
    } else {
        return [
            'status' => 'error',
            'message' => 'Gagal menambahkan barang: ' . $conn->error
        ];
    }
}
?>