<?php
session_start();
include_once "config.php";

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil nama dari session (karena login hanya menyimpan nama)
$nama_user = $_SESSION['user'];

// Ambil NIK berdasarkan nama
$nik_from_session = '';
$qNik = mysqli_query($conn, "SELECT nik FROM tb_warga WHERE nama = '$nama_user' LIMIT 1");

if (mysqli_num_rows($qNik) > 0) {
    $row = mysqli_fetch_assoc($qNik);
    $nik_from_session = $row['nik'];
} else {
    die("ERROR: NIK untuk user '$nama_user' tidak ditemukan di tb_warga.");
}

// Variabel pesan
$message = '';
$message_type = '';

// PROSES TAMBAH SARAN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_saran'])) {

    $tanggal = date('Y-m-d'); // otomatis
    $nik = $nik_from_session;
    $judul = trim($_POST['judul_saran']);
    $isi = trim($_POST['isi_saran']);

    if ($judul === '' || $isi === '') {
        $message = 'Judul dan Isi Saran tidak boleh kosong.';
        $message_type = 'error';
    } else {

        // Auto generate id_saran (S001, S002, ...)
        $qID = mysqli_query($conn, "SELECT id_saran FROM tb_saran ORDER BY id_saran DESC LIMIT 1");

        if (mysqli_num_rows($qID) > 0) {
            $row = mysqli_fetch_assoc($qID);
            $lastID = $row['id_saran'];
            $num = intval(substr($lastID, 1));
            $num++;
            $id_saran = 'S' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $id_saran = 'S001';
        }

        // INSERT DATA
        $stmt = mysqli_prepare($conn,
            "INSERT INTO tb_saran 
            (id_saran, nik, judul_saran, isi_saran, tanggal_saran) 
            VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssss",
                $id_saran,
                $nik,
                $judul,
                $isi,
                $tanggal
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: saran.php");
                $message = 'Saran berhasil ditambahkan.';
                $message_type = 'success';
                $_POST = [];
            } else {
                $message = 'Gagal menyimpan data: ' . mysqli_error($conn);
                $message_type = 'error';
            }

            mysqli_stmt_close($stmt);
        } else {
            $message = 'Kesalahan query: ' . mysqli_error($conn);
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saran Baru</title>
    <link rel="stylesheet" href="Assets/CSS/ya.css">
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Sistem Keluhan & Saran</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="keluhan.php" class="active">Keluhan Baru</a></li>
            <li><a href="saran.php">Saran Baru</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
        <a href="index.php" class="logout-btn">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <header><h1>Form saran</h1></header>

        <?php if ($message !== ''): ?>
            <div class="alert <?= ($message_type === 'success') ? 'alert-success' : 'alert-error'; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="card form-card">
            <h3 class="form-title">Input Saran</h3>

            <form method="post" action="isar.php" class="input-form">

                <!-- Hidden otomatis -->
                <input type="hidden" name="tanggal_saran" value="<?= date('Y-m-d'); ?>">
                <input type="hidden" name="nik" value="<?= htmlspecialchars($nik_from_session); ?>">

                <label class="form-label">Judul Saran</label>
                <input 
                    type="text" 
                    name="judul_saran"
                    class="form-input"
                    placeholder="Masukkan judul Saran"
                >

                <label class="form-label">Deskripsi Saran</label>
                <textarea 
                    name="isi_saran"
                    class="form-textarea"
                    placeholder="Tuliskan Saran Anda..."></textarea>

                <div class="form-btn-group">
                    <button type="submit" name="add_saran" class="btn">Submit</button>
                    <button type="reset" class="btn">Reset</button>
                    <a href="saran.php" class="btn">Back</a>
                </div>

            </form>
        </div>
    </div>

</div>

<button id="themeToggle" class="btn" style="position: fixed; top: 15px; right: 15px;">🌙</button>
    <!-- File JS -->
    <script src="Assets/JS/ya.js"></script>
</body>
</html>