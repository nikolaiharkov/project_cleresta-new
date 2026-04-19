<?php 
session_start(); // Memulai sesi agar bisa dihapus
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghapus data sesi di server

// Alihkan ke halaman login di folder utama (keluar dari folder admin)
header("location:../login.php?alert=logout");
exit(); // Wajib ada agar kode di bawahnya tidak dieksekusi
?>