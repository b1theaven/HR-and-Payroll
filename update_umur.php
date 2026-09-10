<?php
include 'koneksi.php';

// Update hanya karyawan yang ulang tahun hari ini
$query = "
    UPDATE karyawan
    SET umur = umur + 1
    WHERE DATE_FORMAT(tanggal_lahir, '%m-%d') = DATE_FORMAT(CURDATE(), '%m-%d')
";

$result = mysqli_query($koneksi, $query);

if ($result) {
    echo "Update umur berhasil (yang ulang tahun hari ini)";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>