<?php
    session_start();
    include 'koneksi.php';

    if (!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit;
    }

    $id = $_GET['id'];

    $ambil = mysqli_prepare($conn, "SELECT foto FROM kue WHERE id = ?");
    mysqli_stmt_bind_param($ambil, 'i', $id);
    mysqli_stmt_execute($ambil);

    $result = mysqli_stmt_get_result($ambil);
    $kue = mysqli_fetch_assoc($result);

    if ($kue){
        if (file_exists("uploads/" . $kue['foto'])){
            unlink("uploads/" . $kue['foto']);
        }

        $query = mysqli_prepare($conn, "DELETE FROM kue WHERE id = ?");
        mysqli_stmt_bind_param($query, 'i', $id);
        mysqli_stmt_execute($query);
    }

    header("Location: dashboard.php");
    exit;
?>