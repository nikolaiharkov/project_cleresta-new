<?php include 'header.php'; ?>

<style>
    /* Quantity Selector Styles */
    .quantity-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 20px 0;
    }
    .qty-btn {
        width: 40px;
        height: 40px;
        background: #f0f2f5;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 18px;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s;
    }
    .qty-btn:hover:not(:disabled) {
        background: #78B817;
        color: white;
        border-color: #78B817;
    }
    .qty-input {
        width: 70px;
        height: 40px;
        text-align: center;
        font-size: 16px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }
    .qty-input:focus {
        outline: none;
        border-color: #78B817;
    }
    .stock-info {
        font-size: 14px;
        color: #7f8c8d;
        margin-bottom: 15px;
    }
    .stock-info .in-stock {
        color: #78B817;
        font-weight: 600;
    }
    .stock-info .out-stock {
        color: #e74c3c;
        font-weight: 600;
    }
    .btn-buy-now {
        background: #2c3e50;
        color: white;
        padding: 12px 30px;
        border-radius: 4px;
        display: inline-block;
        text-decoration: none;
        margin-left: 10px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }
    .btn-buy-now:hover:not(:disabled) {
        background: #1a2c3e;
    }
    .primary-btn-custom {
        background: #78B817;
        color: white;
        padding: 12px 30px;
        border-radius: 4px;
        display: inline-block;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }
    .primary-btn-custom:hover:not(:disabled) {
        background: #5e9c12;
    }
    #product-main-view { border: 1px solid #eee; border-radius: 8px; background: #fff; position: relative; }
    #product-main-view .product-view img { width: 100%; height: 400px; object-fit: contain; padding: 20px; }
    #product-view { margin-top: 15px; }
    #product-view .product-view { padding: 0 5px; cursor: pointer; }
    #product-view .product-view img { width: 100%; height: 80px; object-fit: cover; border: 2px solid #f0f0f0; border-radius: 4px; }
    #product-view .slick-current img { border-color: #78B817; }
</style>

<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php">Produk</a></li>
            <li class="active">Detail Produk</li>
        </ul>
    </div>
</div>

<?php
$id_produk = mysqli_real_escape_string($koneksi, $_GET['id']);
$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id_produk'");
if(mysqli_num_rows($data) > 0){
    while($d = mysqli_fetch_array($data)){
        $fallback = "gambar/sistem/produk.png";
        $stok = (int)$d['produk_jumlah'];
        $stok_status = ($stok > 0) ? "Tersedia" : "Stok Habis";
        $stok_class = ($stok > 0) ? "in-stock" : "out-stock";
        $max_qty = ($stok > 0) ? $stok : 0;
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div id="product-main-view">
                    <div class="product-view"><img src="<?php echo ($d['produk_foto1'] == "") ? $fallback : "gambar/produk/".$d['produk_foto1']; ?>"></div>
                    <?php if($d['produk_foto2'] != ""){ echo "<div class='product-view'><img src='gambar/produk/".$d['produk_foto2']."'></div>"; } ?>
                    <?php if($d['produk_foto3'] != ""){ echo "<div class='product-view'><img src='gambar/produk/".$d['produk_foto3']."'></div>"; } ?>
                </div>
                <div id="product-view">
                    <div class="product-view"><img src="<?php echo ($d['produk_foto1'] == "") ? $fallback : "gambar/produk/".$d['produk_foto1']; ?>"></div>
                    <?php if($d['produk_foto2'] != ""){ echo "<div class='product-view'><img src='gambar/produk/".$d['produk_foto2']."'></div>"; } ?>
                    <?php if($d['produk_foto3'] != ""){ echo "<div class='product-view'><img src='gambar/produk/".$d['produk_foto3']."'></div>"; } ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-label">
                    <span style="background:#78B817; color:white; padding:2px 8px; border-radius:4px; font-size:12px;"><?php echo $d['kategori_nama']; ?></span>
                </div>
                <h2 style="font-weight:700; color:#333; margin-top:10px;"><?php echo $d['produk_nama']; ?></h2>
                <h3 style="color:#78B817; font-weight:700; margin-bottom:15px;"><?php echo "Rp. ".number_format($d['produk_harga']); ?></h3>
                
                <div class="stock-info">
                    <i class="fa fa-box"></i> Stok: <span class="<?php echo $stok_class; ?>"><?php echo $stok_status; ?></span> (<?php echo number_format($stok); ?> pcs)
                    <span style="margin-left: 20px;"><i class="fa fa-balance-scale"></i> Berat: <?php echo number_format($d['produk_berat']); ?> gr</span>
                </div>
                
                <div class="product-keterangan" style="margin:20px 0; line-height:1.8; color:#555; background:#f9f9f9; padding:15px; border-radius:8px;">
                    <strong>Keterangan Produk:</strong><br>
                    <?php echo nl2br(htmlspecialchars_decode($d['produk_keterangan'])); ?>
                </div>
                
                <div class="quantity-wrapper">
                    <label style="font-weight:bold; color:#333;">Jumlah :</label>
                    <button class="qty-btn" id="qtyMinus" <?php echo ($stok <= 0) ? 'disabled' : ''; ?>>-</button>
                    <input type="number" id="qtyValue" class="qty-input" value="1" min="1" max="<?php echo $max_qty; ?>" <?php echo ($stok <= 0) ? 'disabled' : ''; ?> readonly>
                    <button class="qty-btn" id="qtyPlus" <?php echo ($stok <= 0) ? 'disabled' : ''; ?>>+</button>
                </div>
                
                <div class="action-buttons" style="margin-top:25px;">
                    <button class="primary-btn-custom" id="addToCartBtn" <?php echo ($stok <= 0) ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : ''; ?>>
                        <i class="fa fa-shopping-cart"></i> MASUKKAN KERANJANG
                    </button>
                    <button class="btn-buy-now" id="buyNowBtn" <?php echo ($stok <= 0) ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : ''; ?>>
                        <i class="fa fa-bolt"></i> BELI SEKARANG
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    }
} else {
    echo '<div class="section"><div class="container"><div class="row"><div class="col-md-12 text-center" style="padding:100px 0;"><h3>Produk tidak ditemukan</h3><br><a href="index.php" class="primary-btn-custom">Kembali ke Beranda</a></div></div></div></div>';
}
?>

