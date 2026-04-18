<?php 
include 'koneksi.php';
session_start();

$key = $_POST['key'] ?? 0;
$id_produk = $_POST['id'] ?? 0;
$jumlah = $_POST['jumlah'] ?? 1;
$is_ajax = isset($_POST['ajax']);

if($jumlah < 1) $jumlah = 1;

// Validasi stok di server
$cek = mysqli_query($koneksi, "SELECT produk_jumlah FROM produk WHERE produk_id='$id_produk'");
$stok = mysqli_fetch_assoc($cek);
if($jumlah > $stok['produk_jumlah']){
    $jumlah = $stok['produk_jumlah'];
}

// Update nilai di session
if(isset($_SESSION['keranjang'][$key])){
    $_SESSION['keranjang'][$key]['jumlah'] = $jumlah;
}

if($is_ajax){
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'jumlah' => $jumlah]);
    exit();
}

header("location: keranjang.php");
?>