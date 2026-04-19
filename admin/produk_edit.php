<?php include 'header.php'; ?>

<style>
  .box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; }
  .form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; width: 100%; transition: all 0.2s; }
  .form-control-modern:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
  .btn-green { background: #78B817; color: white; border: none; padding: 10px 25px; border-radius: 40px; font-weight: 600; }
  .img-preview { width: 120px; height: 120px; object-fit: cover; border-radius: 15px; border: 2px solid #eef2f0; margin-top: 10px; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-edit" style="color: #78B817;"></i> Edit Produk</h1>
    <small>Perbarui data stok dan informasi produk</small>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="box-modern">
          <div class="box-header" style="padding: 20px; border-bottom: 1px solid #f8fafc;">
            <h3 class="box-title" style="font-weight: 600;">Form Perubahan Produk</h3>
            <a href="produk.php" class="btn btn-default pull-right" style="border-radius: 40px;"><i class="fa fa-reply"></i> Kembali</a>
          </div>
          
          <div class="box-body" style="padding: 25px;">
            <?php 
            include '../koneksi.php';
            $id = mysqli_real_escape_string($koneksi, $_GET['id']);
            $data = mysqli_query($koneksi, "SELECT * FROM produk WHERE produk_id='$id'");
            while($d = mysqli_fetch_array($data)){
            ?>

            <form action="produk_update.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id" value="<?php echo $d['produk_id']; ?>">

              <div class="row">
                <div class="col-md-8">
                  <div class="form-group">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control-modern" name="nama" required value="<?php echo htmlspecialchars($d['produk_nama']); ?>">
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Kategori Produk</label>
                        <select name="kategori" class="form-control-modern" required>
                          <?php 
                          $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                          while($k = mysqli_fetch_array($kategori)){
                            $selected = ($k['kategori_id'] == $d['produk_kategori']) ? "selected" : "";
                            echo "<option $selected value='".$k['kategori_id']."'>".$k['kategori_nama']."</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" class="form-control-modern" name="harga" required value="<?php echo $d['produk_harga']; ?>">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Keterangan Produk</label>
                    <textarea name="keterangan" class="form-control-modern" rows="6" required style="resize:none;"><?php echo $d['produk_keterangan']; ?></textarea>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Berat (Gram)</label>
                        <input type="number" class="form-control-modern" name="berat" required value="<?php echo $d['produk_berat']; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Jumlah Stok</label>
                        <input type="number" class="form-control-modern" name="stok" required value="<?php echo $d['produk_jumlah']; ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4" style="border-left: 1px solid #f0f3f2;">
                  <h4 style="font-weight: 700; margin-bottom: 20px; color: #7f8c8d;">Foto Produk</h4>
                  
                  <?php for($i=1; $i<=3; $i++): $foto = "produk_foto".$i; ?>
                  <div class="form-group" style="margin-bottom: 25px;">
                    <label>Foto <?php echo $i; ?> <?php echo ($i==1) ? '(Utama)' : ''; ?></label>
                    <input type="file" name="foto<?php echo $i; ?>" class="form-control-modern" style="padding: 5px;">
                    <div class="preview-container">
                      <?php if($d[$foto] == ""){ ?>
                        <img src="../gambar/sistem/produk.png" class="img-preview">
                      <?php } else { ?>
                        <img src="../gambar/produk/<?php echo $d[$foto] ?>" class="img-preview">
                      <?php } ?>
                    </div>
                  </div>
                  <?php endfor; ?>
                </div>
              </div>

              <div class="row" style="margin-top: 30px; border-top: 1px solid #f0f3f2; padding-top: 20px;">
                <div class="col-md-12 text-center">
                  <button type="submit" class="btn-green"><i class="fa fa-save"></i> Simpan Perubahan Produk</button>
                </div>
              </div>
            </form>

            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'footer.php'; ?>