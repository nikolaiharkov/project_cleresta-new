<?php 
include 'koneksi.php';
session_start();

// Pastikan kunci sesi selaras dengan login customer
if(!isset($_SESSION['customer_status']) || $_SESSION['customer_status'] != "login"){
    header("location:masuk.php?alert=login-dulu");
    exit();
}

$id_customer = $_SESSION['customer_id'];
$tanggal = date('Y-m-d');

$nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
$hp = mysqli_real_escape_string($koneksi, $_POST['hp']);
$alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$provinsi = mysqli_real_escape_string($koneksi, $_POST['provinsi']);
$kabupaten = mysqli_real_escape_string($koneksi, $_POST['kabupaten']);
$kurir = $_POST['kurir'] ." - ". $_POST['service'];
$berat = $_POST['berat'];
$ongkir = $_POST['ongkir'];

// Total bayar = subtotal produk + ongkir flat
$total_bayar = $_POST['total_produk'] + $ongkir;

// Simpan data invoice (15 kolom mengikut ecommerce.sql anda)
mysqli_query($koneksi,"insert into invoice values(NULL,'$tanggal','$id_customer','$nama','$hp','$alamat','$provinsi','$kabupaten','$kurir','$berat','$ongkir','$total_bayar','0','','')") or die(mysqli_error($koneksi));

$last_id = mysqli_insert_id($koneksi);
$invoice = $last_id;

$jumlah_isi_keranjang = count($_SESSION['keranjang']);

for($a = 0; $a < $jumlah_isi_keranjang; $a++){
	$id_produk = $_SESSION['keranjang'][$a]['produk'];
	$jml = $_SESSION['keranjang'][$a]['jumlah'];

	$isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
	$i = mysqli_fetch_assoc($isi);

	$produk = $i['produk_id'];
	$harga = $i['produk_harga'];
	
	mysqli_query($koneksi,"insert into transaksi values(NULL,'$invoice','$produk','$jml','$harga')");
}

// Kosongkan keranjang
unset($_SESSION['keranjang']);
$_SESSION['keranjang'] = array();

header("location:customer_pesanan.php?alert=sukses");
?>