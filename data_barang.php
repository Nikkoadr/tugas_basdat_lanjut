<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$cari = isset($_GET['cari']) ? $conn->real_escape_string($_GET['cari']) : '';

$query = "SELECT barang.*, kategori.nama_kategori AS kategori, supplier.nama_supplier AS supplier, users.nama AS nama_penginput 
        FROM barang 
        JOIN kategori ON barang.id_kategori = kategori.id 
        JOIN supplier ON barang.id_supplier = supplier.id
        JOIN users ON barang.id_user = users.id";

if (!empty($cari)) {
    $query .= " WHERE barang.nama_barang LIKE '%$cari%' 
                OR barang.kode_inventaris LIKE '%$cari%'
                OR kategori.nama_kategori LIKE '%$cari%'
                OR supplier.nama_supplier LIKE '%$cari%'";
}

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
            <a class="navbar-brand" href="#">Manajemen Gudang</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <?php include 'navbar.php'; ?>
            </div>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Logout</button>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Data Barang</h1>
        <div class="mb-3">
            <button class="btn btn-success" onclick="location.href='tambah_barang.php'">Tambah Barang</button>
        </div>

        <!-- Form Pencarian -->
        <form method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari barang, kode inventaris, kategori, atau supplier" value="<?= $cari; ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_message']['type']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash_message']['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Kode Inventaris</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Tahun Pembelian</th>
                    <th>Jumlah</th>
                    <th>Supplier</th>
                    <th>Gambar</th>
                    <th>Penginput</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['kode_inventaris']; ?></td>
                            <td><?= $row['nama_barang']; ?></td>
                            <td><?= $row['kategori']; ?></td>
                            <td><?= $row['tahun_pembelian']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                            <td><?= $row['supplier']; ?></td>
                            <td><img src="upload/<?= $row['gambar']; ?>" alt="Gambar Barang" width="100"></td>
                            <td><?= $row['nama_penginput']; ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="location.href='edit_barang.php?id=<?php echo $row['id']; ?>'">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="if(confirm('Yakin ingin menghapus?')) location.href='hapus_barang.php?id=<?php echo $row['id']; ?>'">Hapus</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
