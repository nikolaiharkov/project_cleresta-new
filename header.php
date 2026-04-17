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
	<link rel="stylesheet" href="frontend/css/font-awesome.min.css">
	<link type="text/css" rel="stylesheet" href="frontend/css/style.css" />
	<style>
		:root { --primary-green: #78B817; --dark-text: #333; }
		@media (min-width: 1200px) { .container { width: 95% !important; max-width: 1500px !important; } }
		body { font-family: 'Hind', sans-serif; background-color: #fcfcfc; color: #444; }
		#header { padding: 12px 0; background: #fff; border-bottom: 1px solid #eee; position: sticky; top: 0; z-index: 1000; }
		.header-flex { display: flex; align-items: center; justify-content: space-between; }
		.hamburger-menu { display: none; font-size: 24px; cursor: pointer; color: var(--dark-text); margin-right: 15px; }
		.header-logo img { max-height: 40px; width: auto; }
		.header-search { flex: 1; margin: 0 40px; max-width: 600px; }
		.header-search form { display: flex; }
		.header-search .input { border-radius: 40px 0 0 40px !important; border: 1px solid #ddd; height: 40px; padding-left: 20px; }
		.header-search .search-btn { background: var(--primary-green); border: none; border-radius: 0 40px 40px 0 !important; color: #fff; width: 60px; }
		.header-btns { display: flex; align-items: center; list-style: none; padding: 0; margin: 0; }
		.header-btns > li { margin-left: 20px; }
		.icon-btn { font-size: 24px; color: var(--dark-text); position: relative; text-decoration: none !important; transition: 0.3s; }
		.icon-btn:hover { color: var(--primary-green); }
		.badge-qty { position: absolute; top: -5px; right: -8px; background: var(--primary-green); color: #fff; font-size: 10px; width: 18px; height: 18px; border-radius: 50%; text-align: center; line-height: 18px; font-weight: 700; }
		#mobile-sidebar { position: fixed; top: 0; left: -300px; width: 280px; height: 100%; background: #fff; z-index: 2000; transition: 0.3s; box-shadow: 5px 0 15px rgba(0,0,0,0.1); overflow-y: auto; visibility: hidden; pointer-events: none; }
		#mobile-sidebar.active { left: 0; visibility: visible; pointer-events: auto; }
		.sidebar-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1500; display: none; }
		.sidebar-overlay.active { display: block; }
		@media (max-width: 991px) { .hamburger-menu { display: block; } .header-search { display: none; } }
		#navigation { display: none !important; }
	</style>
</head>
<?php include 'koneksi.php'; session_start(); ?>
<body>
	<div class="sidebar-overlay" id="overlay"></div>
	<div id="mobile-sidebar">
		<div style="padding: 20px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
			<img src="frontend/img/freshcart-logo.svg" style="height: 30px;">
			<i class="fa fa-times" id="close-sidebar" style="font-size: 20px; cursor: pointer;"></i>
		</div>
		<ul class="mobile-nav-list" style="list-style: none; padding: 15px;">
			<li><a href="index.php" style="display:block; padding:12px; color:#333;"><i class="fa fa-home" style="color:var(--primary-green); width:25px;"></i> Beranda</a></li>
			<li><a href="index.php?view=shop" style="display:block; padding:12px; color:#333;"><i class="fa fa-shopping-bag" style="color:var(--primary-green); width:25px;"></i> Produk Belanja</a></li>
			<li><a href="tentangkami.php" style="display:block; padding:12px; color:#333;"><i class="fa fa-info-circle" style="color:var(--primary-green); width:25px;"></i> Tentang Kami</a></li>
			<hr>
			<?php if(!isset($_SESSION['customer_status'])){ ?>
				<li><a href="masuk.php" style="display:block; padding:12px; color:#333;"><i class="fa fa-sign-in" style="color:var(--primary-green); width:25px;"></i> Masuk</a></li>
			<?php } else { ?>
				<li><a href="customer.php" style="display:block; padding:12px; color:#333;"><i class="fa fa-user" style="color:var(--primary-green); width:25px;"></i> Akun Saya</a></li>
				<li><a href="customer_logout.php" style="display:block; padding:12px; color:#333;"><i class="fa fa-sign-out" style="color:var(--primary-green); width:25px;"></i> Keluar</a></li>
			<?php } ?>
		</ul>
	</div>

	<header id="header">
		<div class="container">
			<div class="header-flex">
				<div style="display: flex; align-items: center;">
					<div class="hamburger-menu" id="open-sidebar"><i class="fa fa-bars"></i></div>
					<div class="header-logo"><a href="index.php"><img src="frontend/img/freshcart-logo.svg" alt="Fresh Cart"></a></div>
				</div>
				<div class="header-search">
					<form action="index.php" method="get">
						<input class="input form-control" type="text" name="cari" placeholder="Cari bahan pangan segar...">
						<button class="search-btn"><i class="fa fa-search"></i></button>
					</form>
				</div>
				<ul class="header-btns">
					<li class="dropdown default-dropdown">
						<?php $jlh = isset($_SESSION['keranjang']) ? count($_SESSION['keranjang']) : 0; ?>
						<a class="icon-btn" data-toggle="dropdown" style="cursor:pointer"><i class="fa fa-shopping-basket"></i><span class="badge-qty"><?php echo $jlh; ?></span></a>
						<div class="custom-menu" style="padding:15px; text-align:center; min-width:200px;">
							<?php echo ($jlh > 0) ? "Ada $jlh item di keranjang" : "Keranjang Kosong"; ?>
							<a class="primary-btn" href="checkout.php" style="background:var(--primary-green); color:#fff; display:block; padding:8px; margin-top:10px; border-radius:4px; text-align:center; text-decoration:none;">Checkout</a>
						</div>
					</li>
					<?php if(isset($_SESSION['customer_status'])){ ?>
						<li class="dropdown default-dropdown">
							<a class="icon-btn" data-toggle="dropdown" style="cursor:pointer"><i class="fa fa-user-circle-o"></i></a>
							<ul class="custom-menu">
								<li><a href="customer.php">Profil Saya</a></li>
								<li><a href="customer_pesanan.php">Pesanan</a></li>
								<li><a href="customer_logout.php">Keluar</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li><a href="masuk.php" class="icon-btn" title="Masuk"><i class="fa fa-sign-in"></i></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</header>
	<script>
		const openBtn = document.getElementById('open-sidebar');
		const closeBtn = document.getElementById('close-sidebar');
		const sidebar = document.getElementById('mobile-sidebar');
		const overlay = document.getElementById('overlay');
		if(openBtn) openBtn.onclick = () => { sidebar.classList.add('active'); overlay.classList.add('active'); };
		const closeMenu = () => { sidebar.classList.remove('active'); overlay.classList.remove('active'); };
		if(closeBtn) closeBtn.onclick = closeMenu;
		if(overlay) overlay.onclick = closeMenu;
	</script>
