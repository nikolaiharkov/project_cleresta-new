<?php
session_start();
include '../koneksi.php';

if(!isset($_GET['tanggal_sampai']) || !isset($_GET['tanggal_dari'])){
  exit("Pilih periode!");
}

$dari = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['tanggal_dari'])));
$sampai = date('Y-m-d', strtotime(str_replace('/', '-', $_GET['tanggal_sampai'])));

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_FreshCart_".date('Ymd').".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1">
    <tr>
        <th colspan="6" style="background: #78B817; color: white; height: 30px;">LAPORAN PENJUALAN FRESH CART</th>
    </tr>
    <tr>
        <th colspan="6">Periode: <?php echo $_GET['tanggal_dari']; ?> - <?php echo $_GET['tanggal_sampai']; ?></th>
    </tr>
    <tr style="background: #78B817; color: white;">
        <th>NO</th>
        <th>INVOICE</th>
        <th>TANGGAL</th>
        <th>PELANGGAN</th>
        <th>TOTAL BAYAR</th>
        <th>STATUS</th>
    </tr>
    <?php 
    $no = 1;
    $total = 0;
    $data = mysqli_query($koneksi, "SELECT * FROM invoice JOIN customer ON invoice_customer = customer_id WHERE date(invoice_tanggal) >= '$dari' AND date(invoice_tanggal) <= '$sampai' ORDER BY invoice_id DESC");
    
    while($i = mysqli_fetch_array($data)){
        $total += $i['invoice_total_bayar'];
        $status_id = $i['invoice_status'];
        $texts = [0 => 'Menunggu Bayar', 1 => 'Menunggu Konfirmasi', 2 => 'Ditolak', 3 => 'Diproses', 4 => 'Dikirim', 5 => 'Selesai'];
        
        $tgl_raw = isset($i['invoice_tanggal']) ? $i['invoice_tanggal'] : (isset($i['invoice_tgl']) ? $i['invoice_tgl'] : date('Y-m-d'));
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td>INV-00<?php echo $i['invoice_id']; ?></td>
        <td><?php echo date('d/m/Y', strtotime($tgl_raw)); ?></td>
        <td><?php echo $i['customer_nama']; ?></td>
        <td><?php echo $i['invoice_total_bayar']; ?></td>
        <td><?php echo $texts[$status_id] ?? 'Unknown'; ?></td>
    </tr>
    <?php } ?>
    <tr style="background: #e8f5e9; font-weight: bold;">
        <td colspan="4" align="right">TOTAL PENDAPATAN</td>
        <td colspan="2"><?php echo $total; ?></td>
    </tr>
</table>