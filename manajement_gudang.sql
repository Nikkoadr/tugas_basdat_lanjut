CREATE DATABASE manajement_gudang;
USE manajement_gudang;

CREATE TABLE role (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_role VARCHAR(50) NOT NULL UNIQUE
);
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    nama VARCHAR(255) NOT NULL,
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
    id_user INT NOT NULL,
    FOREIGN KEY (id_kategori) REFERENCES kategori(id),
    FOREIGN KEY (id_supplier) REFERENCES supplier(id),
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    jenis_transaksi ENUM('masuk', 'keluar') NOT NULL,
    jumlah INT NOT NULL,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255)
);

CREATE TABLE lokasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_ruangan VARCHAR(100) NOT NULL,
    lokasi TEXT
);
CREATE TABLE log_aktivitas (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    deskripsi TEXT NOT NULL,
    waktu DATETIME NOT NULL
);
INSERT INTO role (nama_role) VALUES 
('admin'),
('staf');

INSERT INTO users (username, nama, password, id_role) VALUES 
('admin','Administrator', MD5('admin123'), 1),
('staf','Staf', MD5('staf123'), 2);

INSERT INTO kategori (nama_kategori) VALUES 
('Elektronik'), 
('Alat Tulis'), 
('Perabotan'), 
('Buku'), 
('Alat Laboratorium'), 
('Olahraga');

INSERT INTO supplier (nama_supplier, kontak, alamat) VALUES
('PT Enter Komputer', '08123456789', 'Jl. Mawar No. 12, Bandung'),
('PT Nano Komputer', '08567890123', 'Jl. Melati No. 8, Jakarta'),
('Toko Buku Online', '08156789012', 'Jl. Anggrek No. 5, Surabaya'),
('PT Asal Nyambung', '08234567890', 'Jl. Kenangan No. 3, Cirebon');

INSERT INTO barang (kode_inventaris, nama_barang, id_kategori, tahun_pembelian, jumlah, id_supplier, id_user) VALUES
('INV/2025/01/07/0001', 'Laptop', 1, 2025, 10, 1, 1),
('INV/2025/01/07/0002', 'Papan Tulis', 2, 2025, 5, 2, 2),
('INV/2025/01/07/0003', 'Kursi', 3, 2025, 20, 4, 2),
('INV/2025/01/07/0004', 'Buku Pelajaran', 4, 2025, 50, 3, 1),
('INV/2025/01/07/0005', 'Tang Crimping', 5, 2025, 8, 4, 1),
('INV/2025/01/07/0006', 'RJ-45', 1, 2025, 12, 1, 2),
('INV/2025/01/07/0007', 'OTDR', 1, 2025, 15, 1, 1),
('INV/2025/01/07/0008', 'OPM ( Optical Power Meter )', 1, 2025, 7, 1, 2),
('INV/2025/01/07/0009', 'Komputer Desktop', 1, 2025, 5, 1, 1),
('INV/2025/01/07/0010', 'LAN Tester', 5, 2025, 10, 4, 2);

INSERT INTO transaksi (id_barang, jenis_transaksi, jumlah, tanggal, keterangan) VALUES
(1, 'masuk', 5, '2024-12-01', 'Pembelian tambahan laptop'),
(2, 'keluar', 1, '2024-12-05', 'Dipinjam untuk presentasi kelas'),
(3, 'masuk', 3, '2024-12-10', 'Tambahan perabotan untuk ruang guru'),
(6, 'keluar', 2, '2024-11-20', 'Kegiatan olahraga siswa'),
(5, 'masuk', 1, '2024-12-15', 'Pembelian mikroskop baru');

INSERT INTO lokasi (nama_ruangan, lokasi) VALUES
('Ruang TKJ 1', 'Lantai 2, Gedung 2'),
('Laboratorium ANBK', 'Lantai 2, Gedung 2'),
('Ruang Guru', 'Lantai 1, Gedung 2'),
('Ruang Alat', 'Lantai Dasar, Gedung TKJ');

DELIMITER $$

CREATE TRIGGER setelah_barang_ditambah
AFTER INSERT ON barang
FOR EACH ROW
BEGIN
    INSERT INTO log_aktivitas (deskripsi, waktu)
    VALUES (CONCAT('Barang ', NEW.nama_barang, ' ditambahkan.'), NOW());
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER setelah_barang_diupdate
AFTER UPDATE ON barang
FOR EACH ROW
BEGIN
    INSERT INTO log_aktivitas (deskripsi, waktu)
    VALUES (CONCAT('Barang ', OLD.nama_barang, ' diubah menjadi ', NEW.nama_barang, '.'), NOW());
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER setelah_barang_dihapus
AFTER DELETE ON barang
FOR EACH ROW
BEGIN
    INSERT INTO log_aktivitas (deskripsi, waktu)
    VALUES (CONCAT('Barang ', OLD.nama_barang, ' dihapus.'), NOW());
END$$

DELIMITER ;