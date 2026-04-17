<?php 
include '../koneksi.php';
$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM kategori WHERE kategori_id='$id'");
mysqli_query($koneksi, "UPDATE produk SET produk_kategori='1' WHERE produk_kategori='$id'");

header("location: kategori.php");
?>