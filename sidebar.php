<div id="aside" class="col-md-3">
	<div class="aside">
		<h3 class="aside-title">Kategori</h3>
		<div class="category-nav" style="box-shadow: none; border: 1px solid #eee; border-radius: 8px; overflow: hidden;">
			<ul class="category-list" style="position: static; border: none;">
				<?php
				$data = mysqli_query($koneksi,"SELECT * FROM kategori");
				while($d = mysqli_fetch_array($data)){
					?>
					<li><a href="produk_kategori.php?id=<?php echo $d['kategori_id']; ?>"><?php echo $d['kategori_nama']; ?></a></li>
					<?php
				}
				?>
			</ul>
		</div>
	</div>
	</div>
