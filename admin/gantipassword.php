<?php include 'header.php'; ?>
<style>
.content-header h1 { font-size: 24px; font-weight: 600; color: #2c3e50; }
.content-header small { color: #7f8c8d; font-size: 13px; }
.password-card {
  background: white;
  border-radius: 24px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.04);
  border: 1px solid #eef2f0;
  overflow: hidden;
  max-width: 500px;
  margin: 0 auto;
}
.password-header {
  background: linear-gradient(135deg, #78B817, #669e12);
  padding: 20px 24px;
  color: white;
}
.password-header h3 {
  margin: 0;
  font-weight: 600;
}
.password-header p {
  margin: 5px 0 0;
  opacity: 0.9;
  font-size: 13px;
}
.password-body {
  padding: 28px;
}
.form-group-modern {
  margin-bottom: 24px;
}
.form-group-modern label {
  font-weight: 600;
  margin-bottom: 8px;
  display: block;
  color: #2c3e50;
}
.form-control-modern {
  border: 1.5px solid #e2e8f0;
  border-radius: 12px;
  padding: 12px 16px;
  width: 100%;
  transition: all 0.2s;
}
.form-control-modern:focus {
  border-color: #78B817;
  outline: none;
  box-shadow: 0 0 0 3px rgba(120,184,23,0.1);
}
.btn-green {
  background: #78B817;
  color: white;
  border: none;
  padding: 10px 28px;
  border-radius: 40px;
  cursor: pointer;
  font-weight: 600;
  transition: all 0.2s;
}
.btn-green:hover {
  background: #5e9c12;
  transform: translateY(-1px);
}
.alert-modern {
  background: #e8f5e9;
  color: #2e7d32;
  padding: 14px 20px;
  border-radius: 16px;
  margin-bottom: 20px;
  border-left: 4px solid #78B817;
}
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-lock" style="color: #78B817;"></i> Ganti Password</h1>
    <small>Perbarui password akun Anda</small>
    <ol class="breadcrumb" style="background: transparent; padding-left: 0;">
      <li><a href="index.php" style="color: #78B817;"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Ganti Password</li>
    </ol>
  </section>

  <section class="content" style="padding-top: 20px;">
    <div class="password-card">
      <div class="password-header">
        <h3><i class="fa fa-key"></i> Ganti Password</h3>
        <p>Masukkan password baru untuk akun Anda</p>
      </div>
      <div class="password-body">
        <?php 
        if(isset($_GET['alert']) && $_GET['alert'] == "sukses"){
          echo '<div class="alert-modern"><i class="fa fa-check-circle"></i> Password anda berhasil diganti!</div>';
        }
        ?>
        <form action="gantipassword_act.php" method="post">
          <div class="form-group-modern">
            <label>Password Baru</label>
            <input type="password" class="form-control-modern" name="password" placeholder="Masukkan password baru" required minlength="5">
            <small class="text-muted" style="display: block; margin-top: 6px;">Minimal 5 karakter</small>
          </div>
          <button type="submit" class="btn-green">
            <i class="fa fa-save"></i> Simpan Password
          </button>
        </form>
      </div>
    </div>
  </section>
</div>

<?php include 'footer.php'; ?>