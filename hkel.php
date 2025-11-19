<?php
include "config.php";
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepared statement
    $stmt = $conn->prepare("DELETE FROM tb_keluhan WHERE id_keluhan = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: keluhan.php");
exit();
?>
