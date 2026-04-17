<?php 
include '../koneksi.php';

$id = mysqli_real_escape_string($koneksi, $_POST['id']);
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$password = $_POST['password'];

if($password == ""){
    mysqli_query($koneksi, "UPDATE customer SET 
        customer_nama='$nama', 
        customer_email='$email', 
        customer_hp='$hp', 
        customer_alamat='$alamat' 
        WHERE customer_id='$id'");
} else {
    $password_md5 = md5($password);
    mysqli_query($koneksi, "UPDATE customer SET 
        customer_nama='$nama', 
        customer_email='$email', 
        customer_hp='$hp', 
        customer_alamat='$alamat', 
        customer_password='$password_md5' 
        WHERE customer_id='$id'");
}

header("location: customer.php");
exit;
?>