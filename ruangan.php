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
        ruangan.id, 
        ruangan.nama_ruangan, 
        ruangan.lokasi
    FROM 
        ruangan
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
        <h1>Data Ruangan</h1>
        <div class="mb-3">
            <button class="btn btn-success" onclick="location.href='tambah_user.php'">Tambah Ruangan</button>
        </div>
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Nama Ruangan</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['nama_ruangan']; ?></td>
                        <td><?= $row['lokasi']; ?></td>
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
