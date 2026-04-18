<?php include 'header.php'; ?>

<div id="breadcrumb">
	<div class="container">
		<ul class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li class="active">Keranjang Belanja</li>
		</ul>
	</div>
</div>

<div class="section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="order-summary clearfix">
					<div class="section-title">
						<h3 class="title">Detail Belanja Anda</h3>
					</div>

					<?php 
					if(isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0){
						$total_keseluruhan = 0;
					?>
						<div class="table-responsive">
							<table class="shopping-cart-table table">
								<thead>
									<tr>
										<th width="10%">Produk</th>
										<th>Nama</th>
										<th class="text-center">Harga</th>
										<th class="text-center" width="150px">Jumlah</th>
										<th class="text-center">Subtotal</th>
										<th class="text-center">Hapus</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach($_SESSION['keranjang'] as $key => $item){
										$id_produk = $item['produk'];
										$jml = $item['jumlah'];
										
										$res = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id='$id_produk'");
										$p = mysqli_fetch_assoc($res);
										$sub = $p['produk_harga'] * $jml;
										$total_keseluruhan += $sub;
									?>
										<tr class="cart-item" data-key="<?php echo $key; ?>" data-id="<?php echo $id_produk; ?>" data-price="<?php echo $p['produk_harga']; ?>">
											<td>
												<?php if($p['produk_foto1'] == ""){ ?>
													<img src="gambar/sistem/produk.png" style="width: 70px; border-radius:4px;">
												<?php }else{ ?>
													<img src="gambar/produk/<?php echo $p['produk_foto1']; ?>" style="width: 70px; border-radius:4px;">
												<?php } ?>
											</td>
											<td class="details">
												<a href="produk_detail.php?id=<?php echo $p['produk_id'] ?>" style="font-weight: bold; color: #333;"><?php echo $p['produk_nama'] ?></a>
											</td>
											<td class="price text-center">
												<strong>Rp. <?php echo number_format($p['produk_harga']); ?></strong>
											</td>
											<td class="qty text-center">
												<div class="input-group">
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-sm btn-qty" data-action="minus">-</button>
													</span>
													<input type="number" class="form-control input-sm text-center input-qty" value="<?php echo $jml; ?>" min="1" max="<?php echo $p['produk_jumlah']; ?>" readonly>
													<span class="input-group-btn">
														<button type="button" class="btn btn-default btn-sm btn-qty" data-action="plus">+</button>
													</span>
												</div>
												<small>Stok: <?php echo $p['produk_jumlah']; ?></small>
											</td>
											<td class="total text-center">
												<strong class="primary-color item-subtotal">Rp. <?php echo number_format($sub); ?></strong>
											</td>
											<td class="text-center">
												<a href="keranjang_hapus.php?id=<?php echo $id_produk; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">
													<i class="fa fa-trash"></i>
												</a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
								<tfoot>
									<tr>
										<th colspan="3"></th>
										<th class="text-right">GRAND TOTAL</th>
										<th class="text-center" style="font-size: 18px; color: #78B817;"><strong id="grand-total">Rp. <?php echo number_format($total_keseluruhan); ?></strong></th>
										<th></th>
									</tr>
								</tfoot>
							</table>
						</div>

						<div class="pull-left">
							<a href="index.php" class="main-btn"><i class="fa fa-shopping-bag"></i> Belanja Lagi</a>
						</div>
						<div class="pull-right">
							<a href="checkout.php" class="primary-btn">Lanjut Checkout <i class="fa fa-arrow-right"></i></a>
						</div>

					<?php } else { ?>
						<div class="alert alert-warning text-center" style="padding: 50px 0;">
							<i class="fa fa-shopping-cart fa-4x"></i>
							<h3>Keranjang Kosong</h3>
							<p>Yuk, pilih produk segar kami di halaman <a href="index.php">Utama</a>.</p>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'footer.php'; ?>

<script>
$(document).ready(function() {
    function formatRupiah(angka) {
        return "Rp. " + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function updateGrandTotal() {
        var grandTotal = 0;
        $('.item-subtotal').each(function() {
            var sub = $(this).text().replace(/[^0-9]/g, '');
            grandTotal += parseInt(sub);
        });
        $('#grand-total').text(formatRupiah(grandTotal));
    }

    $('.btn-qty').on('click', function() {
        var row = $(this).closest('.cart-item');
        var input = row.find('.input-qty');
        var action = $(this).data('action');
        var currentVal = parseInt(input.val());
        var maxVal = parseInt(input.attr('max'));
        var price = parseInt(row.data('price'));
        var key = row.data('key');
        var id = row.data('id');

        var newVal = currentVal;
        if (action === 'plus') {
            if (currentVal < maxVal) newVal = currentVal + 1;
        } else {
            if (currentVal > 1) newVal = currentVal - 1;
        }

        if (newVal !== currentVal) {
            input.val(newVal);
            var newSubtotal = newVal * price;
            row.find('.item-subtotal').text(formatRupiah(newSubtotal));
            updateGrandTotal();

            $.ajax({
                url: 'keranjang_update.php',
                type: 'POST',
                data: { key: key, id: id, jumlah: newVal, ajax: true },
                success: function(res) { console.log("Session updated"); }
            });
        }
    });
});
</script>