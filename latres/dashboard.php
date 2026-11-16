<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn, "SELECT * FROM kue");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
    <div class="container py-4">
        <div class = "d-flex justify-content-between align-items-center mb-3">
            <h3>Katalog Kue</h3>
            <a href ="logout.php" class = "btn btn-danger btn-sm">Logout</a>
        </div>

        <div class="row g-3">
            <?php
                while ($kue = mysqli_fetch_assoc($result)) { ?>
                    <div class="col-md-3">
                       <div class="card">
                        <img src="uploads/<?= $kue['foto'] ?>" class = "card-img-top" style = "height:200px; object-fit:cover">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($kue['nama']) ?></h5>
                                <p class="card-text">Harga: Rp <?= $kue['harga'] ?></p>
                                <p>Stok: <?= $kue['stok'] ?></p>
                                <a href = "edit_kue.php?id=<?= $kue['id'] ?>" class = "btn btn-warning btn-sm">Edit</a>
                                <a href = "hapus_kue.php?id=<?= $kue['id'] ?>" class = "btn btn-danger btn-sm" onclick = "return confirm('Yakin hapus kue ini?')">Hapus</a>
                            </div>
                        </div>
                    </div>
                    
                <?php } ?>
        </div>
        <a href = "tambah_kue.php" class = "btn btn-primary mt-4">Tambah Kue</a>
    </div>
</body>
</html>