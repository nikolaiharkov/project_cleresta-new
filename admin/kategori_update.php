<?php 
include '../koneksi.php';
$id = $_POST['id'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

mysqli_query($koneksi, "UPDATE kategori SET kategori_nama='$nama' WHERE kategori_id='$id'");
header("location: kategori.php");
?>