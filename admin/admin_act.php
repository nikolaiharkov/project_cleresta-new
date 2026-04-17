<?php 
include '../koneksi.php';
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']);

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];

if($filename == ""){
  mysqli_query($koneksi, "INSERT INTO admin VALUES (NULL, '$nama', '$username', '$password', '')");
  header("location: settings.php?alert=berhasil");
} else {
  $ext = pathinfo($filename, PATHINFO_EXTENSION);
  if(!in_array($ext, $allowed)) {
    header("location: settings.php?alert=gagal");
  } else {
    move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/'.$rand.'_'.$filename);
    $file_gambar = $rand.'_'.$filename;
    mysqli_query($koneksi, "INSERT INTO admin VALUES (NULL, '$nama', '$username', '$password', '$file_gambar')");
    header("location: settings.php?alert=berhasil");
  }
}
exit;
?>