<?php
session_start();
$username = $_SESSION['username'];
include '../koneksi.php';

$nik = $_GET['id'];

// Ambil data dari tabel karyawan berdasarkan NIK
$query = mysqli_query($koneksi, "SELECT * FROM arsip_karyawan WHERE nik='$nik'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    // Insert ke arsip_karyawan
    $insert = mysqli_query($koneksi, "INSERT INTO karyawan 
        (nik, nama, no_rekening, bagian, gender, tanggal_lahir, umur, agama, pendidikan, no_ktp, no_hp, tanggal_masuk, tanggal_keluar, status)
        VALUES (
            '{$data['nik']}',
            '{$data['nama']}',
            '{$data['no_rekening']}',
            '{$data['bagian']}',
            '{$data['gender']}',
            '{$data['tanggal_lahir']}',
            '{$data['umur']}',
            '{$data['agama']}',
            '{$data['pendidikan']}',
            '{$data['no_ktp']}',
            '{$data['no_hp']}',
            '{$data['tanggal_masuk']}',
            '{$data['tanggal_keluar']}',
            '{$data['status']}'
        )
    ");

    // Jika insert berhasil, baru hapus
    if ($insert) {
        mysqli_query($koneksi, "DELETE FROM slip_gaji WHERE no_ktp='{$data['no_ktp']}'");
        $delete = mysqli_query($koneksi, "DELETE FROM arsip_karyawan WHERE nik='$nik'");
        $aksi = "Mengembalikan data karyawan dengan NIK $nik dari folder arsip.";

        mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");

        if ($delete) {
            header("location:arsip_karyawan.php?pesan=oke");
        } else {
            header("location:arsip_karyawan.php?pesan=gagal_menghapus");
        }
    } else {
        header("location:arsip_karyawan.php?pesan=gagal_insert");
    }
} else {
    header("location:arsip_karyawan.php?pesan=data_tidak_ditemukan");
}
?>