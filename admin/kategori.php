<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 20px; border-radius: 40px; text-decoration: none; display: inline-block; cursor: pointer; font-weight: 600; }
.btn-green:hover { background: #5e9c12; color: white; }
.btn-warning-custom { background: #f39c12; color: white; border-radius: 8px; padding: 6px 14px; margin: 0 3px; display: inline-block; border: none; cursor: pointer; }
.btn-danger-custom { background: #e74c3c; color: white; border-radius: 8px; padding: 6px 14px; display: inline-block; border: none; cursor: pointer; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; width: 100%; transition: all 0.2s; }
.form-control-modern:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
.modal-modern .modal-content { border-radius: 24px; border: none; overflow: hidden; }
.modal-modern .modal-header { background: linear-gradient(135deg, #78B817, #669e12); color: white; padding: 18px 24px; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-folder" style="color: #78B817;"></i> Data Kategori</h1>
    <small>Kelola kategori produk bahan pangan</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="box-modern">
      <div class="box-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-list"></i> Daftar Kategori</h3>
        <button type="button" class="btn-green pull-right" data-toggle="modal" data-target="#modalTambahKategori">
          <i class="fa fa-plus"></i> Tambah Kategori
        </button>
      </div>
      <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
          <table class="table table-custom table-bordered table-striped" id="table-datatable">
            <thead>
              <tr>
                <th width="5%">NO</th>
                <th>NAMA KATEGORI</th>
                <th width="20%" class="text-center">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              include '../koneksi.php'; 
              $no=1; 
              $data = mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY kategori_nama ASC");
              while($d = mysqli_fetch_array($data)){ 
              ?>
              <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($d['kategori_nama']); ?></strong></td>
                <td class="text-center">
                  <?php if($d['kategori_id'] != 1){ ?>
                    <button class="btn-warning-custom" onclick="openEditModal(<?php echo $d['kategori_id']; ?>, '<?php echo addslashes($d['kategori_nama']); ?>')">
                      <i class="fa fa-edit"></i> Edit
                    </button>
                    <button class="btn-danger-custom" onclick="confirmDelete(<?php echo $d['kategori_id']; ?>)">
                      <i class="fa fa-trash"></i> Hapus
                    </button>
                  <?php } else { ?>
                    <span class="label label-default">Default Sistem</span>
                  <?php } ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="modal fade modal-modern" id="modalTambahKategori" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Kategori Baru</h4>
      </div>
      <form action="kategori_act.php" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label style="font-weight: 600; margin-bottom: 8px;">Nama Kategori</label>
            <input type="text" class="form-control-modern" name="nama" placeholder="Contoh: Sayuran Segar" required autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 40px;">Batal</button>
          <button type="submit" class="btn-green">Simpan Kategori</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade modal-modern" id="modalEditKategori" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Kategori</h4>
      </div>
      <form action="kategori_update.php" method="post">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="form-group">
            <label style="font-weight: 600; margin-bottom: 8px;">Nama Kategori</label>
            <input type="text" class="form-control-modern" name="nama" id="edit_nama" required autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 40px;">Batal</button>
          <button type="submit" class="btn-green">Update Kategori</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openEditModal(id, nama) {
  document.getElementById('edit_id').value = id;
  document.getElementById('edit_nama').value = nama;
  $('#modalEditKategori').modal('show');
}

function confirmDelete(id) {
  Swal.fire({
    title: 'Hapus Kategori?',
    text: "Produk di kategori ini akan dialihkan ke kategori default.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e74c3c',
    cancelButtonColor: '#7f8c8d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'kategori_hapus.php?id=' + id;
    }
  })
}
</script>

<?php include 'footer.php'; ?>