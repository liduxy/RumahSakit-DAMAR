<?php
include 'db.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$result = $conn->query("SELECT * FROM obat WHERE nama_obat LIKE '%$search%' ORDER BY nama_obat ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_obat'])) {
        $nama_obat = $_POST['nama_obat'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        if (isset($_POST['id_obat']) && $_POST['id_obat'] != '') {
            $id_obat = $_POST['id_obat'];
            $conn->query("UPDATE obat SET nama_obat = '$nama_obat', kategori = '$kategori', harga = '$harga', stok = '$stok' WHERE id_obat = $id_obat");
        } else {
            $conn->query("INSERT INTO obat (nama_obat, kategori, harga, stok) VALUES ('$nama_obat', '$kategori', '$harga', '$stok')");
        }
        echo "<script>window.location.href = 'obat.php';</script>";
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result_edit = $conn->query("SELECT * FROM obat WHERE id_obat = $id");
    $data_edit = $result_edit->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Obat</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?>
        <div class="container-fluid p-4">
            <h2>Manajemen Obat</h2>
            <form method="GET" action="" class="mb-3">
                <input type="text" name="search" placeholder="Cari obat..." class="form-control d-inline w-50">
                <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <a href="obat.php" class="btn btn-success mb-3">Tambah Obat</a>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id_obat']; ?></td>
                        <td><?= $row['nama_obat']; ?></td>
                        <td><?= $row['kategori']; ?></td>
                        <td><?= $row['harga']; ?></td>
                        <td><?= $row['stok']; ?></td>
                        <td>
                            <a href="obat.php?id=<?= $row['id_obat']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                            <a href="hapus_obat.php?id=<?= $row['id_obat']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h3><?= isset($_GET['id']) ? 'Edit' : 'Tambah'; ?> Obat</h3>
            <form method="POST" action="">
                <input type="hidden" name="id_obat" value="<?= isset($data_edit['id_obat']) ? $data_edit['id_obat'] : ''; ?>">
                <div class="mb-3">
                    <label>Nama Obat</label>
                    <input type="text" name="nama_obat" class="form-control" value="<?= isset($data_edit['nama_obat']) ? $data_edit['nama_obat'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="<?= isset($data_edit['kategori']) ? $data_edit['kategori'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="harga" class="form-control" value="<?= isset($data_edit['harga']) ? $data_edit['harga'] : ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= isset($data_edit['stok']) ? $data_edit['stok'] : ''; ?>" required>
                </div>
                <button type="submit" name="tambah_obat" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
