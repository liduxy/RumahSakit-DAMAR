<?php
include 'db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$result = $conn->query("SELECT * FROM dokter WHERE nama LIKE '%$search%' ORDER BY nama ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_dokter'])) {
        $nama = $_POST['nama'];
        $spesialisasi = $_POST['spesialisasi'];
        $no_telepon = $_POST['no_telepon'];
        $alamat = $_POST['alamat'];

        if (isset($_POST['id_dokter']) && $_POST['id_dokter'] != '') {
            $id_dokter = $_POST['id_dokter'];
            $conn->query("UPDATE dokter SET nama = '$nama', spesialisasi = '$spesialisasi', no_telepon = '$no_telepon', alamat = '$alamat' WHERE id_dokter = $id_dokter");
        } else {
            $conn->query("INSERT INTO dokter (nama, spesialisasi, no_telepon, alamat) VALUES ('$nama', '$spesialisasi', '$no_telepon', '$alamat')");
        }
        echo "<script>window.location.href = 'dokter.php';</script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result_edit = $conn->query("SELECT * FROM dokter WHERE id_dokter = $id");
    $data_edit = $result_edit->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Dokter</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid p-4">
            <h2>Manajemen Dokter</h2>
            <form method="GET" action="" class="mb-3">
                <input type="text" name="search" placeholder="Cari dokter..." class="form-control d-inline w-50">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="dokter.php" class="btn btn-success mb-3">Tambah Dokter</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Spesialisasi</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_dokter']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['spesialisasi']; ?></td>
                        <td><?= $row['no_telepon']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td>
                            <a href="dokter.php?id=<?= $row['id_dokter']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                            <a href="hapus_dokter.php?id=<?= $row['id_dokter']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3><?= isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Dokter</h3>
            <form method="POST" action="">
                <input type="hidden" name="id_dokter" value="<?= isset($data_edit['id_dokter']) ? $data_edit['id_dokter'] : ''; ?>">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= isset($data_edit['nama']) ? $data_edit['nama'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Spesialisasi</label>
                    <input type="text" name="spesialisasi" class="form-control" value="<?= isset($data_edit['spesialisasi']) ? $data_edit['spesialisasi'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="<?= isset($data_edit['no_telepon']) ? $data_edit['no_telepon'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?= isset($data_edit['alamat']) ? $data_edit['alamat'] : ''; ?>" required>
                </div>
                <button type="submit" name="tambah_dokter" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
