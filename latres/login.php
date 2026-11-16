<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_prepare($conn, "SELECT id, password FROM users WHERE username = ?");

    mysqli_stmt_bind_param($query, "s", $username);
    mysqli_stmt_execute($query);

    $result = mysqli_stmt_get_result($query);
    $user = mysqli_fetch_assoc($result);

    if($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class = "bg-light">

<div class = "container d-flex justify-content-center align-items-center" style = "min-height:100vh">
    <div class = "card shadow-sm p-4" style = "width:350px">
        <h4 class = "text-center mb-3">Login</h4>

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
            <button type="submit" name = "login" class="btn btn-primary w-100">Login</button>
        </form>
        <p class = "text-center mt-3 mb-0">Belum punya akun? <a href="register.php">Register</a></p>
    </div>
</div>

</body>
</html>