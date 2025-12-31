<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php';

// Query data booking + nama PS
$sql = "
    SELECT b.*, p.nama_ps 
    FROM bookings b
    INNER JOIN playstations p ON b.ps_id = p.id
    ORDER BY b.id DESC
";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
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

    <?php if (mysqli_num_rows($result) === 0): ?>
        <div class="alert alert-info text-center">
            Belum ada data booking.
        </div>
    <?php else: ?>

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

            <?php while ($b = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= htmlspecialchars($b['nama_customer'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($b['nama_ps'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <?= htmlspecialchars($b['tanggal_mulai']) ?><br>
                        <small class="text-muted">
                            s/d <?= htmlspecialchars($b['tanggal_selesai']) ?>
                        </small>
                    </td>
                    <td>Rp <?= number_format((int)$b['total_harga'], 0, ',', '.') ?></td>
                    <td>
                        <?php
                        $statusClass = 'bg-secondary';
                        if ($b['status'] === 'pending') {
                            $statusClass = 'bg-warning';
                        } elseif ($b['status'] === 'approved') {
                            $statusClass = 'bg-success';
                        }
                        ?>
                        <span class="badge <?= $statusClass ?>">
                            <?= ucfirst($b['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($b['status'] === 'pending'): ?>
                            <a href="booking_action.php?id=<?= (int)$b['id'] ?>&act=approve"
                               class="btn btn-success btn-sm mb-1"
                               onclick="return confirm('Approve booking ini?')">
                                Approve
                            </a>

                            <a href="booking_action.php?id=<?= (int)$b['id'] ?>&act=reject"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Reject booking ini?')">
                                Reject
                            </a>

                        <?php elseif ($b['status'] === 'approved'): ?>
                            <a href="booking_action.php?id=<?= (int)$b['id'] ?>&act=selesai"
                               class="btn btn-primary btn-sm"
                               onclick="return confirm('Tandai booking sebagai selesai?')">
                                Selesai
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>

            </tbody>
        </table>
    </div>

    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
