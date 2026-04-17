<style>
	.desktop-sidebar .aside-title { font-size: 16px; font-weight: 700; color: #333; margin-bottom: 15px; text-transform: uppercase; border-left: 4px solid var(--primary-green); padding-left: 10px; }
	.desktop-sidebar .nav-card { background: #fff; border: 1px solid #eee; border-radius: 8px; overflow: hidden; margin-bottom: 25px; }
	.desktop-sidebar .nav-list { list-style: none; padding: 0; margin: 0; }
	.desktop-sidebar .nav-list li a { display: block; padding: 12px 15px; color: #555; text-decoration: none !important; transition: 0.2s; border-bottom: 1px solid #f9f9f9; font-weight: 500; }
	.desktop-sidebar .nav-list li a:hover { background: #f4f9eb; color: var(--primary-green); padding-left: 20px; }
	.desktop-sidebar .nav-list li a i { width: 25px; color: var(--primary-green); }
</style>
<div id="aside" class="col-md-3 hidden-sm hidden-xs desktop-sidebar">
	<div class="aside">
		<h3 class="aside-title">Menu Utama</h3>
		<div class="nav-card">
			<ul class="nav-list">
				<li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
				<li><a href="index.php?view=shop"><i class="fa fa-shopping-bag"></i> Produk Belanja</a></li>
				<li><a href="tentangkami.php"><i class="fa fa-info-circle"></i> Tentang Kami</a></li>
			</ul>
		</div>
	</div>
	<div class="aside">
		<h3 class="aside-title">Kategori</h3>
		<div class="nav-card">
			<ul class="nav-list">
				<?php
				$data = mysqli_query($koneksi,"SELECT * FROM kategori");
				while($d = mysqli_fetch_array($data)){
					echo "<li><a href='produk_kategori.php?id=".$d['kategori_id']."'><i class='fa fa-angle-right'></i> ".$d['kategori_nama']."</a></li>";
				}
				?>
			</ul>
		</div>
	</div>
</div>
