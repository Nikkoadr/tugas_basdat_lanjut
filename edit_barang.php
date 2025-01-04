<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM barang WHERE id = $id";
    $result = $conn->query($query);
    $barang = $result->fetch_assoc();
} else {
    header('Location: data_barang.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">    
</head>
<body>
    <h1>Edit Barang</h1>
</body>
</html>