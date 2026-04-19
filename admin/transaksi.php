<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 20px; border-radius: 40px; text-decoration: none; display: inline-block; cursor: pointer; }
.btn-green:hover { background: #5e9c12; color: white; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.content-header h1 { font-size: 22px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
.content-header small { color: #7f8c8d; font-size: 13px; }
.status-badge { display: inline-block; padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; min-width: 130px; text-align: center; }
.status-0 { background: #fff3e0; color: #e65100; } /* Menunggu Pembayaran */
.status-1 { background: #e3f2fd; color: #1565c0; } /* Menunggu Konfirmasi */
.status-2 { background: #fee8e8; color: #c62828; } /* Ditolak */
.status-3 { background: #e8f0fe; color: #2c3e50; } /* Diproses */
.status-4 { background: #f3e5f5; color: #6a1b9a; } /* Dikirim */
.status-5 { background: #e8f5e9; color: #2e7d32; } /* Selesai */
.btn-sm-custom { padding: 5px 12px; border-radius: 8px; font-size: 12px; margin: 2px; display: inline-block; text-decoration: none; transition: 0.3s; }
.btn-primary-custom { background: #3498db; color: white; border: none; }
.btn-success-custom { background: #27ae60; color: white; border: none; }
.btn-danger-custom { background: #e74c3c; color: white; border: none; }
select.form-control-sm-custom { padding: 5px 10px; border-radius: 8px; border: 1px solid #ddd; font-size: 12px; cursor: pointer; }
.modal-modern .modal-content { border-radius: 24px; border: none; }
.modal-modern .modal-header { background: linear-gradient(135deg, #78B817, #669e12); color: white; border-radius: 24px 24px 0 0; padding: 16px 24px; }
.modal-modern .modal-header .close { color: white; opacity: 0.8; }
.modal-modern .modal-body { padding: 24px; text-align: center; }
.modal-modern .modal-body img { max-width: 100%; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-shopping-basket" style="color: #78B817;"></i> Transaksi / Pesanan</h1>
    <small>Kelola semua pesanan bahan pangan pelanggan</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="box-modern">
      <div class="box-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-list"></i> Daftar Transaksi</h3>
      </div>
      <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
          <table class="table table-custom table-bordered table-striped" id="table-datatable">
            <thead>
              <tr>
                <th width="1%">NO</th>
                <th>INVOICE</th>
                <th>TANGGAL</th>
                <th>PELANGGAN</th>
                <th>TOTAL</th>
                <th class="text-center">STATUS</th>
                <th class="text-center">AKSI STATUS</th>
                <th width="18%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              include '../koneksi.php';
              $no = 1;
              // Mengambil data pesanan dan join dengan data customer
              $invoice = mysqli_query($koneksi, "SELECT * FROM invoice JOIN customer ON customer_id = invoice_customer ORDER BY invoice_id DESC");
              while($i = mysqli_fetch_array($invoice)){
                $status_id = $i['invoice_status'];
                $status_class = "status-$status_id";
                
                // Mapping teks status
                $texts = [
                    0 => 'Menunggu Pembayaran',
                    1 => 'Menunggu Konfirmasi',
                    2 => 'Ditolak',
                    3 => 'Diproses',
                    4 => 'Dikirim',
                    5 => 'Selesai'
                ];
                $status_text = $texts[$status_id] ?? 'Unknown';
              ?>
              <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><strong>INV-00<?php echo $i['invoice_id']; ?></strong></td>
                <td>
                    <?php 
                    // Penanganan aman untuk nama kolom tanggal (invoice_tgl)
                    $tgl = isset($i['invoice_tgl']) ? $i['invoice_tgl'] : (isset($i['invoice_tanggal']) ? $i['invoice_tanggal'] : date('Y-m-d'));
                    echo date('d/m/Y', strtotime($tgl)); 
                    ?>
                </td>
                <td>
                    <strong><?php echo htmlspecialchars($i['customer_nama']); ?></strong><br>
                    <small class="text-muted"><?php echo htmlspecialchars($i['customer_hp']); ?></small>
                </td>
                <td>Rp <?php echo number_format($i['invoice_total_bayar']); ?></td>
                <td class="text-center">
                    <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
                </td>
                <td class="text-center">
                  <form action="transaksi_status.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $i['invoice_id']; ?>">
                    <select name="status" class="form-control-sm-custom" onchange="this.form.submit()">
                      <option value="0" <?php if($status_id == 0) echo "selected"; ?>>Menunggu Pembayaran</option>
                      <option value="1" <?php if($status_id == 1) echo "selected"; ?>>Menunggu Konfirmasi</option>
                      <option value="2" <?php if($status_id == 2) echo "selected"; ?>>Ditolak</option>
                      <option value="3" <?php if($status_id == 3) echo "selected"; ?>>Diproses</option>
                      <option value="4" <?php if($status_id == 4) echo "selected"; ?>>Dikirim</option>
                      <option value="5" <?php if($status_id == 5) echo "selected"; ?>>Selesai</option>
                    </select>
                  </form>
                </td>
                <td class="text-center">
                  <button type="button" class="btn-primary-custom btn-sm-custom" data-toggle="modal" data-target="#buktiPembayaran_<?php echo $i['invoice_id']; ?>" title="Lihat Bukti">
                    <i class="fa fa-image"></i> Bukti
                  </button>
                  <a href="transaksi_invoice.php?id=<?php echo $i['invoice_id']; ?>" class="btn-success-custom btn-sm-custom" title="Cetak Invoice">
                    <i class="fa fa-print"></i>
                  </a>
                  <button class="btn-danger-custom btn-sm-custom" onclick="confirmDelete(<?php echo $i['invoice_id']; ?>)" title="Hapus Transaksi">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>
              
              <div class="modal fade modal-modern" id="buktiPembayaran_<?php echo $i['invoice_id']; ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                      <h4 class="modal-title">Bukti Transfer INV-00<?php echo $i['invoice_id']; ?></h4>
                    </div>
                    <div class="modal-body">
                      <?php if($i['invoice_bukti'] == ""){ ?>
                        <div style="padding: 40px 20px;">
                            <i class="fa fa-info-circle fa-3x text-muted"></i>
                            <p style="margin-top: 15px;">Pelanggan belum mengupload bukti pembayaran.</p>
                        </div>
                      <?php } else { ?>
                        <img src="../gambar/bukti_pembayaran/<?php echo $i['invoice_bukti']; ?>" alt="Bukti Pembayaran">
                        <p style="margin-top: 15px;"><a href="../gambar/bukti_pembayaran/<?php echo $i['invoice_bukti']; ?>" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i> Lihat Ukuran Penuh</a></p>
                      <?php } ?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 40px;">Tutup</button>
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Transaksi?',
        text: "Seluruh data terkait pesanan ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#7f8c8d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'transaksi_hapus.php?id=' + id;
        }
    })
}
</script>

<?php include 'footer.php'; ?>