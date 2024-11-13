<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM dokter WHERE id_dokter=$id");
header('Location: dokter.php');
?>
