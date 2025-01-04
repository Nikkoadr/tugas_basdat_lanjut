<?php
include 'koneksi.php';
session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash_password = md5($password);

    $query = "SELECT id, username, nama, id_role, password FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($hash_password === $user['password']) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'nama' => $user['nama'],
                'id_role' => $user['id_role']
            ];

            header('Location: index.php');
            exit();
        } else {
            $error = 'Password salah';
        }
    } else {
        $error = 'Username tidak ditemukan';
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-sm" style="width: 300px;">
        <h5 class="text-center mb-4">Login Manajement Gudang</h5>
        <form method="post">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <?php if (isset($error)) echo '<p class="text-danger text-center mt-3">' . $error . '</p>'; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>