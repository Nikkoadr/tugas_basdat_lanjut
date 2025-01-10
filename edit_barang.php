<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "
        SELECT 
            barang.*, 
            kategori.nama_kategori, 
            supplier.nama_supplier 
        FROM barang
        LEFT JOIN kategori ON barang.id_kategori = kategori.id
        LEFT JOIN supplier ON barang.id_supplier = supplier.id
        WHERE barang.id = $id
    ";
    $result = $conn->query($query);
    $barang = $result->fetch_assoc();
} else {
    header('Location: data_barang.php');
    exit();
}

$kategoriQuery = "SELECT id, nama_kategori FROM kategori";
$kategoriResult = $conn->query($kategoriQuery);
$kategoriOptions = $kategoriResult->fetch_all(MYSQLI_ASSOC);

$supplierQuery = "SELECT id, nama_supplier FROM supplier";
$supplierResult = $conn->query($supplierQuery);
$supplierOptions = $supplierResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">    
</head>
<body>
<div class="container mt-5">
    <h1>Edit Barang</h1>
    <form method="POST" action="update_barang.php" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label for="kode_inventaris" class="form-label">Kode Inventaris</label>
            <input type="text" class="form-control" id="kode_inventaris" name="kode_inventaris" value="<?= $barang['kode_inventaris']; ?>" readonly required>
        </div>
        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?= $barang['nama_barang']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-control" id="kategori" name="id_kategori" required>
                <?php foreach ($kategoriOptions as $kategori): ?>
                    <option value="<?= $kategori['id']; ?>" <?= $kategori['id'] == $barang['id_kategori'] ? 'selected' : ''; ?>>
                        <?= $kategori['nama_kategori']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
            <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" value="<?= $barang['tahun_pembelian']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" value="<?= $barang['jumlah']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="supplier" class="form-label">Supplier</label>
            <select class="form-control" id="supplier" name="id_supplier" required>
                <?php foreach ($supplierOptions as $supplier): ?>
                    <option value="<?= $supplier['id']; ?>" <?= $supplier['id'] == $barang['id_supplier'] ? 'selected' : ''; ?>>
                        <?= $supplier['nama_supplier']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Upload Gambar</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data_barang.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
