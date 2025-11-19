<?php
ob_start(); // Start output buffering
error_reporting(E_ALL & ~E_DEPRECATED); // Hilangkan deprecated
ini_set('display_errors', 0); // Jangan tampilkan error ke output PDF
include('config.php');
require_once("dompdf/autoload.inc.php");

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$html = '';


// =======================================
// TABEL 1 — DATA KELUHAN (WITH JOIN WARGA)
// =======================================
$q_keluhan = mysqli_query($conn, "
    SELECT k.*, w.nama 
    FROM tb_keluhan k
    LEFT JOIN tb_warga w ON k.nik = w.nik
");

$html .= '
<center><h3>Data Keluhan</h3></center>
<hr/><br>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama</th>
        <th>Judul Keluhan</th>
        <th>Isi Keluhan</th>
    </tr>
';

$no = 1;
while ($k = mysqli_fetch_assoc($q_keluhan)) {
    $html .= "
    <tr>
        <td>{$no}</td>
        <td>{$k['tanggal_keluhan']}</td>
        <td>{$k['nama']}</td>
        <td>{$k['judul_keluhan']}</td>
        <td>{$k['isi_keluhan']}</td>
    </tr>";
    $no++;
}

$html .= "</table><br><br>";


// =======================================
// TABEL 2 — DATA SARAN (WITH JOIN WARGA)
// =======================================
$q_saran = mysqli_query($conn, "
    SELECT s.*, w.nama 
    FROM tb_saran s
    LEFT JOIN tb_warga w ON s.nik = w.nik
");

$html .= '
<center><h3>Data Saran</h3></center>
<hr/><br>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama</th>
        <th>Judul Saran</th>
        <th>Isi Saran</th>
    </tr>
';

$no2 = 1;
while ($s = mysqli_fetch_assoc($q_saran)) {
    $html .= "
    <tr>
        <td>{$no2}</td>
        <td>{$s['tanggal_saran']}</td>
        <td>{$s['nama']}</td>
        <td>{$s['judul_saran']}</td>
        <td>{$s['isi_saran']}</td>
    </tr>";
    $no2++;
}

$html .= "</table>";


// ===========================
// RENDER PDF
// ===========================
ob_end_clean(); // Hapus output lain agar PDF tidak rusak
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('laporan-keluhan-saran.pdf');
?>