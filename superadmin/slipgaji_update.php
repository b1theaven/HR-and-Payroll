<?php
session_start();
$username = $_SESSION['username'];

// menghubungkan koneksi
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

// update data
mysqli_query($koneksi, "update slip_gaji set nik='$nik', nama='$nama', bagian='$bagian', gp_hk_24='$gp_hk_24', ot_20='$ot_20', gaji_pokok='$gaji_pokok', tj_jab='$tj_jab', tj_skill='$tj_skill', tj_bagian='$tj_bagian', tj_kehadiran='$tj_kehadiran', uang_makan='$uang_makan', potongan_hk='$potongan_hk', bpjs_ket='$bpjs_ket', bpjs_kes='$bpjs_kes', pensiun='$pensiun', pph_21='$pph_21', gp='$gp', cos='$cos', bulan='$bulan', tahun='$tahun' where no_ktp='$no_ktp'");
$aksi = "Mengupdate slip gaji milik karyawan dengan NIK $nik.";

mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
// mengalihkan halaman kembali ke halaman pelanggan
header("location:slip_gaji.php?pesan=sukses");
