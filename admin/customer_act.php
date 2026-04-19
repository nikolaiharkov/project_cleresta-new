<?php 
include '../koneksi.php';

$nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
$email    = mysqli_real_escape_string($koneksi, $_POST['email']);
$hp       = mysqli_real_escape_string($koneksi, $_POST['hp']);
$alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$password = md5($_POST['password']);

// Cek apakah email sudah terdaftar
$cek_email = mysqli_query($koneksi, "SELECT * FROM customer WHERE customer_email='$email'");
if(mysqli_num_rows($cek_email) > 0){
    header("location:customer.php?alert=gagal"); // Email sudah ada
} else {
    mysqli_query($koneksi, "INSERT INTO customer VALUES (NULL, '$nama', '$email', '$hp', '$alamat', '$password')") or die(mysqli_error($koneksi));
    header("location:customer.php?alert=sukses");
}
exit;
?>