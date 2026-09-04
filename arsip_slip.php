<?php
include 'koneksi.php';

// Mulai transaksi
mysqli_begin_transaction($koneksi);

try {

    // 1. Copy ke arsip
    mysqli_query($koneksi, "
        INSERT INTO slip_gaji_arsip (
            nik,nama,bagian,gp_hk_24,ot_20,gaji_pokok,
            tj_jab,tj_skill,tj_bagian,tj_kehadiran,
            uang_makan,potongan_hk,bpjs_ket,bpjs_kes,
            pensiun,pph_21,gp,cos,no_ktp,bulan,tahun
        )
        SELECT 
            nik,nama,bagian,gp_hk_24,ot_20,gaji_pokok,
            tj_jab,tj_skill,tj_bagian,tj_kehadiran,
            uang_makan,potongan_hk,bpjs_ket,bpjs_kes,
            pensiun,pph_21,gp,cos,no_ktp,bulan,tahun
        FROM slip_gaji
    ");

    // 2. Hapus tabel utama
    mysqli_query($koneksi, "DELETE FROM slip_gaji");

    mysqli_commit($koneksi);

    echo "Arsip berhasil.";

} catch (Exception $e) {

    mysqli_rollback($koneksi);

    echo "Gagal: " . $e->getMessage();
}
?>