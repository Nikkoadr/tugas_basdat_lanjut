CREATE DATABASE manajemen_gudang;
USE manajemen_gudang;

CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_role VARCHAR(50) NOT NULL UNIQUE
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_role INT NOT NULL,
    FOREIGN KEY (id_role) REFERENCES role(id)
);
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL
);
CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100) NOT NULL,
    kontak VARCHAR(100),
    alamat TEXT
);
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_inventaris VARCHAR(50) NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    id_kategori INT NOT NULL,
    tahun_pembelian INT NOT NULL,
    jumlah INT NOT NULL,
    id_supplier INT NOT NULL,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id),
    FOREIGN KEY (id_supplier) REFERENCES supplier(id)
);
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT NOT NULL,
    tanggal DATE NOT NULL,
    keterangan TEXT,
    FOREIGN KEY (id_barang) REFERENCES barang(id)
);
CREATE TABLE departemen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_departemen VARCHAR(100) NOT NULL,
    deskripsi TEXT
);
CREATE TABLE ruangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruangan VARCHAR(100) NOT NULL,
    lokasi TEXT,
    id_departemen INT NOT NULL,
    FOREIGN KEY (id_departemen) REFERENCES departemen(id)
);
CREATE TABLE log_inventaris (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    tanggal_perubahan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    kolom_berubah VARCHAR(50),
    nilai_lama TEXT,
    nilai_baru TEXT,
    FOREIGN KEY (id_barang) REFERENCES barang(id)
);
CREATE TABLE penugasan_barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    id_ruangan INT NOT NULL,
    tanggal_penugasan DATE NOT NULL,
    tanggal_pengembalian DATE,
    FOREIGN KEY (id_barang) REFERENCES barang(id),
    FOREIGN KEY (id_ruangan) REFERENCES ruangan(id)
);
INSERT INTO role (nama_role) VALUES 
('admin'),
('staf');
INSERT INTO users (username, password, id_role) VALUES 
('admin', MD5('admin123'), 1),
('staf', MD5('staf123'), 2);
INSERT INTO kategori (nama_kategori) VALUES 
('Elektronik'), 
('Alat Tulis'), 
('Perabotan'), 
('Buku'), 
('Alat Laboratorium'), 
('Olahraga'), 
('Kebersihan'), 
('Dekorasi'), 
('Komputer'), 
('Meja dan Kursi');
INSERT INTO supplier (nama_supplier, kontak, alamat) VALUES
('CV Sumber Jaya', '08123456789', 'Jl. Mawar No. 12, Bandung'),
('PT Elektronik Sejahtera', '08567890123', 'Jl. Melati No. 8, Jakarta'),
('Toko Buku Cerdas', '08156789012', 'Jl. Anggrek No. 5, Surabaya'),
('PT Lab Equipment', '08234567890', 'Jl. Kemuning No. 3, Yogyakarta');
INSERT INTO barang (kode_inventaris, nama_barang, id_kategori, tahun_pembelian, jumlah, id_supplier) VALUES
('INV001', 'Laptop', 1, 2022, 10, 1),
('INV002', 'Papan Tulis', 2, 2020, 5, 2),
('INV003', 'Kursi', 10, 2019, 20, 3),
('INV004', 'Buku Pelajaran', 4, 2021, 50, 4),
('INV005', 'Mikroskop', 5, 2023, 8, 4),
('INV006', 'Bola Basket', 6, 2022, 12, 3),
('INV007', 'Sapu', 7, 2020, 15, 2),
('INV008', 'Hiasan Dinding', 8, 2018, 7, 1),
('INV009', 'Komputer Desktop', 9, 2021, 5, 1),
('INV010', 'Meja Guru', 10, 2017, 10, 2);
INSERT INTO transaksi (id_barang, jenis_transaksi, jumlah, tanggal, keterangan) VALUES
(1, 'masuk', 5, '2024-12-01', 'Pembelian tambahan laptop'),
(2, 'keluar', 1, '2024-12-05', 'Dipinjam untuk presentasi kelas'),
(3, 'masuk', 3, '2024-12-10', 'Tambahan perabotan untuk ruang guru'),
(6, 'keluar', 2, '2024-11-20', 'Kegiatan olahraga siswa'),
(5, 'masuk', 1, '2024-12-15', 'Pembelian mikroskop baru');
INSERT INTO departemen (nama_departemen, deskripsi) VALUES
('Administrasi', 'Departemen administrasi sekolah'),
('Teknologi Informasi', 'Departemen pengelolaan teknologi dan informasi'),
('Perpustakaan', 'Departemen pengelolaan buku dan bahan bacaan'),
('Olahraga', 'Departemen pengelolaan kegiatan olahraga');
INSERT INTO ruangan (nama_ruangan, lokasi, id_departemen) VALUES
('Ruang Guru', 'Lantai 1, Gedung A', 1),
('Laboratorium Komputer', 'Lantai 2, Gedung B', 2),
('Perpustakaan', 'Lantai 1, Gedung C', 3),
('Ruang Olahraga', 'Lantai Dasar, Gedung D', 4);
INSERT INTO penugasan_barang (id_barang, id_ruangan, tanggal_penugasan, tanggal_pengembalian) VALUES
(1, 2, '2024-12-15', NULL),
(3, 1, '2024-12-20', '2024-12-25'),
(4, 3, '2024-11-10', NULL),
(6, 4, '2024-12-05', '2024-12-10'),
(8, 1, '2024-12-01', NULL);
