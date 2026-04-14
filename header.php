<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Fresh Cart - Toko Bahan Pangan Segar</title>

	<link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

	<link type="text/css" rel="stylesheet" href="frontend/css/bootstrap.min.css" />

	<link type="text/css" rel="stylesheet" href="frontend/css/slick.css" />
	<link type="text/css" rel="stylesheet" href="frontend/css/slick-theme.css" />

	<link type="text/css" rel="stylesheet" href="frontend/css/nouislider.min.css" />

	<link rel="stylesheet" href="frontend/css/font-awesome.min.css">

	<link type="text/css" rel="stylesheet" href="frontend/css/style.css" />

	<style>
		/* FRESH CART GREEN THEME & LAYOUT OVERRIDES (Mencocokkan Gambar Template) */
		:root {
			--primary-green: #78B817; /* Hijau segar sesuai gambar */
			--dark-text: #333;
			--light-bg: #f9f9f9;
		}

		body {
			font-family: 'Hind', sans-serif;
			color: #555;
			background-color: #fff;
		}

		/* Header & Navigasi */
		#header {
			padding: 20px 0;
			border-bottom: 1px solid #eee;
		}

		.header-logo {
			display: inline-block;
			vertical-align: middle;
			margin-right: 30px;
		}

		.header-logo .logo img {
			max-height: 45px;
			width: auto;
		}

		.header-search {
			display: inline-block;
			vertical-align: middle;
			width: 400px;
		}

		.header-search form .input {
			border-radius: 40px 0 0 40px;
			border: 1px solid #ddd;
			padding-left: 20px;
		}

		.header-search form .search-btn {
			background-color: var(--primary-green);
			border-radius: 0 40px 40px 0;
			color: #fff;
			width: 60px;
		}

		#navigation {
			background-color: #fff;
			border-bottom: 1px solid #eee;
		}

		.category-nav .category-header {
			background-color: var(--primary-green);
			font-weight: 700;
		}

		.menu-nav .menu-list > li > a {
			color: var(--dark-text);
			font-weight: 600;
			text-transform: uppercase;
			font-size: 13px;
		}

		.menu-nav .menu-list > li > a:hover, .menu-nav .menu-list > li.active > a {
			color: var(--primary-green);
		}

		/* Tombol & Elemen UI Warna Hijau */
		.primary-btn {
			background-color: var(--primary-green);
			border-radius: 40px;
			text-transform: uppercase;
			font-weight: 700;
			border: none;
		}

		.primary-btn:hover {
			background-color: #669e12;
		}

		.main-btn:hover {
			color: var(--primary-green);
			border-color: var(--primary-green);
		}

		.header-btns .header-btns-icon {
			color: var(--dark-text);
		}

		.qty {
			background-color: var(--primary-green);
		}

		/* Produk */
		.product.product-single {
			border: 1px solid #eee;
			border-radius: 8px;
			transition: all 0.3s;
		}

		.product.product-single:hover {
			box-shadow: 0 5px 15px rgba(0,0,0,0.05);
			border-color: var(--primary-green);
		}

		.product-price {
			color: var(--primary-green);
			font-weight: 700;
		}

		.product-name a {
			color: var(--dark-text);
			font-weight: 600;
		}

		.product-name a:hover {
			color: var(--primary-green);
		}

		@media only screen and (max-width: 991px) {
			.header-search {
				width: 100%;
				margin: 15px 0;
			}
		}
	</style>
</head>

<?php
include 'koneksi.php';

session_start();

$file = basename($_SERVER['PHP_SELF']);

if(!isset($_SESSION['customer_status'])){
	$lindungi = array('customer.php','customer_logout.php');
	if(in_array($file, $lindungi)){
		header("location:index.php");
	}
	if($file == "checkout.php"){
		header("location:masuk.php?alert=login-dulu");
	}
}else{
	$lindungi = array('masuk.php','daftar.php');
	if(in_array($file, $lindungi)){
		header("location:customer.php");
	}
}

if($file == "checkout.php"){
	if(!isset($_SESSION['keranjang']) || count($_SESSION['keranjang']) == 0){
		header("location:keranjang.php?alert=keranjang_kosong");
	}
}
?>

