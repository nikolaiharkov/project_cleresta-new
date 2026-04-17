<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; }
.btn-green:hover { background: #5e9c12; transform: translateY(-1px); }
.btn-pdf { background: #e74c3c; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; }
.btn-pdf:hover { background: #c0392b; color: white; }
.btn-print { background: #3498db; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; }
.btn-print:hover { background: #2980b9; color: white; }
.btn-excel { background: #27ae60; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; }
.btn-excel:hover { background: #1e8449; color: white; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.content-header h1 { font-size: 24px; font-weight: 600; color: #2c3e50; }
.content-header small { color: #7f8c8d; font-size: 13px; }
.filter-card { background: white; border-radius: 20px; padding: 20px; margin-bottom: 20px; border: 1px solid #eef2f0; }
.filter-label { font-weight: 600; margin-bottom: 8px; display: block; color: #2c3e50; }
.form-control-modern { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; width: 100%; transition: all 0.2s; }
.form-control-modern:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
.datepicker2 { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; width: 100%; }
.info-box { background: #e8f5e9; border-left: 4px solid #78B817; padding: 15px 20px; border-radius: 16px; margin-bottom: 20px; }
.total-box { background: linear-gradient(135deg, #78B817, #669e12); color: white; padding: 15px 25px; border-radius: 20px; display: inline-block; margin-bottom: 20px; }
.total-box h4 { margin: 0; font-size: 24px; }
.total-box p { margin: 0; opacity: 0.9; }
.status-badge { display: inline-block; padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; }
.status-completed { background: #e8f5e9; color: #2e7d32; }
.status-processing { background: #e3f2fd; color: #1565c0; }
.status-pending { background: #fff3e0; color: #e65100; }
.status-cancelled { background: #fee8e8; color: #c62828; }
.btn-group-export { display: flex; gap: 10px; flex-wrap: wrap; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-file-text-o" style="color: #78B817;"></i> Laporan Penjualan</h1>
    <small>Data laporan penjualan dan transaksi</small>
    <ol class="breadcrumb" style="background: transparent; padding-left: 0;">
      <li><a href="index.php" style="color: #78B817;"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Laporan Penjualan</li>
    </ol>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="filter-card">
      <h4 style="margin-top: 0; margin-bottom: 20px;"><i class="fa fa-filter" style="color: #78B817;"></i> Filter Laporan</h4>
      <form method="get" action="" id="filterForm">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="filter-label">Dari Tanggal</label>
              <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_dari'])){echo $_GET['tanggal_dari'];} ?>" name="tanggal_dari" class="datepicker2" placeholder="DD/MM/YYYY" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="filter-label">Sampai Tanggal</label>
              <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_sampai'])){echo $_GET['tanggal_sampai'];} ?>" name="tanggal_sampai" class="datepicker2" placeholder="DD/MM/YYYY" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="filter-label">&nbsp;</label>
              <button type="submit" class="btn-green" style="width: 100%;"><i class="fa fa-search"></i> Tampilkan Laporan</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <?php 
    if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari']) && $_GET['tanggal_dari'] != '' && $_GET['tanggal_sampai'] != ''){
      $tgl_dari = mysqli_real_escape_string($koneksi, $_GET['tanggal_dari']);
      $tgl_sampai = mysqli_real_escape_string($koneksi, $_GET['tanggal_sampai']);
      
      $tgl_dari_format = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_dari)));
      $tgl_sampai_format = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sampai)));
      
      $query = "SELECT * FROM invoice, customer WHERE customer_id = invoice_customer AND date(invoice_tanggal) >= '$tgl_dari_format' AND date(invoice_tanggal) <= '$tgl_sampai_format' ORDER BY invoice_tanggal DESC";
      $data = mysqli_query($koneksi, $query);
      
      // Hitung total pendapatan
      $total_pendapatan = 0;
      $temp_data = mysqli_query($koneksi, $query);
      while($row = mysqli_fetch_array($temp_data)){
        $total_pendapatan += $row['invoice_total_bayar'];
      }
    ?>
    
    <div class="box-modern">
      <div class="box-header" style="padding: 18px 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-chart-line"></i> Hasil Laporan</h3>
        <div class="btn-group-export pull-right">
          <a href="laporan_excel.php?tanggal_dari=<?php echo $tgl_dari; ?>&tanggal_sampai=<?php echo $tgl_sampai; ?>" class="btn-excel" target="_blank">
            <i class="fa fa-file-excel-o"></i> Export ke Excel
          </a>
          <a href="laporan_pdf.php?tanggal_dari=<?php echo $tgl_dari; ?>&tanggal_sampai=<?php echo $tgl_sampai; ?>" target="_blank" class="btn-pdf">
            <i class="fa fa-file-pdf-o"></i> PDF
          </a>
          <a href="laporan_print.php?tanggal_dari=<?php echo $tgl_dari; ?>&tanggal_sampai=<?php echo $tgl_sampai; ?>" target="_blank" class="btn-print">
            <i class="fa fa-print"></i> Print
          </a>
        </div>
      </div>
      <div class="box-body" style="padding: 20px;">
        
        <div class="row">
          <div class="col-md-6">
            <div class="info-box">
              <i class="fa fa-calendar" style="font-size: 18px; margin-right: 10px;"></i>
              <strong>Periode Laporan:</strong><br>
              <?php echo date('d F Y', strtotime($tgl_dari_format)); ?> - <?php echo date('d F Y', strtotime($tgl_sampai_format)); ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="total-box" style="float: right;">
              <p><i class="fa fa-money"></i> Total Pendapatan</p>
              <h4>Rp <?php echo number_format($total_pendapatan, 0, ',', '.'); ?></h4>
            </div>
          </div>
        </div>
        
        <div class="table-responsive">
          <table class="table table-custom table-bordered table-striped" id="table-datatable">
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
              $data = mysqli_query($koneksi, $query);
              if(mysqli_num_rows($data) > 0){
                while($i = mysqli_fetch_array($data)){
                  $status_class = '';
                  $status_text = '';
                  switch($i['invoice_status']){
                    case 0: $status_class = 'status-pending'; $status_text = 'Menunggu Bayar'; break;
                    case 1: $status_class = 'status-pending'; $status_text = 'Menunggu Konfirmasi'; break;
                    case 2: $status_class = 'status-cancelled'; $status_text = 'Ditolak'; break;
                    case 3: $status_class = 'status-processing'; $status_text = 'Diproses'; break;
                    case 4: $status_class = 'status-processing'; $status_text = 'Dikirim'; break;
                    case 5: $status_class = 'status-completed'; $status_text = 'Selesai'; break;
                    default: $status_class = 'status-pending'; $status_text = 'Unknown';
                  }
              ?>
              <tr>
                <td><?php echo $no++; ?></td>
                <td><strong>INV-00<?php echo $i['invoice_id']; ?></strong></td>
                <td><?php echo date('d/m/Y', strtotime($i['invoice_tanggal'])); ?></span></td>
                <td><?php echo htmlspecialchars($i['customer_nama']); ?></td>
                <td>Rp <?php echo number_format($i['invoice_total_bayar'], 0, ',', '.'); ?> </span></span></td>
                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></span></td>
              </tr>
              <?php 
                }
              } else {
                echo '<tr><td colspan="6" class="text-center">Tidak ada data pada periode ini</span></td></tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <?php } else { ?>
      <div class="box-modern">
        <div class="box-body" style="padding: 40px; text-align: center;">
          <i class="fa fa-calendar" style="font-size: 48px; color: #78B817; opacity: 0.5;"></i>
          <h4 style="margin-top: 15px; color: #7f8c8d;">Silahkan Pilih Periode Laporan</h4>
          <p class="text-muted">Pilih tanggal mulai dan selesai untuk melihat laporan penjualan</p>
        </div>
      </div>
    <?php } ?>
    
  </section>
</div>

<script>
$(function() {
  $('.datepicker2').datepicker({
    autoclose: true,
    format: 'dd/mm/yyyy',
    todayHighlight: true
  });
});
</script>

<?php include 'footer.php'; ?>