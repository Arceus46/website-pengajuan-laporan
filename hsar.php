<?php
include "config.php";
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepared statement
    $stmt = $conn->prepare("DELETE FROM tb_saran WHERE id_saran = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: saran.php");
exit();
?>
