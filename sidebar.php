<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}


$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Menu</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>

<div class="bg-dark text-white vh-100 p-3">
<h4>Haloo, <?php echo $username; ?></h4><br>
    <h4 class="mb-4 text-center">Menu Navigasi</h4>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="index.php">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="pasien.php">
                <i class="fas fa-procedures me-2"></i> Manajemen Pasien
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="dokter.php">
                <i class="fas fa-user-md me-2"></i> Manajemen Dokter
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="obat.php">
                <i class="fas fa-pills me-2"></i> Manajemen Obat
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="pemeriksaan.php">
                <i class="fas fa-stethoscope me-2"></i> Manajemen Pemeriksaan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="resep.php">
                <i class="fas fa-file-medical-alt me-2"></i> Manajemen Resep
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="ruang.php">
                <i class="fas fa-bed me-2"></i> Manajemen Ruang
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white d-flex align-items-center" href="rawat_inap.php">
                <i class="fas fa-hospital me-2"></i> Manajemen Rawat Inap
            </a>
        </li class="nav-item">
        <h5><a class="nav-link text-white d-flex align-items-center" href="logout.php">logout akun</a></h5>
        <li>

        </li>
    </ul>
</div>


</body>
</html>
