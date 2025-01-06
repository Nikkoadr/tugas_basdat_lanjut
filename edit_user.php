<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "
        SELECT 
            users.*, 
            role.nama_role
        FROM users
        LEFT JOIN role ON users.id_role = role.id
        WHERE users.id = $id
    ";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();
} else {
    header('Location: data_user.php');
    exit();
}

$roleQuery = "SELECT id, nama_role FROM role";
$roleResult = $conn->query($roleQuery);
$roleOptions = $roleResult->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">    
</head>
<body>
<div class="container mt-5">
    <h1>Edit User</h1>
    <form method="POST" action="update_user.php">
        <input type="hidden" name="id" value="<?= $user['id']; ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password Baru" />
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $user['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="id_role" required>
                <?php foreach ($roleOptions as $role): ?>
                    <option value="<?= $role['id']; ?>" <?= $role['id'] == $user['id_role'] ? 'selected' : ''; ?>>
                        <?= $role['nama_role']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="data_user.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
