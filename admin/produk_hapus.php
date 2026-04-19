<?php 
include '../koneksi.php';

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 1. Ambil nama file foto sebelum data di DB dihapus
$data = mysqli_query($koneksi, "SELECT produk_foto1 FROM produk WHERE produk_id='$id'");
$d = mysqli_fetch_assoc($data);
$foto = $d['produk_foto1'];

// 2. Hapus file fisik di folder jika ada
if($foto != "" && file_exists('../gambar/produk/'.$foto)){
    unlink('../gambar/produk/'.$foto);
}

// 3. Hapus data dari database
mysqli_query($koneksi, "DELETE FROM produk WHERE produk_id='$id'") or die(mysqli_error($koneksi));

header("location:produk.php?alert=terhapus");
exit;
?>