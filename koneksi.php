<?php
    $host = 'localhost';
    $user = 'tugas';
    $pass = 'pyoSXbaltviBuQh3';
    $db = 'manajement_gudang';

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>