<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
    </li>
    
    <?php if ($_SESSION['user']['id_role'] === '1'): ?>
        <li class="nav-item">
            <a class="nav-link" href="data_user.php">User</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="data_supplier.php">Supplier</a>
        </li>
    <?php endif; ?>
    
    <li class="nav-item">
        <a class="nav-link" href="data_kategori.php">Kategori</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="data_lokasi.php">lokasi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="data_barang.php">Data Barang</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="transaksi.php">Transaksi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="log_barang.php">Log Barang</a>
    </li>
</ul>
