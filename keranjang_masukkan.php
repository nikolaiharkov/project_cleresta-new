<?php 
include 'koneksi.php';
session_start();

// Deteksi apakah permintaan menggunakan AJAX
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

// Ambil parameter data
$id_produk = mysqli_real_escape_string($koneksi, $_POST['id'] ?? $_GET['id'] ?? 0);
$jumlah_input = (int)($_POST['jumlah'] ?? $_GET['jumlah'] ?? 1);

// Validasi keberadaan produk di database
$cek_produk = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id='$id_produk'");
if(mysqli_num_rows($cek_produk) == 0){
    if($is_ajax){
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Maaf, produk tidak ditemukan.']);
        exit();
    }
    header("location:index.php");
    exit();
}

$p = mysqli_fetch_assoc($cek_produk);
$stok_tersedia = (int)$p['produk_jumlah'];

// Inisialisasi keranjang jika belum ada
if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = array();
}

$sudah_ada = false;
foreach($_SESSION['keranjang'] as $key => $item){
    if($item['produk'] == $id_produk){
        $new_qty = $item['jumlah'] + $jumlah_input;
        // Jangan melebihi stok yang ada
        if($new_qty > $stok_tersedia) $new_qty = $stok_tersedia;
        
        $_SESSION['keranjang'][$key]['jumlah'] = $new_qty;
        $sudah_ada = true;
        break;
    }
}

if(!$sudah_ada){
    // Pastikan tidak input lebih dari stok yang tersedia
    if($jumlah_input > $stok_tersedia) $jumlah_input = $stok_tersedia;
    
    $_SESSION['keranjang'][] = array(
        'produk' => $id_produk,
        'jumlah' => $jumlah_input
    );
}

// Respon untuk AJAX
if($is_ajax){
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true, 
        'message' => 'Produk berhasil ditambahkan ke keranjang.',
        'cart_count' => count($_SESSION['keranjang'])
    ]);
    exit();
}

// Respon untuk klik link biasa (Fallback)
header("location:keranjang.php?alert=ditambahkan");
exit();
?>