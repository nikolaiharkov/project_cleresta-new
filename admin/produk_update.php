<?php 
include '../koneksi.php';

$id         = $_POST['id'];
$nama       = mysqli_real_escape_string($koneksi, $_POST['nama']);
$kategori   = $_POST['kategori'];
$harga      = (int)$_POST['harga'];
$stok       = (int)$_POST['stok']; // Pastikan casting integer
$berat      = (int)$_POST['berat'];
$desc       = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

// 1. Update data informasi teks (Termasuk Stok & Berat)
mysqli_query($koneksi, "UPDATE produk SET 
    produk_nama='$nama', 
    produk_kategori='$kategori', 
    produk_harga='$harga', 
    produk_jumlah='$stok', 
    produk_berat='$berat', 
    produk_keterangan='$desc' 
    WHERE produk_id='$id'") or die(mysqli_error($koneksi));

// 2. Logika Update 3 Foto
$allowed = array('gif','png','jpg','jpeg');

for($i=1; $i<=3; $i++){
    $input_name = "foto".$i;
    $db_column  = "produk_foto".$i;

    if($_FILES[$input_name]['name'] != ""){
        $filename = $_FILES[$input_name]['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if(in_array(strtolower($ext), $allowed)) {
            $rand = rand();
            $new_filename = $rand.'_'.$filename;

            // Hapus foto lama dari folder
            $lama = mysqli_query($koneksi, "SELECT $db_column FROM produk WHERE produk_id='$id'");
            $l = mysqli_fetch_assoc($lama);
            if($l[$db_column] != "" && file_exists('../gambar/produk/'.$l[$db_column])){
                unlink('../gambar/produk/'.$l[$db_column]);
            }

            // Upload dan update database
            move_uploaded_file($_FILES[$input_name]['tmp_name'], '../gambar/produk/'.$new_filename);
            mysqli_query($koneksi, "UPDATE produk SET $db_column='$new_filename' WHERE produk_id='$id'");
        }
    }
}

header("location:produk.php?alert=update_sukses");
exit;
?>