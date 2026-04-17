<?php 
session_start();
include 'header.php'; 
include 'koneksi.php';
?>

<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li class="active">Keranjang</li>
		</ul>
	</div>
</div>

<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="order-summary clearfix">
					<div class="section-title">
						<h3 class="title">Isi Keranjang Belanja</h3>
					</div>

					<?php 
					// DEBUG: Lihat isi session (hapus nanti)
					// echo "<pre>"; print_r($_SESSION['keranjang']); echo "</pre>";
					?>

					<?php 
					if(isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0){
						$total_keseluruhan = 0;
					?>
						<table class="shopping-cart-table table table-bordered">
							<thead>
								<tr>
									<th>Produk</th>
									<th>Nama Produk</th>
									<th class="text-center">Harga</th>
									<th class="text-center">Jumlah</th>
									<th class="text-center">Subtotal</th>
									<th class="text-center">Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								foreach($_SESSION['keranjang'] as $key => $item){
									$id_produk = $item['produk'];
									$jml = $item['jumlah'];
									
									$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id='$id_produk'");
									if(mysqli_num_rows($query) > 0){
										$i = mysqli_fetch_assoc($query);
										$subtotal = $i['produk_harga'] * $jml;
										$total_keseluruhan += $subtotal;
										
										$foto = ($i['produk_foto1'] != "") ? "gambar/produk/".$i['produk_foto1'] : "gambar/sistem/produk.png";
								?>
										<tr id="row_<?php echo $key; ?>">
											<td width="80">
												<img src="<?php echo $foto; ?>" style="width: 60px; height: 60px; object-fit: cover;">
											</td>
											<td>
												<a href="produk_detail.php?id=<?php echo $i['produk_id']; ?>">
													<?php echo $i['produk_nama']; ?>
												</a>
											</td>
											<td class="text-center">
												Rp <?php echo number_format($i['produk_harga'], 0, ',', '.'); ?>
											</td>
											<td class="text-center">
												<form action="keranjang_update.php" method="post" style="display: inline-block;">
													<input type="hidden" name="key" value="<?php echo $key; ?>">
													<input type="hidden" name="id" value="<?php echo $i['produk_id']; ?>">
													<input type="number" name="jumlah" value="<?php echo $jml; ?>" min="1" max="<?php echo $i['produk_jumlah']; ?>" style="width: 70px; text-align: center;">
													<button type="submit" class="btn btn-sm btn-primary">Update</button>
												</form>
											</td>
											<td class="text-center">
												Rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
											</td>
											<td class="text-center">
												<a href="keranjang_hapus.php?id=<?php echo $i['produk_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus produk ini?')">
													<i class="fa fa-trash"></i> Hapus
												</a>
											</td>
										</tr>
								<?php 
									}
								}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4" class="text-right"><strong>GRAND TOTAL</strong></td>
									<td class="text-center"><strong>Rp <?php echo number_format($total_keseluruhan, 0, ',', '.'); ?></strong></td>
									<td></td>
								</tr>
							</tfoot>
						</table>

						<div class="pull-right">
							<a href="index.php" class="btn btn-default">Lanjutkan Belanja</a>
							<a href="checkout.php" class="btn btn-primary">Checkout</a>
						</div>
					<?php 
					} else { 
					?>
						<div class="alert alert-info text-center">
							<h3>Keranjang Masih Kosong</h3>
							<p>Yuk <a href="index.php">belanja</a> dulu!</p>
						</div>
					<?php 
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>