<?php include 'header.php'; ?>

<div class="content-wrapper" style="background: #f4f6fa;">
  <style>
    /* Modern Dashboard Styles */
    .modern-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 24px;
      margin-bottom: 32px;
      padding: 0 8px;
    }
    .stat-card-modern {
      background: #fff;
      border-radius: 28px;
      padding: 22px 24px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.04);
      transition: all 0.3s ease;
      border: 1px solid rgba(120, 184, 23, 0.1);
      position: relative;
      overflow: hidden;
    }
    .stat-card-modern:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 35px -12px rgba(0,0,0,0.12);
      border-color: #78B81740;
    }
    .stat-card-modern::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 6px;
      height: 100%;
      background: #78B817;
    }
    .stat-icon-modern {
      font-size: 2.2rem;
      color: #78B817;
      opacity: 0.7;
      margin-bottom: 16px;
    }
    .stat-value-modern {
      font-size: 2.2rem;
      font-weight: 700;
      color: #1a2c3e;
      margin-bottom: 8px;
    }
    .stat-label-modern {
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #7f8c8d;
      font-weight: 500;
    }
    .trend-badge {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 0.7rem;
      padding: 4px 10px;
      border-radius: 40px;
      font-weight: 600;
      margin-top: 10px;
    }
    .trend-up { background: #e8f8f0; color: #27ae60; }
    .trend-down { background: #fee8e8; color: #e74c3c; }
    
    /* Charts Row */
    .charts-modern-row {
      display: flex;
      flex-wrap: wrap;
      gap: 24px;
      margin-bottom: 32px;
      padding: 0 8px;
    }
    .chart-card {
      background: #fff;
      border-radius: 28px;
      padding: 20px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.04);
      border: 1px solid #eef2f0;
      flex: 2;
      min-width: 280px;
    }
    .pie-card {
      flex: 1;
      min-width: 260px;
    }
    .card-header-modern {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
      padding-bottom: 12px;
      border-bottom: 2px solid #f0f3f2;
    }
    .card-header-modern h3 {
      font-size: 1.1rem;
      font-weight: 600;
      margin: 0;
      color: #2c3e50;
    }
    /* Table Modern */
    .table-modern-container {
      background: #fff;
      border-radius: 28px;
      padding: 20px;
      margin: 0 8px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.04);
      border: 1px solid #eef2f0;
    }
    .table-modern {
      width: 100%;
      border-collapse: collapse;
    }
    .table-modern th {
      text-align: left;
      padding: 16px 12px;
      font-weight: 600;
      color: #5a6e7a;
      border-bottom: 2px solid #f0f4f8;
      font-size: 0.8rem;
      letter-spacing: 0.5px;
    }
    .table-modern td {
      padding: 14px 12px;
      border-bottom: 1px solid #f5f7fa;
      color: #2c3e50;
      font-weight: 500;
    }
    .status-modern {
      display: inline-block;
      padding: 6px 14px;
      border-radius: 50px;
      font-size: 0.7rem;
      font-weight: 600;
    }
    .status-completed { background: #e3f9ee; color: #2e7d32; }
    .status-pending { background: #fff3e0; color: #e65100; }
    .status-processing { background: #e3f2fd; color: #1565c0; }
    .status-shipped { background: #f3e5f5; color: #6a1b9a; }
    
    .btn-view-all {
      background: transparent;
      border: 1px solid #78B817;
      color: #78B817;
      padding: 6px 14px;
      border-radius: 40px;
      font-size: 0.7rem;
      font-weight: 600;
      transition: all 0.2s;
    }
    .btn-view-all:hover {
      background: #78B817;
      color: white;
    }
    .greeting-text {
      font-size: 0.9rem;
      color: #5a6e7a;
      margin-top: 4px;
    }
  </style>

  <section class="content-header" style="padding-bottom: 0;">
    <h1 style="font-weight: 600; color: #2c3e50;">
      Dashboard 
      <small style="color: #78B817;">Fresh Cart</small>
    </h1>
    <ol class="breadcrumb" style="background: transparent;">
      <li><a href="#" style="color: #78B817;"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <section class="content" style="padding-top: 20px;">
    
    <!-- Stats Cards Modern -->
    <div class="modern-stats">
      <?php
      // Get real data from database
      $total_produk = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk"))['total'];
      $total_customer = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM customer"))['total'];
      $total_invoice = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM invoice"))['total'];
      $total_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM admin"))['total'];
      
      // Get total sales (sum of invoice_total_bayar)
      $total_sales = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(invoice_total_bayar) as total FROM invoice WHERE invoice_status >= 3"))['total'] ?? 0;
      ?>
      
      <div class="stat-card-modern">
        <div class="stat-icon-modern"><i class="fa fa-leaf"></i></div>
        <div class="stat-value-modern"><?php echo number_format($total_produk); ?></div>
        <div class="stat-label-modern">Total Produk</div>
        <span class="trend-badge trend-up"><i class="fa fa-arrow-up"></i> +12%</span>
      </div>
      
      <div class="stat-card-modern">
        <div class="stat-icon-modern"><i class="fa fa-users"></i></div>
        <div class="stat-value-modern"><?php echo number_format($total_customer); ?></div>
        <div class="stat-label-modern">Pelanggan</div>
        <span class="trend-badge trend-up"><i class="fa fa-arrow-up"></i> +5.6%</span>
      </div>
      
      <div class="stat-card-modern">
        <div class="stat-icon-modern"><i class="fa fa-shopping-cart"></i></div>
        <div class="stat-value-modern"><?php echo number_format($total_invoice); ?></div>
        <div class="stat-label-modern">Total Pesanan</div>
        <span class="trend-badge trend-up"><i class="fa fa-arrow-up"></i> +8.2%</span>
      </div>
      
      <div class="stat-card-modern">
        <div class="stat-icon-modern"><i class="fa fa-dollar"></i></div>
        <div class="stat-value-modern">Rp <?php echo number_format($total_sales); ?></div>
        <div class="stat-label-modern">Total Pendapatan</div>
        <span class="trend-badge trend-up"><i class="fa fa-arrow-up"></i> +4.8%</span>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-modern-row">
      <div class="chart-card">
        <div class="card-header-modern">
          <h3><i class="fa fa-line-chart" style="color: #78B817; margin-right: 8px;"></i> Tren Penjualan</h3>
          <span class="label label-success" style="background: #78B817;">2024</span>
        </div>
        <canvas id="salesChart" style="width: 100%; height: 260px;"></canvas>
      </div>
      
      <div class="chart-card pie-card">
        <div class="card-header-modern">
          <h3><i class="fa fa-pie-chart" style="color: #78B817; margin-right: 8px;"></i> Status Pesanan</h3>
        </div>
        <canvas id="statusChart" style="width: 100%; height: 220px;"></canvas>
        <div style="margin-top: 16px; text-align: center; font-size: 0.7rem; color: #7f8c8d;">
          <i class="fa fa-info-circle"></i> Distribusi status pesanan terkini
        </div>
      </div>
    </div>

    <!-- Recent Transactions -->
    <div class="table-modern-container">
      <div class="card-header-modern" style="margin-bottom: 16px;">
        <h3><i class="fa fa-clock-o" style="color: #78B817;"></i> Transaksi Terbaru</h3>
        <a href="transaksi.php" class="btn-view-all"><i class="fa fa-arrow-right"></i> Lihat Semua</a>
      </div>
      
      <div class="table-responsive">
        <table class="table-modern">
          <thead>
            <tr>
              <th>No. Invoice</th>
              <th>Customer</th>
              <th>Tanggal</th>
              <th>Total Bayar</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $recent_trans = mysqli_query($koneksi, "SELECT * FROM invoice ORDER BY invoice_id DESC LIMIT 5");
            if(mysqli_num_rows($recent_trans) > 0){
              while($inv = mysqli_fetch_assoc($recent_trans)){
                $cust = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT customer_nama FROM customer WHERE customer_id='".$inv['invoice_customer']."'"));
                $status_text = "";
                $status_class = "";
                switch($inv['invoice_status']){
                  case 0: $status_text = "Menunggu Bayar"; $status_class = "status-pending"; break;
                  case 1: $status_text = "Menunggu Konfirmasi"; $status_class = "status-pending"; break;
                  case 2: $status_text = "Ditolak"; $status_class = "status-pending"; break;
                  case 3: $status_text = "Diproses"; $status_class = "status-processing"; break;
                  case 4: $status_text = "Dikirim"; $status_class = "status-processing"; break;
                  case 5: $status_text = "Selesai"; $status_class = "status-completed"; break;
                  default: $status_text = "Unknown"; $status_class = "status-pending";
                }
                ?>
                <tr>
                  <td><strong>INV-00<?php echo $inv['invoice_id']; ?></strong></td>
                  <td><?php echo $cust['customer_nama'] ?? '-'; ?></td>
                  <td><?php echo date('d/m/Y', strtotime($inv['invoice_tanggal'])); ?></td>
                  <td>Rp <?php echo number_format($inv['invoice_total_bayar']); ?></td>
                  <td><span class="status-modern <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                </tr>
                <?php
              }
            } else {
              echo '<tr><td colspan="5" class="text-center">Belum ada transaksi</td></tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Admin Info & Detail Login -->
    <div class="row" style="margin-top: 24px; padding: 0 8px;">
      <div class="col-md-6">
        <div class="box box-success" style="border-radius: 20px; border-top-color: #78B817;">
          <div class="box-header with-border">
            <h3 class="box-title" style="color: #2c3e50;"><i class="fa fa-user-circle"></i> Detail Login Admin</h3>
          </div>
          <div class="box-body">
            <table class="table table-borderless">
              <tr><th width="30%">Nama</th><td>: <?php echo $_SESSION['nama']; ?></td></tr>
              <tr><th>Username</th><td>: <?php echo $_SESSION['username']; ?></td></tr>
              <tr><th>Level Akses</th><td>: <span class="label label-success" style="background: #78B817;"><?php echo $_SESSION['status']; ?></span></td></tr>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-info" style="border-radius: 20px; border-top-color: #78B817;">
          <div class="box-header with-border">
            <h3 class="box-title" style="color: #2c3e50;"><i class="fa fa-calendar"></i> Ringkasan Cepat</h3>
          </div>
          <div class="box-body">
            <p><i class="fa fa-check-circle" style="color: #78B817;"></i> Total <?php echo $total_invoice; ?> pesanan telah diproses</p>
            <p><i class="fa fa-trophy" style="color: #78B817;"></i> Pendapatan: Rp <?php echo number_format($total_sales); ?></p>
            <p><i class="fa fa-smile-o" style="color: #78B817;"></i> <?php echo $total_customer; ?> pelanggan setia</p>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
  // Sales Trend Chart
  const ctx = document.getElementById('salesChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
      datasets: [{
        label: 'Pendapatan (Rp)',
        data: [12500000, 14800000, 13200000, 16800000, 19200000, 21500000, 23800000, 25600000, 27800000, 29500000, 31200000, 33500000],
        borderColor: '#78B817',
        backgroundColor: 'rgba(120, 184, 23, 0.05)',
        borderWidth: 3,
        pointRadius: 4,
        pointBackgroundColor: '#78B817',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        tension: 0.3,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: { position: 'top', labels: { usePointStyle: true, font: { family: 'Poppins', size: 11 } } },
        tooltip: { callbacks: { label: (ctx) => `Rp ${ctx.raw.toLocaleString()}` } }
      },
      scales: {
        y: { ticks: { callback: (val) => 'Rp ' + (val/1000000).toFixed(1) + 'jt' }, grid: { color: '#eef2f0' } }
      }
    }
  });

  // Status Pie Chart
  const pieCtx = document.getElementById('statusChart').getContext('2d');
  <?php
  $status_count = [];
  for($i=0;$i<=5;$i++) $status_count[$i] = 0;
  $status_query = mysqli_query($koneksi, "SELECT invoice_status, COUNT(*) as total FROM invoice GROUP BY invoice_status");
  while($row = mysqli_fetch_assoc($status_query)) $status_count[$row['invoice_status']] = $row['total'];
  ?>
  new Chart(pieCtx, {
    type: 'doughnut',
    data: {
      labels: ['Menunggu Bayar', 'Menunggu Konfirmasi', 'Ditolak', 'Diproses', 'Dikirim', 'Selesai'],
      datasets: [{
        data: [<?php echo $status_count[0].','.$status_count[1].','.$status_count[2].','.$status_count[3].','.$status_count[4].','.$status_count[5]; ?>],
        backgroundColor: ['#f39c12', '#95a5a6', '#e74c3c', '#3498db', '#9b59b6', '#27ae60'],
        borderWidth: 0,
        cutout: '55%',
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      plugins: {
        legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 9 } } }
      }
    }
  });
</script>

<?php include 'footer.php'; ?>