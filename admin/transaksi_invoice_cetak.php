<?php 
session_start();
include '../koneksi.php';

// Proteksi akses admin
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    exit("Akses ditolak.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Cetak Invoice - Fresh Cart</title>
  <style>
    body { 
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
        padding: 10px; 
        color: #333;
        font-size: 13px;
    }
    .invoice-box { 
        max-width: 800px; 
        margin: auto; 
        padding: 30px; 
        border: 1px solid #eee; 
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
    }
    .invoice-header { 
        border-bottom: 2px solid #78B817; 
        padding-bottom: 20px; 
        margin-bottom: 20px; 
    }
    .invoice-title { 
        color: #78B817; 
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    table { 
        width: 100%; 
        border-collapse: collapse; 
        margin-top: 20px; 
    }
    th, td { 
        padding: 12px; 
        border-bottom: 1px solid #eee; 
        text-align: left; 
    }
    th { 
        background: #f9fafb; 
        color: #666;
        text-transform: uppercase;
        font-size: 11px;
    }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .total-row { 
        background: #f0fdf4; 
        font-weight: bold; 
        color: #166534;
    }
    .status-badge { 
        display: inline-block; 
        padding: 4px 12px; 
        border-radius: 20px; 
        font-size: 11px; 
        font-weight: 600;
    }
    .status-0 { background: #fff3e0; color: #e65100; }
    .status-1 { background: #e3f2fd; color: #1565c0; }
    .status-2 { background: #fee8e8; color: #c62828; }
    .status-3 { background: #e8f0fe; color: #2c3e50; }
    .status-4 { background: #f3e5f5; color: #6a1b9a; }
    .status-5 { background: #e8f5e9; color: #2e7d32; }

    @media print {
        .invoice-box { border: none; box-shadow: none; }
        body { padding: 0; }
    }
  </style>
</head>
<body>
  <?php 
  $id_invoice = mysqli_real_escape_string($koneksi, $_GET['id']);
  $invoice = mysqli_query($koneksi, "SELECT * FROM invoice WHERE invoice_id='$id_invoice'");
  while($i = mysqli_fetch_array($invoice)){
  ?>
  <div class="invoice-box">
    <div class="invoice-header">
      <div style="float: left;">
        <h2 class="invoice-title">FRESH CART</h2>
        <p style="margin: 5px 0;"><strong>Bahan Pangan Segar & Organik</strong><br>
        Jl. Raya Fresh Cart No. 123, Jakarta<br>
        Telp: (021) 1234567 | support@freshcart.com</p>
      </div>
      <div style="float: right; text-align: right;">
        <h2 style="margin: 0; color: #444;">INVOICE</h2>
        <h4 style="margin: 5px 0; color: #78B817;">#INV-00<?php echo $i['invoice_id']; ?></h4>
<p style="margin: 0; color: #888;">Tanggal: 
    <?php 
    // Cek apakah kolomnya bernama invoice_tgl atau invoice_tanggal
    $tanggal = isset($i['invoice_tgl']) ? $i['invoice_tgl'] : (isset($i['invoice_tanggal']) ? $i['invoice_tanggal'] : date('Y-m-d'));
    echo date('d/m/Y', strtotime($tanggal)); 
    ?>
</p>      </div>
      <div style="clear: both;"></div>
    </div>

    <div>
      <div style="float: left; width: 50%;">
        <p style="margin-bottom: 5px; color: #888; font-size: 11px; text-transform: uppercase;">Dikirim Ke:</p>
        <strong><?php echo htmlspecialchars($i['invoice_nama']); ?></strong><br>
        <?php echo htmlspecialchars($i['invoice_alamat']); ?><br>
        <?php echo htmlspecialchars($i['invoice_kabupaten']); ?>, <?php echo htmlspecialchars($i['invoice_provinsi']); ?><br>
        Telp: <?php echo htmlspecialchars($i['invoice_hp']); ?>
      </div>
      <div style="float: right; width: 50%; text-align: right;">
        <p style="margin-bottom: 5px; color: #888; font-size: 11px; text-transform: uppercase;">Status Pesanan:</p>
        <?php 
        $status_id = $i['invoice_status'];
        $texts = [0 => 'Menunggu Pembayaran', 1 => 'Menunggu Konfirmasi', 2 => 'Ditolak', 3 => 'Diproses', 4 => 'Dikirim', 5 => 'Selesai'];
        $status_text = $texts[$status_id] ?? 'Unknown';
        ?>
        <span class="status-badge status-<?php echo $status_id; ?>"><?php echo $status_text; ?></span>
        <p style="margin-top: 10px; color: #888;">Metode Pengiriman: <br><strong><?php echo strtoupper($i['invoice_kurir']); ?></strong></p>
      </div>
      <div style="clear: both;"></div>
    </div>

    <table>
      <thead>
        <tr>
            <th class="text-center" width="1%">No</th>
            <th>Nama Produk</th>
            <th class="text-center">Harga</th>
            <th class="text-center">Jumlah</th>
            <th class="text-right">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        $total_belanja = 0;
        $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi JOIN produk ON transaksi_produk = produk_id WHERE transaksi_invoice='$id_invoice'");
        while($d = mysqli_fetch_array($transaksi)){
          $subtotal = $d['transaksi_jumlah'] * $d['transaksi_harga'];
          $total_belanja += $subtotal;
        ?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><strong><?php echo htmlspecialchars($d['produk_nama']); ?></strong></td>
            <td class="text-center">Rp <?php echo number_format($d['transaksi_harga']); ?></td>
            <td class="text-center"><?php echo number_format($d['transaksi_jumlah']); ?></td>
            <td class="text-right">Rp <?php echo number_format($subtotal); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

    <div style="margin-top: 20px;">
        <table style="width: 350px; float: right; margin-top: 0;">
          <tr>
            <td class="text-right" style="border:none">Total Harga Produk</td>
            <td class="text-right" style="border:none">Rp <?php echo number_format($total_belanja); ?></td>
          </tr>
          <tr>
            <td class="text-right" style="border:none">Ongkos Kirim (<?php echo strtoupper($i['invoice_kurir']); ?>)</td>
            <td class="text-right" style="border:none">Rp <?php echo number_format($i['invoice_ongkir']); ?></td>
          </tr>
          <tr class="total-row">
            <td class="text-right" style="border:none; font-size: 15px;">TOTAL BAYAR</td>
            <td class="text-right" style="border:none; font-size: 15px;">Rp <?php echo number_format($i['invoice_total_bayar']); ?></td>
          </tr>
        </table>
    </div>
    <div style="clear: both;"></div>
    
    <div style="text-align: center; margin-top: 60px; padding-top: 20px; border-top: 1px dashed #ddd; font-size: 12px; color: #888;">
      Invoice ini adalah bukti pembayaran yang sah.<br>
      <strong>Terima kasih telah mempercayai kesegaran dapur Anda pada Fresh Cart!</strong>
    </div>
  </div>
  <?php } ?>

  <script>
    window.print();
    // Menutup jendela otomatis setelah print (opsional)
    // window.onafterprint = function() { window.close(); };
  </script>
</body>
</html>