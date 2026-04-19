<?php 
include '../koneksi.php';
$id = $_GET['id'];

if($id == 1){
    header("location: settings.php?alert=gagal");
    exit;
}

$data = mysqli_query($koneksi, "SELECT admin_foto FROM admin WHERE admin_id='$id'");
$d = mysqli_fetch_assoc($data);
if($d['admin_foto'] != "" && file_exists('../gambar/user/'.$d['admin_foto'])){
    unlink('../gambar/user/'.$d['admin_foto']);
}

mysqli_query($koneksi, "DELETE FROM admin WHERE admin_id='$id'");

header("location: settings.php?alert=terhapus");
exit;
?>