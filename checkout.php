<?php 
// 1. Mulakan sesi dan koneksi di baris paling atas (Wajib tanpa spasi/HTML sebelum ini)
include 'koneksi.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. Semak login menggunakan kunci 'customer_status' (Sesuai dengan header.php anda)
if(!isset($_SESSION['customer_status']) || $_SESSION['customer_status'] != "login"){
    header("location:masuk.php?alert=login-dulu");
    exit();
}

// 3. Jika lulus semakan, baru muat naik header.php
include 'header.php'; 
?>

<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li class="active">Check Out</li>
		</ul>
	</div>
</div>

<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="order-summary clearfix">
					<div class="section-title">
						<h3 class="title">Buat Pesanan</h3>
					</div>

					<div class="row">
						<form method="post" action="checkout_act.php">
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-12">
										<br>
										<h4 class="text-center">INFORMASI PENERIMA</h4>

										<?php 
										$id_customer = $_SESSION['customer_id'];
										$customer = mysqli_query($koneksi,"select * from customer where customer_id='$id_customer'");
										$c = mysqli_fetch_assoc($customer);
										?>

										<div class="form-group">
											<label>Nama Lengkap</label>
											<input type="text" class="input" name="nama" placeholder="Nama penerima .." required="required" value="<?php echo $c['customer_nama']; ?>">
										</div>

										<div class="form-group">
											<label>Nomor HP</label>
											<input type="number" class="input" name="hp" placeholder="Nomor HP aktif .." required="required" value="<?php echo $c['customer_hp']; ?>">
										</div>

										<div class="form-group">
											<label>Alamat Lengkap</label>
											<textarea name="alamat" class="form-control" style="resize: none;" rows="4" placeholder="Alamat lengkap pengiriman .." required="required"><?php echo $c['customer_alamat']; ?></textarea>
										</div>

										<div class="form-group">
											<label>Provinsi</label>
											<input type="text" class="input" name="provinsi" placeholder="Masukkan nama provinsi .." required="required">
										</div>

										<div class="form-group">
											<label>Kota / Kabupaten</label>
											<input type="text" class="input" name="kabupaten" placeholder="Masukkan nama kota/kabupaten .." required="required">
										</div>

										<input name="kurir" value="Flat Rate" type="hidden">
										<input name="service" value="Regular" type="hidden">
										<input name="ongkir" value="20000" type="hidden"> 

										<div class="alert alert-success">
											<p><i class="fa fa-info-circle"></i> Info: Pengiriman flat ke seluruh wilayah Indonesia adalah <b>Rp. 20.000 ,-</b></p>
										</div>
										<br>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="pull-left">
											<a class="main-btn" href="keranjang.php">Kembali Ke Keranjang</a>
										</div>
										<div class="pull-right">
											<input type="submit" class="primary-btn" value="Selesaikan Pesanan">
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-6">
								<?php 
								if(isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0){
									$jumlah_isi_keranjang = count($_SESSION['keranjang']);
									?>
									<table class="shopping-cart-table table">
										<thead>
											<tr>
												<th>Produk</th>
												<th class="text-center">Harga</th>
												<th class="text-center">Jumlah</th>
												<th class="text-center">Subtotal</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$jumlah_total = 0;
											$total_berat = 0;
											for($a = 0; $a < $jumlah_isi_keranjang; $a++){
												$id_produk = $_SESSION['keranjang'][$a]['produk'];
												$jml = $_SESSION['keranjang'][$a]['jumlah'];

												$isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
												$i = mysqli_fetch_assoc($isi);

												$sub = $i['produk_harga']*$jml;
												$jumlah_total += $sub;
												$total_berat += ($i['produk_berat'] * $jml);
												?>
												<tr>
													<td><?php echo $i['produk_nama'] ?></td>
													<td class="text-center"><?php echo number_format($i['produk_harga']); ?></td>
													<td class="text-center"><?php echo $jml; ?></td>
													<td class="text-center"><strong><?php echo number_format($sub); ?></strong></td>
												</tr>
											<?php } ?>
										</tbody>
										<tfoot>
											<tr>
												<th colspan="2"></th>
												<th>TOTAL BERAT</th>
												<th class="text-center"><?php echo $total_berat; ?> Gram</th>
											</tr>
											<tr>
												<th colspan="2"></th>
												<th>ONGKIR</th>
												<th class="text-center">Rp. 20.000</th>
											</tr>
											<tr>
												<th colspan="2"></th>
												<th>TOTAL BAYAR</th>
												<th class="text-center" style="color: #78B817; font-size: 18px;">Rp. <?php echo number_format($jumlah_total + 20000); ?></th>
											</tr>
										</tfoot>
									</table>
									<input name="berat" value="<?php echo $total_berat ?>" type="hidden">
									<input name="total_produk" value="<?php echo $jumlah_total ?>" type="hidden">
									<?php
								} else {
									echo "<div class='alert alert-info text-center'>Keranjang anda kosong. <a href='index.php'>Klik di sini untuk belanja</a></div>";
								}
								?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>