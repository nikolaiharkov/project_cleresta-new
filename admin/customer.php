<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 20px; border-radius: 40px; text-decoration: none; display: inline-block; cursor: pointer; }
.btn-green:hover { background: #5e9c12; color: white; }
.btn-warning-custom { background: #f39c12; color: white; border-radius: 8px; padding: 6px 14px; margin: 0 3px; display: inline-block; border: none; cursor: pointer; }
.btn-danger-custom { background: #e74c3c; color: white; border-radius: 8px; padding: 6px 14px; display: inline-block; border: none; cursor: pointer; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.content-header h1 { font-size: 22px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
.content-header small { color: #7f8c8d; font-size: 13px; }
.form-group { margin-bottom: 20px; }
.form-group label { font-weight: 600; margin-bottom: 8px; display: block; color: #2c3e50; }
.modal-modern .modal-content { border-radius: 24px; border: none; }
.modal-modern .modal-header { background: linear-gradient(135deg, #78B817, #669e12); color: white; border-radius: 24px 24px 0 0; padding: 16px 24px; }
.modal-modern .modal-header .close { color: white; opacity: 0.8; }
.modal-modern .modal-body { padding: 24px; }
.form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; width: 100%; transition: all 0.2s; }
.form-control-modern:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-users" style="color: #78B817;"></i> Data Pelanggan</h1>
    <small>Kelola semua data pelanggan / customer</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="box-modern">
      <div class="box-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-list"></i> Daftar Pelanggan</h3>
        <button type="button" class="btn-green pull-right" data-toggle="modal" data-target="#modalTambahCustomer" style="border: none;">
          <i class="fa fa-plus"></i> Tambah Pelanggan
        </button>
      </div>
      <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
          <table class="table table-custom table-bordered table-striped" id="table-datatable">
            <thead>
              <tr>
                <th width="5%">NO</th>
                <th>NAMA</th>
                <th>EMAIL</th>
                <th>HP</th>
                <th>ALAMAT</th>
                <th width="15%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <?php include '../koneksi.php'; 
              $no=1; 
              $data = mysqli_query($koneksi,"SELECT * FROM customer ORDER BY customer_id DESC");
              while($d = mysqli_fetch_array($data)){ 
                // Encode data untuk JavaScript agar aman
                $encoded_data = base64_encode(json_encode([
                    'id' => $d['customer_id'],
                    'nama' => $d['customer_nama'],
                    'email' => $d['customer_email'],
                    'hp' => $d['customer_hp'],
                    'alamat' => $d['customer_alamat']
                ]));
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($d['customer_nama']); ?></td>
                <td><?php echo htmlspecialchars($d['customer_email']); ?></span></td>
                <td><?php echo htmlspecialchars($d['customer_hp']); ?></span></td>
                <td><?php echo htmlspecialchars($d['customer_alamat']); ?></span></td>
                <td>
                  <button class="btn-warning-custom" onclick="openEditModal('<?php echo $encoded_data; ?>')"><i class="fa fa-edit"></i> Edit</button>
                  <button class="btn-danger-custom" onclick="confirmDelete(<?php echo $d['customer_id']; ?>)"><i class="fa fa-trash"></i> Hapus</button>
                 </span></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<!-- MODAL TAMBAH CUSTOMER -->
<div class="modal fade modal-modern" id="modalTambahCustomer" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Pelanggan Baru</h4>
      </div>
      <form action="customer_act.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control-modern" name="nama" required placeholder="Masukkan nama pelanggan">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control-modern" name="email" required placeholder="Masukkan email pelanggan">
          </div>
          <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" class="form-control-modern" name="hp" required placeholder="Masukkan nomor HP">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control-modern" name="alamat" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control-modern" name="password" required placeholder="Masukkan password">
            <small class="text-muted">Minimal 5 karakter</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 40px;">Batal</button>
          <button type="submit" class="btn-green" style="border: none;">Simpan Pelanggan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT CUSTOMER -->
<div class="modal fade modal-modern" id="modalEditCustomer" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Pelanggan</h4>
      </div>
      <form action="customer_update.php" method="post">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" class="form-control-modern" name="nama" id="edit_nama" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control-modern" name="email" id="edit_email" required>
          </div>
          <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" class="form-control-modern" name="hp" id="edit_hp" required>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <textarea class="form-control-modern" name="alamat" id="edit_alamat" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label>Password (Opsional)</label>
            <input type="password" class="form-control-modern" name="password" placeholder="Kosongkan jika tidak ingin mengganti">
            <small class="text-muted">Isi hanya jika ingin mengganti password</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 40px;">Batal</button>
          <button type="submit" class="btn-green" style="border: none;">Update Pelanggan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openEditModal(encodedData) {
  try {
    var jsonString = atob(encodedData);
    var data = JSON.parse(jsonString);
    
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_nama').value = data.nama;
    document.getElementById('edit_email').value = data.email;
    document.getElementById('edit_hp').value = data.hp;
    document.getElementById('edit_alamat').value = data.alamat;
    
    $('#modalEditCustomer').modal('show');
  } catch(e) {
    console.error('Error:', e);
    alert('Terjadi kesalahan saat membuka data.');
  }
}

function confirmDelete(id) {
  if(confirm('⚠️ Yakin ingin menghapus pelanggan ini?\n\nSemua data transaksi pelanggan juga akan ikut terhapus.')) {
    window.location.href = 'customer_hapus.php?id=' + id;
  }
}
</script>

<?php include 'footer.php'; ?>