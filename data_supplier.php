<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['user']['id_role'] !== '1') {
    $_SESSION['flash_message'] = [
        'type' => 'warning',
        'message' => 'Anda tidak memiliki akses ke halaman ini.'
    ];
    header('Location: index.php');
    exit();
}

$query = "
    SELECT 
        supplier.id, 
        supplier.nama_supplier, 
        supplier.kontak, 
        supplier.alamat 
    FROM 
        supplier
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Manajement Gudang</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <?php
            include 'navbar.php';
            ?>
            </div>
            <button class="btn btn-danger" onclick="location.href='logout.php'">Logout</button>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>Data Supplier</h1>
        <div class="mb-3">
            <button class="btn btn-success" onclick="location.href='tambah_supplier.php'">Tambah Supplier</button>
        </div>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Nama Supplier</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nama_supplier']; ?></td>
                        <td><?= $row['kontak']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="location.href='edit_supplier.php?id=<?php echo $row['id']; ?>'">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="if(confirm('Yakin ingin menghapus?')) location.href='hapus_supplier.php?id=<?php echo $row['id']; ?>'">Hapus</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
