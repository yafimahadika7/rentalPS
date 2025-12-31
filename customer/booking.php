<?php
include '../config/database.php';

/* =========================
   VALIDASI PARAMETER ID
   ========================= */
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    header("Location: ../index.php");
    exit;
}

/* =========================
   AMBIL DATA PLAYSTATION
   ========================= */
$queryPs = mysqli_query($conn, "SELECT * FROM playstations WHERE id='$id'");
$ps = mysqli_fetch_assoc($queryPs);

if (!$ps) {
    header("Location: ../index.php");
    exit;
}

$alert = '';

/* =========================
   PROSES BOOKING
   ========================= */
if (isset($_POST['submit'])) {

    $nama    = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $hp      = mysqli_real_escape_string($conn, trim($_POST['hp']));
    $alamat  = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $mulai   = $_POST['mulai'];
    $selesai = $_POST['selesai'];

    // validasi input wajib
    if ($nama == '' || $hp == '' || $alamat == '' || !$mulai || !$selesai) {
        $alert = '<div class="alert alert-danger">
                    Semua field wajib diisi.
                  </div>';
    }
    // validasi tanggal
    elseif ($selesai < $mulai) {
        $alert = '<div class="alert alert-danger">
                    Tanggal selesai tidak boleh lebih awal dari tanggal mulai.
                  </div>';
    }
    else {

        // cek bentrok booking
        $cek = mysqli_query($conn, "
            SELECT id FROM bookings
            WHERE ps_id='$id'
            AND status IN ('pending','approved')
            AND (
                '$mulai' BETWEEN tanggal_mulai AND tanggal_selesai
                OR
                '$selesai' BETWEEN tanggal_mulai AND tanggal_selesai
                OR
                tanggal_mulai BETWEEN '$mulai' AND '$selesai'
            )
        ");

        if ($cek && mysqli_num_rows($cek) > 0) {
            $alert = '<div class="alert alert-warning">
                        PlayStation sudah dibooking pada rentang tanggal tersebut.
                      </div>';
        } else {

            // hitung total harga
            $selisih_hari = (strtotime($selesai) - strtotime($mulai)) / 86400 + 1;
            $total_harga  = $selisih_hari * $ps['harga_per_hari'];

            // simpan booking
            $insert = mysqli_query($conn, "
                INSERT INTO bookings
                (ps_id, nama_customer, no_hp, alamat, tanggal_mulai, tanggal_selesai, total_harga, status)
                VALUES
                ('$id', '$nama', '$hp', '$alamat', '$mulai', '$selesai', '$total_harga', 'pending')
            ");

            if ($insert) {
                $alert = '<div class="alert alert-success">
                            Booking berhasil!<br>
                            Total bayar: <strong>Rp ' . number_format($total_harga) . '</strong><br>
                            <small class="text-muted">
                                Menunggu konfirmasi admin.
                            </small>
                            <hr>
                            <strong>Catatan:</strong>
                            Silakan datang langsung ke tempat rental PS dan
                            <strong>membawa identitas diri (KTP/Kartu Pelajar)</strong>
                            sebagai persyaratan booking
                          </div>';
            } else {
                $alert = '<div class="alert alert-danger">
                            Terjadi kesalahan saat menyimpan booking.
                          </div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking PlayStation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="../index.php" class="navbar-brand fw-bold">Rental PlayStation</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <?= $alert ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    Booking <?= htmlspecialchars($ps['nama_ps']) ?>
                </div>

                <div class="card-body">

                    <p>
                        Harga / Hari:
                        <strong>Rp <?= number_format($ps['harga_per_hari']) ?></strong>
                    </p>

                    <form method="post" autocomplete="off">

                        <div class="mb-3">
                            <label class="form-label">Nama Customer</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="hp" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="form-label">Tanggal Mulai</label>
                                <input type="date" name="mulai" class="form-control" required>
                            </div>
                            <div class="col">
                                <label class="form-label">Tanggal Selesai</label>
                                <input type="date" name="selesai" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success mt-3 w-100">
                            Booking Sekarang
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
