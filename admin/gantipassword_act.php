<?php 
include '../koneksi.php';
session_start();

// Pastikan user sudah login
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    header("location:../login.php?alert=belum_login");
    exit;
}

$id = $_SESSION['id'];
// Mengamankan input meskipun akan di-hash
$password_baru = mysqli_real_escape_string($koneksi, $_POST['password']);
$password_md5 = md5($password_baru);

// Eksekusi Update
$update = mysqli_query($koneksi, "UPDATE admin SET admin_password='$password_md5' WHERE admin_id='$id'");

if($update){
    // Logika Redirect Pintar: 
    // Jika ganti password dilakukan via tab di settings.php, kembali ke sana.
    // Jika dilakukan di halaman terpisah gantipassword.php, kembali ke sana.
    if(isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'settings.php') !== false){
        header("location: settings.php?alert_pass=sukses");
    } else {
        header("location: gantipassword.php?alert=sukses");
    }
} else {
    header("location: settings.php?alert_pass=gagal");
}
exit;
?>