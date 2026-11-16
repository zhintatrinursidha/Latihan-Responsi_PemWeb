<?php
include 'koneksi.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $check = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");

    mysqli_stmt_bind_param($check, "s", $username);
    mysqli_stmt_execute($check);

    $result = mysqli_stmt_get_result($check);

    if(mysqli_num_rows($result) > 0){
        $error = "Username sudah terdaftar";
    } else {
        $query = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");

        mysqli_stmt_bind_param($query, "ss", $username, $hashedPassword);

        if(mysqli_stmt_execute($query)){
            header("Location: login.php");
            exit();
        } else {
            $error = "Register Gagal";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class = "bg-light">

<div class = "container d-flex justify-content-center align-items-center" style = "min-height:100vh">
    <div class = "card shadow-sm p-4" style = "width:350px">
        <h4 class = "text-center mb-3">Register</h4>

        <?php
        if(isset($error)){
            echo '<div class = "alert alert-danger">' . $error . '</div>';
        }
        ?>

        <form method = "POST">
            <div class="mb-3">
                <label>Username</label>
                <input type = "text" name = "username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type = "password" name = "password" class="form-control" required>
            </div>
            <button type="submit" name = "register" class="btn btn-success w-100">Register</button>
        </form>
        <p class = "text-center mt-3 mb-0">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</div>

</body>
</html>