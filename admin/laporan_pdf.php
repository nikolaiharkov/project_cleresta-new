<?php 
session_start();
include '../koneksi.php';
if(!isset($_GET['tanggal_dari']) || !isset($_GET['tanggal_sampai'])) exit;

$dari = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['tanggal_dari'])));
$sampai = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['tanggal_sampai'])));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Laporan PDF - Fresh Cart</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: Arial, sans-serif; padding: 40px; line-height: 1.6; }
    .header { text-align: center; border-bottom: 2px solid #78B817; padding-bottom: 10px; margin-bottom: 20px; }
    h1 { color: #78B817; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; font-size: 12px; }
    th { background: #78B817; color: white; }
    .text-right { text-align: right; }
    .text-center { text-align: center; }
    .total { background: #f0fdf4; font-weight: bold; }
    .no-print { text-align: center; margin-bottom: 20px; }
    @media print { .no-print { display: none; } }
  </style>
</head>
<body>

<div class="no-print">
    <button onclick="window.print()" style="padding: 10px 20px; background: #78B817; color: white; border: none; border-radius: 5px; cursor: pointer;">Cetak / Simpan PDF</button>
</div>

<div class="header">
    <h1>FRESH CART</h1>
    <p>Laporan Penjualan Produk Bahan Pangan</p>
    <p>Periode: <?php echo $_GET['tanggal_dari']; ?> s/d <?php echo $_GET['tanggal_sampai']; ?></p>
</div>

<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>INVOICE</th>
            <th>TANGGAL</th>
            <th>PELANGGAN</th>
            <th>STATUS</th>
            <th>TOTAL BAYAR</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        $total = 0;
        $data = mysqli_query($koneksi, "SELECT * FROM invoice JOIN customer ON invoice_customer = customer_id WHERE date(invoice_tanggal) >= '$dari' AND date(invoice_tanggal) <= '$sampai' ORDER BY invoice_id DESC");
        while($i = mysqli_fetch_array($data)){
            $total += $i['invoice_total_bayar'];
            $tgl_raw = isset($i['invoice_tanggal']) ? $i['invoice_tanggal'] : (isset($i['invoice_tgl']) ? $i['invoice_tgl'] : date('Y-m-d'));
            $st = [0 => 'Pending', 1 => 'Konfirmasi', 2 => 'Ditolak', 3 => 'Proses', 4 => 'Kirim', 5 => 'Selesai'];
        ?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td class="text-center">INV-<?php echo $i['invoice_id']; ?></td>
            <td class="text-center"><?php echo date('d/m/Y', strtotime($tgl_raw)); ?></td>
            <td><?php echo $i['customer_nama']; ?></td>
            <td class="text-center"><?php echo $st[$i['invoice_status']]; ?></td>
            <td class="text-right">Rp <?php echo number_format($i['invoice_total_bayar']); ?></td>
        </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr class="total">
            <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
            <td class="text-right">Rp <?php echo number_format($total); ?></td>
        </tr>
    </tfoot>
</table>

<div style="margin-top: 30px; font-size: 10px; color: #888; text-align: center;">
    Laporan ini dibuat otomatis oleh sistem Fresh Cart.
</div>

</body>
</html>