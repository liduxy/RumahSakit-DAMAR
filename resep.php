<?php
include 'db.php';

// Cari data resep berdasarkan nama obat atau pemeriksaan
$search = isset($_GET['search']) ? $_GET['search'] : '';
$result = $conn->query("SELECT r.id_resep, p.tanggal, o.nama_obat, r.jumlah, ps.nama as nama_pasien, d.nama as nama_dokter
                        FROM resep r
                        JOIN pemeriksaan p ON r.id_pemeriksaan = p.id_pemeriksaan
                        JOIN obat o ON r.id_obat = o.id_obat
                        JOIN pasien ps ON p.id_pasien = ps.id_pasien
                        JOIN dokter d ON p.id_dokter = d.id_dokter
                        WHERE o.nama_obat LIKE '%$search%' ORDER BY p.tanggal DESC");

// Menambah atau mengedit data resep
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_resep'])) {
        $id_pemeriksaan = $_POST['id_pemeriksaan'];
        $id_obat = $_POST['id_obat'];
        $jumlah = $_POST['jumlah'];

        if (isset($_POST['id_resep']) && $_POST['id_resep'] != '') {
            $id_resep = $_POST['id_resep'];
            $conn->query("UPDATE resep SET id_pemeriksaan = '$id_pemeriksaan', id_obat = '$id_obat', jumlah = '$jumlah' WHERE id_resep = $id_resep");
        } else {
            $conn->query("INSERT INTO resep (id_pemeriksaan, id_obat, jumlah) VALUES ('$id_pemeriksaan', '$id_obat', '$jumlah')");
        }
        echo "<script>window.location.href = 'resep.php';</script>";
    }
}

// Menampilkan data yang ingin diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result_edit = $conn->query("SELECT * FROM resep WHERE id_resep = $id");
    $data_edit = $result_edit->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Resep</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid p-4">
            <h2>Manajemen Resep</h2>
            <form method="GET" action="" class="mb-3">
                <input type="text" name="search" placeholder="Cari obat..." class="form-control d-inline w-50">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="resep.php" class="btn btn-success mb-3">Tambah Resep</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Resep</th>
                        <th>Nama Pasien</th>
                        <th>Nama Dokter</th>
                        <th>Nama Obat</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_resep']; ?></td>
                        <td><?= $row['nama_pasien']; ?></td>
                        <td><?= $row['nama_dokter']; ?></td>
                        <td><?= $row['nama_obat']; ?></td>
                        <td><?= $row['jumlah']; ?></td>
                        <td>
                            <a href="resep.php?id=<?= $row['id_resep']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                            <a href="hapus_resep.php?id=<?= $row['id_resep']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3><?= isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Resep</h3>
            <form method="POST" action="">
                <input type="hidden" name="id_resep" value="<?= isset($data_edit['id_resep']) ? $data_edit['id_resep'] : ''; ?>">

                <div class="mb-3">
                    <label>Pemeriksaan</label>
                    <select name="id_pemeriksaan" class="form-control" required>
                        <option value="">Pilih Pemeriksaan</option>
                        <?php
                        $pemeriksaan_result = $conn->query("SELECT * FROM pemeriksaan");
                        while ($pemeriksaan = $pemeriksaan_result->fetch_assoc()):
                        ?>
                        <option value="<?= $pemeriksaan['id_pemeriksaan']; ?>" <?= isset($data_edit['id_pemeriksaan']) && $data_edit['id_pemeriksaan'] == $pemeriksaan['id_pemeriksaan'] ? 'selected' : ''; ?>><?= $pemeriksaan['tanggal']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Obat</label>
                    <select name="id_obat" class="form-control" required>
                        <option value="">Pilih Obat</option>
                        <?php
                        $obat_result = $conn->query("SELECT * FROM obat");
                        while ($obat = $obat_result->fetch_assoc()):
                        ?>
                        <option value="<?= $obat['id_obat']; ?>" <?= isset($data_edit['id_obat']) && $data_edit['id_obat'] == $obat['id_obat'] ? 'selected' : ''; ?>><?= $obat['nama_obat']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Jumlah</label>
                    <input type="number" name="jumlah" class="form-control" value="<?= isset($data_edit['jumlah']) ? $data_edit['jumlah'] : ''; ?>" required>
                </div>

                <button type="submit" name="tambah_resep" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
