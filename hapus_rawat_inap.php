<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM rawat_inap WHERE id_rawat_inap=$id");
header('Location: rawat_inap.php');
?>
