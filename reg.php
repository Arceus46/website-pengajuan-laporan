<?php
    include 'config.php';
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nik = $_POST['nik'] ?? '';
        $nama = $_POST['nama'] ?? '';
        $alamat = $_POST['alamat'] ?? '';
        $no_hp = $_POST['no_hp'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirmPassword'] ?? '';

        if ($password !== $confirmPassword) {
            echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toast = document.createElement('div');
                        toast.className = 'toast';
                        toast.textContent = 'Password Tidak Cocok!';
                        document.body.appendChild(toast);

                        setTimeout(() => toast.remove(), 3000);
                    });";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $conn->prepare("INSERT INTO tb_warga (nik, nama, alamat, no_hp, email, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $nik, $nama, $alamat, $no_hp, $email, $hashedPassword);
            
            if ($stmt->execute()) {
                echo "
                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const toast = document.createElement('div');
                        toast.className = 'toast';
                        toast.textContent = 'Registrasi berhasil!';
                        document.body.appendChild(toast);

                        setTimeout(() => toast.remove(), 3000);
                    });
                    </script>;";
                    header('Location: login.php');
            } else {
                echo "<p class='error'>Error: " . $stmt->error . "</p>"
                ;
            }
            
            $stmt->close();
            $conn->close();
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Sistem Laporan Keluhan</title>
<link href="Assets/CSS/yaa.css" rel="stylesheet">
</head>
<body>
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h2 class="text-center mb-4">Register Akun</h2>
    <form method="POST">
        <div class="form-group mb-3">
            <label for="nik">NIK</label>
            <input type="text" id="nik" name="nik" required>
        </div>
        <div class="form-group mb-3">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" required>
        </div>
        <div class="form-group mb-3">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" required>
        </div>
        <div class="form-group mb-3">
            <label for="no_hp">No HP</label>
            <input type="text" id="no_hp" name="no_hp" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group mb-3">
            <label for="confirmPassword">Konfirmasi Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
        </div>
    <button type="submit" class="btn">Register</button>
</form>

<div class="register-text">
    Sudah punya akun? <a href="login.php">Login</a>
</div>
        </div>
    </div>
</body>
</html>
