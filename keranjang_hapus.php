<?php 
session_start();

$id_produk = $_GET['id'] ?? 0;

if(isset($_SESSION['keranjang'])){
    foreach($_SESSION['keranjang'] as $key => $item){
        if($item['produk'] == $id_produk){
            unset($_SESSION['keranjang'][$key]);
            break;
        }
    }
    // Re-index agar urutan array kembali 0,1,2...
    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
}

header("location: keranjang.php");
exit();
?>