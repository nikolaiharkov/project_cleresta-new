<!DOCTYPE html>
<html>
<head>
  <title>Laporan Penjualan - Fresh Cart</title>
  <meta charset="utf-8">
  <style>
    @media print {
      .no-print { display: none !important; }
      body { margin: 0; padding: 0; }
      .print-container { margin: 0; padding: 15px; box-shadow: none; }
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 30px;
      background: #f0f2f5;
    }
    .print-container {
      max-width: 1000px;
      margin: 0 auto;
      background: white;
      border-radius: 20px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .header {
      text-align: center;
      border-bottom: 3px solid #78B817;
      padding-bottom: 15px;
      margin-bottom: 25px;
    }
    .header h1 {
      color: #78B817;
      margin: 0;
      font-size: 28px;
    }
    .header p {
      color: #666;
      margin: 5px 0 0;
    }
    .periode-box {
      background: #f8fafc;
      padding: 12px 20px;
      margin-bottom: 25px;
      border-left: 4px solid #78B817;
      border-radius: 8px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #78B817;
      color: white;
      font-weight: 600;
    }
    .total-row {
      background: #e8f5e9;
      font-weight: bold;
    }
    .footer {
      margin-top: 30px;
      text-align: center;
      font-size: 11px;
      color: #999;
      border-top: 1px solid #eee;
      padding-top: 15px;
    }
    .btn-group {
      text-align: center;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eef2f0;
    }
    .btn-print {
      background: #78B817;
      color: white;
      border: none;
      padding: 10px 28px;
      border-radius: 40px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      margin: 0 8px;
      transition: all 0.2s;
    }
    .btn-print:hover {
      background: #5e9c12;
      transform: translateY(-2px);
    }
    .btn-close {
      background: #7f8c8d;
      color: white;
      border: none;
      padding: 10px 28px;
      border-radius: 40px;
      cursor: pointer;
      font-size: 14px;
      font-weight: 600;
      margin: 0 8px;
      transition: all 0.2s;
    }
    .btn-close:hover {
      background: #6c7a7e;
      transform: translateY(-2px);
    }
    .text-right {
      text-align: right;
    }
    .text-center {
      text-align: center;
    }
  </style>
</head>
<body>

<div class="print-container">
  
  <!-- Tombol Aksi (Tidak muncul saat print) -->
  <div class="btn-group no-print">
    <button class="btn-print" onclick="window.print();">
      <i class="fa fa-print"></i> 🖨️ Cetak / Print
    </button>
    <button class="btn-close" onclick="window.close();">
      <i class="fa fa-times"></i> ❌ Tutup Halaman
    </button>
  </div>

  <?php 
  include '../koneksi.php';
  if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari']) && $_GET['tanggal_dari'] != '' && $_GET['tanggal_sampai'] != ''){
    $tgl_dari = $_GET['tanggal_dari'];
    $tgl_sampai = $_GET['tanggal_sampai'];
    $tgl_dari_format = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_dari)));
    $tgl_sampai_format = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sampai)));
  ?>
  
  <div class="header">
    <h1>🌿 Fresh Cart</h1>
    <p>Laporan Penjualan</p>
  </div>

  <div class="periode-box">
    <strong>📅 Periode Laporan:</strong> <?php echo date('d F Y', strtotime($tgl_dari_format)); ?> - <?php echo date('d F Y', strtotime($tgl_sampai_format)); ?>
  </div>

  <table cellspacing="0">
    <thead>
      <tr>
        <th width="5%">NO</th>
        <th>INVOICE</th>
        <th>TANGGAL</th>
        <th>PELANGGAN</th>
        <th>TOTAL BAYAR</th>
        <th>STATUS</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $no=1;
      $total_pendapatan = 0;
      $data = mysqli_query($koneksi, "SELECT * FROM invoice, customer WHERE customer_id = invoice_customer AND date(invoice_tanggal) >= '$tgl_dari_format' AND date(invoice_tanggal) <= '$tgl_sampai_format' ORDER BY invoice_tanggal DESC");
      
      if(mysqli_num_rows($data) > 0){
        while($i = mysqli_fetch_array($data)){
          $total_pendapatan += $i['invoice_total_bayar'];
          $status_text = '';
          $status_class = '';
          switch($i['invoice_status']){
            case 0: $status_text = 'Menunggu Bayar'; break;
            case 1: $status_text = 'Menunggu Konfirmasi'; break;
            case 2: $status_text = 'Ditolak'; break;
            case 3: $status_text = 'Diproses'; break;
            case 4: $status_text = 'Dikirim'; break;
            case 5: $status_text = 'Selesai'; break;
            default: $status_text = 'Unknown';
          }
      ?>
      <tr>
        <td><?php echo $no++; ?></td>
        <td><strong>INV-00<?php echo $i['invoice_id']; ?></strong></td>
        <td><?php echo date('d/m/Y', strtotime($i['invoice_tanggal'])); ?></td>
        <td><?php echo htmlspecialchars($i['customer_nama']); ?></td>
        <td>Rp <?php echo number_format($i['invoice_total_bayar'], 0, ',', '.'); ?></td>
        <td><?php echo $status_text; ?></td>
      </tr>
      <?php 
        }
      } else {
        echo '<tr><td colspan="6" class="text-center" style="padding: 40px;">📊 Tidak ada data pada periode ini</td></tr>';
      }
      ?>
    </tbody>
    <?php if(mysqli_num_rows($data) > 0){ ?>
    <tfoot>
      <tr class="total-row">
        <td colspan="4" class="text-right"><strong>TOTAL PENDAPATAN</strong></td>
        <td colspan="2"><strong>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></strong></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>

  <div class="footer">
    Dicetak pada: <?php echo date('d F Y H:i:s'); ?><br>
    &copy; <?php echo date('Y'); ?> Fresh Cart - All Rights Reserved
  </div>

  <?php 
  } else { 
    echo '<div style="text-align: center; padding: 50px;">
            <h3>⚠️ Silahkan Filter Laporan Terlebih Dulu</h3>
            <p style="margin-top: 10px;">Pilih tanggal mulai dan selesai untuk melihat laporan.</p>
            <div class="no-print" style="margin-top: 20px;">
              <button class="btn-close" onclick="window.location.href=\'laporan.php\';">Kembali ke Laporan</button>
            </div>
          </div>';
  } 
  ?>
  
</div>

<script>
  // Fungsi untuk menutup jendela dengan konfirmasi
  function closeWindow() {
    if(confirm('Apakah Anda yakin ingin menutup halaman ini?')) {
      window.close();
    }
  }
  
  // Shortcut Ctrl+P untuk print
  document.addEventListener('keydown', function(e) {
    if((e.ctrlKey || e.metaKey) && e.key === 'p') {
      e.preventDefault();
      window.print();
    }
  });
</script>

</body>
</html>