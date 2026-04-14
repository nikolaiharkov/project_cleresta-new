<?php include 'header.php'; ?>

<div class="section">
	<div class="container">
		<div class="row">

			<?php include 'sidebar.php'; ?>

			<div id="main" class="col-md-9">

				<div id="store">
					<div class="row">
						<?php
						// PERUBAHAN -> Pagination dihapus, menampilkan semua produk sesuai kriteria pencarian
						if(isset($_GET['cari'])){
							$cari = $_GET['cari'];
							$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori and produk_nama like '%$cari%' order by produk_id desc");
							echo "<div class='col-md-12'><h4>Hasil Pencarian: <b>".htmlspecialchars($cari)."</b></h4><br></div>";
						}else{
							$data = mysqli_query($koneksi,"select * from produk,kategori where kategori_id=produk_kategori order by produk_id desc");
						}

						if(mysqli_num_rows($data) == 0){
							echo "<div class='col-md-12'><center><h4>Produk tidak ditemukan.</h4></center></div>";
						}

						while($d = mysqli_fetch_array($data)){
							?>
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<a href="produk_detail.php?id=<?php echo $d['produk_id'] ?>" class="main-btn quick-view"><i class="fa fa-search-plus"></i> Lihat</a>
										<img src="<?php echo ($d['produk_foto1'] == "") ? "https://nibble-images.b-cdn.net/nibble/original_images/supermarket_di_jakarta_4_b03594e68d_np7EAjtsd.jpg" : "gambar/produk/".$d['produk_foto1']; ?>" alt="<?php echo $d['produk_nama']; ?>" style="height: 200px; object-fit: contain; padding: 15px;">
									</div>
									<div class="product-body" style="text-align: center;">
										<h3 class="product-price"><?php echo "Rp. ".number_format($d['produk_harga']); ?></h3>
										<h2 class="product-name" style="height: 40px; overflow: hidden;"><a href="produk_detail.php?id=<?php echo $d['produk_id'] ?>"><?php echo $d['produk_nama'] ?></a></h2>
										<div class="product-btns">
											<a class="primary-btn add-to-cart" href="keranjang_masukkan.php?id=<?php echo $d['produk_id']; ?>&redirect=index" style="width: 100%;"><i class="fa fa-shopping-cart"></i> Tambah</a>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</div>
				</div>

				</div>
			</div>
	</div>
</div>

<?php include 'footer.php'; ?>
