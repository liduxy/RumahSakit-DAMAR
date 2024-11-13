<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM resep WHERE id_resep=$id");
header('Location: resep.php');
?>
