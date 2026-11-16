<?php
    session_start();
    include 'koneksi.php';

    if(!isset($_SESSION['user_id'])){
        header("Location: login.php");
        exit();
    }

    $id = $_GET['id'];

    $ambil = mysqli_prepare($conn, "SELECT * FROM kue WHERE id = ?");
    mysqli_stmt_bind_param($ambil, 'i', $id);
    mysqli_stmt_execute($ambil);

    $result = mysqli_stmt_get_result($ambil);
    $kue = mysqli_fetch_assoc($result);

    if (isset($_POST['simpan'])){
        $nama = $_POST ['nama'];
        $harga = $_POST ['harga'];
        $stok = $_POST ['stok'];

        $namaFoto = $kue['foto'];

        if ($_FILES['foto']['error'] === 0){
            $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
            $namaFoto = uniqid() . "." . $ext;

            move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $namaFoto);

            if (file_exists("uploads/" . $kue['foto'])){
                unlink("uploads/" . $kue['foto']);
            }
        }

        $query = mysqli_prepare($conn, "UPDATE kue SET nama = ?, harga = ?, stok = ?, foto = ? WHERE id = ?");

        mysqli_stmt_bind_param($query, 'siisi', $nama, $harga, $stok, $namaFoto, $id);
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
    <title>Edit Kue</title>

    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class = "card shadow-sm p-4">
        <h4>Edit Kue</h4>

        <form method = "POST" enctype = "multipart/form-data">
            <label>Foto Lama:</label><br>
            <img src = "uploads/<?= $kue['foto'] ?>" width = "120" class = "mb-3"><br>

            <div class = "mb-3">
                <label>Ganti Foto (Opsional)</label>
                <input type = "file" name = "foto" class = "form-control">
            </div>

            <div class = "mb-3">
                <label>Nama Kue</label>
                <input type = "text" name = "nama" class = "form-control" value = "<?= htmlspecialchars($kue['nama']) ?>" required>
            </div>

            <div class = "mb-3">
                <label>Harga</label>
                <input type = "number" name = "harga" class = "form-control" value = "<?= $kue['harga'] ?>" required>
            </div>

            <div class = "mb-3">
                <label>Stok</label>
                <input type = "number" name = "stok" class = "form-control" value = "<?= $kue['stok'] ?>" required>
            </div>

            <button type = "submit" name = "simpan" class = "btn btn-warning">Simpan Perubahan</button>
            <a href = "dashboard.php" class = "btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>