<?php
session_start();
include "config.php";

if (isset($_POST["submit"])) {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // PREPARED STATEMENT
    $stmt = $conn->prepare("SELECT * FROM tb_warga WHERE email = ?");
    if (!$stmt) {
        echo "<div class='alert alert-danger'>Kesalahan database!</div>";
    } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // CEK EMAIL
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();


            // CEK PASSWORD HASH
            if (password_verify($password, $row["password"])) {
                
                // SIMPAN SESSION
                $_SESSION["user"] = $row["nama"];
                $_SESSION["nikuser"] = $row["nik"];

                header("Location: dashboard.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Password salah!</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Email tidak ditemukan!</div>";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Laporan Keluhan</title>
    <link href="Assets/CSS/yaa.css" rel="stylesheet">
</head>
<body>
    <div class="card">
    <h2>Login</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name ="email"required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password"required>
        </div>
         <button type="submit" class="btn" name="submit">Login</button>
    </form>
    <div class="register-text">
        Belum punya akun? <a href="reg.php">Register</a>
    </div>
</div>
</body>
</html>