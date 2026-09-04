<?php
session_start();
$username = $_SESSION['username'];

// menghubungkan koneksi
include '../koneksi.php';

// menangkap data yang dikirim dari form
$nik = $_POST['nik'];
$nama = $_POST['nama'];
$no_rekening = $_POST['no_rekening'];
$bagian = $_POST['bagian'];
$gender = $_POST['gender'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$umur = $_POST['umur'];
$agama = $_POST['agama'];
$pendidikan = $_POST['pendidikan'];
$no_ktp = $_POST['no_ktp'];
$no_hp = $_POST['no_hp'];
$tanggal_masuk = $_POST['tanggal_masuk'];
$tanggal_keluar = $_POST['tanggal_keluar'];
$status = isset($_POST['status']) && $_POST['status'] !== '' ? $_POST['status'] : $_POST['old_status'];

// update data
mysqli_query($koneksi, "update karyawan set nama='$nama', no_rekening='$no_rekening', bagian='$bagian', gender='$gender', tanggal_lahir='$tanggal_lahir', umur='$umur', agama='$agama', pendidikan='$pendidikan', no_ktp='$no_ktp', no_hp='$no_hp', tanggal_masuk='$tanggal_masuk', tanggal_keluar='$tanggal_keluar', status='$status' where nik='$nik'");
$aksi = "Mengedit data karyawan dengan NIK $nik.";

mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");

// mengalihkan halaman kembali ke halaman pelanggan
header("location:karyawan.php?pesan=sukses");
