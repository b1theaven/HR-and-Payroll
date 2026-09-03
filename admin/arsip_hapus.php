<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Tidak diketahui';

// menghubungkan koneksi
include '../koneksi.php';

// menangkap data id yang dikirim dari url
$nik = $_GET['id'];

// menghapus pelanggan
$aksi = "Menghapus arsip karyawan dengan NIK $nik.";
        mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");

        mysqli_query($koneksi, "delete from arsip_karyawan where nik='$nik'");

// alihkan halaman ke halaman pelanggan
header("location:arsip_karyawan.php?pesan=terhapus");