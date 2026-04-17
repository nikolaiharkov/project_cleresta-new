  <footer class="main-footer" style="background-color: #f9f9f9; border-top: 1px solid #eee; padding: 50px 0 30px 0; color: #555;">
    <div class="container">
      <div class="row">

        <div class="col-md-4 col-sm-12" style="margin-bottom: 30px;">
          <div style="margin-bottom: 20px;">
            <img src="frontend/img/freshcart-logo.svg" alt="Fresh Cart Logo" style="max-height: 50px;">
          </div>
          <p style="line-height: 1.8; text-align: justify; padding-right: 20px;">
            <strong>Fresh Cart</strong> adalah penyedia bahan pangan segar dan organik kualitas premium. Kami menghubungkan petani lokal langsung ke dapur Anda untuk memastikan kesegaran tanpa kompromi setiap hari.
          </p>
          <div style="margin-top: 15px;">
            <a href="#" style="margin-right: 15px; color: #78B817;"><i class="fa fa-facebook fa-lg"></i></a>
            <a href="#" style="margin-right: 15px; color: #78B817;"><i class="fa fa-instagram fa-lg"></i></a>
            <a href="#" style="margin-right: 15px; color: #78B817;"><i class="fa fa-twitter fa-lg"></i></a>
          </div>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom: 30px;">
          <h4 style="color: #333; font-weight: 700; margin-bottom: 20px;">Halaman</h4>
          <ul style="list-style: none; padding: 0; line-height: 2.2;">
            <li><a href="index.php" style="color: #666; text-decoration: none;">Beranda</a></li>
            <li><a href="index.php" style="color: #666; text-decoration: none;">Belanja</a></li>
            <li><a href="tentangkami.php" style="color: #666; text-decoration: none;">Tentang Kami</a></li>
            <li><a href="#" style="color: #666; text-decoration: none;">Promo</a></li>
          </ul>
        </div>

        <div class="col-md-2 col-sm-4 col-xs-6" style="margin-bottom: 30px;">
          <h4 style="color: #333; font-weight: 700; margin-bottom: 20px;">Bantuan</h4>
          <ul style="list-style: none; padding: 0; line-height: 2.2;">
            <li><a href="masuk.php" style="color: #666; text-decoration: none;">Login Pelanggan</a></li>
            <li><a href="daftar.php" style="color: #666; text-decoration: none;">Daftar Akun</a></li>
            <li><a href="keranjang.php" style="color: #666; text-decoration: none;">Keranjang Belanja</a></li>
            <li><a href="#" style="color: #666; text-decoration: none;">Syarat & Ketentuan</a></li>
          </ul>
        </div>

        <div class="col-md-4 col-sm-4" style="margin-bottom: 30px;">
          <h4 style="color: #333; font-weight: 700; margin-bottom: 20px;">Hubungi Kami</h4>
          <p><i class="fa fa-map-marker" style="color: #78B817; width: 20px;"></i> Jl. Kebun Hijau No. 123, Jakarta</p>
          <p><i class="fa fa-phone" style="color: #78B817; width: 20px;"></i> +62 812-3456-7890</p>
          <p><i class="fa fa-envelope" style="color: #78B817; width: 20px;"></i> support@freshcart.com</p>
          <p><i class="fa fa-clock-o" style="color: #78B817; width: 20px;"></i> 08:00 - 21:00 (Setiap Hari)</p>
        </div>

      </div>

      <hr style="border-top: 1px solid #ddd; margin-top: 20px;">

      <div class="row">
        <div class="col-md-12 text-center" style="font-size: 13px;">
          <strong>Copyright &copy; <?php echo date('Y') ?> - <span style="color: #78B817;">Fresh Cart</span> Grocery Management System</strong>. All rights reserved.
        </div>
      </div>
    </div>
  </footer>
</div>

<script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  if (typeof $.widget !== 'undefined') {
    $.widget.bridge('uibutton', $.ui.button);
  }
</script>
<script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/bower_components/raphael/raphael.min.js"></script>
<script src="assets/bower_components/morris.js/morris.min.js"></script>
<script src="assets/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="assets/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="assets/bower_components/moment/min/moment.min.js"></script>
<script src="assets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="assets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/bower_components/fastclick/lib/fastclick.js"></script>
<script src="assets/dist/js/adminlte.min.js"></script>
<script src="assets/dist/js/pages/dashboard.js"></script>
<script src="assets/dist/js/demo.js"></script>
<script src="assets/bower_components/ckeditor/ckeditor.js"></script>

<script src="frontend/js/slick.min.js"></script>

<script>
  $(document).ready(function(){
    // Inisialisasi DataTable hanya jika ada tabel dengan ID tersebut
    if ($.fn.DataTable && $('#table-datatable').length) {
      $('#table-datatable').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : true,
        'ordering'    : false,
        'info'        : true,
        'autoWidth'   : true,
        "pageLength": 50
      });
    }

    // Inisialisasi Datepicker
    if ($.fn.datepicker) {
      $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',
      }).datepicker("setDate", new Date());

      $('.datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy/mm/dd',
      });
    }

    // Inisialisasi CKEditor jika library termuat
    if (typeof CKEDITOR !== 'undefined' && $('#editor1').length) {
      CKEDITOR.replace('editor1');
    }
  });
</script>
</body>
</html>
