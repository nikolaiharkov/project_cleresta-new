<?php 
include 'header.php'; 
include '../koneksi.php';
?>

<style>
/* Modern Settings Styles */
.settings-container { max-width: 1200px; margin: 0 auto; }
.settings-tabs { display: flex; gap: 12px; margin-bottom: 28px; border-bottom: 2px solid #eef2f0; padding-bottom: 0; }
.tab-btn { padding: 12px 28px; font-size: 15px; font-weight: 600; background: transparent; border: none; cursor: pointer; color: #7f8c8d; border-radius: 30px 30px 0 0; transition: all 0.2s ease; position: relative; }
.tab-btn:hover { color: #78B817; }
.tab-btn.active { color: #78B817; background: #f0f7e8; }
.tab-btn.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 3px; background: #78B817; border-radius: 3px; }
.tab-panel { display: none; background: white; padding: 28px; border-radius: 24px; box-shadow: 0 8px 24px rgba(0,0,0,0.04); border: 1px solid #eef2f0; animation: fadeIn 0.25s ease; }
.tab-panel.active { display: block; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: translateY(0); } }

/* Modern Buttons */
.btn-green { background: #78B817; color: white; border: none; padding: 10px 25px; border-radius: 40px; cursor: pointer; font-weight: 600; transition: all 0.2s; text-decoration: none; display: inline-block; }
.btn-green:hover { background: #5e9c12; transform: translateY(-1px); color: white; }
.btn-warning-custom { background: #f39c12; color: white; border: none; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: inline-block; }
.btn-danger-custom { background: #e74c3c; color: white; border: none; padding: 6px 14px; border-radius: 8px; font-size: 12px; cursor: pointer; text-decoration: none; display: inline-block; }
.btn-outline { background: transparent; border: 1.5px solid #78B817; color: #78B817; padding: 8px 22px; border-radius: 40px; cursor: pointer; font-weight: 600; }

/* Table Styles */
.admin-table { width: 100%; border-collapse: collapse; }
.admin-table th { background: #f8fafc; color: #2c3e50; font-weight: 600; padding: 14px 12px; border-bottom: 2px solid #78B817; text-align: left; }
.admin-table td { padding: 14px 12px; border-bottom: 1px solid #eef2f0; vertical-align: middle; }
.avatar-img { width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid #78B817; background: #f0f2f5; }

/* Form Styles */
.form-group-modern { margin-bottom: 24px; }
.form-group-modern label { font-weight: 600; margin-bottom: 8px; display: block; color: #2c3e50; }
.form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 12px 16px; width: 100%; transition: all 0.2s; }
.form-control-modern:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-cog" style="color: #78B817;"></i> Settings</h1>
    <small>Kelola Akun Administrator & Keamanan</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="settings-container">
      
      <div class="settings-tabs">
        <button class="tab-btn active" onclick="openTab(event, 'adminTab')">
          <i class="fa fa-user-secret"></i> Manajemen Admin
        </button>
        <button class="tab-btn" onclick="openTab(event, 'passwordTab')">
          <i class="fa fa-lock"></i> Keamanan Akun
        </button>
      </div>

      <div id="adminTab" class="tab-panel active">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
          <h4 style="margin: 0; color: #2c3e50; font-weight: 700;">Daftar Pengguna Panel</h4>
          <button class="btn-green" data-toggle="modal" data-target="#modalTambahAdmin">
            <i class="fa fa-plus"></i> Tambah Admin Baru
          </button>
        </div>

        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th width="5%">NO</th>
                <th width="8%">FOTO</th>
                <th>NAMA LENGKAP</th>
                <th>USERNAME</th>
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
                <td>
                  <?php if($d['admin_foto'] == ""){ ?>
                    <img src="../gambar/sistem/user.png" class="avatar-img">
                  <?php }else{ ?>
                    <img src="../gambar/user/<?php echo $d['admin_foto']; ?>" class="avatar-img">
                  <?php } ?>
                </td>
                <td><strong><?php echo htmlspecialchars($d['admin_nama']); ?></strong></td>
                <td><code><?php echo htmlspecialchars($d['admin_username']); ?></code></td>
                <td>
                  <button class="btn-warning-custom" onclick="openEditAdminModal('<?php echo $encoded_data; ?>')">
                    <i class="fa fa-edit"></i>
                  </button>
                  <?php if($d['admin_id'] != 1){ ?>
                    <button class="btn-danger-custom" onclick="confirmDeleteAdmin(<?php echo $d['admin_id']; ?>)">
                      <i class="fa fa-trash"></i>
                    </button>
                  <?php } else { ?>
                    <span class="label label-default" style="border-radius: 10px;">Utama</span>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

      <div id="passwordTab" class="tab-panel">
        <h4 style="margin-top: 0; margin-bottom: 24px; color: #2c3e50; font-weight: 700;"><i class="fa fa-key"></i> Ganti Password Saya</h4>
        
        <div style="max-width: 500px;">
            <p class="text-muted">Halo <strong><?php echo $_SESSION['nama']; ?></strong>, demi keamanan silakan perbarui password Anda secara berkala.</p>
            <form action="gantipassword_act.php" method="post">
              <div class="form-group-modern">
                <label>Password Baru</label>
                <input type="password" class="form-control-modern" name="password" placeholder="Masukkan minimal 5 karakter" required minlength="5">
              </div>
              <div class="form-group-modern">
                <button type="submit" class="btn-green">
                  <i class="fa fa-save"></i> Perbarui Password
                </button>
              </div>
            </form>
        </div>
      </div>

    </div>
  </section>
</div>

<div class="modal fade modal-modern" id="modalTambahAdmin" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-user-plus"></i> Tambah Admin Baru</h4>
      </div>
      <form action="admin_act.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group-modern">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control-modern" name="nama" required placeholder="Masukkan nama lengkap admin">
          </div>
          <div class="form-group-modern">
            <label>Username</label>
            <input type="text" class="form-control-modern" name="username" required placeholder="Username untuk login">
          </div>
          <div class="form-group-modern">
            <label>Password</label>
            <input type="password" class="form-control-modern" name="password" required placeholder="Minimal 5 karakter" minlength="5">
          </div>
          <div class="form-group-modern">
            <label>Foto Profil (Opsional)</label>
            <input type="file" class="form-control-modern" name="foto" accept="image/*" style="padding: 8px;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn-green">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade modal-modern" id="modalEditAdmin" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-user-edit"></i> Edit Akun Admin</h4>
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
            <label>Password Baru</label>
            <input type="password" class="form-control-modern" name="password" placeholder="Kosongkan jika tidak diganti">
            <small class="text-muted">Isi hanya jika ingin mereset password user ini.</small>
          </div>
          <div class="form-group-modern">
            <label>Foto Saat Ini</label>
            <div id="preview_foto_lama" style="margin-bottom: 12px;"></div>
            <label>Ganti Foto</label>
            <input type="file" class="form-control-modern" name="foto" accept="image/*" style="padding: 8px;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn-outline" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn-green">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openTab(evt, tabName) {
  var panels = document.getElementsByClassName("tab-panel");
  for (var i = 0; i < panels.length; i++) { panels[i].classList.remove("active"); }
  var btns = document.getElementsByClassName("tab-btn");
  for (var i = 0; i < btns.length; i++) { btns[i].classList.remove("active"); }
  document.getElementById(tabName).classList.add("active");
  evt.currentTarget.classList.add("active");
}

function openEditAdminModal(encodedData) {
  try {
    var data = JSON.parse(atob(encodedData));
    document.getElementById('edit_admin_id').value = data.id;
    document.getElementById('edit_admin_nama').value = data.nama;
    document.getElementById('edit_admin_username').value = data.username;
    
    var previewHtml = `<img src="../gambar/${data.foto ? 'user/'+data.foto : 'sistem/user.png'}" class="avatar-img" style="width:70px; height:70px;">`;
    document.getElementById('preview_foto_lama').innerHTML = previewHtml;
    $('#modalEditAdmin').modal('show');
  } catch(e) { alert('Gagal memuat data.'); }
}

function confirmDeleteAdmin(id) {
  Swal.fire({
    title: 'Hapus Akun Admin?',
    text: "Tindakan ini tidak dapat dibatalkan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e74c3c',
    cancelButtonColor: '#7f8c8d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'admin_hapus.php?id=' + id;
    }
  })
}
</script>

<?php include 'footer.php'; ?>