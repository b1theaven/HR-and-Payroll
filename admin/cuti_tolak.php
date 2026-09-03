<?php
include '../koneksi.php';
session_start();
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $alasan_admin = mysqli_real_escape_string($koneksi, $_POST['alasan_penolakan']);

    // 1. Ambil data pengajuan cuti & nomor HP karyawan berdasarkan ID Pengajuan
    $query_data = mysqli_query($koneksi, "
        SELECT pc.*, k.nama, k.no_hp 
        FROM potongan_cuti pc
        JOIN karyawan k ON pc.nik = k.nik
        WHERE pc.id = '$id'
    ");

    if ($query_data && mysqli_num_rows($query_data) > 0) {
        $d = mysqli_fetch_assoc($query_data);
        
        $nik = $d['nik'];
        $nama = $d['nama'];
        $jenis_cuti = $d['jenis_cuti'];
        $alasan_karyawan = $d['alasan'];
        $no_hp = preg_replace('/[^0-9]/', '', $d['no_hp']);
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }
        $tgl_awal = new DateTime($d['tanggal_mulai']);
        $tgl_akhir = new DateTime($d['tanggal_selesai']);
        $durasi_hari = $tgl_awal->diff($tgl_akhir)->days + 1;

        // 2. Update status pengajuan cuti menjadi DITOLAK (2) di tabel potongan_cuti
        $update = mysqli_query($koneksi, "UPDATE potongan_cuti SET status = 2 WHERE id = '$id'");

        if ($update) {
            // 3. Catat aktivitas penolakan ke audit log admin
            $aksi = "Menolak permohonan $jenis_cuti karyawan dengan NIK $nik.";
            mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");

            // 4. Susun pesan konfirmasi Penolakan Cuti via WhatsApp
            $pesan = "*PENGAJUAN CUTI DITOLAK*\n\n"
                   . "Halo *$nama* ($nik),\n"
                   . "Mohon maaf, permohonan *${jenis_cuti}* Anda *DITOLAK* oleh Atasan/Admin.\n\n"
                   . "*Detail Form Cuti:*\n"
                   . "📅 Periode: " . date('d-m-Y', strtotime($d['tanggal_mulai'])) . " s/d " . date('d-m-Y', strtotime($d['tanggal_selesai'])) . "\n"
                   . "⏳ Total Durasi: $durasi_hari Hari\n"
                   . "📝 Alasan Anda: \"$alasan_karyawan\"\n\n"
                   . "🚫 *Alasan Penolakan Admin:*\n"
                   . "\"$alasan_admin\"\n\n"
                   . "_Informasi: Silakan hubungi bagian HRD/Admin jika ada berkas bukti yang kurang atau ingin mengajukan permohonan ulang kembali._";

            // 5. Kirim Pesan via Fonnte API menggunakan cURL PHP
            $token = "6sZL6fQszJXv3v4igf56"; 

            $payload = http_build_query(array(
                'target' => $no_hp,
                'message' => $pesan
            ));

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: $token",
                    "Content-Type: application/x-www-form-urlencoded"
                ),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ));

            $response = curl_exec($curl);
            curl_close($curl);
        }
    }

    // 6. Jalankan lempar halaman (Redirect) membawa parameter status ditolak (2) & pesan tolak
    header("Location: cuti.php?status=2&pesan=tolak");
    exit();
}
?>