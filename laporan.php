<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Include koneksi
include 'koneksi.php';

// Query untuk semua data barang
$sql_barang = "
    SELECT barang.id, barang.nama_barang, barang.jumlah, kategori.nama_kategori 
    FROM barang 
    INNER JOIN kategori ON barang.id_kategori = kategori.id;
";
$data_barang = $conn->query($sql_barang);

// Query untuk rekapitulasi umum
$sql_rekap = "
    SELECT 
        MIN(jumlah) AS min_jumlah, 
        MAX(jumlah) AS max_jumlah, 
        COUNT(*) AS total_barang 
    FROM barang;
";
$result = $conn->query($sql_rekap);
$rekap = $result->fetch_assoc();

// Query barang dengan jumlah paling sedikit
$sql_min_barang = "
    SELECT nama_barang, jumlah 
    FROM barang 
    WHERE jumlah = (SELECT MIN(jumlah) FROM barang)
    LIMIT 1;
";
$min_barang = $conn->query($sql_min_barang)->fetch_assoc();

// Query barang dengan jumlah paling banyak
$sql_max_barang = "
    SELECT nama_barang, jumlah 
    FROM barang 
    WHERE jumlah = (SELECT MAX(jumlah) FROM barang)
    LIMIT 1;
";
$max_barang = $conn->query($sql_max_barang)->fetch_assoc();

// Query total barang per kategori
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
    <title>Laporan Data Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-size: 12pt;
        }
        @media print {
            @page {
                margin: 1cm;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Laporan Data Barang</h1>

        <!-- Tabel Data Barang -->
        <div class="mb-4">
            <h4>Seluruh Data Barang</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $data_barang->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['nama_barang']; ?></td>
                            <td><?= $row['nama_kategori']; ?></td>
                            <td><?= $row['jumlah']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Rekapitulasi -->
        <div class="mb-4">
            <h4>Rekapitulasi Data Barang</h4>
            <p><strong>Barang yang paling sedikit:</strong> <?= $min_barang['nama_barang']; ?> (<?= $min_barang['jumlah']; ?>)</p>
            <p><strong>Barang yang paling banyak:</strong> <?= $max_barang['nama_barang']; ?> (<?= $max_barang['jumlah']; ?>)</p>
            <p><strong>Total Barang di Gudang:</strong> <?= $rekap['total_barang']; ?></p>
            <h5>Total Barang per Kategori</h5>
            <ul>
                <?php while ($row = $total_per_kategori->fetch_assoc()): ?>
                    <li><?= $row['nama_kategori']; ?>: <?= $row['total_kategori']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>

<?php $conn->close(); ?>