<?php include 'footer.php'; ?>

<script>
$(document).ready(function() {
    const qtyInput = $('#qtyValue');
    const maxStock = parseInt(qtyInput.attr('max')) || 0;
    
    // Tombol Tambah/Kurang
    $('#qtyMinus').click(function() {
        let val = parseInt(qtyInput.val());
        if (val > 1) qtyInput.val(val - 1);
    });
    
    $('#qtyPlus').click(function() {
        let val = parseInt(qtyInput.val());
        if (val < maxStock) {
            qtyInput.val(val + 1);
        } else {
            Swal.fire({ icon: 'warning', title: 'Stok Terbatas', text: 'Maaf, stok hanya tersedia ' + maxStock + ' pcs.', confirmButtonColor: '#78B817' });
        }
    });

    // Fungsi Global AJAX Tambah Keranjang
    function processAddToCart(quantity, isBuyNow = false) {
        const productId = <?php echo (int)$id_produk; ?>;
        
        $.ajax({
            url: 'keranjang_masukkan.php',
            type: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            data: { id: productId, jumlah: quantity },
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    if(isBuyNow) {
                        window.location.href = 'checkout.php';
                    } else {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Produk berhasil ditambahkan ke keranjang.',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#78B817',
                            cancelButtonColor: '#2c3e50',
                            confirmButtonText: 'Lihat Keranjang',
                            cancelButtonText: 'Lanjut Belanja'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'keranjang.php';
                            } else {
                                location.reload(); // Refresh untuk update badge qty di header
                            }
                        });
                    }
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: response.message || 'Gagal menambahkan produk.', confirmButtonColor: '#78B817' });
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan sistem. Silahkan coba lagi.', confirmButtonColor: '#78B817' });
            }
        });
    }
    
    // Event Click Tambah Keranjang
    $('#addToCartBtn').click(function(e) {
        e.preventDefault();
        processAddToCart(parseInt(qtyInput.val()));
    });
    
    // Event Click Beli Sekarang
    $('#buyNowBtn').click(function(e) {
        e.preventDefault();
        processAddToCart(parseInt(qtyInput.val()), true);
    });

    // Inisialisasi Slider (Wajib setelah Slick terload di footer)
    if ($.fn.slick) {
        $('#product-main-view').slick({
            slidesToShow: 1, slidesToScroll: 1, arrows: true, fade: false, asNavFor: '#product-view',
            prevArrow: '<button class="slick-prev"><i class="fa fa-angle-left"></i></button>',
            nextArrow: '<button class="slick-next"><i class="fa fa-angle-right"></i></button>'
        });
        $('#product-view').slick({
            slidesToShow: 3, slidesToScroll: 1, asNavFor: '#product-main-view', dots: false, centerMode: true, focusOnSelect: true, arrows: false
        });
    }
});
</script>