<body>
	<header>
		<div id="header">
			<div class="container">
				<div class="pull-left">
					<div class="header-logo">
						<a class="logo" href="index.php">
							<img src="frontend/img/freshcart-logo.svg" alt="Fresh Cart">
						</a>
					</div>
					<div class="header-search">
						<form action="index.php" method="get">
							<input class="input" type="text" name="cari" placeholder="Cari bahan pangan segar..">
							<button class="search-btn"><i class="fa fa-search"></i></button>
						</form>
					</div>
					</div>
				<div class="pull-right">
					<ul class="header-btns">

						<li class="header-cart dropdown default-dropdown">
							<?php
							$jumlah_isi_keranjang = isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0;
							?>
							<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
								<div class="header-btns-icon">
									<i class="fa fa-shopping-basket"></i>
									<span class="qty"><?php echo $jumlah_isi_keranjang; ?></span>
								</div>
								<strong class="text-uppercase" style="font-size: 12px;">Keranjang:</strong><br>
								<?php
								$total = 0;
								if(isset($_SESSION['keranjang'])){
									$jumlah_isi_keranjang = count($_SESSION['keranjang']);
									for($a = 0; $a < $jumlah_isi_keranjang; $a++){
										$id_produk = $_SESSION['keranjang'][$a]['produk'];
										$isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
										$i = mysqli_fetch_assoc($isi);
										$total += $i['produk_harga'];
									}
								}
								?>
								<span style="font-weight: bold; color: var(--primary-green);"><?php echo "Rp. ".number_format($total); ?></span>
							</a>
							<div class="custom-menu">
								<div id="shopping-cart">
									<div class="shopping-cart-list">
										<?php
										if(isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0){
											$jumlah_isi_keranjang = count($_SESSION['keranjang']);
											for($a = 0; $a < $jumlah_isi_keranjang; $a++){
												$id_produk = $_SESSION['keranjang'][$a]['produk'];
												$isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
												$i = mysqli_fetch_assoc($isi);
												?>
												<div class="product product-widget">
													<div class="product-thumb">
														<img src="<?php echo ($i['produk_foto1'] == "") ? "https://nibble-images.b-cdn.net/nibble/original_images/supermarket_di_jakarta_4_b03594e68d_np7EAjtsd.jpg" : "gambar/produk/".$i['produk_foto1']; ?>" alt="<?php echo $i['produk_nama']; ?>" style="object-fit: cover;">
													</div>
													<div class="product-body">
														<h3 class="product-price"><?php echo "Rp. ".number_format($i['produk_harga']); ?></h3>
														<h2 class="product-name"><a href="produk_detail.php?id=<?php echo $i['produk_id'] ?>"><?php echo $i['produk_nama'] ?></a></h2>
													</div>
													<a class="cancel-btn" href="keranjang_hapus.php?id=<?php echo $i['produk_id']; ?>&redirect=keranjang"><i class="fa fa-trash"></i></a>
												</div>
												<?php
											}
										}else{
											echo "<center>Keranjang Kosong.</center>";
										}
										?>
									</div>
									<div class="shopping-cart-btns">
										<a class="main-btn" href="keranjang.php">Detail</a>
										<a class="primary-btn" href="checkout.php">Checkout</a>
									</div>
								</div>
							</div>
						</li>

						<?php
						if(isset($_SESSION['customer_status'])){
							$id_customer = $_SESSION['customer_id'];
							$customer = mysqli_query($koneksi,"select * from customer where customer_id='$id_customer'");
							$c = mysqli_fetch_assoc($customer);
						?>
							<li class="header-account dropdown default-dropdown" style="min-width: 150px">
								<div class="dropdown-toggle" role="button" data-toggle="dropdown">
									<div class="header-btns-icon"><i class="fa fa-user-circle-o"></i></div>
									<strong class="text-uppercase"><?php echo explode(' ', $c['customer_nama'])[0]; ?> <i class="fa fa-caret-down"></i></strong>
								</div>
								<ul class="custom-menu">
									<li><a href="customer.php">Akun Saya</a></li>
									<li><a href="customer_pesanan.php">Pesanan</a></li>
									<li><a href="customer_logout.php">Keluar</a></li>
								</ul>
							</li>
						<?php }else{ ?>
							<li class="header-account">
								<a href="masuk.php" class="text-uppercase main-btn" style="border:none;">Masuk</a>
								<a href="daftar.php" class="text-uppercase primary-btn">Daftar</a>
							</li>
						<?php } ?>

						<li class="nav-toggle">
							<button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</header>

	<div id="navigation">
		<div class="container">
			<div id="responsive-nav">
				<div class="category-nav show-on-click">
					<span class="category-header">Kategori <i class="fa fa-list"></i></span>
					<ul class="category-list">
						<?php
						$data = mysqli_query($koneksi,"SELECT * FROM kategori");
						while($d = mysqli_fetch_array($data)){
							echo "<li><a href='produk_kategori.php?id=".$d['kategori_id']."'>".$d['kategori_nama']."</a></li>";
						}
						?>
					</ul>
				</div>
				<div class="menu-nav">
					<span class="menu-header">Menu <i class="fa fa-bars"></i></span>
					<ul class="menu-list">
						<li class="active"><a href="index.php">Home</a></li>
						<li><a href="index.php">Belanja</a></li>
						<li><a href="tentangkami.php">Tentang Kami</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
