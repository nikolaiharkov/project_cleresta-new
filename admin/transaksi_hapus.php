<?php 
include '../koneksi.php';
$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM invoice WHERE invoice_id='$id'");
mysqli_query($koneksi, "DELETE FROM transaksi WHERE transaksi_invoice='$id'");

header("location: transaksi.php");
exit;
?>