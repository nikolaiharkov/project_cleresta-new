<?php 
include '../koneksi.php';
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

mysqli_query($koneksi, "INSERT INTO kategori VALUES (NULL, '$nama')");
header("location: kategori.php");
?>