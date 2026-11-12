<?php
session_start();
$username = $_SESSION['username'];
// menghubungkan koneksi 
include '../koneksi.php';

// menangkap data id yang dikirim dari url 
$nik = $_GET['id'];

// menghapus transaksi
$aksi = "Menghapus slip gaji milik karyawan dengan NIK $nik.";
        mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
        mysqli_query($koneksi, "delete from slip_gaji where nik='$nik'");

// alihkan halaman ke halaman transaksi 
header("location:slip_gaji.php?pesan=terhapus");
