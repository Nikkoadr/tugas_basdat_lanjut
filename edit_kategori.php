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
            kategori.*
        FROM kategori
        WHERE kategori.id = $id
    ";
    $result = $conn->query($query);
    $kategori = $result->fetch_assoc();
} else {
    header('Location: data_kategori.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">    
</head>
<body>
<div class="container mt-5">
    <h1>Edit User</h1>
    <form method="POST" action="update_kategori.php">
        <input type="hidden" name="id" value="<?= $kategori['id']; ?>">
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= $kategori['nama_kategori']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data_kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
