<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM ruang WHERE id_ruang=$id");
header('Location: ruang.php');
?>
