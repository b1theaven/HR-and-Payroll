<?php
session_start();
$username = $_SESSION['username'];

// menghubungkan dengan koneksi
include '../koneksi.php';

// menangkap data yang dikirim dari form
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$bagian = $_POST['bagian'];
$gp_hk_24 = $_POST['gp_hk_24'];
$ot_20 = $_POST['ot_20'];
$gaji_pokok = $_POST['gaji_pokok'];
$tj_jab = $_POST['tj_jab'];
$tj_skill = $_POST['tj_skill'];
$tj_bagian = $_POST['tj_bagian'];
$tj_kehadiran = $_POST['tj_kehadiran'];
$uang_makan = $_POST['uang_makan'];
$potongan_hk = $_POST['potongan_hk'];
$bpjs_ket = $_POST['bpjs_ket'];
$bpjs_kes = $_POST['bpjs_kes'];
$pensiun = $_POST['pensiun'];
$pph_21 = $_POST['pph_21'];
$gp = $_POST['gp'];
$cos = $_POST['cos'];
$no_ktp = $_POST['no_ktp'];
$bulan = date('n');
$tahun = date('Y');

// input data ke tabel slip gaji
mysqli_query($koneksi, "insert into slip_gaji (nik, nama, bagian, gp_hk_24, ot_20, gaji_pokok, tj_jab, tj_skill, tj_bagian, tj_kehadiran, uang_makan, potongan_hk, bpjs_ket, bpjs_kes, pensiun, pph_21, gp, cos, no_ktp, bulan, tahun)
values('$nik','$nama','$bagian', '$gp_hk_24', '$ot_20', '$gaji_pokok', '$tj_jab', '$tj_skill', '$tj_bagian', '$tj_kehadiran', '$uang_makan', '$potongan_hk', '$bpjs_ket', '$bpjs_kes', '$pensiun', '$pph_21', '$gp', '$cos', '$no_ktp', '$bulan', '$tahun')");

$aksi = "Menambahkan slip gaji dari karyawan $nik ke database.";

mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");

header("location:slip_gaji.php?pesan=oke");
