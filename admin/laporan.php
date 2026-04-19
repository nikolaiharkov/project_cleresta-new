<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; font-weight: 600; }
.btn-green:hover { background: #5e9c12; transform: translateY(-1px); }
.btn-pdf { background: #e74c3c; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; font-weight: 600; }
.btn-pdf:hover { background: #c0392b; color: white; }
.btn-print { background: #3498db; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; font-weight: 600; }
.btn-print:hover { background: #2980b9; color: white; }
.btn-excel { background: #27ae60; color: white; border: none; padding: 8px 22px; border-radius: 40px; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-block; font-weight: 600; }
.btn-excel:hover { background: #1e8449; color: white; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.filter-card { background: white; border-radius: 20px; padding: 25px; margin-bottom: 20px; border: 1px solid #eef2f0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); }
.filter-label { font-weight: 600; margin-bottom: 8px; display: block; color: #2c3e50; }
.datepicker2 { border: 1.5px solid #e2e8f0; border-radius: 12px; padding: 10px 16px; width: 100%; transition: 0.2s; }
.datepicker2:focus { border-color: #78B817; outline: none; box-shadow: 0 0 0 3px rgba(120,184,23,0.1); }
.total-box { background: linear-gradient(135deg, #78B817, #669e12); color: white; padding: 20px 30px; border-radius: 20px; text-align: right; }
.status-badge { display: inline-block; padding: 4px 12px; border-radius: 50px; font-size: 11px; font-weight: 600; }
.status-0 { background: #fff3e0; color: #e65100; }
.status-1 { background: #e3f2fd; color: #1565c0; }
.status-2 { background: #fee8e8; color: #c62828; }
.status-3 { background: #e8f0fe; color: #2c3e50; }
.status-4 { background: #f3e5f5; color: #6a1b9a; }
.status-5 { background: #e8f5e9; color: #2e7d32; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-file-text-o" style="color: #78B817;"></i> Laporan Penjualan</h1>
    <small>Data ringkasan transaksi Fresh Cart</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="filter-card">
      <h4 style="margin-top: 0; margin-bottom: 20px; font-weight: 700;"><i class="fa fa-filter" style="color: #78B817;"></i> Filter Periode</h4>
      <form method="get" action="">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label class="filter-label">Dari Tanggal</label>
              <input autocomplete="off" type="text" value="<?php echo isset($_GET['tanggal_dari']) ? $_GET['tanggal_dari'] : ''; ?>" name="tanggal_dari" class="datepicker2" placeholder="DD/MM/YYYY" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="filter-label">Sampai Tanggal</label>
              <input autocomplete="off" type="text" value="<?php echo isset($_GET['tanggal_sampai']) ? $_GET['tanggal_sampai'] : ''; ?>" name="tanggal_sampai" class="datepicker2" placeholder="DD/MM/YYYY" required>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label class="filter-label">&nbsp;</label>
              <button type="submit" class="btn-green" style="width: 100%; padding: 11px;"><i class="fa fa-search"></i> Tampilkan Laporan</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <?php 
    if(isset($_GET['tanggal_dari']) && isset($_GET['tanggal_sampai'])){
      include '../koneksi.php';
      $tgl_dari = mysqli_real_escape_string($koneksi, $_GET['tanggal_dari']);
      $tgl_sampai = mysqli_real_escape_string($koneksi, $_GET['tanggal_sampai']);
      
      // Konversi format tanggal untuk query MySQL
      $dari = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_dari)));
      $sampai = date('Y-m-d', strtotime(str_replace('/', '-', $tgl_sampai)));

      // Query dinamis (menggunakan date() untuk memastikan hanya membandingkan tanggal, bukan waktu)
      $query = "SELECT * FROM invoice JOIN customer ON invoice_customer = customer_id WHERE date(invoice_tanggal) >= '$dari' AND date(invoice_tanggal) <= '$sampai' ORDER BY invoice_id DESC";
      $data = mysqli_query($koneksi, $query);
    ?>
    
    <div class="box-modern">
      <div class="box-header" style="padding: 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 700; margin: 0;"><i class="fa fa-chart-line"></i> Ringkasan Penjualan</h3>
        <div class="btn-group pull-right">
          <a href="laporan_excel.php?tanggal_dari=<?php echo $tgl_dari; ?>&tanggal_sampai=<?php echo $tgl_sampai; ?>" class="btn-excel" target="_blank"><i class="fa fa-file-excel-o"></i> Excel</a>
          <a href="laporan_pdf.php?tanggal_dari=<?php echo $tgl_dari; ?>&tanggal_sampai=<?php echo $tgl_sampai; ?>" class="btn-pdf" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>
          <a href="laporan_print.php?tanggal_dari=<?php echo $tgl_dari; ?>&tanggal_sampai=<?php echo $tgl_sampai; ?>" class="btn-print" target="_blank"><i class="fa fa-print"></i> Print</a>
        </div>
      </div>
      
      <div class="box-body" style="padding: 25px;">
        <div class="row" style="margin-bottom: 20px;">
          <div class="col-md-6">
            <p class="text-muted"><i class="fa fa-info-circle"></i> Menampilkan data dari <b><?php echo $tgl_dari; ?></b> s/d <b><?php echo $tgl_sampai; ?></b></p>
          </div>
          <div class="col-md-6">
            <?php 
            $total_pendapatan = 0;
            $res = mysqli_query($koneksi, $query);
            while($row = mysqli_fetch_array($res)){ $total_pendapatan += $row['invoice_total_bayar']; }
            ?>
            <div class="total-box">
              <small>TOTAL PENDAPATAN</small>
              <h3 style="margin: 0; font-weight: 800;">Rp <?php echo number_format($total_pendapatan); ?></h3>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-custom table-bordered table-striped" id="table-datatable">
            <thead>
              <tr>
                <th width="1%">NO</th>
                <th>INVOICE</th>
                <th>TANGGAL</th>
                <th>PELANGGAN</th>
                <th>TOTAL BAYAR</th>
                <th class="text-center">STATUS</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;
              mysqli_data_seek($data, 0); // Reset pointer data
              while($i = mysqli_fetch_array($data)){
                $status_id = $i['invoice_status'];
                $texts = [0 => 'Menunggu Pembayaran', 1 => 'Menunggu Konfirmasi', 2 => 'Ditolak', 3 => 'Diproses', 4 => 'Dikirim', 5 => 'Selesai'];
                $status_text = $texts[$status_id] ?? 'Unknown';
              ?>
              <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><strong>INV-00<?php echo $i['invoice_id']; ?></strong></td>
                <td>
                    <?php 
                    $tgl_raw = isset($i['invoice_tanggal']) ? $i['invoice_tanggal'] : $i['invoice_tgl'];
                    echo date('d/m/Y', strtotime($tgl_raw)); 
                    ?>
                </td>
                <td><?php echo htmlspecialchars($i['customer_nama']); ?></td>
                <td>Rp <?php echo number_format($i['invoice_total_bayar']); ?></td>
                <td class="text-center">
                    <span class="status-badge status-<?php echo $status_id; ?>"><?php echo $status_text; ?></span>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php } else { ?>
      <div class="box-modern">
        <div class="box-body" style="padding: 50px; text-align: center; color: #94a3b8;">
            <i class="fa fa-calendar-check-o" style="font-size: 60px; opacity: 0.3;"></i>
            <h4 style="margin-top: 20px; font-weight: 600;">Pilih Periode Laporan</h4>
            <p>Silahkan masukkan rentang tanggal untuk melihat data penjualan.</p>
        </div>
      </div>
    <?php } ?>
  </section>
</div>

<?php include 'footer.php'; ?>