<?php include 'header.php'; ?>
<style>
	#home-banner-slider { margin-bottom: 30px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative; }
	.banner-item { position: relative; outline: none; }
	.banner-item img { width: 100%; height: 380px; object-fit: cover; }
	.banner-caption { position: absolute; top: 50%; left: 50px; transform: translateY(-50%); color: #fff; z-index: 2; max-width: 550px; }
	.banner-caption h2 { font-size: 38px; font-weight: 700; margin-bottom: 12px; text-shadow: 2px 2px 5px rgba(0,0,0,0.6); color: #fff; }
	.banner-caption p { font-size: 18px; background: rgba(120, 184, 23, 0.9); display: inline-block; padding: 6px 18px; border-radius: 4px; }
	.title-section { border-bottom: 2px solid var(--primary-green); display: inline-block; padding-bottom: 5px; margin-bottom: 25px; color: #333; font-weight: 700; }
	.product.product-single { border: 1px solid #eee; border-radius: 8px; overflow: hidden; background: #fff; margin-bottom: 25px; transition: 0.3s; }
	.product.product-single:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); border-color: var(--primary-green); }
	@media (max-width: 768px) { .banner-item img { height: 220px; } .banner-caption { left: 20px; } .banner-caption h2 { font-size: 22px; } .banner-caption p { font-size: 12px; } }
</style>
<div class="section">
	<div class="container">
		<div class="row">
			<?php include 'sidebar.php'; ?>
			<div id="main" class="col-md-9 col-sm-12 col-xs-12">
				<div id="home-banner-slider">
					<div class="banner-item">
						<div class="banner-caption"><h2>Bahan Pangan 100% Organik</h2><p>Kesegaran terbaik langsung dari petani lokal untuk Anda.</p></div>
						<img src="gambar/banner/ad-banner-1.jpg" alt="Banner 1">
					</div>
					<div class="banner-item">
						<div class="banner-caption"><h2>Hidup Sehat Mulai Dari Dapur</h2><p>Nutrisi lengkap untuk menjaga daya tahan keluarga tercinta.</p></div>
						<img src="gambar/banner/ad-banner-2.jpg" alt="Banner 2">
					</div>
					<div class="banner-item">
						<div class="banner-caption"><h2>Promo Spesial Member Baru</h2><p>Dapatkan diskon hingga 50% untuk pesanan pertama hari ini!</p></div>
						<img src="gambar/banner/ad-banner-3.jpg" alt="Banner 3">
					</div>
				</div>
				<div id="store">
					<div class="row">
						<div class="col-md-12"><h3 class="title-section">Semua Produk Pilihan</h3></div>
						<?php
						$fallback = "https://nibble-images.b-cdn.net/nibble/original_images/supermarket_di_jakarta_4_b03594e68d_np7EAjtsd.jpg";
						if(isset($_GET['cari'])){
							$cari = $_GET['cari'];
							$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_nama like '%$cari%' order by produk_id desc");
						} else if(isset($_GET['view']) && $_GET['view'] == 'shop') {
							$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori order by produk_nama ASC");
						} else {
							$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori order by produk_id desc");
						}
						while($d = mysqli_fetch_array($data)){
							?>
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<a href="produk_detail.php?id=<?php echo $d['produk_id'] ?>" class="main-btn quick-view"><i class="fa fa-search-plus"></i> Detail</a>
										<img src="<?php echo ($d['produk_foto1'] == "") ? $fallback : "gambar/produk/".$d['produk_foto1']; ?>" style="height: 200px; object-fit: contain; padding: 15px;">
									</div>
									<div class="product-body" style="text-align: center; padding: 15px;">
										<h3 class="product-price" style="color: var(--primary-green); font-weight:700; font-size:18px"><?php echo "Rp. ".number_format($d['produk_harga']); ?></h3>
										<h2 class="product-name" style="height: 35px; overflow: hidden; font-size: 14px;"><a href="produk_detail.php?id=<?php echo $d['produk_id'] ?>"><?php echo $d['produk_nama'] ?></a></h2>
										<div class="product-btns">
											<a class="primary-btn add-to-cart" href="keranjang_masukkan.php?id=<?php echo $d['produk_id']; ?>&redirect=index" style="width: 100%; background: var(--primary-green); border:none; border-radius:4px; font-size:12px; padding:10px 0; color:#fff; text-align:center; display:block; text-decoration:none; font-weight:700;">BELI SEKARANG</a>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php'; ?>
<script>
	window.addEventListener('load', function() {
		if (typeof $ !== 'undefined' && $.fn.slick) {
			$('#home-banner-slider').slick({ autoplay: true, autoplaySpeed: 4000, dots: true, arrows: false, fade: true, cssEase: 'linear', infinite: true });
		}
	});
</script>
