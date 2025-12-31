<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../config/database.php';

// ambil data playstation
$data = mysqli_query($conn, "SELECT * FROM playstations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data PlayStation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Admin - Data PlayStation</span>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
    </div>
</nav>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar PlayStation</h4>
        <a href="ps_tambah.php" class="btn btn-primary btn-sm">
            + Tambah PlayStation
        </a>
    </div>

    <?php if (mysqli_num_rows($data) == 0) { ?>
        <div class="alert alert-info text-center">
            Data PlayStation belum tersedia.
        </div>
    <?php } else { ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nama PS</th>
                    <th>Harga / Hari</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php while ($ps = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td><?= htmlspecialchars($ps['nama_ps']) ?></td>
                    <td>Rp <?= number_format($ps['harga_per_hari']) ?></td>
                    <td>
                        <span class="badge <?= $ps['status']=='tersedia' ? 'bg-success' : 'bg-danger' ?>">
                            <?= ucfirst($ps['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="ps_edit.php?id=<?= $ps['id'] ?>" 
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <a href="ps_hapus.php?id=<?= $ps['id'] ?>" 
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Hapus data PlayStation ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
            <?php } ?>

            </tbody>
        </table>
    </div>

    <?php } ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
