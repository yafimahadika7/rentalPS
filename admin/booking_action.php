<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../config/database.php';

// validasi parameter
$id  = $_GET['id'] ?? null;
$act = $_GET['act'] ?? null;

if (!$id || !$act) {
    header("Location: booking.php");
    exit;
}

// ambil data booking
$q = mysqli_query($conn, "SELECT * FROM bookings WHERE id='$id'");
$booking = mysqli_fetch_assoc($q);

if (!$booking) {
    header("Location: booking.php");
    exit;
}

// PROSES AKSI
if ($act === 'approve' && $booking['status'] === 'pending') {

    mysqli_query($conn, "UPDATE bookings SET status='approved' WHERE id='$id'");
    mysqli_query(
        $conn,
        "UPDATE playstations SET status='dibooking' WHERE id='{$booking['ps_id']}'"
    );

}

elseif ($act === 'reject' && $booking['status'] === 'pending') {

    mysqli_query($conn, "UPDATE bookings SET status='rejected' WHERE id='$id'");

}

elseif ($act === 'selesai' && $booking['status'] === 'approved') {

    mysqli_query($conn, "UPDATE bookings SET status='selesai' WHERE id='$id'");
    mysqli_query(
        $conn,
        "UPDATE playstations SET status='tersedia' WHERE id='{$booking['ps_id']}'"
    );

}

header("Location: booking.php");
exit;
