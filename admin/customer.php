<?php include 'header.php'; ?>
<style>
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-danger-custom { background: #e74c3c; color: white; border-radius: 8px; padding: 6px 14px; display: inline-block; border: none; cursor: pointer; transition: 0.3s; }
.btn-danger-custom:hover { background: #c0392b; color: white; transform: scale(1.05); }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.content-header h1 { font-size: 22px; font-weight: 600; color: #2c3e50; margin-bottom: 5px; }
.content-header small { color: #7f8c8d; font-size: 13px; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">
  <section class="content-header">
    <h1><i class="fa fa-users" style="color: #78B817;"></i> Data Pelanggan</h1>
    <small>Pantau dan kelola akses pelanggan Fresh Cart</small>
  </section>

  <section class="content" style="padding-top: 10px;">
    <div class="box-modern">
      <div class="box-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f0;">
        <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-list"></i> Daftar Pelanggan Aktif</h3>
      </div>
      <div class="box-body" style="padding: 20px;">
        <div class="table-responsive">
          <table class="table table-custom table-bordered table-striped" id="table-datatable">
            <thead>
              <tr>
                <th width="5%">NO</th>
                <th>NAMA PELANGGAN</th>
                <th>EMAIL</th>
                <th>NOMOR HP</th>
                <th>ALAMAT</th>
                <th width="10%">AKSI</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              include '../koneksi.php'; 
              $no=1; 
              $data = mysqli_query($koneksi,"SELECT * FROM customer ORDER BY customer_id DESC");
              while($d = mysqli_fetch_array($data)){ 
              ?>
              <tr>
                <td class="text-center"><?php echo $no++; ?></td>
                <td><strong><?php echo htmlspecialchars($d['customer_nama']); ?></strong></td>
                <td><?php echo htmlspecialchars($d['customer_email']); ?></td>
                <td><?php echo htmlspecialchars($d['customer_hp']); ?></td>
                <td><?php echo htmlspecialchars($d['customer_alamat']); ?></td>
                <td class="text-center">
                  <button class="btn-danger-custom" onclick="confirmDelete(<?php echo $d['customer_id']; ?>)" title="Hapus Akun">
                    <i class="fa fa-trash"></i> Hapus
                  </button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Hapus Akun Pelanggan?',
    text: "⚠️ PERHATIAN: Menghapus pelanggan akan menghapus SELURUH riwayat pesanan dan transaksi mereka secara permanen.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e74c3c',
    cancelButtonColor: '#7f8c8d',
    confirmButtonText: 'Ya, Hapus Permanen!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'customer_hapus.php?id=' + id;
    }
  })
}
</script>

<?php include 'footer.php'; ?>