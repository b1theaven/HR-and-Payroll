<?php
include '../koneksi.php';
session_start();
$username = $_SESSION['username'];

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Ambil detail pengajuan cuti & profil nomor HP karyawan berdasarkan ID Pengajuan
    $query_data = mysqli_query($koneksi, "
        SELECT 
            pc.*, 
            k.nama, 
            k.no_hp 
        FROM potongan_cuti pc
        JOIN karyawan k ON pc.nik = k.nik
        WHERE pc.id = '$id'
    ");

    if ($query_data && mysqli_num_rows($query_data) > 0) {
        $d = mysqli_fetch_assoc($query_data);
        $nik = $d['nik'];
        $nama = $d['nama'];
        $jenis_cuti = $d['jenis_cuti'];
        $alasan = $d['alasan'];
        $tgl_awal = new DateTime($d['tanggal_mulai']);
        $tgl_akhir = new DateTime($d['tanggal_selesai']);
        $durasi_hari = $tgl_awal->diff($tgl_akhir)->days + 1;
        $no_hp = preg_replace('/[^0-9]/', '', $d['no_hp']);
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }

        // 2. Update status pengajuan cuti di tabel potongan_cuti menjadi DISETUJUI / DITERIMA (1)
        $update_status = mysqli_query($koneksi, "UPDATE potongan_cuti SET status = 1 WHERE id = '$id'");

        if ($update_status) {
            $aksi = "Menerima permohonan $jenis_cuti karyawan dengan NIK $nik.";
            mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
        
            // 3. Kirim Notifikasi Sukses via Bot WhatsApp ke Karyawan
            if (!empty($no_hp)) {
                $pesan = "*PENGAJUAN CUTI DI-ACC*\n\n"
                       . "Halo *$nama* ($nik),\n"
                       . "Selamat, permohonan *${jenis_cuti}* Anda telah *DISETUJUI* oleh Atasan/Admin.\n\n"
                       . "*Detail Form Cuti:*\n"
                       . "📅 Periode: " . date('d-m-Y', strtotime($d['tanggal_mulai'])) . " s/d " . date('d-m-Y', strtotime($d['tanggal_selesai'])) . "\n"
                       . "⏳ Total Durasi: $durasi_hari Hari\n"
                       . "📝 Alasan Anda: \"$alasan\"\n\n"
                       . "_Permohonan telah aktif pada sistem pencatatan internal. Terima kasih dan selamat beristirahat / menjalankan keperluan Anda!_";

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
    }

    header("Location: cuti.php?status=1&pesan=terima");
    exit();
}
?>