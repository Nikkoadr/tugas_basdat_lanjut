<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$lokasi_query = "SELECT * FROM lokasi";
$lokasi_result = $conn->query($lokasi_query);

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;

unset($_SESSION['error']);
unset($_SESSION['success']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
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
        <h1>Transaksi Barang</h1>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="proses_transaksi.php">
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" required>
                <input type="hidden" id="id_barang" name="id_barang">
            </div>
            <div class="mb-3">
                <label for="id_lokasi" class="form-label">Lokasi</label>
                <select class="form-select" id="id_lokasi" name="id_lokasi" required>
                    <option value="" disabled selected>Pilih Lokasi</option>
                    <?php while ($lokasi = $lokasi_result->fetch_assoc()): ?>
                        <option value="<?= htmlspecialchars($lokasi['id']); ?>">
                            <?= htmlspecialchars($lokasi['nama_ruangan']) . ' - ' . htmlspecialchars($lokasi['lokasi']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Masukkan Jumlah" required>
            </div>
            <div class="mb-3">
                <label for="transaksi" class="form-label">Jenis Transaksi</label>
                <select class="form-select" id="transaksi" name="transaksi" required>
                    <option value="keluar">Barang Keluar</option>
                    <option value="kembali">Barang Kembali</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            $('#nama_barang').typeahead({
                source: function (query, process) {
                    return $.get('auto_komplit.php', { query: query }, function (data) {
                        return process(data.map(function (item) {
                            return { id: item.id, name: item.nama_barang };
                        }));
                    });
                },
                updater: function (item) {
                    $('#id_barang').val(item.id);
                    return item.name;
                },
                displayText: function (item) {
                    return item.name;
                },
                autoSelect: true,
                minLength: 1
            });
        });
    </script>
</body>
</html>
