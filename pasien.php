<?php
include 'db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$result = $conn->query("SELECT * FROM pasien WHERE nama LIKE '%$search%' ORDER BY nama ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_pasien'])) {
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $no_telepon = $_POST['no_telepon'];
        $tanggal_lahir = $_POST['tanggal_lahir'];
        $jenis_kelamin = $_POST['jenis_kelamin'];

        if (isset($_POST['id_pasien']) && $_POST['id_pasien'] != '') {
            $id_pasien = $_POST['id_pasien'];
            $conn->query("UPDATE pasien SET nama = '$nama', alamat = '$alamat', no_telepon = '$no_telepon', tanggal_lahir = '$tanggal_lahir', jenis_kelamin = '$jenis_kelamin' WHERE id_pasien = $id_pasien");
        } else {
            $conn->query("INSERT INTO pasien (nama, alamat, no_telepon, tanggal_lahir, jenis_kelamin) VALUES ('$nama', '$alamat', '$no_telepon', '$tanggal_lahir', '$jenis_kelamin')");
        }
        echo "<script>window.location.href = 'pasien.php';</script>";  // Penyegaran otomatis
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result_edit = $conn->query("SELECT * FROM pasien WHERE id_pasien = $id");
    $data_edit = $result_edit->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pasien</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex ">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid p-4">
            <h2>Manajemen Pasien</h2>
            <form method="GET" action="" class="mb-3">
                <input type="text" name="search" placeholder="Cari pasien..." class="form-control d-inline w-50">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="pasien.php" class="btn btn-success mb-3">Tambah Pasien</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_pasien']; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['alamat']; ?></td>
                        <td><?= $row['no_telepon']; ?></td>
                        <td><?= $row['tanggal_lahir']; ?></td>
                        <td><?= $row['jenis_kelamin']; ?></td>
                        <td>
                            <a href="pasien.php?id=<?= $row['id_pasien']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                            <a href="hapus_pasien.php?id=<?= $row['id_pasien']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3><?= isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Pasien</h3>
            <form method="POST" action="">
                <input type="hidden" name="id_pasien" value="<?= isset($data_edit['id_pasien']) ? $data_edit['id_pasien'] : ''; ?>">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="<?= isset($data_edit['nama']) ? $data_edit['nama'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="<?= isset($data_edit['alamat']) ? $data_edit['alamat'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>No Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" value="<?= isset($data_edit['no_telepon']) ? $data_edit['no_telepon'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= isset($data_edit['tanggal_lahir']) ? $data_edit['tanggal_lahir'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required>
                        <option value="Laki-laki" <?= isset($data_edit['jenis_kelamin']) && $data_edit['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?= isset($data_edit['jenis_kelamin']) && $data_edit['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>
                <button type="submit" name="tambah_pasien" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
