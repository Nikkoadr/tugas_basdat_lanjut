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
        users.id, 
        users.username, 
        users.nama, 
        role.nama_role
    FROM 
        users
    INNER JOIN 
        role 
    ON 
        users.id_role = role.id
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
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
        <h1>Data Karyawan</h1>
        <div class="mb-3">
            <button class="btn btn-success" onclick="location.href='tambah_user.php'">Tambah Karyawan</button>
        </div>
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
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['username']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['nama_role']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" onclick="location.href='edit_user.php?id=<?php echo $row['id']; ?>'">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="if(confirm('Yakin ingin menghapus?')) location.href='hapus_user.php?id=<?php echo $row['id']; ?>'">Hapus</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
