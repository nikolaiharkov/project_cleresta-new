<?php include 'header.php'; ?>

<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li class="active">Pesanan Customer</li>
		</ul>
	</div>
</div>
<div class="section">
	<div class="container">
		<div class="row">
			
			<?php 
			include 'customer_sidebar.php'; 
			?>

			<div id="main" class="col-md-9">
				
				<h4>PESANAN</h4>

				<div id="store">
					<div class="row">

						<div class="col-lg-12">

							<?php 
							if(isset($_GET['alert'])){
								if($_GET['alert'] == "gagal"){
									echo "<div class='alert alert-danger'>Gambar gagal diupload!</div>";
								}elseif($_GET['alert'] == "sukses"){
									echo "<div class='alert alert-success'>Pesanan berhasil dibuat, silahkan melakukan pembayaran!</div>";
								}elseif($_GET['alert'] == "upload"){
									echo "<div class='alert alert-success'>Konfirmasi pembayaran berhasil tersimpan, silahkan menunggu konfirmasi dari admin!</div>";
								}
							}
							?>

							<small class="text-muted">
								Semua data pesanan / invoice anda.
							</small>

							<br/>
							<br/>


							<div class="table-responsive">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th width="1%">NO</th>
											<th class="text-center">NOMOR INVOICE</th>
											<th class="text-center">TANGGAL</th>
											<th class="text-center">TOTAL BAYAR</th>
											<th class="text-center">STATUS</th>
											<th class="text-center">OPSI</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$id = $_SESSION['customer_id'];
										$invoice = mysqli_query($koneksi,"select * from invoice where invoice_customer='$id' order by invoice_id desc");
										
										// Inisialisasi variabel nomor urut
										$no = 1; 
										
										while($i = mysqli_fetch_array($invoice)){
											// Perbaikan Error Undefined Index: Cek nama kolom yang mungkin berbeda
											if(isset($i['invoice_tgl'])){
												$tgl_pesanan = $i['invoice_tgl'];
											} elseif(isset($i['invoice_tanggal'])) {
												$tgl_pesanan = $i['invoice_tanggal'];
											} else {
												$tgl_pesanan = date('Y-m-d'); // Fallback jika kolom tidak ditemukan
											}
											?>
											<tr>
												<td class="text-center"><?php echo $no++; ?></td>
												<td class="text-center">INV-00<?php echo $i['invoice_id']; ?></td>
												<td class="text-center"><?php echo date('d-m-Y', strtotime($tgl_pesanan)); ?></td>
												<td class="text-center"><?php echo "Rp. ".number_format($i['invoice_total_bayar'])." ,-"; ?></td>
												<td class="text-center">
													<?php 
													if($i['invoice_status'] == 0){
														echo "<span class='label label-warning'>Menunggu Pembayaran</span>";
													}elseif($i['invoice_status'] == 1){
														echo "<span class='label label-default'>Menunggu Konfirmasi</span>";
													}elseif($i['invoice_status'] == 2){
														echo "<span class='label label-danger'>Ditolak</span>";
													}elseif($i['invoice_status'] == 3){
														echo "<span class='label label-primary'>Dikonfirmasi & Sedang Diproses</span>";
													}elseif($i['invoice_status'] == 4){
														echo "<span class='label label-warning'>Dikirim</span>";
													}elseif($i['invoice_status'] == 5){
														echo "<span class='label label-success'>Selesai</span>";
													}
													?>
												</td>
												<td class="text-center">
													<?php 
													if($i['invoice_status'] == 0 || $i['invoice_status'] == 1){
														?>
														<a class='btn btn-sm btn-primary' href="customer_pembayaran.php?id=<?php echo $i['invoice_id']; ?>"><i class="fa fa-money"></i> Pembayaran</a>
														<?php
													}
													?>
													<a class='btn btn-sm btn-success' href="customer_invoice.php?id=<?php echo $i['invoice_id']; ?>"><i class="fa fa-print"></i> Invoice</a>
												</td>
											</tr>
											<?php 
										}
										?>
									</tbody>
								</table>
							</div>
							


						</div>	

					</div>
				</div>

			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>