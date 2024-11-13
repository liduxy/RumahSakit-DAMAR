<?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$result = $conn->query("SELECT * FROM ruang WHERE nama_ruang LIKE '%$search%' ORDER BY nama_ruang ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_ruang'])) {
        $nama_ruang = $_POST['nama_ruang'];
        $kapasitas = $_POST['kapasitas'];
        $jenis_ruang = $_POST['jenis_ruang'];

        if (isset($_POST['id_ruang']) && $_POST['id_ruang'] != '') {
            $id_ruang = $_POST['id_ruang'];
            $conn->query("UPDATE ruang SET nama_ruang = '$nama_ruang', kapasitas = '$kapasitas', jenis_ruang = '$jenis_ruang' WHERE id_ruang = $id_ruang");
        } else {
            $conn->query("INSERT INTO ruang (nama_ruang, kapasitas, jenis_ruang) VALUES ('$nama_ruang', '$kapasitas', '$jenis_ruang')");
        }
    }
}

if (isset($_GET['id'])) {
    $id_ruang = $_GET['id'];
    $result_edit = $conn->query("SELECT * FROM ruang WHERE id_ruang = $id_ruang");
    $data_edit = $result_edit->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Ruang</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid p-4">
            <h2>Manajemen Ruang</h2>
            <form method="GET" action="" class="mb-3">
                <input type="text" name="search" placeholder="Cari ruang..." class="form-control d-inline w-50">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="ruang.php" class="btn btn-success mb-3">Tambah Ruang</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Ruang</th>
                        <th>Kapasitas</th>
                        <th>Jenis Ruang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_ruang']; ?></td>
                        <td><?= $row['nama_ruang']; ?></td>
                        <td><?= $row['kapasitas']; ?></td>
                        <td><?= $row['jenis_ruang']; ?></td>
                        <td>
                            <a href="ruang.php?id=<?= $row['id_ruang']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                            <a href="hapus_ruang.php?id=<?= $row['id_ruang']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3><?= isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Ruang</h3>
            <form method="POST" action="">
                <input type="hidden" name="id_ruang" value="<?= isset($data_edit['id_ruang']) ? $data_edit['id_ruang'] : ''; ?>">

                <div class="mb-3">
                    <label>Nama Ruang</label>
                    <input type="text" name="nama_ruang" class="form-control" value="<?= isset($data_edit['nama_ruang']) ? $data_edit['nama_ruang'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label>Kapasitas</label>
                    <input type="number" name="kapasitas" class="form-control" value="<?= isset($data_edit['kapasitas']) ? $data_edit['kapasitas'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label>Jenis Ruang</label>
                    <select name="jenis_ruang" class="form-control" required>
                        <option value="VIP" <?= isset($data_edit['jenis_ruang']) && $data_edit['jenis_ruang'] == 'VIP' ? 'selected' : ''; ?>>VIP</option>
                        <option value="Kelas 1" <?= isset($data_edit['jenis_ruang']) && $data_edit['jenis_ruang'] == 'Kelas 1' ? 'selected' : ''; ?>>Kelas 1</option>
                        <option value="Kelas 2" <?= isset($data_edit['jenis_ruang']) && $data_edit['jenis_ruang'] == 'Kelas 2' ? 'selected' : ''; ?>>Kelas 2</option>
                        <option value="Kelas 3" <?= isset($data_edit['jenis_ruang']) && $data_edit['jenis_ruang'] == 'Kelas 3' ? 'selected' : ''; ?>>Kelas 3</option>
                    </select>
                </div>

                <button type="submit" name="tambah_ruang" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
