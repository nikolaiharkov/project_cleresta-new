<?php 
include '../koneksi.php';

// Menangkap ID invoice dengan aman
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 1. Hapus semua detail produk terkait pesanan ini di tabel transaksi
mysqli_query($koneksi, "DELETE FROM transaksi WHERE transaksi_invoice='$id'") or die(mysqli_error($koneksi));

// 2. Hapus data utama pesanan di tabel invoice
mysqli_query($koneksi, "DELETE FROM invoice WHERE invoice_id='$id'") or die(mysqli_error($koneksi));

// Redirect kembali ke halaman transaksi dengan pemicu SweetAlert
header("location: transaksi.php?alert=terhapus");
exit;
?>