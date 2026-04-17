<?php 
session_start();

$id_produk = $_GET['id'] ?? 0;

foreach($_SESSION['keranjang'] as $key => $item){
    if($item['produk'] == $id_produk){
        unset($_SESSION['keranjang'][$key]);
        break;
    }
}

// Reindex array
$_SESSION['keranjang'] = array_values($_SESSION['keranjang']);

header("location: keranjang.php");
exit;
?>