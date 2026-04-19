<?php 
include '../koneksi.php';
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Proteksi agar kategori ID 1 (Default) tidak bisa dihapus
if($id == 1){
    header("location: kategori.php?alert=gagal");
    exit;
}

// 1. Alihkan semua produk yang menggunakan kategori ini ke kategori ID 1 (Default)
mysqli_query($koneksi, "UPDATE produk SET produk_kategori='1' WHERE produk_kategori='$id'");

// 2. Hapus kategori tersebut
mysqli_query($koneksi, "DELETE FROM kategori WHERE kategori_id='$id'");

header("location: kategori.php?alert=terhapus");
exit;
?>