<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }

    include 'koneksi.php';

    $sql = "
        SELECT 
            MIN(jumlah) AS min_jumlah, 
            MAX(jumlah) AS max_jumlah, 
            COUNT(*) AS total_barang 
        FROM barang;
    ";
    $result = $conn->query($sql);
    $rekap = $result->fetch_assoc();

    $sql_min_barang = "
        SELECT nama_barang, jumlah 
        FROM barang 
        WHERE jumlah = (SELECT MIN(jumlah) FROM barang)
        LIMIT 1;
    ";
    $min_barang = $conn->query($sql_min_barang)->fetch_assoc();

    $sql_max_barang = "
        SELECT nama_barang, jumlah 
        FROM barang 
        WHERE jumlah = (SELECT MAX(jumlah) FROM barang)
        LIMIT 1;
    ";
    $max_barang = $conn->query($sql_max_barang)->fetch_assoc();

    $sql_total_per_kategori = "
        SELECT kategori.nama_kategori, SUM(barang.jumlah) AS total_kategori 
        FROM barang 
        INNER JOIN kategori ON barang.id_kategori = kategori.id 
        GROUP BY kategori.nama_kategori;
    ";
    $total_per_kategori = $conn->query($sql_total_per_kategori);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Manajement Gudang</a>
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
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_message']['type']; ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['flash_message']['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    
        <h1>Assalamu'alaikum Wr.Wb, <?= $_SESSION['user']['nama']; ?>!</h1>

    <div class="container mt-5">
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                Rekapitulasi Data Barang
            </div>
            <div class="card-body">
                <p><strong>Barang yang paling sedikit :</strong> <?= $min_barang['nama_barang']; ?> (<?= $min_barang['jumlah']; ?>)</p>
                <p><strong>Barang yang paling banyak :</strong> <?= $max_barang['nama_barang']; ?> (<?= $max_barang['jumlah']; ?>)</p>
                <p><strong>Total Barang di Gudang:</strong> <?= $rekap['total_barang']; ?></p>
                <h5 class="mt-4">Total Barang per Kategori</h5>
                <ul>
                    <?php while ($row = $total_per_kategori->fetch_assoc()): ?>
                        <li><?= $row['nama_kategori']; ?>: <?= $row['total_kategori']; ?></li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="card-footer d-flex justify-content-end">
                <!-- Tombol Laporan -->
                <a href="laporan.php" class="btn btn-success" target="_blank">Lihat Laporan Lengkap</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
