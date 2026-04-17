<?php 
include '../koneksi.php';
$id = $_POST['id'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$pwd = $_POST['password'];

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if($pwd == "" && $filename == ""){
  mysqli_query($koneksi, "UPDATE admin SET admin_nama='$nama', admin_username='$username' WHERE admin_id='$id'");
  header("location: settings.php?alert=berhasil");
} elseif($pwd == "") {
  if(in_array($ext, $allowed)) {
    // Hapus foto lama
    $query_lama = mysqli_query($koneksi, "SELECT admin_foto FROM admin WHERE admin_id='$id'");
    $lama = mysqli_fetch_assoc($query_lama);
    if($lama['admin_foto'] != "" && file_exists("../gambar/user/".$lama['admin_foto'])) {
      unlink("../gambar/user/".$lama['admin_foto']);
    }
    // Upload foto baru
    move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/'.$rand.'_'.$filename);
    $file_gambar = $rand.'_'.$filename;
    mysqli_query($koneksi, "UPDATE admin SET admin_nama='$nama', admin_username='$username', admin_foto='$file_gambar' WHERE admin_id='$id'");
    header("location: settings.php?alert=berhasil");
  }
} elseif($filename == "") {
  $password = md5($pwd);
  mysqli_query($koneksi, "UPDATE admin SET admin_nama='$nama', admin_username='$username', admin_password='$password' WHERE admin_id='$id'");
  header("location: settings.php?alert=berhasil");
} else {
  $password = md5($pwd);
  // Hapus foto lama
  $query_lama = mysqli_query($koneksi, "SELECT admin_foto FROM admin WHERE admin_id='$id'");
  $lama = mysqli_fetch_assoc($query_lama);
  if($lama['admin_foto'] != "" && file_exists("../gambar/user/".$lama['admin_foto'])) {
    unlink("../gambar/user/".$lama['admin_foto']);
  }
  // Upload foto baru
  move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/'.$rand.'_'.$filename);
  $file_gambar = $rand.'_'.$filename;
  mysqli_query($koneksi, "UPDATE admin SET admin_nama='$nama', admin_username='$username', admin_password='$password', admin_foto='$file_gambar' WHERE admin_id='$id'");
  header("location: settings.php?alert=berhasil");
}
exit;
?>