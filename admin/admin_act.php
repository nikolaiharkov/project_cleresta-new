<?php 
include '../koneksi.php';

$nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']);

$rand     = rand();
$allowed  = array('gif', 'png', 'jpg', 'jpeg');
$filename = $_FILES['foto']['name'];

if($filename == ""){
    mysqli_query($koneksi, "INSERT INTO admin VALUES (NULL, '$nama', '$username', '$password', '')");
    header("location: settings.php?alert=sukses");
} else {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!in_array(strtolower($ext), $allowed)) {
        header("location: settings.php?alert=gagal");
    } else {
        $new_filename = $rand.'_'.$filename;
        move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/user/'.$new_filename);
        mysqli_query($koneksi, "INSERT INTO admin VALUES (NULL, '$nama', '$username', '$password', '$new_filename')");
        header("location: settings.php?alert=sukses");
    }
}
exit;
?>