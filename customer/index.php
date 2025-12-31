<?php
include '../config/database.php';

$data = mysqli_query(
    $conn,
    "SELECT id, nama_ps, harga_per_hari, status FROM playstations"
);

if (!$data) {
    die('Query error: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rental PlayStation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .top-link {
            text-align: right;
            margin-bottom: 15px;
        }

        .top-link a {
            text-decoration: none;
            background: #007bff;
            color: #fff;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 14px;
        }

        .top-link a:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: #343a40;
            color: #fff;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .status-tersedia {
            color: green;
            font-weight: bold;
        }

        .status-dibooking {
            color: red;
            font-weight: bold;
        }

        .btn-booking {
            background: #28a745;
            color: #fff;
            padding: 5px 8px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn-booking:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Rental PlayStation</h2>

    <div class="top-link">
        <a href="../admin/login.php">Login Admin</a>
    </div>

    <hr>

    <h3>Daftar PlayStation</h3>

    <?php if (mysqli_num_rows($data) == 0) { ?>
        <p><strong>Data PlayStation belum tersedia.</strong></p>
    <?php } else { ?>

    <table>
        <tr>
            <th>No</th>
            <th>Nama PlayStation</th>
            <th>Harga / Hari</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($ps = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($ps['nama_ps']) ?></td>
            <td>Rp <?= number_format($ps['harga_per_hari']) ?></td>
            <td class="<?= $ps['status'] == 'tersedia' ? 'status-tersedia' : 'status-dibooking' ?>">
                <?= ucfirst($ps['status']) ?>
            </td>
            <td>
                <?php if ($ps['status'] == 'tersedia') { ?>
                    <a href="booking.php?id=<?= $ps['id'] ?>" class="btn-booking">
                        Booking
                    </a>
                <?php } else { ?>
                    -
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

    </table>

    <?php } ?>

</div>

</body>
</html>
