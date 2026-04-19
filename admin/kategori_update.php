<?php 
include '../koneksi.php';
$id   = mysqli_real_escape_string($koneksi, $_POST['id']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);

mysqli_query($koneksi, "UPDATE kategori SET kategori_nama='$nama' WHERE kategori_id='$id'") or die(mysqli_error($koneksi));

header("location: kategori.php?alert=update_sukses");
exit;
?>