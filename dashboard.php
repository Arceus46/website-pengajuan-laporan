<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "config.php";
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
$nik = $_SESSION['nikuser'];
$nama = ucfirst(strtolower($user));
// Keluhan
$Totalkel = mysqli_query($conn, "SELECT COUNT(*) AS totalkel FROM tb_keluhan WHERE nik = '$nik'");
$totalkeluhan = mysqli_fetch_assoc($Totalkel)['totalkel'];
$ambilkel = "SELECT * FROM tb_keluhan WHERE nik = '$nik'";
$sqlkel = mysqli_query($conn, $ambilkel);
// Saran
$Totalsar = mysqli_query($conn, "SELECT COUNT(*) AS totalsar FROM tb_saran WHERE nik = '$nik'");
$totalsaran = mysqli_fetch_assoc($Totalsar)['totalsar'];
$ambilsar = "SELECT * FROM tb_saran WHERE nik = '$nik'";
$sqlsar = mysqli_query($conn, $ambilsar);

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pengguna</title>
  <link rel="stylesheet" href="Assets/CSS/ya.css">
</head>
<body>
  <div class="container">
    <!-- Sidebar -->
   <div class="sidebar">
  <h2>Sistem Keluhan & Saran</h2>
  <ul>
    <li><a href="dashboard.php" class="active">Dashboard</a></li>
    <li><a href="keluhan.php">Keluhan Baru</a></li>
    <li><a href="saran.php">Saran Baru</a></li>
    <li><a href="profil.php">Profil</a></li>
  </ul>

  <!-- Tombol Logout di bawah -->
  <a href="keluar.php" class="logout-btn">Logout</a>
</div>


    <!-- Main Content -->
    <div class="main-content">
      <header>
        <h1>Selamat Datang <?php echo $nama; ?></h1>
      </header>
      <section class="motivasi">
      <h3>Informasi Cuaca Hari Ini</h3>
      <p id="quote">Memuat cuaca...</p>
      </section>

      <!-- Kartu Statistik -->
      <section class="cards">
        <div class="card blue">
          <h5>Jumlah Keluhan Saya</h5>
          <h2><?php echo $totalkeluhan; ?></h2>
        </div>
        <div class="card cyan">
          <h5>Total Saran Saya</h5>
          <h2><?php echo $totalsaran; ?></h2>
        </div>
      </section>
      <button type="button" class="btn">
                    <a href="cetak.php" style="color:white">Cetak Semua Data</a>
                </button>

      <!-- Tabel Keluhan User -->
      <section class="table-section">
        <h3>Laporan Keluhan Saya</h3>
        <div class="table-container">
          <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Judul Keluhan</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = mysqli_fetch_array($sqlkel)) {
                            echo "
                            <tr align='center'>
                                <td>{$data['id_keluhan']}</td>
                                <td>{$data['tanggal_keluhan']}</td>
                                <td>{$data['judul_keluhan']}</td>
                                <td>{$data['isi_keluhan']}</td>
                                </tr>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
        </div>
      </section>
      

      <!-- Tabel Saran User -->
      <section class="table-section">
        <h3>Laporan Saran Saya</h3>
        <div class="table-container">
          <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tanggal</th>
                            <th>Judul Saran</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($data = mysqli_fetch_array($sqlsar)) {
                            echo "
                            <tr align='center'>
                                <td>{$data['id_saran']}</td>
                                <td>{$data['tanggal_saran']}</td>
                                <td>{$data['judul_saran']}</td>
                                <td>{$data['isi_saran']}</td>
                                </tr>
                            ";
                        }
                        ?>
                    </tbody>
                </table>
        </div>
      </section>
    </div>
  </div>
  
<!-- Tombol Mode Gelap -->
<button id="themeToggle" class="btn" style="position: fixed; top: 15px; right: 15px;">🌙</button>

<!-- toast container -->
<div id="toastRoot" class="toast-container" aria-live="polite" aria-atomic="true"></div>

<!-- File JS -->
<script src="Assets/JS/ya.js"></script>
</body>
</html>
