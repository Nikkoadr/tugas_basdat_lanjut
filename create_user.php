<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['user']['id_role'] !== '1') {
    $_SESSION['flash_message'] = [
        'type' => 'warning',
        'message' => 'Anda tidak memiliki akses ke halaman ini.'
    ];
    header('Location: index.php');
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $nama = trim($_POST['nama']);
    $role = $_POST['role'];

    if (empty($username) || empty($nama) || empty($role) || empty($password)) {
        $error = "Semua field harus diisi!";
    } else {
        $password_md5 = md5($password);

        $query = "INSERT INTO users (username, nama, id_role, password) VALUES ('$username', '$nama', '$role', '$password_md5')";

        if ($conn->query($query) === TRUE) {
            header('Location: data_user.php');
            exit();
        } else {
            $error = "Gagal menambahkan user: " . $conn->error;
        }
    }
}
?>