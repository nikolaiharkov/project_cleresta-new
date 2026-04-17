<?php 
include '../koneksi.php';
$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$id'");
$d = mysqli_fetch_assoc($data);
$foto = $d['admin_foto'];
if($foto != "" && file_exists("../gambar/user/$foto")) {
  unlink("../gambar/user/$foto");
}
mysqli_query($koneksi, "DELETE FROM admin WHERE admin_id='$id'");

header("location: settings.php?alert=hapus");
exit;
?>