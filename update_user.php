<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = intval($_POST['id']);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $id_role = $_POST['id_role'];

    if ($username && $nama && $id_role) {
        $query = "UPDATE users
                SET 
                    username = '$username',
                    nama = '$nama',
                    id_role = $id_role
                WHERE 
                    id = $id_user";

        if ($password) {
            $hashed_password = md5($password);
            $query = "UPDATE users
                    SET 
                        username = '$username',
                        password = '$hashed_password',
                        nama = '$nama',
                        id_role = $id_role
                    WHERE 
                        id = $id_user";
        }

        if ($conn->query($query)) {
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'message' => 'Data Karyawan berhasil diperbarui.'
            ];
        } else {
            $_SESSION['flash_message'] = [
                'type' => 'danger',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $conn->error
            ];
        }
    } else {
        $_SESSION['flash_message'] = [
            'type' => 'danger',
            'message' => 'Semua inputan harus diisi.'
        ];
    }
    header('Location: data_user.php');
    exit();
} else {
    header('Location: data_user.php');
    exit();
}
