<?php
session_start();
include 'koneksi.php';

$id_user = $_GET['id'];

$sql = "DELETE FROM users WHERE id = $id_user";

if ($conn->query($sql) === TRUE) {
    $_SESSION['flash_message'] = [
        'type' => 'success',
        'message' => 'User berhasil dihapus.'
    ];
} else {
    $_SESSION['flash_message'] = [
        'type' => 'danger',
        'message' => 'Error: ' . $conn->error
    ];
}

$conn->close();
header("Location: data_user.php");
exit();
?>
