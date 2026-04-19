<?php include 'header.php'; ?>

<style>
/* Desain Modern yang diseragamkan */
.box-modern { background: white; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.03); border: 1px solid #eef2f0; overflow: hidden; margin-top: 20px; }
.btn-green { background: #78B817; color: white; border: none; padding: 8px 20px; border-radius: 40px; text-decoration: none; display: inline-block; cursor: pointer; font-weight: 600; }
.btn-green:hover { background: #5e9c12; color: white; }
.btn-warning-custom { background: #f39c12; color: white; border-radius: 8px; padding: 6px 14px; margin: 0 3px; display: inline-block; border: none; cursor: pointer; }
.btn-danger-custom { background: #e74c3c; color: white; border-radius: 8px; padding: 6px 14px; display: inline-block; border: none; cursor: pointer; }
.table-custom th { background: #f8fafc; color: #2c3e50; font-weight: 600; border-bottom: 2px solid #78B817; padding: 14px 12px; }
.table-custom td { padding: 12px; vertical-align: middle; }
.admin-img { width: 45px; height: 45px; object-fit: cover; border-radius: 50%; border: 2px solid #eef2f0; }
.content-header h1 { font-size: 22px; font-weight: 600; color: #2c3e50; }
</style>

<div class="content-wrapper" style="background: #f4f6fa;">

  <section class="content-header">
    <h1><i class="fa fa-lock" style="color: #78B817;"></i> Manajemen Admin</h1>
    <small>Kelola pengguna yang memiliki akses ke panel ini</small>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Data Admin</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <section class="col-lg-10 col-lg-offset-1">
        <div class="box-modern">

          <div class="box-header" style="padding: 16px 20px; border-bottom: 1px solid #eef2f0;">
            <h3 class="box-title" style="font-weight: 600; margin: 0;"><i class="fa fa-users"></i> Daftar Admin</h3>
            <a href="admin_tambah.php" class="btn-green pull-right">
              <i class="fa fa-plus"></i> Tambah Admin Baru
            </a>              
          </div>

          <div class="box-body" style="padding: 20px;">
            <div class="table-responsive">
              <table class="table table-custom table-bordered table-striped" id="table-datatable">
                <thead>
                  <tr>
                    <th width="1%">NO</th>
                    <th width="10%">FOTO</th>
                    <th>NAMA LENGKAP</th>
                    <th>USERNAME</th>
                    <th width="15%">OPSI</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  include '../koneksi.php';
                  $no=1;
                  $data = mysqli_query($koneksi,"SELECT * FROM admin ORDER BY admin_id ASC");
                  while($d = mysqli_fetch_array($data)){
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $no++; ?></td>
                      <td class="text-center">
                        <?php if($d['admin_foto'] == ""){ ?>
                          <img src="../gambar/sistem/user.png" class="admin-img">
                        <?php }else{ ?>
                          <img src="../gambar/user/<?php echo $d['admin_foto'] ?>" class="admin-img">
                        <?php } ?>
                      </td>
                      <td><strong><?php echo $d['admin_nama']; ?></strong></td>
                      <td><code><?php echo $d['admin_username']; ?></code></td>
                      <td class="text-center">                        
                        <a class="btn-warning-custom" href="admin_edit.php?id=<?php echo $d['admin_id'] ?>" title="Edit Akun"><i class="fa fa-cog"></i></a>
                        
                        <?php if($d['admin_id'] != 1){ ?>
                          <button class="btn-danger-custom" onclick="confirmDelete(<?php echo $d['admin_id']; ?>)" title="Hapus Akun">
                            <i class="fa fa-trash"></i>
                          </button>
                        <?php } else { ?>
                          <span class="label label-default">Utama</span>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php 
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </section>
    </div>
  </section>

</div>

<script>
function confirmDelete(id) {
  Swal.fire({
    title: 'Hapus Admin?',
    text: "Akun ini tidak akan bisa mengakses panel admin lagi setelah dihapus.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#e74c3c',
    cancelButtonColor: '#7f8c8d',
    confirmButtonText: 'Ya, Hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'admin_hapus.php?id=' + id;
    }
  })
}
</script>

<?php include 'footer.php'; ?>