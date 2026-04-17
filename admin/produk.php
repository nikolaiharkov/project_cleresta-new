<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 20px; border-radius: 40px; text-decoration: none; display: inline-block; cursor: pointer; }
.btn-green:hover { background: #5e9c12; color: white; }
.btn-warning-custom { background: #f39c12; color: white; border-radius: 8px; padding: 6px 14px; margin: 0 3px; display: inline-block; border: none; cursor: pointer; }
.btn-danger-custom { background: #e74c3c; color: white; border-radius: 8px; padding: 6px 14px; display: inline-block; border: none; cursor: pointer; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.produk-img { width: 50px; height: 50px; object-fit: cover; border-radius: 10px; background: #f0f2f5; }
.modal-modern .modal-content { border-radius: 24px; border: none; }
.modal-modern .modal-header { background: linear-gradient(135deg, #78B817, #669e12); color: white; border-radius: 24px 24px 0 0; padding: 16px 24px; }
.modal-modern .modal-header .close { color: white; opacity: 0.8; }
.modal-modern .modal-body { padding: 24px; max-height: 70vh; overflow-y: auto; }
.form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; width: 100%; transition: all 0.2s; }
.form-control-modern:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
select.form-control-modern { background: white; cursor: pointer; }
textarea.form-control-modern { resize: vertical; min-height: 150px; }
.content-header h1 { font-size: 22px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
.content-header small { color: #7f8c8d; font-size: 13px; }
.form-group { margin-bottom: 20px; }
.form-group label { font-weight: 600; margin-bottom: 8px; display: block; color: #2c3e50; }
.image-preview { margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap; }
.image-preview img { width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #e2e8f0; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-leaf" style="color: #78B817;"></i> Data Produk</h1>
    <small>Kelola semua produk toko Anda</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="box-modern">
      <div class="box-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-list"></i> Daftar Produk</h3>
        <button type="button" class="btn-green pull-right" data-toggle="modal" data-target="#modalTambahProduk" style="border: none;">
          <i class="fa fa-plus"></i> Tambah Produk
        </button>
      </div>
      <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
          <table class="table table-custom table-bordered table-striped" id="table-datatable">
            <thead>
              <tr><th width="5%">NO</th><th>NAMA PRODUK</th><th>KATEGORI</th><th>HARGA</th><th>STOK</th><th>FOTO</th><th width="15%">OPSI</th></tr>
            </thead>
            <tbody>
              <?php include '../koneksi.php'; 
              $no=1; 
              $data = mysqli_query($koneksi,"SELECT * FROM produk,kategori WHERE kategori_id=produk_kategori ORDER BY produk_id DESC");
              while($d = mysqli_fetch_array($data)){ 
                $foto = ($d['produk_foto1'] != '') ? $d['produk_foto1'] : '../gambar/sistem/produk.png';
                // Gunakan base64 encode untuk mengamankan karakter khusus
                $encoded_data = base64_encode(json_encode([
                    'id' => $d['produk_id'],
                    'nama' => $d['produk_nama'],
                    'kategori' => $d['produk_kategori'],
                    'harga' => $d['produk_harga'],
                    'keterangan' => $d['produk_keterangan'],
                    'berat' => $d['produk_berat'],
                    'jumlah' => $d['produk_jumlah'],
                    'foto1' => $d['produk_foto1'],
                    'foto2' => $d['produk_foto2'],
                    'foto3' => $d['produk_foto3']
                ]));
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($d['produk_nama']); ?></td>
                <td><?php echo htmlspecialchars($d['kategori_nama']); ?></td>
                <td>Rp <?php echo number_format($d['produk_harga']); ?></td>
                <td><?php echo number_format($d['produk_jumlah']); ?></td>
                <td><img src="../gambar/produk/<?php echo $foto; ?>" class="produk-img" onerror="this.src='../gambar/sistem/produk.png'"></td>
                <td>
                  <button class="btn-warning-custom" onclick="openEditModal('<?php echo $encoded_data; ?>')"><i class="fa fa-edit"></i> Edit</button>
                  <button class="btn-danger-custom" onclick="confirmDelete(<?php echo $d['produk_id']; ?>)"><i class="fa fa-trash"></i> Hapus</button>
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

<!-- MODAL TAMBAH PRODUK -->
<div class="modal fade modal-modern" id="modalTambahProduk" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Tambah Produk Baru</h4>
      </div>
      <form action="produk_act.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control-modern" name="nama" required placeholder="Masukkan nama produk">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control-modern" required>
                  <option value="">- Pilih Kategori -</option>
                  <?php 
                  $kategori = mysqli_query($koneksi,"SELECT * FROM kategori");
                  while($k = mysqli_fetch_array($kategori)){
                    echo '<option value="'.$k['kategori_id'].'">'.htmlspecialchars($k['kategori_nama']).'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" class="form-control-modern" name="harga" required placeholder="Masukkan harga">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Stok / Jumlah</label>
                <input type="number" class="form-control-modern" name="jumlah" required placeholder="Masukkan jumlah stok">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Berat (gram)</label>
                <input type="number" class="form-control-modern" name="berat" required placeholder="Masukkan berat produk">
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control-modern" name="keterangan" rows="8" placeholder="Deskripsi produk (bisa panjang, pakai enter, dll)"></textarea>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Foto Utama</label>
                <input type="file" class="form-control-modern" name="foto1" accept="image/*">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Foto 2</label>
                <input type="file" class="form-control-modern" name="foto2" accept="image/*">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Foto 3</label>
                <input type="file" class="form-control-modern" name="foto3" accept="image/*">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 40px;">Batal</button>
          <button type="submit" class="btn-green" style="border: none;">Simpan Produk</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT PRODUK -->
<div class="modal fade modal-modern" id="modalEditProduk" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Produk</h4>
      </div>
      <form action="produk_update.php" method="post" enctype="multipart/form-data" id="formEditProduk">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" class="form-control-modern" name="nama" id="edit_nama" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control-modern" id="edit_kategori" required>
                  <option value="">- Pilih Kategori -</option>
                  <?php 
                  $kategori = mysqli_query($koneksi,"SELECT * FROM kategori");
                  while($k = mysqli_fetch_array($kategori)){
                    echo '<option value="'.$k['kategori_id'].'">'.htmlspecialchars($k['kategori_nama']).'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" class="form-control-modern" name="harga" id="edit_harga" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Stok / Jumlah</label>
                <input type="number" class="form-control-modern" name="jumlah" id="edit_jumlah" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Berat (gram)</label>
                <input type="number" class="form-control-modern" name="berat" id="edit_berat" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label>Keterangan</label>
                <textarea class="form-control-modern" name="keterangan" id="edit_keterangan" rows="10"></textarea>
              </div>
            </div>
            
            <!-- FOTO LAMA (Preview) -->
            <div class="col-md-12">
              <div class="form-group">
                <label>Foto Saat Ini</label>
                <div class="image-preview" id="preview_foto"></div>
              </div>
            </div>
            
            <!-- INPUT UPLOAD FOTO BARU -->
            <div class="col-md-12">
              <hr>
              <label><i class="fa fa-image"></i> Ganti Foto (Kosongkan jika tidak ingin mengubah)</label>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Foto Utama</label>
                <input type="file" class="form-control-modern" name="foto1" accept="image/*">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Foto 2</label>
                <input type="file" class="form-control-modern" name="foto2" accept="image/*">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Foto 3</label>
                <input type="file" class="form-control-modern" name="foto3" accept="image/*">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 40px;">Batal</button>
          <button type="submit" class="btn-green" style="border: none;">Update Produk</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function openEditModal(encodedData) {
  try {
    // Decode base64 dan parse JSON
    var jsonString = atob(encodedData);
    var data = JSON.parse(jsonString);
    
    document.getElementById('edit_id').value = data.id;
    document.getElementById('edit_nama').value = data.nama;
    document.getElementById('edit_kategori').value = data.kategori;
    document.getElementById('edit_harga').value = data.harga;
    document.getElementById('edit_jumlah').value = data.jumlah;
    document.getElementById('edit_berat').value = data.berat;
    document.getElementById('edit_keterangan').value = data.keterangan;
    
    // Tampilkan preview foto lama
    let previewHtml = '';
    if(data.foto1 && data.foto1 != '') previewHtml += `<div style="display:inline-block; text-align:center; margin:5px;"><img src="../gambar/produk/${data.foto1}" style="width:80px; height:80px; object-fit:cover; border-radius:10px; border:2px solid #78B817;"><br><small>Foto Utama</small></div>`;
    if(data.foto2 && data.foto2 != '') previewHtml += `<div style="display:inline-block; text-align:center; margin:5px;"><img src="../gambar/produk/${data.foto2}" style="width:80px; height:80px; object-fit:cover; border-radius:10px;"><br><small>Foto 2</small></div>`;
    if(data.foto3 && data.foto3 != '') previewHtml += `<div style="display:inline-block; text-align:center; margin:5px;"><img src="../gambar/produk/${data.foto3}" style="width:80px; height:80px; object-fit:cover; border-radius:10px;"><br><small>Foto 3</small></div>`;
    if(!previewHtml) previewHtml = '<span class="text-muted">Tidak ada foto</span>';
    document.getElementById('preview_foto').innerHTML = previewHtml;
    
    $('#modalEditProduk').modal('show');
  } catch(e) {
    console.error('Error:', e);
    alert('Terjadi kesalahan saat membuka data. Silahkan refresh halaman.');
  }
}

function confirmDelete(id) {
  if(confirm('⚠️ Yakin ingin menghapus produk ini?\n\nData produk akan dihapus permanen.')) {
    window.location.href = 'produk_hapus.php?id=' + id;
  }
}
</script>

<?php include 'footer.php'; ?>