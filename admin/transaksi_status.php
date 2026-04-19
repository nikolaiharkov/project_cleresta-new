<?php 
include '../koneksi.php';

// Menangkap data dari form transaksi.php
// Menggunakan null coalescing untuk menangani perbedaan nama input (id atau invoice)
$invoice = mysqli_real_escape_string($koneksi, $_POST['invoice'] ?? $_POST['id']);
$status  = mysqli_real_escape_string($koneksi, $_POST['status']);

// Eksekusi update status ke database
mysqli_query($koneksi, "UPDATE invoice SET invoice_status='$status' WHERE invoice_id='$invoice'") or die(mysqli_error($koneksi));

// Redirect kembali dengan parameter sukses untuk memicu SweetAlert
header("location: transaksi.php?alert=update_sukses");
exit;
?>