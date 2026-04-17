<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 20px; border-radius: 40px; text-decoration: none; display: inline-block; cursor: pointer; }
.btn-green:hover { background: #5e9c12; color: white; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.content-header h1 { font-size: 22px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
.content-header small { color: #7f8c8d; font-size: 13px; }
.status-badge { display: inline-block; padding: 5px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; }
.status-0 { background: #fff3e0; color: #e65100; }
.status-1 { background: #e3f2fd; color: #1565c0; }
.status-2 { background: #fee8e8; color: #c62828; }
.status-3 { background: #e8f0fe; color: #2c3e50; }
.status-4 { background: #f3e5f5; color: #6a1b9a; }
.status-5 { background: #e8f5e9; color: #2e7d32; }
.btn-sm-custom { padding: 5px 12px; border-radius: 8px; font-size: 12px; margin: 2px; display: inline-block; text-decoration: none; }
.btn-primary-custom { background: #3498db; color: white; border: none; }
.btn-success-custom { background: #27ae60; color: white; border: none; }
.btn-danger-custom { background: #e74c3c; color: white; border: none; }
select.form-control-sm-custom { padding: 5px 10px; border-radius: 8px; border: 1px solid #ddd; font-size: 12px; }
.modal-modern .modal-content { border-radius: 24px; border: none; }
.modal-modern .modal-header { background: linear-gradient(135deg, #78B817, #669e12); color: white; border-radius: 24px 24px 0 0; padding: 16px 24px; }
.modal-modern .modal-header .close { color: white; opacity: 0.8; }
.modal-modern .modal-body { padding: 24px; text-align: center; }
.modal-modern .modal-body img { max-width: 100%; border-radius: 12px; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-shopping-basket" style="color: #78B817;"></i> Transaksi / Pesanan</h1>
    <small>Kelola semua transaksi dan pesanan pelanggan</small>
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
                <th width="5%">NO</th>
                <th>NO. INVOICE</th>
                <th>TANGGAL</th>
                <th>CUSTOMER</th>
                <th>TOTAL BAYAR</th>
                <th>STATUS</th>
                <th>UPDATE STATUS</th>
                <th width="20%">OPSI</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              include '../koneksi.php';
              $no = 1;
              $invoice = mysqli_query($koneksi, "SELECT * FROM invoice, customer WHERE customer_id = invoice_customer ORDER BY invoice_id DESC");
              while($i = mysqli_fetch_array($invoice)){
                $status_class = '';
                $status_text = '';
                switch($i['invoice_status']){
                  case 0: $status_class = 'status-0'; $status_text = 'Menunggu Pembayaran'; break;
                  case 1: $status_class = 'status-1'; $status_text = 'Menunggu Konfirmasi'; break;
                  case 2: $status_class = 'status-2'; $status_text = 'Ditolak'; break;
                  case 3: $status_class = 'status-3'; $status_text = 'Diproses'; break;
                  case 4: $status_class = 'status-4'; $status_text = 'Dikirim'; break;
                  case 5: $status_class = 'status-5'; $status_text = 'Selesai'; break;
                  default: $status_class = 'status-0'; $status_text = 'Unknown';
                }
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><strong>INVOICE-00<?php echo $i['invoice_id']; ?></strong></td>
                <td><?php echo date('d/m/Y', strtotime($i['invoice_tanggal'])); ?></td>
                <td><?php echo htmlspecialchars($i['customer_nama']); ?></span></td>
                <td>Rp <?php echo number_format($i['invoice_total_bayar']); ?> </span></td>
                <td class="text-center"><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                <td class="text-center">
                  <form action="transaksi_status.php" method="post" style="display: inline-block;">
                    <input type="hidden" name="invoice" value="<?php echo $i['invoice_id']; ?>">
                    <select name="status" class="form-control-sm-custom" onchange="this.form.submit()">
                      <option value="0" <?php echo ($i['invoice_status'] == 0) ? 'selected' : ''; ?>>Menunggu Pembayaran</option>
                      <option value="1" <?php echo ($i['invoice_status'] == 1) ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                      <option value="2" <?php echo ($i['invoice_status'] == 2) ? 'selected' : ''; ?>>Ditolak</option>
                      <option value="3" <?php echo ($i['invoice_status'] == 3) ? 'selected' : ''; ?>>Diproses</option>
                      <option value="4" <?php echo ($i['invoice_status'] == 4) ? 'selected' : ''; ?>>Dikirim</option>
                      <option value="5" <?php echo ($i['invoice_status'] == 5) ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                  </form>
                </td>
                <td class="text-center">
                  <button type="button" class="btn-primary-custom btn-sm-custom" data-toggle="modal" data-target="#buktiPembayaran_<?php echo $i['invoice_id']; ?>" style="border: none; cursor: pointer;">
                    <i class="fa fa-image"></i> Bukti
                  </button>
                  <a href="transaksi_invoice.php?id=<?php echo $i['invoice_id']; ?>" class="btn-success-custom btn-sm-custom">
                    <i class="fa fa-print"></i> Invoice
                  </a>
                  <button class="btn-danger-custom btn-sm-custom" onclick="confirmDelete(<?php echo $i['invoice_id']; ?>)" style="border: none; cursor: pointer;">
                    <i class="fa fa-trash"></i> Hapus
                  </button>
                </td>
              </tr>
              
              <!-- Modal Bukti Pembayaran -->
              <div class="modal fade modal-modern" id="buktiPembayaran_<?php echo $i['invoice_id']; ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                      <h4 class="modal-title">Bukti Pembayaran - INVOICE-00<?php echo $i['invoice_id']; ?></h4>
                    </div>
                    <div class="modal-body">
                      <?php if($i['invoice_bukti'] == ""){ ?>
                        <p class="text-muted"><i class="fa fa-info-circle"></i> Bukti pembayaran belum diupload oleh pelanggan.</p>
                      <?php } else { ?>
                        <img src="../gambar/bukti_pembayaran/<?php echo $i['invoice_bukti']; ?>" alt="Bukti Pembayaran">
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
  if(confirm('⚠️ Yakin ingin menghapus transaksi ini?\n\nSemua data terkait transaksi akan dihapus permanen.')) {
    window.location.href = 'transaksi_hapus.php?id=' + id;
  }
}
</script>

<?php include 'footer.php'; ?>