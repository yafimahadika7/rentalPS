<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../config/database.php';

// ambil data booking + nama PS
$query = "
    SELECT b.*, p.nama_ps 
    FROM bookings b
    JOIN playstations p ON b.ps_id = p.id
    ORDER BY b.id DESC
";
$data = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Admin - Data Booking</span>
        <a href="dashboard.php" class="btn btn-outline-light btn-sm">Dashboard</a>
    </div>
</nav>

<div class="container mt-4">

    <h4 class="mb-3">Daftar Booking</h4>

    <?php if (mysqli_num_rows($data) == 0) { ?>
        <div class="alert alert-info text-center">
            Belum ada data booking.
        </div>
    <?php } else { ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Customer</th>
                    <th>PlayStation</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th width="160">Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php while ($b = mysqli_fetch_assoc($data)) { ?>
                <tr>
                    <td><?= htmlspecialchars($b['nama_customer']) ?></td>
                    <td><?= htmlspecialchars($b['nama_ps']) ?></td>
                    <td>
                        <?= $b['tanggal_mulai'] ?>
                        <br>
                        <small class="text-muted">s/d <?= $b['tanggal_selesai'] ?></small>
                    </td>
                    <td>Rp <?= number_format($b['total_harga']) ?></td>
                    <td>
                        <span class="badge 
                            <?= $b['status']=='pending' ? 'bg-warning' : 
                               ($b['status']=='approved' ? 'bg-success' : 'bg-secondary') ?>">
                            <?= ucfirst($b['status']) ?>
                        </span>
                    </td>
                    <td>

                        <?php if ($b['status'] == 'pending') { ?>
                            <a href="booking_action.php?id=<?= $b['id'] ?>&act=approve"
                               class="btn btn-success btn-sm mb-1"
                               onclick="return confirm('Approve booking ini?')">
                                Approve
                            </a>

                            <a href="booking_action.php?id=<?= $b['id'] ?>&act=reject"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Reject booking ini?')">
                                Reject
                            </a>

                        <?php } elseif ($b['status'] == 'approved') { ?>
                            <a href="booking_action.php?id=<?= $b['id'] ?>&act=selesai"
                               class="btn btn-primary btn-sm"
                               onclick="return confirm('Tandai booking sebagai selesai?')">
                                Selesai
                            </a>
                        <?php } else { ?>
                            <span class="text-muted">-</span>
                        <?php } ?>

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
