<?php
include 'db.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$result = $conn->query("SELECT r.id_rawat_inap, p.nama as nama_pasien, ru.nama_ruang, r.tanggal_masuk, r.tanggal_keluar 
                        FROM rawat_inap r
                        JOIN pasien p ON r.id_pasien = p.id_pasien
                        JOIN ruang ru ON r.id_ruang = ru.id_ruang
                        WHERE p.nama LIKE '%$search%' ORDER BY r.tanggal_masuk DESC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_rawat_inap'])) {
        $id_pasien = $_POST['id_pasien'];
        $id_ruang = $_POST['id_ruang'];
        $tanggal_masuk = $_POST['tanggal_masuk'];
        $tanggal_keluar = $_POST['tanggal_keluar'];

        if (isset($_POST['id_rawat_inap']) && $_POST['id_rawat_inap'] != '') {
            $id_rawat_inap = $_POST['id_rawat_inap'];
            $conn->query("UPDATE rawat_inap SET id_pasien = '$id_pasien', id_ruang = '$id_ruang', tanggal_masuk = '$tanggal_masuk', tanggal_keluar = '$tanggal_keluar' WHERE id_rawat_inap = $id_rawat_inap");
        } else {
            $conn->query("INSERT INTO rawat_inap (id_pasien, id_ruang, tanggal_masuk, tanggal_keluar) VALUES ('$id_pasien', '$id_ruang', '$tanggal_masuk', '$tanggal_keluar')");
        }
    }
}

if (isset($_GET['id'])) {
    $id_rawat_inap = $_GET['id'];
    $result_edit = $conn->query("SELECT * FROM rawat_inap WHERE id_rawat_inap = $id_rawat_inap");
    $data_edit = $result_edit->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Rawat Inap</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid p-4">
            <h2>Manajemen Rawat Inap</h2>
            <form method="GET" action="" class="mb-3">
                <input type="text" name="search" placeholder="Cari pasien..." class="form-control d-inline w-50">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="rawat_inap.php" class="btn btn-success mb-3">Tambah Rawat Inap</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Pasien</th>
                        <th>Nama Ruang</th>
                        <th>Tanggal Masuk</th>
                        <th>Tanggal Keluar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_rawat_inap']; ?></td>
                        <td><?= $row['nama_pasien']; ?></td>
                        <td><?= $row['nama_ruang']; ?></td>
                        <td><?= $row['tanggal_masuk']; ?></td>
                        <td><?= $row['tanggal_keluar']; ?></td>
                        <td>
                            <a href="rawat_inap.php?id=<?= $row['id_rawat_inap']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                            <a href="hapus_rawat_inap.php?id=<?= $row['id_rawat_inap']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3><?= isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Rawat Inap</h3>
            <form method="POST" action="">
                <input type="hidden" name="id_rawat_inap" value="<?= isset($data_edit['id_rawat_inap']) ? $data_edit['id_rawat_inap'] : ''; ?>">

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
                    <label>Ruang</label>
                    <select name="id_ruang" class="form-control" required>
                        <?php
                        $ruang_result = $conn->query("SELECT * FROM ruang");
                        while ($ruang = $ruang_result->fetch_assoc()) {
                            $selected = (isset($data_edit['id_ruang']) && $data_edit['id_ruang'] == $ruang['id_ruang']) ? 'selected' : '';
                            echo "<option value='{$ruang['id_ruang']}' $selected>{$ruang['nama_ruang']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="<?= isset($data_edit['tanggal_masuk']) ? $data_edit['tanggal_masuk'] : ''; ?>" required>
                </div>

                <div class="mb-3">
                    <label>Tanggal Keluar</label>
                    <input type="date" name="tanggal_keluar" class="form-control" value="<?= isset($data_edit['tanggal_keluar']) ? $data_edit['tanggal_keluar'] : ''; ?>">
                </div>

                <button type="submit" name="tambah_rawat_inap" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
