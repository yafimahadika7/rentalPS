<?php
include '../config/database.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM playstations WHERE id='$id'");
header("Location: ps.php");
