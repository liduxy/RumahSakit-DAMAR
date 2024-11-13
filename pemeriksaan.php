<?php
include 'db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$result = $conn->query("SELECT p.id_pemeriksaan, p.tanggal, p.hasil, pa.nama AS pasien, d.nama AS dokter FROM pemeriksaan p
                        JOIN pasien pa ON p.id_pasien = pa.id_pasien
                        JOIN dokter d ON p.id_dokter = d.id_dokter
                        WHERE pa.nama LIKE '%$search%' ORDER BY p.tanggal ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_pemeriksaan'])) {
        $id_pasien = $_POST['id_pasien'];
        $id_dokter = $_POST['id_dokter'];
        $tanggal = $_POST['tanggal'];
        $hasil = $_POST['hasil'];

        if (isset($_POST['id_pemeriksaan']) && $_POST['id_pemeriksaan'] != '') {
            $id_pemeriksaan = $_POST['id_pemeriksaan'];
            $conn->query("UPDATE pemeriksaan SET id_pasien = '$id_pasien', id_dokter = '$id_dokter', tanggal = '$tanggal', hasil = '$hasil' WHERE id_pemeriksaan = $id_pemeriksaan");
        } else {
            $conn->query("INSERT INTO pemeriksaan (id_pasien, id_dokter, tanggal, hasil) VALUES ('$id_pasien', '$id_dokter', '$tanggal', '$hasil')");
        }
        echo "<script>window.location.href = 'pemeriksaan.php';</script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result_edit = $conn->query("SELECT * FROM pemeriksaan WHERE id_pemeriksaan = $id");
    $data_edit = $result_edit->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pemeriksaan</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid p-4">
            <h2>Manajemen Pemeriksaan</h2>
            <form method="GET" action="" class="mb-3">
                <input type="text" name="search" placeholder="Cari pasien..." class="form-control d-inline w-50">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="pemeriksaan.php" class="btn btn-success mb-3">Tambah Pemeriksaan</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pemeriksaan</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Tanggal</th>
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_pemeriksaan']; ?></td>
                        <td><?= $row['pasien']; ?></td>
                        <td><?= $row['dokter']; ?></td>
                        <td><?= $row['tanggal']; ?></td>
                        <td><?= $row['hasil']; ?></td>
                        <td>
                            <a href="pemeriksaan.php?id=<?= $row['id_pemeriksaan']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                            <a href="hapus_pemeriksaan.php?id=<?= $row['id_pemeriksaan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3><?= isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Pemeriksaan</h3>
            <form method="POST" action="">
                <input type="hidden" name="id_pemeriksaan" value="<?= isset($data_edit['id_pemeriksaan']) ? $data_edit['id_pemeriksaan'] : ''; ?>">
                <div class="mb-3">
                    <label>Pasien</label>
                    <select name="id_pasien" class="form-control" required>
                        <?php
                        $pasien_result = $conn->query("SELECT * FROM pasien");
                        while ($pasien = $pasien_result->fetch_assoc()) {
                            $selected = (isset($data_edit['id_pasien']) && $data_edit['id_pasien'] == $pasien['id_pasien']) ? 'selected' : '';
                            echo "<option value='{$pasien['id_pasien']}' $selected>{$pasien['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Dokter</label>
                    <select name="id_dokter" class="form-control" required>
                        <?php
                        $dokter_result = $conn->query("SELECT * FROM dokter");
                        while ($dokter = $dokter_result->fetch_assoc()) {
                            $selected = (isset($data_edit['id_dokter']) && $data_edit['id_dokter'] == $dokter['id_dokter']) ? 'selected' : '';
                            echo "<option value='{$dokter['id_dokter']}' $selected>{$dokter['nama']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal" class="form-control" value="<?= isset($data_edit['tanggal']) ? $data_edit['tanggal'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Hasil Pemeriksaan</label>
                    <textarea name="hasil" class="form-control" required><?= isset($data_edit['hasil']) ? $data_edit['hasil'] : ''; ?></textarea>
                </div>
                <button type="submit" name="tambah_pemeriksaan" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
