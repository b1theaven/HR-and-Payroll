<?php
session_start();
$username = $_SESSION['username'];

// koneksi ke database 
include '../koneksi.php';

// ambil ID calon karyawan dari URL
$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT nama FROM calon_karyawan WHERE id='$id'");
$d = mysqli_fetch_assoc($data);

$nama = $d['nama'];
$aksi = "Menghapus data calon karyawan dengan nama $nama.";
mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
mysqli_query($koneksi, "DELETE FROM calon_karyawan WHERE id='$id'");

header("location:calon_karyawan.php?pesan=dihapus");
exit;