<?php 
include '../koneksi.php';
$invoice = $_POST['invoice'];
$status = $_POST['status'];

mysqli_query($koneksi, "UPDATE invoice SET invoice_status='$status' WHERE invoice_id='$invoice'");

header("location: transaksi.php");
exit;
?>