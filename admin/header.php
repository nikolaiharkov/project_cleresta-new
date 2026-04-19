<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard Admin - Fresh Cart</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="../assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="../assets/bower_components/morris.js/morris.css">
  <link rel="stylesheet" href="../assets/bower_components/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="../assets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    /* Header Navbar & Logo */
    .main-header .navbar { background: linear-gradient(135deg, #78B817, #669e12) !important; }
    .main-header .logo { background-color: #669e12 !important; }
    
    /* ========== PERBAIKAN SIDEBAR AGAR TEKS JELAS ========== */
    .skin-green .main-sidebar {
        background: #ffffff;
    }
    
    /* Teks menu sidebar jadi GELAP & TERBACA */
    .skin-green .sidebar-menu > li > a {
        color: #2c3e50 !important;
        font-weight: 500;
        border-radius: 10px;
        margin: 4px 12px;
    }
    
    /* Icon sidebar warna hijau */
    .skin-green .sidebar-menu > li > a > i {
        color: #78B817 !important;
    }
    
    /* Hover */
    .skin-green .sidebar-menu > li > a:hover {
        background: #eef5e6 !important;
        color: #1a5c0e !important;
    }
    
    /* Menu Aktif */
    .skin-green .sidebar-menu > li.active > a {
        background: #78B817 !important;
        color: white !important;
        box-shadow: 0 2px 8px rgba(120,184,23,0.3);
    }
    
    .skin-green .sidebar-menu > li.active > a > i {
        color: white !important;
    }
    
    /* Header Navigasi Utama */
    .sidebar-menu .header {
        color: #78B817 !important;
        font-weight: 700;
        font-size: 0.75rem;
    }
    
    /* User panel teks */
    .user-panel > .info > p {
        color: #2c3e50 !important;
        font-weight: 600;
    }
    
    .user-panel > .info > a {
        color: #78B817 !important;
    }
    
    /* Dropdown submenu */
    .sidebar-menu .treeview-menu > li > a {
        color: #4a5a6e !important;
    }
    
    .sidebar-menu .treeview-menu > li > a:hover {
        color: #78B817 !important;
        background: #f0f7e8;
    }

    /* ========== HILANGKAN WARNA ABU-ABU DI SIDEBAR ========== */
.skin-green .sidebar-menu > li > a {
  background: transparent !important;
  color: #2c3e50 !important;
}

.skin-green .sidebar-menu > li > a:hover {
  background: #eef5e6 !important;
  color: #1a5c0e !important;
}

/* Hilangkan background abu-abu default */
.skin-green .sidebar-menu > li {
  background: transparent !important;
}

/* Hilangkan efek abu-abu pada body sidebar */
.skin-green .main-sidebar,
.skin-green .left-side,
.skin-green .sidebar {
  background: #ffffff !important;
}
</style>

  <?php
  include '../koneksi.php';
  session_start();
  if($_SESSION['status'] != "login"){
    header("location:../login.php?alert=belum_login");
  }
  ?>

</head>
<body class="hold-transition skin-green sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <a href="index.php" class="logo">
        <span class="logo-mini"><b>F-C</b></span>
        <span class="logo-lg"><b>Fresh Cart</b></span>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">

            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <?php
                $id_admin = $_SESSION['id'];
                $profil = mysqli_query($koneksi,"select * from admin where admin_id='$id_admin'");
                $profil = mysqli_fetch_assoc($profil);
                if($profil['admin_foto'] == ""){
                  ?>
                  <img src="../gambar/sistem/user.png" class="user-image">
                <?php }else{ ?>
                  <img src="../gambar/user/<?php echo $profil['admin_foto'] ?>" class="user-image">
                <?php } ?>
                <span class="hidden-xs"><?php echo $_SESSION['nama']; ?> - Admin Fresh Cart</span>
              </a>
            </li>
            <li>
  <a href="logout.php" onclick="confirmLogout(event)">
    <i class="fa fa-sign-out"></i> <span>Log out</span>
  </a>
</li>
          </ul>
        </div>
      </nav>
    </header>

    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <?php
            $id = $_SESSION['id'];
            $profil = mysqli_query($koneksi,"select * from admin where admin_id='$id'");
            $profil = mysqli_fetch_assoc($profil);
            if($profil['admin_foto'] == ""){
              ?>
              <img src="../gambar/sistem/user.png" class="img-circle">
            <?php }else{ ?>
              <img src="../gambar/user/<?php echo $profil['admin_foto'] ?>" class="img-circle" style="max-height:45px; width:45px; height:45px; object-fit:cover;">
            <?php } ?>
          </div>
          <div class="pull-left info">
            <p><?php echo $_SESSION['nama']; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>

        <ul class="sidebar-menu" data-widget="tree">
  <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">
    <a href="index.php">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
    </a>
  </li>

  <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'kategori.php') ? 'active' : ''; ?>">
    <a href="kategori.php">
      <i class="fa fa-folder"></i> <span>Data Kategori</span>
    </a>
  </li>

  <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'produk.php') ? 'active' : ''; ?>">
    <a href="produk.php">
      <i class="fa fa-leaf"></i> <span>Data Produk</span>
    </a>
  </li>

  <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'customer.php') ? 'active' : ''; ?>">
    <a href="customer.php">
      <i class="fa fa-users"></i> <span>Data Pelanggan</span>
    </a>
  </li>

  <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'transaksi.php') ? 'active' : ''; ?>">
    <a href="transaksi.php">
      <i class="fa fa-shopping-basket"></i> <span>Transaksi / Pesanan</span>
    </a>
  </li>

  <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'laporan.php') ? 'active' : ''; ?>">
    <a href="laporan.php">
      <i class="fa fa-file-text-o"></i> <span>Laporan Penjualan</span>
    </a>
  </li>

  <!-- Spacer -->
  <li style="height: 20px;"></li>

  <!-- SETTINGS - langsung ke halaman settings.php (tanpa dropdown) -->
  <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'settings.php') ? 'active' : ''; ?>">
    <a href="settings.php">
      <i class="fa fa-cog"></i> <span>Settings</span>
    </a>
  </li>

  <!-- LOGOUT -->
<li>
  <a href="logout.php">
    <i class="fa fa-sign-out"></i> <span>LOGOUT</span>
  </a>
</li>
</ul>
      </section>
    </aside>
