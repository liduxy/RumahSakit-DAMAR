<?php
include 'db.php';
$id = $_GET['id'];
$sql = "DELETE FROM pasien WHERE id_pasien = $id";
$conn->query($sql);
header('Location: pasien.php');
?>
