<?php 
include '../koneksi.php';

$id = $_POST['id'];
$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
$harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
$keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
$berat = mysqli_real_escape_string($koneksi, $_POST['berat']);
$jumlah = mysqli_real_escape_string($koneksi, $_POST['jumlah']);

$rand = rand();
$allowed = array('gif', 'png', 'jpg', 'jpeg');

// UPDATE data dasar produk
mysqli_query($koneksi, "UPDATE produk SET 
    produk_nama='$nama', 
    produk_kategori='$kategori', 
    produk_harga='$harga', 
    produk_keterangan='$keterangan', 
    produk_berat='$berat', 
    produk_jumlah='$jumlah' 
    WHERE produk_id='$id'");

// Update Foto 1
if($_FILES['foto1']['name'] != ""){
    $filename1 = $_FILES['foto1']['name'];
    $ext = pathinfo($filename1, PATHINFO_EXTENSION);
    if(in_array($ext, $allowed)) {
        $query_lama = mysqli_query($koneksi, "SELECT produk_foto1 FROM produk WHERE produk_id='$id'");
        $lama = mysqli_fetch_assoc($query_lama);
        if($lama['produk_foto1'] != "" && file_exists("../gambar/produk/".$lama['produk_foto1'])) {
            unlink("../gambar/produk/".$lama['produk_foto1']);
        }
        $nama_file_baru = $rand.'_'.$filename1;
        move_uploaded_file($_FILES['foto1']['tmp_name'], '../gambar/produk/'.$nama_file_baru);
        mysqli_query($koneksi, "UPDATE produk SET produk_foto1='$nama_file_baru' WHERE produk_id='$id'");
    }
}

// Update Foto 2
if($_FILES['foto2']['name'] != ""){
    $filename2 = $_FILES['foto2']['name'];
    $ext = pathinfo($filename2, PATHINFO_EXTENSION);
    if(in_array($ext, $allowed)) {
        $query_lama = mysqli_query($koneksi, "SELECT produk_foto2 FROM produk WHERE produk_id='$id'");
        $lama = mysqli_fetch_assoc($query_lama);
        if($lama['produk_foto2'] != "" && file_exists("../gambar/produk/".$lama['produk_foto2'])) {
            unlink("../gambar/produk/".$lama['produk_foto2']);
        }
        $nama_file_baru = $rand.'_'.$filename2;
        move_uploaded_file($_FILES['foto2']['tmp_name'], '../gambar/produk/'.$nama_file_baru);
        mysqli_query($koneksi, "UPDATE produk SET produk_foto2='$nama_file_baru' WHERE produk_id='$id'");
    }
}

// Update Foto 3
if($_FILES['foto3']['name'] != ""){
    $filename3 = $_FILES['foto3']['name'];
    $ext = pathinfo($filename3, PATHINFO_EXTENSION);
    if(in_array($ext, $allowed)) {
        $query_lama = mysqli_query($koneksi, "SELECT produk_foto3 FROM produk WHERE produk_id='$id'");
        $lama = mysqli_fetch_assoc($query_lama);
        if($lama['produk_foto3'] != "" && file_exists("../gambar/produk/".$lama['produk_foto3'])) {
            unlink("../gambar/produk/".$lama['produk_foto3']);
        }
        $nama_file_baru = $rand.'_'.$filename3;
        move_uploaded_file($_FILES['foto3']['tmp_name'], '../gambar/produk/'.$nama_file_baru);
        mysqli_query($koneksi, "UPDATE produk SET produk_foto3='$nama_file_baru' WHERE produk_id='$id'");
    }
}

header("location: produk.php");
exit;
?>