<?php 
session_start();
include '../koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Invoice Fresh Cart</title>
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; }
    .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; border-radius: 20px; }
    .invoice-header { border-bottom: 2px solid #78B817; padding-bottom: 15px; margin-bottom: 20px; }
    .invoice-title { color: #78B817; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #f5f5f5; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .total-row { background: #e8f5e9; font-weight: bold; }
    .status-badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; }
    .status-0 { background: #fff3e0; color: #e65100; }
    .status-1 { background: #e3f2fd; color: #1565c0; }
    .status-2 { background: #fee8e8; color: #c62828; }
    .status-3 { background: #e8f0fe; color: #2c3e50; }
    .status-4 { background: #f3e5f5; color: #6a1b9a; }
    .status-5 { background: #e8f5e9; color: #2e7d32; }
  </style>
</head>
<body>
  <?php 
  $id_invoice = $_GET['id'];
  $invoice = mysqli_query($koneksi, "SELECT * FROM invoice WHERE invoice_id='$id_invoice'");
  while($i = mysqli_fetch_array($invoice)){
  ?>
  <div class="invoice-box">
    <div class="invoice-header">
      <div style="float: left;">
        <h2 class="invoice-title"><i class="fa fa-leaf"></i> Fresh Cart</h2>
        <p>Jl. Raya Fresh Cart No. 123<br>Telp: (021) 1234567</p>
      </div>
      <div style="float: right; text-align: right;">
        <h3>INVOICE</h3>
        <h4>INVOICE-00<?php echo $i['invoice_id']; ?></h4>
        <p>Tanggal: <?php echo date('d/m/Y', strtotime($i['invoice_tanggal'])); ?></p>
      </div>
      <div style="clear: both;"></div>
    </div>

    <div>
      <div style="float: left; width: 50%;">
        <strong>Kepada Yth:</strong><br>
        <?php echo htmlspecialchars($i['invoice_nama']); ?><br>
        <?php echo htmlspecialchars($i['invoice_alamat']); ?><br>
        <?php echo htmlspecialchars($i['invoice_provinsi']); ?> - <?php echo htmlspecialchars($i['invoice_kabupaten']); ?><br>
        Hp: <?php echo htmlspecialchars($i['invoice_hp']); ?>
      </div>
      <div style="float: right; width: 50%; text-align: right;">
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
        }
        ?>
        <span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span>
      </div>
      <div style="clear: both;"></div>
    </div>

    <table>
      <thead>
        <tr><th>No</th><th>Produk</th><th class="text-center">Harga</th><th class="text-center">Jumlah</th><th class="text-right">Subtotal</th></tr>
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
        <tr><td class="text-center"><?php echo $no++; ?></td><td><?php echo htmlspecialchars($d['produk_nama']); ?></td><td class="text-center">Rp <?php echo number_format($d['transaksi_harga']); ?></td><td class="text-center"><?php echo number_format($d['transaksi_jumlah']); ?></td><td class="text-right">Rp <?php echo number_format($subtotal); ?></td></tr>
        <?php } ?>
      </tbody>
    </table>

    <table style="margin-top: 10px; width: 300px; float: right;">
      <tr><td class="text-right">Total Belanja</td><td class="text-right">Rp <?php echo number_format($total); ?></td></tr>
      <tr><td class="text-right">Ongkos Kirim (<?php echo $i['invoice_kurir']; ?>)</td><td class="text-right">Rp <?php echo number_format($i['invoice_ongkir']); ?></td></tr>
      <tr class="total-row"><td class="text-right">TOTAL BAYAR</td><td class="text-right">Rp <?php echo number_format($i['invoice_total_bayar']); ?></td></tr>
    </table>
    <div style="clear: both;"></div>
    
    <div style="text-align: center; margin-top: 40px; font-size: 12px; color: #999;">
      Terima kasih telah berbelanja di Fresh Cart
    </div>
  </div>
  <?php } ?>
  <script>window.print();</script>
</body>
</html>