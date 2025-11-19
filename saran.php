<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
$user = $_SESSION['user'];
$nik = $_SESSION['nikuser'];
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
    <div class="sidebar">
  <h2>Sistem Keluhan & Saran</h2>
  <ul>
    <li><a href="dashboard.php" class="active">Dashboard</a></li>
    <li><a href="keluhan.php">Keluhan Baru</a></li>
    <li><a href="saran.php">Saran Baru</a></li>
    <li><a href="profil.php">Profil</a></li>
  </ul>

  <!-- Tombol Logout di bawah -->
  <a href="index.php" class="logout-btn">Logout</a>
</div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
      <header><h1>Form Saran</h1></header>
      <form method="GET" action="saran.php">
      <a href="isar.php"><h3>[+]Tambah Data[+]</h3><br></a>
      <input type="text" name="cari" class="wlee"value="<?php echo $search; ?>" placeholder="" />
                <button type="submit" class="btn">Cari</button>
                <button type="button" class="btn">
                    <a href="saran.php" style="color:white">Reset</a>
                </button>
                <section class="table-section">
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Judul Keluhan</th>
                <th>Deskripsi</th>
                <th colspan="2">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
                        include "config.php";
                        $no = 1;
                        if (isset($_GET['cari'])) {
                            $cari = $_GET['cari'];
                            $ambil = "SELECT * FROM tb_saran
                                      WHERE id_saran LIKE '%$cari%'
                                      OR judul_saran LIKE '%$cari%'
                                      OR isi_saran LIKE '%$cari%'
                                      OR tanggal_saran LIKE '%$cari%'";
                        } else {
                            $ambil = "SELECT * FROM tb_saran where nik = '$nik'";
                        }
                        $sql = mysqli_query($conn, $ambil);
                        while ($data = mysqli_fetch_array($sql)) {
                            echo "
                            <tr align='center'>
                                <td>{$data['id_saran']}</td>
                                <td>{$data['tanggal_saran']}</td>
                                <td>{$data['judul_saran']}</td>
                                <td>{$data['isi_saran']}</td>
                                <td><a class='badge warning' href='usar.php?id={$data['id_saran']}'>Update</a></td>
                                <td><a class='badge warning' href='hsar.php?id={$data['id_saran']}'>Hapus</a></td>
                            </tr>
                            ";
                        }
                        ?>
            </tbody>
          </table>
                      </form>
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