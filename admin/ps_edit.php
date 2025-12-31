<?php
include '../config/database.php';
$id = $_GET['id'];

$ps = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM playstations WHERE id='$id'")
);

if (isset($_POST['update'])) {
    mysqli_query($conn, "
        UPDATE playstations SET 
        nama_ps='$_POST[nama]',
        harga_per_hari='$_POST[harga]'
        WHERE id='$id'
    ");
    header("Location: ps.php");
}
?>

<h3>Edit PlayStation</h3>
<form method="post">
    Nama PS <br>
    <input type="text" name="nama" value="<?= $ps['nama_ps'] ?>"><br><br>

    Harga / Hari <br>
    <input type="number" name="harga" value="<?= $ps['harga_per_hari'] ?>"><br><br>

    <button name="update">Update</button>
</form>
