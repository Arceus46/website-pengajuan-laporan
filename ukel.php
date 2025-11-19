<?php
session_start();
include_once "config.php";

// Pastikan user login
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

// Ambil nama dari session
$nama_user = $_SESSION['user'];

// Ambil NIK
$nik_from_session = '';
$qNik = mysqli_query($conn, "SELECT nik FROM tb_warga WHERE nama = '$nama_user' LIMIT 1");

if (mysqli_num_rows($qNik) > 0) {
    $row = mysqli_fetch_assoc($qNik);
    $nik_from_session = $row['nik'];
} else {
    die("ERROR: NIK untuk user '$nama_user' tidak ditemukan.");
}

// Ambil id_keluhan dari URL
if (!isset($_GET['id'])) {
    die("ID keluhan tidak ditemukan.");
}

$id_keluhan = $_GET['id'];

// Ambil data keluhan lama
$qData = mysqli_query($conn, "SELECT * FROM tb_keluhan WHERE id_keluhan = '$id_keluhan' LIMIT 1");
if (mysqli_num_rows($qData) == 0) {
    die("Keluhan dengan ID '$id_keluhan' tidak ditemukan.");
}

$data = mysqli_fetch_assoc($qData);

// Variabel pesan
$message = '';
$message_type = '';

// PROSES UPDATE KELUHAN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_keluhan'])) {

    $judul = trim($_POST['judul_keluhan']);
    $isi = trim($_POST['isi_keluhan']);

    if ($judul === '' || $isi === '') {
        $message = 'Judul dan isi keluhan tidak boleh kosong.';
        $message_type = 'error';
    } else {
        $stmt = mysqli_prepare($conn,
            "UPDATE tb_keluhan 
             SET judul_keluhan = ?, isi_keluhan = ?
             WHERE id_keluhan = ?"
        );

        mysqli_stmt_bind_param($stmt, "sss", $judul, $isi, $id_keluhan);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: keluhan.php");
            exit;
        } else {
            $message = 'Gagal update keluhan: ' . mysqli_error($conn);
            $message_type = 'error';
        }

        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Keluhan</title>
    <link rel="stylesheet" href="Assets/CSS/ya.css">
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>Sistem Keluhan & Saran</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="keluhan.php" class="active">Data Keluhan</a></li>
            <li><a href="saran.php">Saran</a></li>
            <li><a href="profil.php">Profil</a></li>
        </ul>
        <a href="index.php" class="logout-btn">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <header><h1>Edit Keluhan</h1></header>

        <?php if ($message !== ''): ?>
            <div class="alert <?= ($message_type === 'success') ? 'alert-success' : 'alert-error'; ?>">
                <?= htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <div class="card form-card">
            <h3 class="form-title">Form Update Keluhan</h3>

            <form method="post" action="" class="input-form">

                <label class="form-label">Judul Keluhan</label>
                <input 
                    type="text" 
                    name="judul_keluhan"
                    class="form-input"
                    value="<?= htmlspecialchars($data['judul_keluhan']); ?>"
                >

                <label class="form-label">Deskripsi Keluhan</label>
                <textarea 
                    name="isi_keluhan"
                    class="form-textarea"><?= htmlspecialchars($data['isi_keluhan']); ?></textarea>

                <div class="form-btn-group">
                    <button type="submit" name="update_keluhan" class="btn">Update</button>
                    <a href="keluhan.php" class="btn">Back</a>
                </div>

            </form>
        </div>
    </div>

</div>

<button id="themeToggle" class="btn" style="position: fixed; top: 15px; right: 15px;">🌙</button>
<script src="Assets/JS/ya.js"></script>
</body>
</html>
