<?php include 'header.php'; ?>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-shopping-bag" style="color: #78B817;"></i> Data Produk</h1>
    <small>Kelola katalog bahan pangan Fresh Cart</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="box-modern">
      <div class="box-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-list"></i> Daftar Produk</h3>
        <button type="button" class="btn-green pull-right" data-toggle="modal" data-target="#modalTambahProduk" style="border:none; padding: 8px 20px; border-radius: 40px; background:#78B817; color:white; font-weight:600;">
          <i class="fa fa-plus"></i> Tambah Produk
        </button>
      </div>
      <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="table-datatable">
            <thead>
              <tr>
                <th width="1%">NO</th>
                <th width="8%">FOTO</th>
                <th>NAMA PRODUK</th>
                <th>KATEGORI</th>
                <th>HARGA</th>
                <th width="10%">STOK</th>
                <th width="15%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              include '../koneksi.php';
              $no=1;
              $data = mysqli_query($koneksi,"SELECT * FROM produk, kategori WHERE produk_kategori=kategori_id ORDER BY produk_id DESC");
              while($d = mysqli_fetch_array($data)){
              ?>
              <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td class="text-center">
                  <img src="../gambar/produk/<?php echo $d['produk_foto1']; ?>" style="width:50px; height:50px; border-radius:8px; object-fit:cover;">
                </td>
                <td><strong><?php echo htmlspecialchars($d['produk_nama']); ?></strong></td>
                <td><span class="label label-success" style="background:#78B817;"><?php echo $d['kategori_nama']; ?></span></td>
                <td>Rp <?php echo number_format($d['produk_harga']); ?></td>
                <td class="text-center"><?php echo number_format($d['produk_jumlah']); ?></td>
                <td class="text-center">
                  <a href="produk_edit.php?id=<?php echo $d['produk_id']; ?>" class="btn btn-warning btn-sm" style="border-radius:8px;"><i class="fa fa-edit"></i></a>
                  <button class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $d['produk_id']; ?>)" style="border-radius:8px;"><i class="fa fa-trash"></i></button>
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

<div class="modal fade" id="modalTambahProduk" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="border-radius:20px; overflow:hidden;">
      <div class="modal-header" style="background:#78B817; color:white;">
        <button type="button" class="close" data-dismiss="modal" style="color:white; opacity:1;"><span>&times;</span></button>
        <h4 class="modal-title">Tambah Produk Baru</h4>
      </div>
      <form action="produk_act.php" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" class="form-control" name="nama" required placeholder="Masukkan nama produk">
          </div>
          <div class="form-group">
            <label>Kategori</label>
            <select name="kategori" class="form-control" required>
              <option value="">-- Pilih Kategori --</option>
              <?php 
              $kat = mysqli_query($koneksi,"SELECT * FROM kategori ORDER BY kategori_nama ASC");
              while($k = mysqli_fetch_array($kat)){
                echo "<option value='".$k['kategori_id']."'>".$k['kategori_nama']."</option>";
              }
              ?>
            </select>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" class="form-control" name="harga" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Stok</label>
                <input type="number" class="form-control" name="stok" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label>Berat (Gram)</label>
            <input type="number" class="form-control" name="berat" required>
          </div>
          <div class="form-group">
            <label>Keterangan / Deskripsi</label>
            <textarea class="form-control" name="keterangan" rows="3" required></textarea>
          </div>
          <div class="form-group">
            <label>Foto Produk</label>
            <input type="file" name="foto" required accept="image/*">
            <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB)</small>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:20px;">Batal</button>
          <button type="submit" class="btn-green" style="background:#78B817; color:white; border:none; padding:8px 20px; border-radius:20px;">Simpan Produk</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Hapus Produk?',
    text: "Data produk dan foto akan dihapus secara permanen!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e74c3c',
    cancelButtonColor: '#7f8c8d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'produk_hapus.php?id=' + id;
    }
  })
}
</script>

<?php include 'footer.php'; ?>