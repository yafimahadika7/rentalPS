<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/database.php';

/* ===============================
   VALIDASI PARAMETER
================================ */
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$act = isset($_GET['act']) ? $_GET['act'] : '';

if ($id <= 0 || $act === '') {
    header("Location: booking.php");
    exit;
}

/* ===============================
   AMBIL DATA BOOKING
================================ */
$stmt = mysqli_prepare($conn, "SELECT id, ps_id, status FROM bookings WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$booking = mysqli_fetch_assoc($result);

if (!$booking) {
    header("Location: booking.php");
    exit;
}

/* ===============================
   PROSES AKSI
================================ */
if ($act === 'approve' && $booking['status'] === 'pending') {

    mysqli_query(
        $conn,
        "UPDATE bookings SET status='approved' WHERE id={$id}"
    );

    mysqli_query(
        $conn,
        "UPDATE playstations SET status='dibooking' WHERE id={$booking['ps_id']}"
    );

} elseif ($act === 'reject' && $booking['status'] === 'pending') {

    mysqli_query(
        $conn,
        "UPDATE bookings SET status='rejected' WHERE id={$id}"
    );

} elseif ($act === 'selesai' && $booking['status'] === 'approved') {

    mysqli_query(
        $conn,
        "UPDATE bookings SET status='selesai' WHERE id={$id}"
    );

    mysqli_query(
        $conn,
        "UPDATE playstations SET status='tersedia' WHERE id={$booking['ps_id']}"
    );
}

/* ===============================
   REDIRECT
================================ */
header("Location: booking.php");
exit;
