<?php 
// 1. Mulakan sesi dan koneksi
include 'koneksi.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. Semak login
if(!isset($_SESSION['customer_status']) || $_SESSION['customer_status'] != "login"){
    header("location:masuk.php?alert=login-dulu");
    exit();
}

include 'header.php'; 
?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    /* Penyesuaian agar Select2 tampil modern seperti input lainnya */
    .select2-container--default .select2-selection--single {
        border: 1px solid #E4E7ED;
        height: 40px;
        border-radius: 0px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        padding-left: 15px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
</style>

<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.php">Home</a></li>
            <li class="active">Check Out</li>
        </ul>
    </div>
</div>

<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="order-summary clearfix">
                    <div class="section-title">
                        <h3 class="title">Buat Pesanan</h3>
                    </div>

                    <div class="row">
                        <form method="post" action="checkout_act.php">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <br>
                                        <h4 class="text-center">INFORMASI PENERIMA</h4>

                                        <?php 
                                        $id_customer = $_SESSION['customer_id'];
                                        $customer = mysqli_query($koneksi,"select * from customer where customer_id='$id_customer'");
                                        $c = mysqli_fetch_assoc($customer);
                                        ?>

                                        <div class="form-group">
                                            <label>Nama Lengkap</label>
                                            <input type="text" class="input" name="nama" required value="<?php echo $c['customer_nama']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Nomor HP</label>
                                            <input type="number" class="input" name="hp" required value="<?php echo $c['customer_hp']; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label>Alamat Lengkap</label>
                                            <textarea name="alamat" class="form-control" style="resize: none;" rows="4" required><?php echo $c['customer_alamat']; ?></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Provinsi</label>
                                            <select class="input select2-wilayah" name="provinsi" id="provinsi" required>
                                                <option value="">- Pilih Provinsi -</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Kota / Kabupaten</label>
                                            <select class="input select2-wilayah" name="kabupaten" id="kabupaten" required>
                                                <option value="">- Pilih Kota/Kabupaten -</option>
                                            </select>
                                        </div>

                                        <input name="kurir" value="Flat Rate" type="hidden">
                                        <input name="service" value="Regular" type="hidden">
                                        <input name="ongkir" value="20000" type="hidden"> 

                                        <div class="alert alert-success">
                                            <p><i class="fa fa-info-circle"></i> Info: Pengiriman flat ke seluruh wilayah Indonesia adalah <b>Rp. 20.000 ,-</b></p>
                                        </div>
                                        <br>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="pull-left">
                                            <a class="main-btn" href="keranjang.php">Kembali Ke Keranjang</a>
                                        </div>
                                        <div class="pull-right">
                                            <input type="submit" class="primary-btn" value="Selesaikan Pesanan">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <?php 
                                if(isset($_SESSION['keranjang']) && count($_SESSION['keranjang']) > 0){
                                    $jumlah_isi_keranjang = count($_SESSION['keranjang']);
                                    ?>
                                    <table class="shopping-cart-table table">
                                        <thead>
                                            <tr>
                                                <th>Produk</th>
                                                <th class="text-center">Harga</th>
                                                <th class="text-center">Jumlah</th>
                                                <th class="text-center">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $jumlah_total = 0;
                                            $total_berat = 0;
                                            for($a = 0; $a < $jumlah_isi_keranjang; $a++){
                                                $id_produk = $_SESSION['keranjang'][$a]['produk'];
                                                $jml = $_SESSION['keranjang'][$a]['jumlah'];

                                                $isi = mysqli_query($koneksi,"select * from produk where produk_id='$id_produk'");
                                                $i = mysqli_fetch_assoc($isi);

                                                $sub = $i['produk_harga']*$jml;
                                                $jumlah_total += $sub;
                                                $total_berat += ($i['produk_berat'] * $jml);
                                                ?>
                                                <tr>
                                                    <td><?php echo $i['produk_nama'] ?></td>
                                                    <td class="text-center"><?php echo number_format($i['produk_harga']); ?></td>
                                                    <td class="text-center"><?php echo $jml; ?></td>
                                                    <td class="text-center"><strong><?php echo number_format($sub); ?></strong></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th>TOTAL BERAT</th>
                                                <th class="text-center"><?php echo $total_berat; ?> Gram</th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th>ONGKIR</th>
                                                <th class="text-center">Rp. 20.000</th>
                                            </tr>
                                            <tr>
                                                <th colspan="2"></th>
                                                <th>TOTAL BAYAR</th>
                                                <th class="text-center" style="color: #78B817; font-size: 18px;">Rp. <?php echo number_format($jumlah_total + 20000); ?></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input name="berat" value="<?php echo $total_berat ?>" type="hidden">
                                    <input name="total_produk" value="<?php echo $jumlah_total ?>" type="hidden">
                                <?php } ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Gunakan noConflict untuk menghindari bentrok dengan jQuery dari footer.php nanti
var $j = jQuery.noConflict();

$j(document).ready(function() {
    // Cek apakah Select2 berhasil dimuat
    if ($j.fn.select2) {
        $j('.select2-wilayah').select2({
            width: '100%',
            placeholder: "- Pilih -"
        });
    }

    const dataWilayah = {
        "Aceh": ["Kab. Aceh Barat", "Kab. Aceh Barat Daya", "Kab. Aceh Besar", "Kab. Aceh Jaya", "Kab. Aceh Selatan", "Kab. Aceh Singkil", "Kab. Aceh Tamiang", "Kab. Aceh Tengah", "Kab. Aceh Tenggara", "Kab. Aceh Timur", "Kab. Aceh Utara", "Kab. Bener Meriah", "Kab. Bireuen", "Kab. Gayo Lues", "Kab. Nagan Raya", "Kab. Pidie", "Kab. Pidie Jaya", "Kab. Simeulue", "Kota Banda Aceh", "Kota Langsa", "Kota Lhokseumawe", "Kota Sabang", "Kota Subulussalam"],
        "Sumatera Utara": ["Kab. Asahan", "Kab. Batubara", "Kab. Dairi", "Kab. Deli Serdang", "Kab. Humbang Hasundutan", "Kab. Karo", "Kab. Labuhanbatu", "Kab. Labuhanbatu Selatan", "Kab. Labuhanbatu Utara", "Kab. Langkat", "Kab. Mandailing Natal", "Kab. Nias", "Kab. Nias Barat", "Kab. Nias Selatan", "Kab. Nias Utara", "Kab. Padang Lawas", "Kab. Padang Lawas Utara", "Kab. Pakpak Bharat", "Kab. Samosir", "Kab. Serdang Bedagai", "Kab. Simalungun", "Kab. Tapanuli Selatan", "Kab. Tapanuli Tengah", "Kab. Tapanuli Utara", "Kab. Toba", "Kota Binjai", "Kota Gunungsitoli", "Kota Medan", "Kota Padangsidempuan", "Kota Pematangsiantar", "Kota Sibolga", "Kota Tanjungbalai", "Kota Tebing Tinggi"],
        "Sumatera Barat": ["Kab. Agam", "Kab. Dharmasraya", "Kab. Kepulauan Mentawai", "Kab. Lima Puluh Kota", "Kab. Padang Pariaman", "Kab. Pasaman", "Kab. Pasaman Barat", "Kab. Pesisir Selatan", "Kab. Sijunjung", "Kab. Solok", "Kab. Solok Selatan", "Kab. Tanah Datar", "Kota Bukittinggi", "Kota Padang", "Kota Padang Panjang", "Kota Pariaman", "Kota Payakumbuh", "Kota Sawahlunto", "Kota Solok"],
        "Riau": ["Kab. Bengkalis", "Kab. Indragiri Hilir", "Kab. Indragiri Hulu", "Kab. Kampar", "Kab. Kepulauan Meranti", "Kab. Kuantan Singingi", "Kab. Pelalawan", "Kab. Rokan Hilir", "Kab. Rokan Hulu", "Kab. Siak", "Kota Dumai", "Kota Pekanbaru"],
        "Jambi": ["Kab. Batanghari", "Kab. Bungo", "Kab. Kerinci", "Kab. Merangin", "Kab. Muaro Jambi", "Kab. Sarolangun", "Kab. Tanjung Jabung Barat", "Kab. Tanjung Jabung Timur", "Kab. Tebo", "Kota Jambi", "Kota Sungai Penuh"],
        "Sumatera Selatan": ["Kab. Banyuasin", "Kab. Empat Lawang", "Kab. Lahat", "Kab. Muara Enim", "Kab. Musi Banyuasin", "Kab. Musi Rawas", "Kab. Musi Rawas Utara", "Kab. Ogan Ilir", "Kab. Ogan Komering Ilir", "Kab. Ogan Komering Ulu", "Kab. Ogan Komering Ulu Selatan", "Kab. Ogan Komering Ulu Timur", "Kab. Penukal Abab Lematang Ilir", "Kota Lubuklinggau", "Kota Pagar Alam", "Kota Palembang", "Kota Prabumulih"],
        "Bengkulu": ["Kab. Bengkulu Selatan", "Kab. Bengkulu Tengah", "Kab. Bengkulu Utara", "Kab. Kaur", "Kab. Kepahiang", "Kab. Lebong", "Kab. Mukomuko", "Kab. Rejang Lebong", "Kab. Seluma", "Kota Bengkulu"],
        "Lampung": ["Kab. Lampung Barat", "Kab. Lampung Selatan", "Kab. Lampung Tengah", "Kab. Lampung Timur", "Kab. Lampung Utara", "Kab. Mesuji", "Kab. Pesawaran", "Kab. Pesisir Barat", "Kab. Pringsewu", "Kab. Tanggamus", "Kab. Tulang Bawang", "Kab. Tulang Bawang Barat", "Kab. Way Kanan", "Kota Bandar Lampung", "Kota Metro"],
        "Kepulauan Bangka Belitung": ["Kab. Bangka", "Kab. Bangka Barat", "Kab. Bangka Selatan", "Kab. Bangka Tengah", "Kab. Belitung", "Kab. Belitung Timur", "Kota Pangkal Pinang"],
        "Kepulauan Riau": ["Kab. Bintan", "Kab. Karimun", "Kab. Kepulauan Anambas", "Kab. Lingga", "Kab. Natuna", "Kota Batam", "Kota Tanjung Pinang"],
        "DKI Jakarta": ["Kab. Adm. Kepulauan Seribu", "Kota Adm. Jakarta Barat", "Kota Adm. Jakarta Pusat", "Kota Adm. Jakarta Selatan", "Kota Adm. Jakarta Timur", "Kota Adm. Jakarta Utara"],
        "Jawa Barat": ["Kab. Bandung", "Kab. Bandung Barat", "Kab. Bekasi", "Kab. Bogor", "Kab. Ciamis", "Kab. Cianjur", "Kab. Cirebon", "Kab. Garut", "Kab. Indramayu", "Kab. Karawang", "Kab. Kuningan", "Kab. Majalengka", "Kab. Pangandaran", "Kab. Purwakarta", "Kab. Subang", "Kab. Sukabumi", "Kab. Sumedang", "Kab. Tasikmalaya", "Kota Bandung", "Kota Banjar", "Kota Bekasi", "Kota Bogor", "Kota Cimahi", "Kota Cirebon", "Kota Depok", "Kota Sukabumi", "Kota Tasikmalaya"],
        "Jawa Tengah": ["Kab. Banjarnegara", "Kab. Banyumas", "Kab. Batang", "Kab. Blora", "Kab. Boyolali", "Kab. Brebes", "Kab. Cilacap", "Kab. Demak", "Kab. Grobogan", "Kab. Jepara", "Kab. Karanganyar", "Kab. Kebumen", "Kab. Kendal", "Kab. Klaten", "Kab. Kudus", "Kab. Magelang", "Kab. Pati", "Kab. Pekalongan", "Kab. Pemalang", "Kab. Purbalingga", "Kab. Purworejo", "Kab. Rembang", "Kab. Semarang", "Kab. Sragen", "Kab. Sukoharjo", "Kab. Tegal", "Kab. Temanggung", "Kab. Wonogiri", "Kab. Wonosobo", "Kota Magelang", "Kota Pekalongan", "Kota Salatiga", "Kota Semarang", "Kota Surakarta", "Kota Tegal"],
        "DI Yogyakarta": ["Kab. Bantul", "Kab. Gunungkidul", "Kab. Kulon Progo", "Kab. Sleman", "Kota Yogyakarta"],
        "Jawa Timur": ["Kab. Bangkalan", "Kab. Banyuwangi", "Kab. Blitar", "Kab. Bojonegoro", "Kab. Bondowoso", "Kab. Gresik", "Kab. Jember", "Kab. Jombang", "Kab. Kediri", "Kab. Lamongan", "Kab. Lumajang", "Kab. Madiun", "Kab. Magetan", "Kab. Malang", "Kab. Mojokerto", "Kab. Nganjuk", "Kab. Ngawi", "Kab. Pacitan", "Kab. Pamekasan", "Kab. Pasuruan", "Kab. Ponorogo", "Kab. Probolinggo", "Kab. Sampang", "Kab. Sidoarjo", "Kab. Situbondo", "Kab. Sumenep", "Kab. Trenggalek", "Kab. Tuban", "Kab. Tulungagung", "Kota Batu", "Kota Blitar", "Kota Kediri", "Kota Madiun", "Kota Malang", "Kota Mojokerto", "Kota Pasuruan", "Kota Probolinggo", "Kota Surabaya"],
        "Banten": ["Kab. Lebak", "Kab. Pandeglang", "Kab. Serang", "Kab. Tangerang", "Kota Cilegon", "Kota Serang", "Kota Tangerang", "Kota Tangerang Selatan"],
        "Bali": ["Kab. Badung", "Kab. Bangli", "Kab. Buleleng", "Kab. Gianyar", "Kab. Jembrana", "Kab. Karangasem", "Kab. Klungkung", "Kab. Tabanan", "Kota Denpasar"],
        "Nusa Tenggara Barat": ["Kab. Bima", "Kab. Dompu", "Kab. Lombok Barat", "Kab. Lombok Tengah", "Kab. Lombok Timur", "Kab. Lombok Utara", "Kab. Sumbawa", "Kab. Sumbawa Barat", "Kota Bima", "Kota Mataram"],
        "Nusa Tenggara Timur": ["Kab. Alor", "Kab. Belu", "Kab. Ende", "Kab. Flores Timur", "Kab. Kupang", "Kab. Lembata", "Kab. Malaka", "Kab. Manggarai", "Kab. Manggarai Barat", "Kab. Manggarai Timur", "Kab. Nagekeo", "Kab. Ngada", "Kab. Rote Ndao", "Kab. Sabu Raijua", "Kab. Sikka", "Kab. Sumba Barat", "Kab. Sumba Barat Daya", "Kab. Sumba Tengah", "Kab. Sumba Timur", "Kab. Timor Tengah Selatan", "Kab. Timor Tengah Utara", "Kota Kupang"],
        "Kalimantan Barat": ["Kab. Bengkayang", "Kab. Kapuas Hulu", "Kab. Kayong Utara", "Kab. Ketapang", "Kab. Kubu Raya", "Kab. Landak", "Kab. Melawi", "Kab. Mempawah", "Kab. Sambas", "Kab. Sanggau", "Kab. Sekadau", "Kab. Sintang", "Kota Pontianak", "Kota Singkawang"],
        "Kalimantan Tengah": ["Kab. Barito Selatan", "Kab. Barito Timur", "Kab. Barito Utara", "Kab. Gunung Mas", "Kab. Kapuas", "Kab. Katingan", "Kab. Kotawaringin Barat", "Kab. Kotawaringin Timur", "Kab. Lamandau", "Kab. Murung Raya", "Kab. Pulang Pisau", "Kab. Sukamara", "Kab. Seruyan", "Kota Palangkaraya"],
        "Kalimantan Selatan": ["Kab. Balangan", "Kab. Banjar", "Kab. Barito Kuala", "Kab. Hulu Sungai Selatan", "Kab. Hulu Sungai Tengah", "Kab. Hulu Sungai Utara", "Kab. Kotabaru", "Kab. Tabalong", "Kab. Tanah Bumbu", "Kab. Tanah Laut", "Kab. Tapin", "Kota Banjarbaru", "Kota Banjarmasin"],
        "Kalimantan Timur": ["Kab. Berau", "Kab. Kutai Barat", "Kab. Kutai Kartanegara", "Kab. Kutai Timur", "Kab. Mahakam Ulu", "Kab. Paser", "Kab. Penajam Paser Utara", "Kota Balikpapan", "Kota Bontang", "Kota Samarinda"],
        "Kalimantan Utara": ["Kab. Bulungan", "Kab. Malinau", "Kab. Nunukan", "Kab. Tana Tidung", "Kota Tarakan"],
        "Sulawesi Utara": ["Kab. Bolaang Mongondow", "Kab. Bolaang Mongondow Selatan", "Kab. Bolaang Mongondow Timur", "Kab. Bolaang Mongondow Utara", "Kab. Kepulauan Sangihe", "Kab. Kepulauan Siau Tagulandang Biaro", "Kab. Kepulauan Talaud", "Kab. Minahasa", "Kab. Minahasa Selatan", "Kab. Minahasa Tenggara", "Kab. Minahasa Utara", "Kota Bitung", "Kota Kotamobagu", "Kota Manado", "Kota Tomohon"],
        "Sulawesi Tengah": ["Kab. Banggai", "Kab. Banggai Kepulauan", "Kab. Banggai Laut", "Kab. Buol", "Kab. Donggala", "Kab. Morowali", "Kab. Morowali Utara", "Kab. Parigi Moutong", "Kab. Poso", "Kab. Sigi", "Kab. Tojo Una-Una", "Kab. Tolitoli", "Kota Palu"],
        "Sulawesi Selatan": ["Kab. Bantaeng", "Kab. Barru", "Kab. Bone", "Kab. Bulukumba", "Kab. Enrekang", "Kab. Gowa", "Kab. Jeneponto", "Kab. Kepulauan Selayar", "Kab. Luwu", "Kab. Luwu Timur", "Kab. Luwu Utara", "Kab. Maros", "Kab. Pangkajene dan Kepulauan", "Kab. Pinrang", "Kab. Sidenreng Rappang", "Kab. Sinjai", "Kab. Soppeng", "Kab. Takalar", "Kab. Tana Toraja", "Kab. Toraja Utara", "Kab. Wajo", "Kota Makassar", "Kota Palopo", "Kota Parepare"],
        "Sulawesi Tenggara": ["Kab. Bombana", "Kab. Buton", "Kab. Buton Selatan", "Kab. Buton Tengah", "Kab. Buton Utara", "Kab. Kolaka", "Kab. Kolaka Timur", "Kab. Kolaka Utara", "Kab. Konawe", "Kab. Konawe Kepulauan", "Kab. Konawe Selatan", "Kab. Konawe Utara", "Kab. Muna", "Kab. Muna Barat", "Kab. Wakatobi", "Kota Bau-Bau", "Kota Kendari"],
        "Gorontalo": ["Kab. Boalemo", "Kab. Bone Bolango", "Kab. Gorontalo", "Kab. Gorontalo Utara", "Kab. Pohuwato", "Kota Gorontalo"],
        "Sulawesi Barat": ["Kab. Majene", "Kab. Mamasa", "Kab. Mamuju", "Kab. Mamuju Tengah", "Kab. Pasangkayu", "Kab. Polewali Mandar"],
        "Maluku": ["Kab. Buru", "Kab. Buru Selatan", "Kab. Kepulauan Aru", "Kab. Kepulauan Tanimbar", "Kab. Maluku Barat Daya", "Kab. Maluku Tengah", "Kab. Maluku Tenggara", "Kab. Seram Bagian Barat", "Kab. Seram Bagian Timur", "Kota Ambon", "Kota Tual"],
        "Maluku Utara": ["Kab. Halmahera Barat", "Kab. Halmahera Tengah", "Kab. Halmahera Timur", "Kab. Halmahera Selatan", "Kab. Halmahera Utara", "Kab. Kepulauan Sula", "Kab. Pulau Morotai", "Kab. Pulau Taliabu", "Kota Ternate", "Kota Tidore Kepulauan"],
        "Papua": ["Kab. Biak Numfor", "Kab. Jayapura", "Kab. Keerom", "Kab. Kepulauan Yapen", "Kab. Mamberamo Raya", "Kab. Sarmi", "Kab. Supiori", "Kab. Waropen", "Kota Jayapura"],
        "Papua Barat": ["Kab. Fakfak", "Kab. Kaimana", "Kab. Manokwari", "Kab. Manokwari Selatan", "Kab. Pegunungan Arfak", "Kab. Teluk Bintuni", "Kab. Teluk Wondama"],
        "Papua Tengah": ["Kab. Deiyai", "Kab. Dogiyai", "Kab. Intan Jaya", "Kab. Mimika", "Kab. Nabire", "Kab. Paniai", "Kab. Puncak", "Kab. Puncak Jaya"],
        "Papua Pegunungan": ["Kab. Jayawijaya", "Kab. Lanny Jaya", "Kab. Mamberamo Tengah", "Kab. Nduga", "Kab. Pegunungan Bintang", "Kab. Tolikara", "Kab. Yahukimo", "Kab. Yalimo"],
        "Papua Selatan": ["Kab. Asmat", "Kab. Boven Digoel", "Kab. Mappi", "Kab. Merauke"],
        "Papua Barat Daya": ["Kab. Maybrat", "Kab. Raja Ampat", "Kab. Sorong", "Kab. Sorong Selatan", "Kab. Tambrauw", "Kota Sorong"]
    };

    // Isi Dropdown Provinsi
    const provSelect = $j('#provinsi');
    Object.keys(dataWilayah).forEach(prov => {
        provSelect.append(new Option(prov, prov));
    });

    // Event ketika Provinsi berubah
    provSelect.on('change', function() {
        const selectedProv = $j(this).val();
        const kabupatenSelect = $j('#kabupaten');
        
        kabupatenSelect.empty().append('<option value="">- Pilih Kota/Kabupaten -</option>');

        if (selectedProv && dataWilayah[selectedProv]) {
            dataWilayah[selectedProv].forEach(kab => {
                kabupatenSelect.append(new Option(kab, kab));
            });
        }
        
        kabupatenSelect.trigger('change');
    });
});
</script>

<?php include 'footer.php'; ?>