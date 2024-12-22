<?php
include 'koneksi.php';
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $stmt = $conn->prepare("INSERT INTO items (name, quantity) VALUES (?, ?)");
        $stmt->bind_param('si', $name, $quantity);
        $stmt->execute();
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

$result = $conn->query("SELECT * FROM items");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Barang</title>
</head>
<body>
    <h1>Daftar Barang</h1>
    <form method="post">
        <input type="text" name="name" placeholder="Nama Barang" required>
        <input type="number" name="quantity" placeholder="Jumlah" required>
        <button type="submit" name="add">Tambah</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>