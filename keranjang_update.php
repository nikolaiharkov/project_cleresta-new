<?php 
session_start();
include 'koneksi.php';

$key = $_POST['key'] ?? 0;
$id_produk = $_POST['id'] ?? 0;
$jumlah = $_POST['jumlah'] ?? 1;

if($jumlah < 1) $jumlah = 1;

// Cek stok
$cek = mysqli_query($koneksi, "SELECT produk_jumlah FROM produk WHERE produk_id='$id_produk'");
$stok = mysqli_fetch_assoc($cek);
if($jumlah > $stok['produk_jumlah']){
    $jumlah = $stok['produk_jumlah'];
}

if(isset($_SESSION['keranjang'][$key])){
    $_SESSION['keranjang'][$key]['jumlah'] = $jumlah;
}

header("location: keranjang.php");
exit;
?><?php 
session_start();
include 'koneksi.php';

$key = $_POST['key'] ?? 0;
$id_produk = $_POST['id'] ?? 0;
$jumlah = $_POST['jumlah'] ?? 1;

if($jumlah < 1) $jumlah = 1;

// Cek stok
$cek = mysqli_query($koneksi, "SELECT produk_jumlah FROM produk WHERE produk_id='$id_produk'");
$stok = mysqli_fetch_assoc($cek);
if($jumlah > $stok['produk_jumlah']){
    $jumlah = $stok['produk_jumlah'];
}

if(isset($_SESSION['keranjang'][$key])){
    $_SESSION['keranjang'][$key]['jumlah'] = $jumlah;
}

header("location: keranjang.php");
exit;
?>