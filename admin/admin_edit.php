<?php 
include 'header.php';
include '../koneksi.php';
?>

<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 10px 25px; border-radius: 40px; text-decoration: none; display: inline-block; cursor: pointer; font-weight: 600; }
.btn-green:hover { background: #5e9c12; color: white; }
.form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; width: 100%; transition: all 0.2s; }
.form-control-modern:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
.content-header h1 { font-size: 22px; font-weight: 600; color: #2c3e50; }
.form-group label { font-weight: 600; margin-bottom: 8px; color: #2c3e50; display: block; }
.current-img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 2px solid #78B817; margin-bottom: 10px; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">

  <section class="content-header">
    <h1><i class="fa fa-user-edit" style="color: #78B817;"></i> Edit Admin</h1>
    <small>Perbarui informasi akun administrator</small>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-6 col-lg-offset-3">       
        <div class="box-modern">

          <div class="box-header" style="padding: 20px; border-bottom: 1px solid #eef2f0;">
            <h3 class="box-title" style="font-weight: 600; margin: 0;">Formulir Edit Admin</h3>
            <a href="admin.php" class="pull-right text-muted" style="margin-top: 5px;"><i class="fa fa-reply"></i> Kembali</a> 
          </div>

          <div class="box-body" style="padding: 30px;">
            <form action="admin_update.php" method="post" enctype="multipart/form-data">
              <?php 
              $id = mysqli_real_escape_string($koneksi, $_GET['id']);              
              $data = mysqli_query($koneksi, "SELECT * FROM admin WHERE admin_id='$id'");
              while($d = mysqli_fetch_array($data)){
                ?>
                
                <input type="hidden" name="id" value="<?php echo $d['admin_id'] ?>">

                <div class="form-group">
                  <label>Nama Lengkap</label>
                  <input type="text" class="form-control-modern" name="nama" value="<?php echo $d['admin_nama'] ?>" required="required">
                </div>

                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control-modern" name="username" value="<?php echo $d['admin_username'] ?>" required="required">
                </div>

                <div class="form-group">
                  <label>Password Baru</label>
                  <input type="password" class="form-control-modern" name="password" minlength="5" placeholder="Isi jika ingin mengganti password..">
                  <small class="text-muted"><i class="fa fa-info-circle"></i> Biarkan kosong jika tidak ingin diubah</small>
                </div>

                <div class="form-group">
                  <label>Foto Profil Saat Ini</label>
                  <?php if($d['admin_foto'] == ""){ ?>
                    <img src="../gambar/sistem/user.png" class="current-img">
                  <?php }else{ ?>
                    <img src="../gambar/user/<?php echo $d['admin_foto'] ?>" class="current-img">
                  <?php } ?>
                  
                  <input type="file" name="foto" class="form-control-modern" accept="image/*" style="padding: 8px;">
                  <small class="text-muted"><i class="fa fa-image"></i> Pilih file baru untuk mengganti foto</small>
                </div>

                <div class="form-group" style="margin-top: 30px;">
                  <button type="submit" class="btn-green btn-block">
                    <i class="fa fa-save"></i> &nbsp; SIMPAN PERUBAHAN
                  </button>
                </div>
                <?php
              }
              ?>
            </form>
          </div>

        </div>
      </section>
    </div>
  </section>

</div>

<?php include 'footer.php'; ?>