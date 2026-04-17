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

// Set header untuk CSV
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=Laporan_Penjualan_FreshCart_" . date('Y-m-d') . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

// Buka output stream
$output = fopen('php://output', 'w');

// Tambahkan BOM untuk UTF-8 (agar kompatibel dengan Excel/Google Sheets)
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Header CSV
fputcsv($output, ['LAPORAN PENJUALAN FRESH CART']);
fputcsv($output, ['Periode: ' . date('d F Y', strtotime($tgl_dari_format)) . ' - ' . date('d F Y', strtotime($tgl_sampai_format))]);
fputcsv($output, []); // Baris kosong
fputcsv($output, ['NO', 'INVOICE', 'TANGGAL', 'PELANGGAN', 'TOTAL BAYAR', 'STATUS']);

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
    fputcsv($output, [
      $no++,
      'INV-00' . $i['invoice_id'],
      date('d/m/Y', strtotime($i['invoice_tanggal'])),
      $i['customer_nama'],
      'Rp ' . number_format($i['invoice_total_bayar'], 0, ',', '.'),
      $status_text
    ]);
  }
  
  // Baris Total
  fputcsv($output, []);
  fputcsv($output, ['TOTAL PENDAPATAN', '', '', '', 'Rp ' . number_format($total_pendapatan, 0, ',', '.'), '']);
  
} else {
  fputcsv($output, ['Tidak ada data pada periode ini']);
}

fclose($output);
?>