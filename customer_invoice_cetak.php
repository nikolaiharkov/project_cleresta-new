<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Invoice - Fresh Cart</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #78B817;
            padding-bottom: 10px;
        }

        .header-table td {
            vertical-align: top;
        }

        .shop-info h2 {
            margin: 0;
            color: #78B817;
            text-transform: uppercase;
        }

        .shop-info p {
            margin: 2px 0;
            color: #777;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h1 {
            margin: 0;
            color: #444;
            font-size: 24px;
        }

        .billing-info {
            width: 100%;
            margin-bottom: 20px;
        }

        .billing-info td {
            width: 50%;
            padding: 10px 0;
        }

        .info-label {
            font-weight: bold;
            color: #78B817;
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th {
            background-color: #f9f9f9;
            border-bottom: 2px solid #eee;
            padding: 12px;
            text-align: left;
            color: #555;
        }

        .table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .total-box {
            float: right;
            width: 300px;
            margin-top: 20px;
        }

        .total-box table {
            width: 100%;
        }

        .total-box td {
            padding: 5px 0;
        }

        .grand-total {
            font-size: 16px;
            font-weight: bold;
            color: #78B817;
            border-top: 1px solid #eee;
            padding-top: 10px !important;
        }

        .footer-note {
            margin-top: 50px;
            text-align: center;
            color: #aaa;
            font-style: italic;
        }

        @media print {
            .no-print { display: none; }
            .invoice-box { border: none; box-shadow: none; padding: 0; }
            body { padding: 0; }
        }
        
        .btn-print {
            padding: 10px 20px;
            background: #78B817;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <?php 
    session_start();
    include 'koneksi.php';

    // Cek apakah user sudah login
    if(!isset($_SESSION['customer_id'])){
        exit("<div style='text-align:center; padding:50px;'><h3>Akses ditolak. Silahkan login kembali.</h3></div>");
    }

    $id_invoice = mysqli_real_escape_string($koneksi, $_GET['id']);
    $id_customer = $_SESSION['customer_id'];

    // Ambil data invoice secara detail
    $invoice_query = mysqli_query($koneksi, "SELECT * FROM invoice WHERE invoice_customer='$id_customer' AND invoice_id='$id_invoice'");
    $i = mysqli_fetch_array($invoice_query);

    if(!$i){
        exit("<div style='text-align:center; padding:50px;'><h3>Invoice tidak ditemukan atau bukan milik Anda.</h3></div>");
    }

    // Solusi Error Undefined Index: Cek nama kolom yang mungkin berbeda (invoice_tgl atau invoice_tanggal)
    if(isset($i['invoice_tgl'])){
        $tgl_invoice = $i['invoice_tgl'];
    } elseif(isset($i['invoice_tanggal'])) {
        $tgl_invoice = $i['invoice_tanggal'];
    } else {
        $tgl_invoice = date('Y-m-d'); // Fallback jika tidak ada di DB
    }
    ?>

    <div class="text-center no-print">
        <button class="btn-print" onclick="window.print()">CETAK INVOICE SEKARANG</button>
        <br><br>
    </div>

    <div class="invoice-box">
        <table class="header-table">
            <tr>
                <td class="shop-info">
                    <h2>FRESH CART</h2>
                    <p>Bahan Pangan Segar & Organik</p>
                    <p>Jl. Kebun Hijau No. 123, Jakarta</p>
                    <p>support@freshcart.com | +62 812-3456-7890</p>
                </td>
                <td class="invoice-title">
                    <h1>INVOICE</h1>
                    <p><strong>#INV-00<?php echo $i['invoice_id']; ?></strong></p>
                    <p>Tanggal: <?php echo date('d/m/Y', strtotime($tgl_invoice)); ?></p>
                </td>
            </tr>
        </table>

        <table class="billing-info">
            <tr>
                <td>
                    <span class="info-label">Dikirim Ke:</span>
                    <strong><?php echo isset($i['invoice_nama']) ? $i['invoice_nama'] : '-'; ?></strong><br>
                    <?php echo isset($i['invoice_hp']) ? $i['invoice_hp'] : '-'; ?><br>
                    <?php echo isset($i['invoice_alamat']) ? $i['invoice_alamat'] : '-'; ?><br>
                    <?php echo isset($i['invoice_kabupaten']) ? $i['invoice_kabupaten'] : ''; ?>, <?php echo isset($i['invoice_provinsi']) ? $i['invoice_provinsi'] : ''; ?>
                </td>
                <td class="text-right" style="vertical-align: bottom;">
                    <span class="info-label">Status Pesanan:</span>
                    <?php 
                    $status = $i['invoice_status'];
                    if($status == 0){
                        echo "<span style='color:#f0ad4e; font-weight:bold;'>Menunggu Pembayaran</span>";
                    }elseif($status == 1){
                        echo "<span style='color:#777; font-weight:bold;'>Menunggu Konfirmasi</span>";
                    }elseif($status == 2){
                        echo "<span style='color:#d9534f; font-weight:bold;'>Ditolak</span>";
                    }elseif($status == 3){
                        echo "<span style='color:#337ab7; font-weight:bold;'>Diproses</span>";
                    }elseif($status == 4){
                        echo "<span style='color:#5bc0de; font-weight:bold;'>Dikirim</span>";
                    }elseif($status == 5){
                        echo "<span style='color:#5cb85c; font-weight:bold;'>Selesai</span>";
                    }
                    ?>
                </td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th width="1%" class="text-center">NO</th>
                    <th>ITEM PESANAN</th>
                    <th class="text-center">HARGA</th>
                    <th class="text-center">JUMLAH</th>
                    <th class="text-right">SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $total_belanja = 0;
                $id_inv = $i['invoice_id'];
                $transaksi = mysqli_query($koneksi, "SELECT * FROM transaksi, produk WHERE transaksi_produk=produk_id AND transaksi_invoice='$id_inv'");
                while($t = mysqli_fetch_array($transaksi)){
                    $subtotal = $t['transaksi_jumlah'] * $t['transaksi_harga'];
                    $total_belanja += $subtotal;
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><strong><?php echo $t['produk_nama']; ?></strong></td>
                        <td class="text-center">Rp. <?php echo number_format($t['transaksi_harga']); ?></td>
                        <td class="text-center"><?php echo $t['transaksi_jumlah']; ?></td>
                        <td class="text-right">Rp. <?php echo number_format($subtotal); ?></td>
                    </tr>
                    <?php 
                }
                ?>
            </tbody>
        </table>

        <div class="total-box">
            <table>
                <tr>
                    <td>Total Harga Produk</td>
                    <td class="text-right">Rp. <?php echo number_format($total_belanja); ?></td>
                </tr>
                <tr>
                    <td>Ongkos Kirim (<?php echo $i['invoice_kurir']; ?>)</td>
                    <td class="text-right">Rp. <?php echo number_format($i['invoice_ongkir']); ?></td>
                </tr>
                <tr class="grand-total">
                    <td>TOTAL BAYAR</td>
                    <td class="text-right">Rp. <?php echo number_format($i['invoice_total_bayar']); ?></td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <div class="footer-note">
            <p>Terima kasih telah mempercayai **Fresh Cart** untuk kebutuhan pangan segar Anda.</p>
            <p>Silahkan simpan invoice ini sebagai bukti transaksi yang sah.</p>
        </div>
    </div>

    <script>
        // Dialog print otomatis (opsional)
        // window.print();
    </script>
</body>
</html>