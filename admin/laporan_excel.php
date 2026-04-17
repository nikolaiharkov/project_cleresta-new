<?php
include '../koneksi.php';

if(!isset($_GET['tanggal_sampai']) || !isset($_GET['tanggal_dari']) || $_GET['tanggal_dari'] == '' || $_GET['tanggal_sampai'] == ''){
  echo "<script>alert('Silahkan pilih periode laporan terlebih dahulu!'); window.location.href='laporan.php';</script>";
  exit;
}

$tgl_dari = $_GET['tanggal_dari'];
$tgl_sampai = $_GET['tanggal_sampai'];
$tgl_dari_format = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_dari)));
$tgl_sampai_format = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sampai)));

// Set header untuk export Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penjualan_FreshCart_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Nama file yang akan di-download
$filename = "Laporan_Penjualan_" . date('Ymd') . ".xls";
header("Content-Disposition: attachment; filename=\"$filename\"");

// Tampilkan data dalam format tabel untuk Excel
echo "<table border='1'>";
echo "<tr>";
echo "<th colspan='6' style='text-align: center; font-size: 16px; background: #78B817; color: white;'>LAPORAN PENJUALAN FRESH CART</th>";
echo "</tr>";
echo "<tr>";
echo "<th colspan='6' style='text-align: center;'>Periode: " . date('d F Y', strtotime($tgl_dari_format)) . " - " . date('d F Y', strtotime($tgl_sampai_format)) . "</th>";
echo "</tr>";
echo "<tr style='background: #78B817; color: white;'>";
echo "<th>NO</th>";
echo "<th>INVOICE</th>";
echo "<th>TANGGAL</th>";
echo "<th>PELANGGAN</th>";
echo "<th>TOTAL BAYAR</th>";
echo "<th>STATUS</th>";
echo "</tr>";

$no = 1;
$total_pendapatan = 0;
$data = mysqli_query($koneksi, "SELECT * FROM invoice, customer WHERE customer_id = invoice_customer AND date(invoice_tanggal) >= '$tgl_dari_format' AND date(invoice_tanggal) <= '$tgl_sampai_format' ORDER BY invoice_tanggal DESC");

if(mysqli_num_rows($data) > 0){
  while($i = mysqli_fetch_array($data)){
    $total_pendapatan += $i['invoice_total_bayar'];
    $status_text = '';
    switch($i['invoice_status']){
      case 0: $status_text = 'Menunggu Bayar'; break;
      case 1: $status_text = 'Menunggu Konfirmasi'; break;
      case 2: $status_text = 'Ditolak'; break;
      case 3: $status_text = 'Diproses'; break;
      case 4: $status_text = 'Dikirim'; break;
      case 5: $status_text = 'Selesai'; break;
      default: $status_text = 'Unknown';
    }
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>INV-00" . $i['invoice_id'] . "</td>";
    echo "<td>" . date('d/m/Y', strtotime($i['invoice_tanggal'])) . "</td>";
    echo "<td>" . htmlspecialchars($i['customer_nama']) . "</td>";
    echo "<td>Rp " . number_format($i['invoice_total_bayar'], 0, ',', '.') . "</td>";
    echo "<td>" . $status_text . "</td>";
    echo "</tr>";
  }
  
  // Baris Total
  echo "<tr style='background: #e8f5e9; font-weight: bold;'>";
  echo "<td colspan='4' style='text-align: right;'><strong>TOTAL PENDAPATAN</strong></td>";
  echo "<td colspan='2'><strong>Rp " . number_format($total_pendapatan, 0, ',', '.') . "</strong></td>";
  echo "</tr>";
  
} else {
  echo "<tr>";
  echo "<td colspan='6' style='text-align: center;'>Tidak ada data pada periode ini</td>";
  echo "</tr>";
}

echo "</table>";
?>