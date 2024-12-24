<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$kategori_query = "SELECT id, nama_kategori FROM kategori";
$supplier_query = "SELECT id, nama_supplier FROM supplier";
$kategori_result = $conn->query($kategori_query);
$supplier_result = $conn->query($supplier_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_inventaris = $_POST['kode_inventaris'];
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $tahun_pembelian = $_POST['tahun_pembelian'];
    $jumlah = $_POST['jumlah'];
    $id_supplier = $_POST['id_supplier'];

    $query = "INSERT INTO barang (kode_inventaris, nama_barang, id_kategori, tahun_pembelian, jumlah, id_supplier) 
            VALUES ('$kode_inventaris', '$nama_barang', '$id_kategori', '$tahun_pembelian', '$jumlah', '$id_supplier')";

    if ($conn->query($query) === TRUE) {
        header('Location: data_barang.php');
        exit();
    } else {
        $error = "Gagal menambahkan barang: " . $conn->error;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1>Tambah Barang</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"> <?php echo htmlspecialchars($error); ?> </div>
        <?php endif; ?>
        <form method="POST" class="mt-4">
            <div class="mb-3">
                <label for="kode_inventaris" class="form-label">Kode Inventaris</label>
                <input type="text" class="form-control" id="kode_inventaris" name="kode_inventaris" value="INV/<?php echo date('Y/m/d'); ?>/<?php echo rand(1000, 9999); ?>" readonly required>
            </div>
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select class="form-select" id="id_kategori" name="id_kategori" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <?php while ($kategori = $kategori_result->fetch_assoc()): ?>
                        <option value="<?php echo $kategori['id']; ?>">
                            <?php echo htmlspecialchars($kategori['nama_kategori']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="tahun_pembelian" class="form-label">Tahun Pembelian</label>
                <input type="number" class="form-control" id="tahun_pembelian" name="tahun_pembelian" required>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
            </div>
            <div class="mb-3">
                <label for="id_supplier" class="form-label">Supplier</label>
                <select class="form-select" id="id_supplier" name="id_supplier" required>
                    <option value="" disabled selected>Pilih Supplier</option>
                    <?php while ($supplier = $supplier_result->fetch_assoc()): ?>
                        <option value="<?php echo $supplier['id']; ?>">
                            <?php echo htmlspecialchars($supplier['nama_supplier']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="data_barang.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
