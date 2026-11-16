<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['tambah'])){
    $nama = $_POST ['nama'];
    $harga = $_POST ['harga'];
    $stok = $_POST ['stok'];

    $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    $namaFoto = uniqid() . "." . $ext;

    move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $namaFoto);

    $query = mysqli_prepare($conn, "INSERT INTO kue (nama, harga, stok, foto) VALUES (?, ?, ?, ?)" );

    mysqli_stmt_bind_param($query, 'siis', $nama, $harga, $stok, $namaFoto);
    mysqli_stmt_execute($query);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kue</title>

    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class = "container py-5">
        <div class = "card shadow-sm p-4">
            <h4>Tambah Kue</h4>

            <form method = "POST" enctype = "multipart/form-data">
                <div class = "mb-3">
                    <label>Foto</label>
                    <input type = "file" name = "foto" class = "form-control" required>
                </div>

                <div class = "mb-3">
                    <label>Nama Kue</label>
                    <input type = "text" name = "nama" class = "form-control" required>
                </div>

                <div class = "mb-3">
                    <label>Harga</label>
                    <input type = "number" name = "harga" class = "form-control" required>
                </div>

                <div class = "mb-3">
                    <label>Stok</label>
                    <input type = "number" name = "stok" class = "form-control" required>
                </div>

                <button type = "submit" name = "tambah" class = "btn btn-primary">Tambah</button>
                <a href = "dashboard.php" class = "btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    
</body>
</html>