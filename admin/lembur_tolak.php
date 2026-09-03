<?php
include '../koneksi.php';
session_start();
$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $alasan_admin = mysqli_real_escape_string($koneksi, $_POST['alasan_penolakan']);

    // 1. Ambil data pengajuan lembur & nomor HP karyawan berdasarkan NIK
    $query_data = mysqli_query($koneksi, "
        SELECT tl.*, k.nama, k.no_hp 
        FROM tambahan_lembur tl
        JOIN karyawan k ON tl.nik = k.nik
        WHERE tl.id = '$id'
    ");

    if ($query_data && mysqli_num_rows($query_data) > 0) {
        $d = mysqli_fetch_assoc($query_data);
        
        $nik = $d['nik'];
        $nama = $d['nama'];
        $no_hp = $d['no_hp'];
        $jam_mulai = $d['jam_mulai'];
        $jam_selesai = $d['jam_selesai'];
        $alasan_karyawan = $d['alasan'];

        // 2. Update status pengajuan lembur menjadi DITOLAK (2), nominal = 0, alasan_admin diisi
        $update = mysqli_query($koneksi, "
            UPDATE tambahan_lembur 
            SET status = 2, 
                alasan_admin = '$alasan_admin', 
                nominal = 0 
            WHERE id = '$id'
        ");

        $aksi = "Menolak permintaan lembur karyawan dengan NIK $nik.";
        
        mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
        
        if ($update && !empty($no_hp)) {
            // 3. Susun template pesan teks Bot WhatsApp
            $pesan = "*PENGAJUAN LEMBUR DITOLAK*\n\n"
                   . "Halo *$nama* ($nik),\n"
                   . "Pengajuan lembur Anda telah ditolak oleh Atasan/Admin.\n\n"
                   . "📋 *Detail Form Pengajuan:*\n"
                   . "⏰ Jam Kerja: $jam_mulai - $jam_selesai\n"
                   . "📝 Alasan Anda: $alasan_karyawan\n\n"
                   . "🚫 *Alasan Penolakan Admin:*\n"
                   . "\"$alasan_admin\"\n\n"
                   . "💡 _Informasi: Anda diperbolehkan mengajukan ulang form lembur kembali hari ini jika ada kesalahan data sebelumnya._";

            // 4. Kirim Pesan via Fonnte API menggunakan cURL PHP
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

    header("Location: lembur.php?status=2&pesan=tolak");
    exit();
}
?>