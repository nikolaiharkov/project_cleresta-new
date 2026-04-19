<?php 
session_start();
include '../koneksi.php';
if(!isset($_SESSION['status']) || $_SESSION['status'] != "login"){
    exit("Akses ditolak.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Laporan Penjualan - Fresh Cart</title>
  <meta charset="utf-8">
  <style>
    @media print {
      .no-print { display: none !important; }
      body { margin: 0; padding: 0; background: white; }
      .print-container { margin: 0; padding: 15px; box-shadow: none; border: none; }
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 30px; background: #f0f2f5; }
    .print-container { max-width: 1000px; margin: 0 auto; background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid #eee; }
    .header { text-align: center; border-bottom: 3px solid #78B817; padding-bottom: 15px; margin-bottom: 25px; }
    .header h1 { color: #78B817; margin: 0; font-size: 28px; }
    .periode-box { background: #f8fafc; padding: 12px 20px; margin-bottom: 25px; border-left: 4px solid #78B817; border-radius: 8px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: left; font-size: 13px; }
    th { background: #78B817; color: white; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; }
    .total-row { background: #f0fdf4; font-weight: bold; color: #166534; }
    .footer { margin-top: 30px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; padding-top: 15px; }
    .btn-group { text-align: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 1px solid #eef2f0; }
    .btn-print { background: #78B817; color: white; border: none; padding: 10px 28px; border-radius: 40px; cursor: pointer; font-size: 14px; font-weight: 600; margin: 0 8px; transition: 0.2s; }
    .btn-print:hover { background: #5e9c12; transform: translateY(-2px); }
    .btn-close { background: #7f8c8d; color: white; border: none; padding: 10px 28px; border-radius: 40px; cursor: pointer; font-size: 14px; font-weight: 600; margin: 0 8px; transition: 0.2s; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
  </style>
</head>
<body>

<div class="print-container">
  <div class="btn-group no-print">
    <button class="btn-print" onclick="window.print();">🖨️ Cetak Sekarang</button>
    <button class="btn-close" onclick="window.close();">❌ Tutup</button>
  </div>

  <?php 
  if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari'])){
    $tgl_dari = $_GET['tanggal_dari'];
    $tgl_sampai = $_GET['tanggal_sampai'];
    $dari = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_dari)));
    $sampai = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sampai)));
  ?>
  
  <div class="header">
    <h1>🌿 FRESH CART</h1>
    <p>Laporan Rekapitulasi Penjualan</p>
  </div>

  <div class="periode-box">
    <strong>📅 Periode:</strong> <?php echo date('d F Y', strtotime($dari)); ?> - <?php echo date('d F Y', strtotime($sampai)); ?>
  </div>

  <table>
    <thead>
      <tr>
        <th class="text-center" width="5%">NO</th>
        <th>INVOICE</th>
        <th class="text-center">TANGGAL</th>
        <th>PELANGGAN</th>
        <th class="text-right">TOTAL BAYAR</th>
        <th class="text-center">STATUS</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $no=1;
      $total_pendapatan = 0;
      $query = "SELECT * FROM invoice JOIN customer ON invoice_customer = customer_id WHERE date(invoice_tanggal) >= '$dari' AND date(invoice_tanggal) <= '$sampai' ORDER BY invoice_id DESC";
      $data = mysqli_query($koneksi, $query);
      
      if(mysqli_num_rows($data) > 0){
        while($i = mysqli_fetch_array($data)){
          $total_pendapatan += $i['invoice_total_bayar'];
          $status_id = $i['invoice_status'];
          $texts = [0 => 'Menunggu Bayar', 1 => 'Menunggu Konfirmasi', 2 => 'Ditolak', 3 => 'Diproses', 4 => 'Dikirim', 5 => 'Selesai'];
          $status_text = $texts[$status_id] ?? 'Unknown';
          
          // Fallback Tanggal
          $tgl_raw = isset($i['invoice_tanggal']) ? $i['invoice_tanggal'] : (isset($i['invoice_tgl']) ? $i['invoice_tgl'] : date('Y-m-d'));
      ?>
      <tr>
        <td class="text-center"><?php echo $no++; ?></td>
        <td><strong>INV-00<?php echo $i['invoice_id']; ?></strong></td>
        <td class="text-center"><?php echo date('d/m/Y', strtotime($tgl_raw)); ?></td>
        <td><?php echo htmlspecialchars($i['customer_nama']); ?></td>
        <td class="text-right">Rp <?php echo number_format($i['invoice_total_bayar']); ?></td>
        <td class="text-center"><?php echo $status_text; ?></td>
      </tr>
      <?php 
        }
      } else {
        echo '<tr><td colspan="6" class="text-center" style="padding: 40px;">Tidak ada data pada periode ini</td></tr>';
      }
      ?>
    </tbody>
    <?php if(mysqli_num_rows($data) > 0){ ?>
    <tfoot>
      <tr class="total-row">
        <td colspan="4" class="text-right">TOTAL PENDAPATAN</td>
        <td colspan="2" class="text-right">Rp <?php echo number_format($total_pendapatan); ?></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>

  <div class="footer">
    Dicetak oleh Sistem Fresh Cart pada: <?php echo date('d/m/Y H:i:s'); ?>
  </div>
  <?php } ?>
</div>

</body>
</html>