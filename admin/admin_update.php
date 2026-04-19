<?php 
include '../koneksi.php';

$id       = $_POST['id'];
$nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$pwd      = $_POST['password'];

mysqli_query($koneksi, "UPDATE admin SET admin_nama='$nama', admin_username='$username' WHERE admin_id='$id'");

if($pwd != ""){
    $password = md5($pwd);
    mysqli_query($koneksi, "UPDATE admin SET admin_password='$password' WHERE admin_id='$id'");
}

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];

if($filename != ""){
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(in_array(strtolower($ext), $allowed)) {
        $lama = mysqli_query($koneksi, "SELECT admin_foto FROM admin WHERE admin_id='$id'");
        $l = mysqli_fetch_assoc($lama);
        if($l['admin_foto'] != "" && file_exists('../gambar/user/'.$l['admin_foto'])){
            unlink('../gambar/user/'.$l['admin_foto']);
        }

        $new_filename = $rand.'_'.$filename;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/'.$new_filename);
        mysqli_query($koneksi, "UPDATE admin SET admin_foto='$new_filename' WHERE admin_id='$id'");
    }
}

header("location: settings.php?alert=update_sukses");
exit;
?>