<?php 
session_start();
include 'koneksi.php';

// Ambil parameter
$id_produk = $_GET['id'] ?? $_POST['id'] ?? 0;
$redirect = $_GET['redirect'] ?? $_POST['redirect'] ?? 'keranjang';
$jumlah = $_POST['jumlah'] ?? $_GET['jumlah'] ?? 1;

// Validasi jumlah minimal 1
if($jumlah < 1) $jumlah = 1;

// Cek apakah produk ada di database
$cek_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id='$id_produk'");
if(mysqli_num_rows($cek_produk) == 0){
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan']);
        exit;
    }
    header("location: index.php");
    exit;
}

$produk = mysqli_fetch_assoc($cek_produk);
$stok_tersedia = $produk['produk_jumlah'];

// Inisialisasi keranjang jika belum ada
if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = array();
}

// Cek apakah produk sudah ada di keranjang
$found = false;
foreach($_SESSION['keranjang'] as $key => $item){
    if($item['produk'] == $id_produk){
        // Update jumlah, batasi maksimal stok
        $new_jumlah = $item['jumlah'] + $jumlah;
        if($new_jumlah > $stok_tersedia){
            $new_jumlah = $stok_tersedia;
        }
        $_SESSION['keranjang'][$key]['jumlah'] = $new_jumlah;
        $found = true;
        break;
    }
}

// Jika belum ada, tambahkan ke keranjang
if(!$found){
    // Batasi jumlah tidak melebihi stok
    if($jumlah > $stok_tersedia){
        $jumlah = $stok_tersedia;
    }
    $_SESSION['keranjang'][] = array(
        'produk' => $id_produk,
        'jumlah' => $jumlah
    );
}

// Jika AJAX request, return JSON
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    header('Content-Type: application/json');
    
    // Hitung total item di keranjang
    $total_item = 0;
    foreach($_SESSION['keranjang'] as $item){
        $total_item += $item['jumlah'];
    }
    
    echo json_encode([
        'success' => true, 
        'message' => 'Produk ditambahkan ke keranjang',
        'cart_count' => count($_SESSION['keranjang']),
        'total_item' => $total_item
    ]);
    exit;
}

// Redirect sesuai parameter
switch($redirect){
    case 'index':
        $r = "index.php";
        break;
    case 'detail':
        $r = "produk_detail.php?id=".$id_produk;
        break;
    case 'checkout':
        $r = "checkout.php";
        break;
    default:
        $r = "keranjang.php";
}

header("location: ".$r);
exit;
?>