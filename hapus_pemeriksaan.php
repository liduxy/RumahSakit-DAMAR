<?php
include '../db.php';
$id = $_GET['id'];
$result = $conn->query("SELECT * FROM pemeriksaan WHERE id_pemeriksaan = $id");
$data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pemeriksaan</title>
</head>
<body>
    <h2>Edit Pemeriksaan</h2>
    <form method="POST">
        <label>Diagnosa:</label>
        <textarea name="diagnosa"><?= $data['diagnosa']; ?></textarea><br>
        <button type="submit" name="submit">Update</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $diagnosa = $_POST['diagnosa'];
        $sql = "UPDATE pemeriksaan SET diagnosa='$diagnosa' WHERE id_pemeriksaan=$id";
        $conn->query($sql);
        header('Location: ../pemeriksaan.php');
    }
    ?>
</body>
</html>
