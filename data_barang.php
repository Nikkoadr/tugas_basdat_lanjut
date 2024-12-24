<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$query = "SELECT barang.*, kategori.nama_kategori AS kategori, supplier.nama_supplier AS supplier 
        FROM barang 
        JOIN kategori ON barang.id_kategori = kategori.id 
        JOIN supplier ON barang.id_supplier = supplier.id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">My Website</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Data Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Departement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Log</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Log Inventaris</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Penugasan Barang Ruangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Supplier</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">User</a>
                    </li>
                </ul>
            </div>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Logout</button>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Data Barang</h1>
        <div class="mb-3">
            <button class="btn btn-success" onclick="location.href='tambah_barang.php'">Tambah Barang</button>
        </div>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Kode Inventaris</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Tahun Pembelian</th>
                    <th>Jumlah</th>
                    <th>Supplier</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['kode_inventaris']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                        <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                        <td><?php echo htmlspecialchars($row['tahun_pembelian']); ?></td>
                        <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                        <td><?php echo htmlspecialchars($row['supplier']); ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="location.href='edit_barang.php?id=<?php echo $row['id']; ?>'">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="if(confirm('Yakin ingin menghapus?')) location.href='hapus_barang.php?id=<?php echo $row['id']; ?>'">Hapus</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
