<?php
include 'koneksi.php';

$search = $_GET['query'] ?? '';
$search = $conn->real_escape_string($search);

$query = "
    SELECT id, nama_barang 
    FROM barang 
    WHERE nama_barang LIKE '%$search%' 
    LIMIT 10
";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'id' => $row['id'],
        'nama_barang' => $row['nama_barang']
    ];
}

header('Content-Type: application/json');
echo json_encode($data);
