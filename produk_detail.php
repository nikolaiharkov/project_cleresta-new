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
	.qty-btn:hover {
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
		color: #27ae60;
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
	.btn-buy-now:hover {
		background: #1a2c3e;
	}
	.primary-btn {
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
	.primary-btn:hover {
		background: #5e9c12;
	}
	#product-main-view { border: 1px solid #eee; border-radius: 8px; background: #fff; position: relative; }
	#product-main-view .product-view img { width: 100%; height: 400px; object-fit: contain; padding: 20px; }
	#product-view { margin-top: 15px; }
	#product-view .product-view { padding: 0 5px; cursor: pointer; }
	#product-view .product-view img { width: 100%; height: 80px; object-fit: cover; border: 2px solid #f0f0f0; border-radius: 4px; }
	#product-view .slick-current img { border-color: #78B817; }
	.slick-arrow { width: 35px; height: 35px; background: #fff !important; border-radius: 50%; z-index: 10; border: 1px solid #ddd !important; display: flex !important; align-items: center; justify-content: center; position: absolute; top: 50%; transform: translateY(-50%); }
	.slick-prev { left: 10px; } .slick-next { right: 10px; }
	.slick-arrow:before { font-family: 'FontAwesome'; color: #333; font-size: 14px; }
	.slick-prev:before { content: "\f104"; } .slick-next:before { content: "\f105"; }
	.toast-notif {
		position: fixed;
		bottom: 30px;
		right: 30px;
		background: #27ae60;
		color: white;
		padding: 12px 24px;
		border-radius: 50px;
		z-index: 1000;
		transform: translateX(400px);
		transition: transform 0.3s;
		box-shadow: 0 5px 15px rgba(0,0,0,0.2);
	}
	.toast-notif.show {
		transform: translateX(0);
	}
</style>

<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li><a href="produk.php">Produk</a></li>
			<li class="active">Detail Produk</li>
		</ul>
	</div>
</div>

<?php
$id_produk = mysqli_real_escape_string($koneksi, $_GET['id']);
$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_id='$id_produk'");
if(mysqli_num_rows($data) > 0){
	while($d = mysqli_fetch_array($data)){
		$fallback = "https://nibble-images.b-cdn.net/nibble/original_images/supermarket_di_jakarta_4_b03594e68d_np7EAjtsd.jpg";
		$stok = $d['produk_jumlah'];
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
				<h2 style="font-weight:700; color:#333;"><?php echo $d['produk_nama']; ?></h2>
				<h3 style="color:#78B817; font-weight:700;"><?php echo "Rp. ".number_format($d['produk_harga']); ?></h3>
				
				<div class="stock-info">
					<i class="fa fa-box"></i> Stok: <span class="<?php echo $stok_class; ?>"><?php echo $stok_status; ?></span> (<?php echo number_format($stok); ?> pcs)
					<span style="margin-left: 20px;"><i class="fa fa-weight"></i> Berat: <?php echo number_format($d['produk_berat']); ?> gram</span>
				</div>
				
				<div class="product-keterangan" style="margin:20px 0; line-height:1.8;">
					<?php echo nl2br(htmlspecialchars_decode($d['produk_keterangan'])); ?>
				</div>
				
				<!-- Quantity Selector -->
				<div class="quantity-wrapper">
					<button class="qty-btn" id="qtyMinus" <?php echo ($stok <= 0) ? 'disabled' : ''; ?>>
						<i class="fa fa-minus"></i>
					</button>
					<input type="number" id="qtyValue" class="qty-input" value="1" min="1" max="<?php echo $max_qty; ?>" <?php echo ($stok <= 0) ? 'disabled' : ''; ?>>
					<button class="qty-btn" id="qtyPlus" <?php echo ($stok <= 0) ? 'disabled' : ''; ?>>
						<i class="fa fa-plus"></i>
					</button>
					<?php if($stok > 0): ?>
					<small style="color:#7f8c8d; margin-left:10px;">Maksimal <?php echo number_format($stok); ?> pcs</small>
					<?php endif; ?>
				</div>
				
				<div class="action-buttons">
					<button class="primary-btn" id="addToCartBtn" <?php echo ($stok <= 0) ? 'disabled style="opacity:0.5;"' : ''; ?>>
						<i class="fa fa-shopping-cart"></i> MASUKKAN KERANJANG
					</button>
					<button class="btn-buy-now" id="buyNowBtn" <?php echo ($stok <= 0) ? 'disabled style="opacity:0.5;"' : ''; ?>>
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
	echo '<div class="section"><div class="container"><div class="row"><div class="col-md-12"><h3>Produk tidak ditemukan</h3><a href="index.php" class="primary-btn">Kembali ke Beranda</a></div></div></div></div>';
}
?>

<!-- Toast Notification -->
<div id="toastNotif" class="toast-notif">
	<i class="fa fa-check-circle"></i> Produk ditambahkan ke keranjang!
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
	// Quantity Selector
	const qtyInput = $('#qtyValue');
	const qtyMinus = $('#qtyMinus');
	const qtyPlus = $('#qtyPlus');
	const maxStock = parseInt(qtyInput.attr('max')) || 999;
	
	function updateQuantity() {
		let val = parseInt(qtyInput.val());
		if (isNaN(val)) val = 1;
		if (val < 1) val = 1;
		if (val > maxStock) val = maxStock;
		qtyInput.val(val);
	}
	
	qtyMinus.click(function() {
		let val = parseInt(qtyInput.val());
		if (val > 1) qtyInput.val(val - 1);
		updateQuantity();
	});
	
	qtyPlus.click(function() {
		let val = parseInt(qtyInput.val());
		if (val < maxStock) qtyInput.val(val + 1);
		updateQuantity();
	});
	
	qtyInput.on('input', function() {
		updateQuantity();
	});
	
	// Show Toast
	function showToast(message) {
		$('#toastNotif').html('<i class="fa fa-check-circle"></i> ' + message);
		$('#toastNotif').addClass('show');
		setTimeout(function() {
			$('#toastNotif').removeClass('show');
		}, 2000);
	}
	
	// Add to Cart dengan AJAX
	$('#addToCartBtn').click(function(e) {
		e.preventDefault();
		const quantity = parseInt(qtyInput.val());
		const productId = <?php echo $id_produk; ?>;
		
		$.ajax({
			url: 'keranjang_masukkan.php',
			type: 'POST',
			data: {
				id: productId,
				jumlah: quantity
			},
			success: function(response) {
				showToast('Produk berhasil ditambahkan ke keranjang!');
				// Update keranjang count di header jika ada
				$('.cart-count').text(function(i, old) {
					return (parseInt(old) || 0) + quantity;
				});
			},
			error: function() {
				showToast('Gagal menambahkan produk. Silahkan coba lagi.');
			}
		});
	});
	
	// Buy Now
	$('#buyNowBtn').click(function(e) {
		e.preventDefault();
		const quantity = parseInt(qtyInput.val());
		const productId = <?php echo $id_produk; ?>;
		
		$.ajax({
			url: 'keranjang_masukkan.php',
			type: 'POST',
			data: {
				id: productId,
				jumlah: quantity,
				redirect: 'checkout'
			},
			success: function(response) {
				window.location.href = 'checkout.php';
			},
			error: function() {
				showToast('Gagal memproses. Silahkan coba lagi.');
			}
		});
	});
});

// Slider initialization
window.addEventListener('load', function() {
	if (typeof $ !== 'undefined' && $.fn.slick) {
		$('#product-main-view').slick({
			slidesToShow: 1, arrows: true, fade: false, asNavFor: '#product-view'
		});
		$('#product-view').slick({
			slidesToShow: 3, asNavFor: '#product-main-view', centerMode: true, focusOnSelect: true, arrows: false
		});
	}
});
</script>

<?php include 'footer.php'; ?>