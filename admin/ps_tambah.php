<?php
include '../config/database.php';

if (isset($_POST['simpan'])) {
    mysqli_query($conn, "
        INSERT INTO playstations (nama_ps, harga_per_hari)
        VALUES ('$_POST[nama]', '$_POST[harga]')
    ");
    header("Location: ps.php");
}
?>

<h3>Tambah PlayStation</h3>
<form method="post">
    Nama PS <br>
    <input type="text" name="nama" required><br><br>

    Harga / Hari <br>
    <input type="number" name="harga" required><br><br>

    <button name="simpan">Simpan</button>
</form>
