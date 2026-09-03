<?php
include 'koneksi.php';

$nama = $_POST['nama'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$gender = $_POST['gender'] ?? '';
$divisi = $_POST['divisi'] ?? '';
$umur = $_POST['umur'] ?? '';
$ktp = $_POST['ktp'];
$cv = $_POST['cv'];
$surat_lamaran = $_POST['surat_lamaran'];
$ijazah = $_POST['ijazah'];
$skck = $_POST['skck'];
$sehat = $_POST['sehat'];
$tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
$sertifikat = !empty($_POST['sertifikat']) ? $_POST['sertifikat'] : NULL;

if ($nama == "" || $no_hp == "") {
    echo "DATA_INVALID";
    exit;
}

// Cek agar nomor HP tidak duplikat
$cek = mysqli_query($koneksi, "SELECT * FROM calon_karyawan WHERE no_hp='$no_hp'");
if (mysqli_num_rows($cek) > 0) {
    echo "DUPLICATE";
    exit;
}

mysqli_query($koneksi, "
INSERT INTO calon_karyawan 
(nama, no_hp, gender, divisi, tanggal_lahir, ktp, cv, umur, surat_lamaran, ijazah, skck, sehat, sertifikat)
VALUES 
('$nama', '$no_hp', '$gender', '$divisi', '$tanggal_lahir', '$ktp', '$cv', '$umur', '$surat_lamaran', '$ijazah', '$skck', '$sehat', ".($sertifikat ? "'$sertifikat'" : "NULL")."
)
");
echo "OK";
?>