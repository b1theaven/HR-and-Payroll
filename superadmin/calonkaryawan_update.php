<?php
session_start();
include '../koneksi.php';

// Ambil data dari form
$id     = $_POST['id'] ?? '';
$nama   = $_POST['nama'] ?? '';
$no_hp  = $_POST['no_hp'] ?? '';
$divisi = $_POST['divisi'] ?? '';
$gender = $_POST['gender'] ?? '';
$status = $_POST['status'] ?? '';
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$alasan = $_POST['alasan'] ?? '';

// Validasi sederhana
if ($id == '' || $status == '') {
    header("location:calon_karyawan.php?pesan=gagal");
    exit;
}

// Ambil alasan lama dari database
$get = mysqli_query($koneksi, "SELECT alasan FROM calon_karyawan WHERE id='$id'");
$data_lama = mysqli_fetch_assoc($get);
$alasan_lama = $data_lama['alasan'];

// Jika alasan kosong → pakai alasan lama
if ($alasan == '' || $alasan == null) {
    $alasan = $alasan_lama;
}

// Update data
$query = "UPDATE calon_karyawan SET 
            nama='$nama',
            no_hp='$no_hp',
            divisi='$divisi',
            gender='$gender',
            status='$status',
            alasan='$alasan',
            tanggal_lahir='$tanggal_lahir'
          WHERE id='$id'";

$update = mysqli_query($koneksi, $query);

// Cek hasil
if ($update) {
    $username = $_SESSION['username'];
        $statusText = ($status == "1") ? "LOLOS" : (($status == "2") ? "TIDAK LOLOS" : "PENDING");
    
        $aksi = "Mengubah data calon karyawan $nama menjadi status $statusText dengan alasan: $alasan";
    
        mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");

    header("location:calon_karyawan.php?pesan=sukses");
} else {
    echo "Gagal update data: " . mysqli_error($koneksi);
}
?>