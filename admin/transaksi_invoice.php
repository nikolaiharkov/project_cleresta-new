<?php include 'header.php'; ?>
<style>
.invoice-container { background: white; border-radius: 20px; padding: 30px; margin: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
.invoice-header { border-bottom: 2px solid #78B817; padding-bottom: 15px; margin-bottom: 20px; }
.invoice-title { color: #78B817; font-weight: 700; }
.invoice-table th, .invoice-table td { padding: 12px; vertical-align: middle; }
.invoice-table th { background: #f8fafc; border-bottom: 2px solid #78B817; }
.status-badge-invoice { display: inline-block; padding: 6px 15px; border-radius: 50px; font-size: 12px; font-weight: 600; }
.status-0 { background: #fff3e0; color: #e65100; }
.status-1 { background: #e3f2fd; color: #1565c0; }
.status-2 { background: #fee8e8; color: #c62828; }
.status-3 { background: #e8f0fe; color: #2c3e50; }
.status-4 { background: #f3e5f5; color: #6a1b9a; }
.status-5 { background: #e8f5e9; color: #2e7d32; }
.btn-print { background: #78B817; color: white; padding: 8px 20px; border-radius: 40px; border: none; text-decoration: none; display: inline-block; }
.btn-back { background: #7f8c8d; color: white; padding: 8px 20px; border-radius: 40px; border: none; text-decoration: none; display: inline-block; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-file-text-o" style="color: #78B817;"></i> Detail Invoice</h1>
    <small>Detail pesanan dan invoice</small>
  </section>

  <section class="content">
    <?php 
    $id_invoice = $_GET['id'];
    $invoice = mysqli_query($koneksi, "SELECT * FROM invoice WHERE invoice_id='$id_invoice'");
    while($i = mysqli_fetch_array($invoice)){
    ?>
    <div class="invoice-container">
      <div class="invoice-header">
        <div class="row">
          <div class="col-md-6">
            <h3 class="invoice-title"><i class="fa fa-leaf"></i> Fresh Cart</h3>
            <p>Jl. Raya Fresh Cart No. 123<br>Telp: (021) 1234567</p>
          </div>
          <div class="col-md-6 text-right">
            <h4>INVOICE</h4>
            <h5>INVOICE-00<?php echo $i['invoice_id']; ?></h5>
            <p>Tanggal: <?php echo date('d/m/Y', strtotime($i['invoice_tanggal'])); ?></p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <strong>Kepada Yth:</strong><br>
          <?php echo htmlspecialchars($i['invoice_nama']); ?><br>
          <?php echo htmlspecialchars($i['invoice_alamat']); ?><br>
          <?php echo htmlspecialchars($i['invoice_provinsi']); ?> - <?php echo htmlspecialchars($i['invoice_kabupaten']); ?><br>
          Hp: <?php echo htmlspecialchars($i['invoice_hp']); ?>
        </div>
        <div class="col-md-6 text-right">
          <strong>Status Pesanan:</strong><br>
          <?php 
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
          <span class="status-badge-invoice <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
        </div>
      </div>

      <br>

      <div class="table-responsive">
        <table class="table invoice-table table-bordered">
          <thead>
            <tr>
              <th class="text-center">NO</th>
              <th>Produk</th>
              <th class="text-center">Harga</th>
              <th class="text-center">Jumlah</th>
              <th class="text-center">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            $total = 0;
            $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi, produk WHERE transaksi_produk = produk_id AND transaksi_invoice='$id_invoice'");
            while($d = mysqli_fetch_array($transaksi)){
              $subtotal = $d['transaksi_jumlah'] * $d['transaksi_harga'];
              $total += $subtotal;
            ?>
            <tr>
              <td class="text-center"><?php echo $no++; ?></td>
              <td><?php echo htmlspecialchars($d['produk_nama']); ?></td>
              <td class="text-center">Rp <?php echo number_format($d['transaksi_harga']); ?></td>
              <td class="text-center"><?php echo number_format($d['transaksi_jumlah']); ?></td>
              <td class="text-center">Rp <?php echo number_format($subtotal); ?></td>
            </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr><td colspan="4" class="text-right"><strong>Total Belanja</strong></td><td class="text-center">Rp <?php echo number_format($total); ?></td></tr>
            <tr><td colspan="4" class="text-right"><strong>Ongkos Kirim (<?php echo $i['invoice_kurir']; ?>)</strong></td><td class="text-center">Rp <?php echo number_format($i['invoice_ongkir']); ?></td></tr>
            <tr style="background: #e8f5e9;"><td colspan="4" class="text-right"><strong>TOTAL BAYAR</strong></td><td class="text-center"><strong>Rp <?php echo number_format($i['invoice_total_bayar']); ?></strong></td></tr>
          </tfoot>
        </table>
      </div>

      <div class="row" style="margin-top: 30px;">
        <div class="col-md-12 text-center">
          <a href="transaksi.php" class="btn-back"><i class="fa fa-arrow-left"></i> Kembali</a>
          <a href="transaksi_invoice_cetak.php?id=<?php echo $id_invoice; ?>" target="_blank" class="btn-print"><i class="fa fa-print"></i> Cetak Invoice</a>
        </div>
      </div>
    </div>
    <?php } ?>
  </section>
</div>

<?php include 'footer.php'; ?>