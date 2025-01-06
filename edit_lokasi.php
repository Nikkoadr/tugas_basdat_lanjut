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
            lokasi.*
        FROM lokasi
        WHERE lokasi.id = $id
    ";
    $result = $conn->query($query);
    $lokasi = $result->fetch_assoc();
} else {
    header('Location: data_lokasi.php');
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
    <form method="POST" action="update_lokasi.php">
        <input type="hidden" name="id" value="<?= $lokasi['id']; ?>">
        <div class="mb-3">
            <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
            <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" value="<?= $lokasi['nama_ruangan']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" class="form-control" id="lokasi" name="lokasi" value="<?= $lokasi['lokasi']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data_kategori.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
