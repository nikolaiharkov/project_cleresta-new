<?php include 'header.php'; ?>
<style>
.invoice-container { background: white; border-radius: 20px; padding: 30px; margin: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eef2f0; }
.invoice-header { border-bottom: 2px solid #78B817; padding-bottom: 15px; margin-bottom: 20px; }
.invoice-title { color: #78B817; font-weight: 700; margin: 0; }
.invoice-table th, .invoice-table td { padding: 15px 12px; vertical-align: middle; }
.invoice-table th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; }
.status-badge-invoice { display: inline-block; padding: 6px 15px; border-radius: 50px; font-size: 12px; font-weight: 600; min-width: 140px; text-align: center; }
.status-0 { background: #fff3e0; color: #e65100; }
.status-1 { background: #e3f2fd; color: #1565c0; }
.status-2 { background: #fee8e8; color: #c62828; }
.status-3 { background: #e8f0fe; color: #2c3e50; }
.status-4 { background: #f3e5f5; color: #6a1b9a; }
.status-5 { background: #e8f5e9; color: #2e7d32; }
.btn-print { background: #78B817; color: white; padding: 10px 25px; border-radius: 40px; border: none; text-decoration: none; display: inline-block; font-weight: 600; transition: 0.3s; }
.btn-print:hover { background: #5e9c12; color: white; box-shadow: 0 4px 12px rgba(120,184,23,0.3); }
.btn-back { background: #f1f5f9; color: #64748b; padding: 10px 25px; border-radius: 40px; border: none; text-decoration: none; display: inline-block; font-weight: 600; margin-right: 10px; transition: 0.3s; }
.btn-back:hover { background: #e2e8f0; color: #334155; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-file-text-o" style="color: #78B817;"></i> Detail Invoice</h1>
    <small>Kelola rincian pesanan pelanggan</small>
  </section>

  <section class="content">
    <?php 
    include '../koneksi.php';
    $id_invoice = mysqli_real_escape_string($koneksi, $_GET['id']);
    $invoice = mysqli_query($koneksi, "SELECT * FROM invoice WHERE invoice_id='$id_invoice'");
    
    // Jika data tidak ditemukan
    if(mysqli_num_rows($invoice) == 0){
        echo "<div class='alert alert-danger'>Invoice tidak ditemukan.</div>";
    }

    while($i = mysqli_fetch_array($invoice)){
    ?>
    <div class="invoice-container">
      <div class="invoice-header">
        <div class="row">
          <div class="col-md-6">
            <h3 class="invoice-title"><i class="fa fa-leaf"></i> FRESH CART</h3>
            <p style="margin-top: 10px; color: #7f8c8d;">
                <strong>Penyedia Bahan Pangan Segar</strong><br>
                Jl. Raya Fresh Cart No. 123, Jakarta<br>
                Telp: (021) 1234567 | support@freshcart.com
            </p>
          </div>
          <div class="col-md-6 text-right">
            <h2 style="margin: 0; color: #2c3e50; font-weight: 800;">INVOICE</h2>
            <h4 style="color: #78B817; margin: 5px 0;">#INV-00<?php echo $i['invoice_id']; ?></h4>
            <p class="text-muted">
                Tanggal Pesan: <?php echo date('d/m/Y', strtotime($i['invoice_tgl'])); ?>
            </p>
          </div>
        </div>
      </div>

      <div class="row" style="margin-bottom: 30px;">
        <div class="col-md-6">
          <h5 style="font-weight: 700; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px;">Informasi Pengiriman:</h5>
          <div style="background: #f8fafc; padding: 15px; border-radius: 12px; border-left: 4px solid #78B817;">
              <strong><?php echo htmlspecialchars($i['invoice_nama']); ?></strong><br>
              <?php echo htmlspecialchars($i['invoice_alamat']); ?><br>
              <?php echo htmlspecialchars($i['invoice_kabupaten']); ?>, <?php echo htmlspecialchars($i['invoice_provinsi']); ?><br>
              <i class="fa fa-phone"></i> <?php echo htmlspecialchars($i['invoice_hp']); ?>
          </div>
        </div>
        <div class="col-md-6 text-right">
          <h5 style="font-weight: 700; color: #2c3e50; text-transform: uppercase; letter-spacing: 1px;">Status Pesanan:</h5>
          <?php 
          $status_id = $i['invoice_status'];
          $status_class = "status-$status_id";
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
          <span class="status-badge-invoice <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
          <p style="margin-top: 10px; color: #7f8c8d;">Metode Kirim: <strong><?php echo strtoupper($i['invoice_kurir']); ?></strong></p>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table invoice-table table-bordered">
          <thead>
            <tr>
              <th class="text-center" width="1%">NO</th>
              <th>PRODUK</th>
              <th class="text-center">HARGA SATUAN</th>
              <th class="text-center">QTY</th>
              <th class="text-center">SUBTOTAL</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $no = 1;
            $total_belanja_produk = 0;
            $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi JOIN produk ON transaksi_produk = produk_id WHERE transaksi_invoice='$id_invoice'");
            while($d = mysqli_fetch_array($transaksi)){
              $subtotal = $d['transaksi_jumlah'] * $d['transaksi_harga'];
              $total_belanja_produk += $subtotal;
            ?>
            <tr>
              <td class="text-center"><?php echo $no++; ?></td>
              <td><strong><?php echo htmlspecialchars($d['produk_nama']); ?></strong></td>
              <td class="text-center">Rp <?php echo number_format($d['transaksi_harga']); ?></td>
              <td class="text-center"><?php echo number_format($d['transaksi_jumlah']); ?></td>
              <td class="text-center">Rp <?php echo number_format($subtotal); ?></td>
            </tr>
            <?php } ?>
          </tbody>
          <tfoot>
            <tr>
                <td colspan="4" class="text-right" style="border:none"><strong>Total Harga Produk</strong></td>
                <td class="text-center">Rp <?php echo number_format($total_belanja_produk); ?></td>
            </tr>
            <tr>
                <td colspan="4" class="text-right" style="border:none"><strong>Ongkos Kirim (<?php echo strtoupper($i['invoice_kurir']); ?>)</strong></td>
                <td class="text-center">Rp <?php echo number_format($i['invoice_ongkir']); ?></td>
            </tr>
            <tr style="background: #f0fdf4; border-top: 2px solid #78B817;">
                <td colspan="4" class="text-right" style="border:none"><strong>GRAND TOTAL</strong></td>
                <td class="text-center"><h4 style="margin:0; font-weight:800; color:#166534;">Rp <?php echo number_format($i['invoice_total_bayar']); ?></h4></td>
            </tr>
          </tfoot>
        </table>
      </div>

      <div class="row" style="margin-top: 40px;">
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