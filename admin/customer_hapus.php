<?php 
include '../koneksi.php';
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 1. Hapus detail transaksi yang terkait dengan invoice customer ini
$get_invoice = mysqli_query($koneksi, "SELECT invoice_id FROM invoice WHERE invoice_customer='$id'");
while($inv = mysqli_fetch_array($get_invoice)){
    $id_inv = $inv['invoice_id'];
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE transaksi_invoice='$id_inv'");
}

// 2. Hapus invoice milik customer
mysqli_query($koneksi, "DELETE FROM invoice WHERE invoice_customer='$id'");

// 3. Hapus data customer utama
mysqli_query($koneksi, "DELETE FROM customer WHERE customer_id='$id'");

header("location:customer.php?alert=terhapus");
exit;
?>