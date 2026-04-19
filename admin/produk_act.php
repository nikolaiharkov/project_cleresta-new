<?php 
include '../koneksi.php';

// 1. Tangkap data dan pastikan tipe datanya benar
$nama       = mysqli_real_escape_string($koneksi, $_POST['nama']);
$kategori   = $_POST['kategori'];
$harga      = (int)$_POST['harga'];
$stok       = (int)$_POST['stok'];
$berat      = (int)$_POST['berat']; // Data berat dipastikan angka
$keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

$rand = rand();
$allowed = array('gif','png','jpg','jpeg');
$filename = $_FILES['foto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if(!in_array(strtolower($ext), $allowed)) {
    header("location:produk.php?alert=gagal");
} else {
    $new_filename = $rand.'_'.$filename;
    move_uploaded_file($_FILES['foto']['tmp_name'], '../gambar/produk/'.$new_filename);
    
    // 2. QUERY DENGAN MENYEBUTKAN NAMA KOLOM (SANGAT DISARANKAN)
    // Sesuaikan nama kolom di bawah ini (produk_nama, dll) dengan yang ada di database Anda
    $query = "INSERT INTO produk (
                produk_nama, 
                produk_kategori, 
                produk_harga, 
                produk_jumlah, 
                produk_berat, 
                produk_keterangan, 
                produk_foto1
              ) VALUES (
                '$nama', 
                '$kategori', 
                '$harga', 
                '$stok', 
                '$berat', 
                '$keterangan', 
                '$new_filename'
              )";

    mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));
    
    header("location:produk.php?alert=sukses");
}
?>