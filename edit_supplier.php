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
            supplier.*
        FROM supplier
        WHERE supplier.id = $id
    ";
    $result = $conn->query($query);
    $supplier = $result->fetch_assoc();
} else {
    header('Location: data_supplier.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">    
</head>
<body>
<div class="container mt-5">
    <h1>Edit Supplier</h1>
    <form method="POST" action="update_supplier.php">
        <input type="hidden" name="id" value="<?= $supplier['id']; ?>">
        <div class="mb-3">
            <label for="nama_supplier" class="form-label">Nama Supplier</label>
            <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" value="<?= $supplier['nama_supplier']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="kontak" class="form-label">Kontak</label>
            <input type="text" class="form-control" id="kontak" name="kontak" value="<?= $supplier['kontak']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $supplier['alamat']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data_kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
