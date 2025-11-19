<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Pengajuan Keluhan</title>
  <link rel="stylesheet" href="Assets/CSS/ya.css">
</head>
<body>
<div class="container">
  <div class="sidebar">
    <h2>Sistem Keluhan & Saran</h2>
    <ul>
      <li><a href="index.php">Dashboard</a></li>
      <li><a href="login.php">Login</a></li>
    </ul>
  </div>

  <div class="main-content">
    <h1>Dashboard</h1>
    <section class="motivasi">
      <h3>Informasi Cuaca Hari Ini</h3>
      <p id="quote">Memuat cuaca...</p>
      </section>
    <div class="cards">
      <div class="card blue"><h5>Total Keluhan</h5><h2 id="totalKeluhan">150</h2></div>
      <div class="card yellow"><h5>Dalam Proses</h5><h2>45</h2></div>
      <div class="card green"><h5>Selesai</h5><h2>105</h2></div>
      <div class="card cyan"><h5>Total Saran</h5><h2 id="totalSaran">80</h2></div>
    </div>
    <div class="table-section">
  <div class="table-header">
    <h3>Daftar Keluhan Terbaru</h3>
    <div class="header-actions">
      <select id="filterStatus">
        <option value="all">Semua Status</option>
        <option value="Dalam Proses">Dalam Proses</option>
        <option value="Selesai">Selesai</option>
      </select>
      <a href="#" id="btnCetak" class="btn">Cetak</a>
    </div>
  </div>

  <table id="tabelKeluhan">
    <thead>
      <tr><th>ID</th><th>Tanggal</th><th>Pelapor</th><th>Keluhan</th><th>Status</th></tr>
    </thead>
    <tbody>
      <tr><td>#001</td><td>2023-06-15</td><td>John Doe</td><td>Kerusakan AC</td><td><span class="badge warning">Dalam Proses</span></td></tr>
      <tr><td>#002</td><td>2023-06-14</td><td>Jane Smith</td><td>Kebocoran Pipa</td><td><span class="badge success">Selesai</span></td></tr>
    </tbody>
  </table>
</div>
    <div class="table-section">
      <h3>Daftar Saran Terbaru</h3>
      <table>
        <thead>
          <tr><th>ID</th><th>Tanggal</th><th>Pengirim</th><th>Isi Saran</th><th>Status</th></tr>
        </thead>
        <tbody>
          <tr><td>#S01</td><td>2023-06-16</td><td>Rina Putri</td><td>Perlu lebih banyak tempat sampah.</td><td><span class="badge success">Diterima</span></td></tr>
          <tr><td>#S02</td><td>2023-06-13</td><td>Adi Prasetyo</td><td>Tambahkan kipas di ruang tunggu.</td><td><span class="badge secondary">Ditinjau</span></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<button id="themeToggle" class="btn" style="position: fixed; top: 15px; right: 15px;">🌙</button>
<div id="toastRoot" class="toast-container" aria-live="polite" aria-atomic="true"></div>
<script src="Assets/JS/ya.js"></script>
</body>
</html>