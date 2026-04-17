<?php 
include '../koneksi.php';
session_start();
$id = $_SESSION['id'];
$password = md5($_POST['password']);

mysqli_query($koneksi, "UPDATE admin SET admin_password='$password' WHERE admin_id='$id'") or die(mysqli_error($koneksi));

// Redirect ke halaman asal
if(strpos($_SERVER['HTTP_REFERER'], 'settings.php') !== false){
  header("location: settings.php?alert_pass=sukses");
} else {
  header("location: gantipassword.php?alert=sukses");
}
exit;
?>