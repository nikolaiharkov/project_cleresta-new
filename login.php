<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Fresh Cart - Login Admin</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .login-page {
      background-color: #f4f7f6;
    }
    .login-box-body {
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .btn-primary {
      background-color: #78B817;
      border-color: #669e12;
    }
    .btn-primary:hover {
      background-color: #669e12;
      border-color: #558510;
    }
    h3 {
      color: #78B817;
      font-weight: bold;
    }
  </style>
</head>
<body class="hold-transition login-page">
  <div class="container">
    <div class="login-box">

      <center>
        <h2>ADMIN</h2>
        <h3>Fresh Cart</h3>
        <br/>

        <?php
        if(isset($_GET['alert'])){
          if($_GET['alert'] == "gagal"){
            echo "<div class='alert alert-danger'>Login gagal! username dan password salah!</div>";
          }else if($_GET['alert'] == "logout"){
            echo "<div class='alert alert-success'>Anda telah berhasil logout</div>";
          }else if($_GET['alert'] == "belum_login"){
            echo "<div class='alert alert-warning'>Anda harus login untuk mengakses halaman admin</div>";
          }
        }
        ?>
      </center>

      <div class="login-box-body">
        <br>
        <p class="login-box-msg text-bold">SILAHKAN LOGIN</p>

        <form action="periksa_login.php" method="POST">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Username" name="username" required="required" autocomplete="off">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password" required="required" autocomplete="off">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">LOGIN SYSTEM</button>
            </div>
          </div>
        </form>

        <br>
        <center>
          <a href="index.php">Kembali ke Beranda</a>
        </center>
      </div>
    </div>
  </div>

  <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
