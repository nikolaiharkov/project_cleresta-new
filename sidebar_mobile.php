<div class="aside">
	<h3 class="aside-title">Menu Utama</h3>
	<div class="category-nav">
		<ul class="category-list">
			<li><a href="index.php"><i class="fa fa-home"></i> Beranda</a></li>
			<li><a href="index.php?view=shop"><i class="fa fa-shopping-bag"></i> Produk Belanja</a></li>
			<li><a href="tentangkami.php"><i class="fa fa-info-circle"></i> Tentang Kami</a></li>
		</ul>
	</div>
</div>

<div class="aside">
	<h3 class="aside-title">Akun & Akses</h3>
	<div class="category-nav">
		<ul class="category-list">
			<?php if(!isset($_SESSION['customer_status'])){ ?>
				<li><a href="masuk.php"><i class="fa fa-lock"></i> Masuk Akun</a></li>
				<li><a href="daftar.php"><i class="fa fa-user-plus"></i> Daftar Baru</a></li>
			<?php } else { ?>
				<li><a href="customer.php"><i class="fa fa-user"></i> Profil Saya</a></li>
				<li><a href="customer_logout.php"><i class="fa fa-sign-out"></i> Keluar</a></li>
			<?php } ?>
		</ul>
	</div>
</div>

<div class="aside">
	<h3 class="aside-title">Semua Kategori</h3>
	<div class="category-nav">
		<ul class="category-list">
			<?php
			$data = mysqli_query($koneksi,"SELECT * FROM kategori");
			while($d = mysqli_fetch_array($data)){
				echo "<li><a href='produk_kategori.php?id=".$d['kategori_id']."'><i class='fa fa-leaf'></i> ".$d['kategori_nama']."</a></li>";
			}
			?>
		</ul>
	</div>
</div>
