<?php
session_start();
$username = $_SESSION['username'];

// menghubungkan dengan koneksi
include '../koneksi.php';

// menangkap data yang dikirim dari form
$total = 1;
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

// input data ke tabel karyawan
mysqli_query($koneksi, "insert into karyawan (nik, nama, no_rekening, bagian, gender, tanggal_lahir, umur, agama, pendidikan, no_ktp, no_hp, tanggal_masuk, tanggal_keluar, status)
values('$nik','$nama','$no_rekening', '$bagian', '$gender', '$tanggal_lahir', '$umur', '$agama', '$pendidikan', '$no_ktp', '$no_hp', '$tanggal_masuk', '$tanggal_keluar', 0)");

$aksi = "Menambahkan $total data karyawan ke database.";

mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");


header("location:karyawan.php?pesan=oke");
