<?php 
include 'header.php'; 
include '../koneksi.php';
?>

<style>
/* Modern Settings Styles */
.settings-container {
  max-width: 1200px;
  margin: 0 auto;
}
.settings-tabs {
  display: flex;
  gap: 12px;
  margin-bottom: 28px;
  border-bottom: 2px solid #eef2f0;
  padding-bottom: 0;
}
.tab-btn {
  padding: 12px 28px;
  font-size: 15px;
  font-weight: 600;
  background: transparent;
  border: none;
  cursor: pointer;
  color: #7f8c8d;
  border-radius: 30px 30px 0 0;
  transition: all 0.2s ease;
  position: relative;
}
.tab-btn:hover {
  color: #78B817;
}
.tab-btn.active {
  color: #78B817;
  background: #f0f7e8;
}
.tab-btn.active::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  width: 100%;
  height: 3px;
  background: #78B817;
  border-radius: 3px;
}
.tab-panel {
  display: none;
  background: white;
  padding: 28px;
  border-radius: 24px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.04);
  border: 1px solid #eef2f0;
  animation: fadeIn 0.25s ease;
}
.tab-panel.active {
  display: block;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Modern Button */
.btn-green {
  background: #78B817;
  color: white;
  border: none;
  padding: 8px 22px;
  border-radius: 40px;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.2s;
  text-decoration: none;
  display: inline-block;
}
.btn-green:hover {
  background: #5e9c12;
  transform: translateY(-1px);
  color: white;
}
.btn-warning-custom {
  background: #f39c12;
  color: white;
  border: none;
  padding: 6px 14px;
  border-radius: 8px;
  font-size: 12px;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
  transition: all 0.2s;
}
.btn-warning-custom:hover {
  background: #e67e22;
  color: white;
}
.btn-danger-custom {
  background: #e74c3c;
  color: white;
  border: none;
  padding: 6px 14px;
  border-radius: 8px;
  font-size: 12px;
  cursor: pointer;
  text-decoration: none;
  display: inline-block;
  transition: all 0.2s;
}
.btn-danger-custom:hover {
  background: #c0392b;
  color: white;
}
.btn-outline {
  background: transparent;
  border: 1.5px solid #78B817;
  color: #78B817;
  padding: 8px 22px;
  border-radius: 40px;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-outline:hover {
  background: #78B817;
  color: white;
}

/* Table Styles */
.admin-table {
  width: 100%;
  border-collapse: collapse;
}
.admin-table th {
  background: #f8fafc;
  color: #2c3e50;
  font-weight: 600;
  padding: 14px 12px;
  border-bottom: 2px solid #78B817;
  text-align: left;
}
.admin-table td {
  padding: 14px 12px;
  border-bottom: 1px solid #eef2f0;
  vertical-align: middle;
}
.avatar-img {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #78B817;
}

/* Form Styles Modern */
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
  padding: 10px 16px;
  width: 100%;
  max-width: 400px;
  transition: all 0.2s;
}
.form-control-modern:focus {
  border-color: #78B817;
  outline: none;
  box-shadow: 0 0 0 3px rgba(120,184,23,0.1);
}

/* Modal Modern */
.modal-modern .modal-content {
  border-radius: 24px;
  border: none;
  overflow: hidden;
}
.modal-modern .modal-header {
  background: linear-gradient(135deg, #78B817, #669e12);
  color: white;
  padding: 18px 24px;
  border: none;
}
.modal-modern .modal-header .close {
  color: white;
  opacity: 0.8;
  font-size: 24px;
}
.modal-modern .modal-header .close:hover {
  opacity: 1;
}
.modal-modern .modal-body {
  padding: 24px;
}
.modal-modern .modal-footer {
  border-top: 1px solid #eef2f0;
  padding: 16px 24px;
}

/* Alert */
.alert-modern {
  background: #e8f5e9;
  color: #2e7d32;
  padding: 14px 20px;
  border-radius: 16px;
  margin-bottom: 20px;
  border-left: 4px solid #78B817;
}

.content-header h1 {
  font-size: 24px;
  font-weight: 600;
  color: #2c3e50;
}
.content-header small {
  color: #7f8c8d;
  font-size: 13px;
}
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1>
      <i class="fa fa-cog" style="color: #78B817;"></i> Settings
      <small>Pengaturan Akun & Admin</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Settings</li>
    </ol>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="settings-container">
      
      <!-- Tab Navigation -->
      <div class="settings-tabs">
        <button class="tab-btn active" onclick="openTab(event, 'adminTab')">
          <i class="fa fa-user-secret"></i> Data Admin
        </button>
        <button class="tab-btn" onclick="openTab(event, 'passwordTab')">
          <i class="fa fa-lock"></i> Ganti Password
        </button>
      </div>

      <!-- Tab 1: Data Admin -->
      <div id="adminTab" class="tab-panel active">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap;">
          <h4 style="margin: 0; color: #2c3e50;"><i class="fa fa-users" style="color: #78B817;"></i> Kelola Data Admin</h4>
          <button class="btn-green" data-toggle="modal" data-target="#modalTambahAdmin">
            <i class="fa fa-plus"></i> Tambah Admin Baru
          </button>
        </div>

        <?php if(isset($_GET['alert']) && $_GET['alert'] == 'berhasil'): ?>
          <div class="alert-modern"><i class="fa fa-check-circle"></i> Data admin berhasil disimpan!</div>
        <?php endif; ?>
        <?php if(isset($_GET['alert']) && $_GET['alert'] == 'hapus'): ?>
          <div class="alert-modern"><i class="fa fa-check-circle"></i> Data admin berhasil dihapus!</div>
        <?php endif; ?>
        
        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th width="5%">NO</th>
                <th>NAMA</th>
                <th>USERNAME</th>
                <th width="12%">FOTO</th>
                <th width="15%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no=1;
              $data = mysqli_query($koneksi, "SELECT * FROM admin ORDER BY admin_id ASC");
              while($d = mysqli_fetch_array($data)){
                $encoded_data = base64_encode(json_encode([
                    'id' => $d['admin_id'],
                    'nama' => $d['admin_nama'],
                    'username' => $d['admin_username'],
                    'foto' => $d['admin_foto']
                ]));
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($d['admin_nama']); ?></td>
                <td><?php echo htmlspecialchars($d['admin_username']); ?></td>
                <td>
                  <?php if($d['admin_foto'] == ""){ ?>
                    <img src="../gambar/sistem/user.png" class="avatar-img">
                  <?php }else{ ?>
                    <img src="../gambar/user/<?php echo $d['admin_foto']; ?>" class="avatar-img">
                  <?php } ?>
                 </span></td>
                <td>
                  <button class="btn-warning-custom" onclick="openEditAdminModal('<?php echo $encoded_data; ?>')">
                    <i class="fa fa-edit"></i> Edit
                  </button>
                  <?php if($d['admin_id'] != 1){ ?>
                    <button class="btn-danger-custom" onclick="confirmDeleteAdmin(<?php echo $d['admin_id']; ?>)">
                      <i class="fa fa-trash"></i> Hapus
                    </button>
                  <?php } ?>
                 </span></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Tab 2: Ganti Password -->
      <div id="passwordTab" class="tab-panel">
        <h4 style="margin-top: 0; margin-bottom: 24px; color: #2c3e50;"><i class="fa fa-key" style="color: #78B817;"></i> Ganti Password</h4>
        
        <?php 
        if(isset($_GET['alert_pass']) && $_GET['alert_pass'] == "sukses"){
          echo '<div class="alert-modern"><i class="fa fa-check-circle"></i> Password anda berhasil diganti!</div>';
        }
        ?>
        
        <form action="gantipassword_act.php" method="post">
          <div class="form-group-modern">
            <label>Password Baru</label>
            <input type="password" class="form-control-modern" name="password" placeholder="Masukkan password baru" required minlength="5">
            <small class="text-muted" style="display: block; margin-top: 6px;">Minimal 5 karakter</small>
          </div>
          <div class="form-group-modern">
            <button type="submit" class="btn-green">
              <i class="fa fa-save"></i> Simpan Password Baru
            </button>
          </div>
        </form>
      </div>

    </div>
  </section>
</div>

<!-- MODAL TAMBAH ADMIN -->
<div class="modal fade modal-modern" id="modalTambahAdmin" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Admin Baru</h4>
      </div>
      <form action="admin_act.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group-modern">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control-modern" name="nama" required placeholder="Masukkan nama admin">
          </div>
          <div class="form-group-modern">
            <label>Username</label>
            <input type="text" class="form-control-modern" name="username" required placeholder="Masukkan username">
          </div>
          <div class="form-group-modern">
            <label>Password</label>
            <input type="password" class="form-control-modern" name="password" required placeholder="Masukkan password" minlength="5">
            <small class="text-muted">Minimal 5 karakter</small>
          </div>
          <div class="form-group-modern">
            <label>Foto (Opsional)</label>
            <input type="file" class="form-control-modern" name="foto" accept="image/*">
            <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn-green">Simpan Admin</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT ADMIN -->
<div class="modal fade modal-modern" id="modalEditAdmin" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Admin</h4>
      </div>
      <form action="admin_update.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_admin_id">
          <div class="form-group-modern">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control-modern" name="nama" id="edit_admin_nama" required>
          </div>
          <div class="form-group-modern">
            <label>Username</label>
            <input type="text" class="form-control-modern" name="username" id="edit_admin_username" required>
          </div>
          <div class="form-group-modern">
            <label>Password (Opsional)</label>
            <input type="password" class="form-control-modern" name="password" placeholder="Kosongkan jika tidak ingin mengganti">
            <small class="text-muted">Isi hanya jika ingin mengganti password</small>
          </div>
          <div class="form-group-modern">
            <label>Foto Saat Ini</label>
            <div id="preview_foto_lama" style="margin-bottom: 10px;"></div>
            <label>Ganti Foto</label>
            <input type="file" class="form-control-modern" name="foto" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn-green">Update Admin</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openTab(evt, tabName) {
  var panels = document.getElementsByClassName("tab-panel");
  for (var i = 0; i < panels.length; i++) {
    panels[i].classList.remove("active");
  }
  var btns = document.getElementsByClassName("tab-btn");
  for (var i = 0; i < btns.length; i++) {
    btns[i].classList.remove("active");
  }
  document.getElementById(tabName).classList.add("active");
  evt.currentTarget.classList.add("active");
}

function openEditAdminModal(encodedData) {
  try {
    var jsonString = atob(encodedData);
    var data = JSON.parse(jsonString);
    
    document.getElementById('edit_admin_id').value = data.id;
    document.getElementById('edit_admin_nama').value = data.nama;
    document.getElementById('edit_admin_username').value = data.username;
    
    // Preview foto lama
    var previewHtml = '';
    if(data.foto && data.foto != '') {
      previewHtml = `<img src="../gambar/user/${data.foto}" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #78B817;">`;
    } else {
      previewHtml = `<img src="../gambar/sistem/user.png" style="width: 60px; height: 60px; border-radius: 50%; border: 2px solid #78B817;">`;
    }
    document.getElementById('preview_foto_lama').innerHTML = previewHtml;
    
    $('#modalEditAdmin').modal('show');
  } catch(e) {
    console.error('Error:', e);
    alert('Terjadi kesalahan saat membuka data.');
  }
}

function confirmDeleteAdmin(id) {
  if(confirm('⚠️ Yakin ingin menghapus admin ini?\n\nData admin akan dihapus permanen.')) {
    window.location.href = 'admin_hapus.php?id=' + id;
  }
}
</script>

<?php include 'footer.php'; ?>