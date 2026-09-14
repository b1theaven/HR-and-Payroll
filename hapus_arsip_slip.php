<?php
include 'koneksi.php';

// bulan sebelumnya
$bulan_sekarang = date('n');
$tahun_sekarang = date('Y');

// Hitung bulan yang masih boleh disimpan = bulan lalu
$bulan_simpan = $bulan_sekarang - 1;
$tahun_simpan = $tahun_sekarang;

if ($bulan_simpan == 0) {
    $bulan_simpan = 12;
    $tahun_simpan--;
}

// Hapus yang lebih lama dari bulan simpan
$query = "
DELETE FROM slip_gaji_arsip
WHERE (tahun < '$tahun_simpan')
OR (tahun = '$tahun_simpan' AND bulan < '$bulan_simpan')
";

$result = mysqli_query($koneksi, $query);

if ($result) {
    echo "Arsip lama berhasil dibersihkan.";
} else {
    echo mysqli_error($koneksi);
}
?>