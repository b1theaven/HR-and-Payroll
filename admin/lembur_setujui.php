<?php
include '../koneksi.php';
session_start();
$username = $_SESSION['username'];

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Ambil detail pengajuan lembur & profil lengkap karyawan berdasarkan NIK
    $query_data = mysqli_query($koneksi, "
        SELECT 
            tl.*, 
            k.nama, 
            k.bagian, 
            k.no_ktp, 
            k.no_hp 
        FROM tambahan_lembur tl
        JOIN karyawan k ON tl.nik = k.nik
        WHERE tl.id = '$id'
    ");

    if ($query_data && mysqli_num_rows($query_data) > 0) {
        $d = mysqli_fetch_assoc($query_data);
        
        $nik = $d['nik'];
        $nama = $d['nama'];
        $bagian = $d['bagian'];
        $no_ktp = $d['no_ktp'];
        $nominal_lembur = intval($d['nominal']); 

        $no_hp = preg_replace('/[^0-9]/', '', $d['no_hp']);
        if (substr($no_hp, 0, 1) === '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }

        $bulan_sekarang = date('n');
        $tahun_sekarang = date('Y');
        
        $bulan_indo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $nama_bulan = $bulan_indo[$bulan_sekarang];

        // 2. Update status pengajuan lembur di tabel tambahan_lembur menjadi DITERIMA (1)
        $update_status = mysqli_query($koneksi, "UPDATE tambahan_lembur SET status = 1 WHERE id = '$id'");

        if ($update_status) {

            $query_payroll = "
                INSERT INTO slip_gaji (nik, nama, bagian, no_ktp, bulan, tahun, ot_20) 
                VALUES ('$nik', '$nama', '$bagian', '$no_ktp', '$bulan_sekarang', '$tahun_sekarang', '$nominal_lembur')
                ON DUPLICATE KEY UPDATE ot_20 = ot_20 + '$nominal_lembur'
            ";
            
            $eksekusi_payroll = mysqli_query($koneksi, $query_payroll);
            
            if (!$eksekusi_payroll) {
                die("<h3 style='color:red;'>--- DATABASE ERROR ON SLIP_GAJI ---</h3>" . mysqli_error($koneksi));
            }
            
        $aksi = "Menerima permintaan lembur karyawan dengan NIK $nik.";
        
        mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
        
            // 3. Kirim Notifikasi Sukses via Bot WhatsApp ke Karyawan
            if (!empty($no_hp)) {
                $pesan = "*PENGAJUAN LEMBUR DI-ACC*\n\n"
                       . "Halo *$nama* ($nik),\n"
                       . "Selamat, pengajuan lembur Anda telah *DISETUJUI* oleh Atasan/Admin.\n\n"
                       . "📋 *Detail Form Pengajuan:*\n"
                       . "⏰ Jam Kerja: " . $d['jam_mulai'] . " - " . $d['jam_selesai'] . "\n"
                       . "📝 Alasan Anda: " . $d['alasan'] . "\n"
                       . "💰 Nominal Lembur: Rp " . number_format($nominal_lembur, 0, ',', '.') . "\n\n"
                       . " Nominal tersebut otomatis diakumulasikan ke dalam payroll Anda periode bulan $nama_bulan/$tahun_sekarang.\n\n"
                       . "_Terima kasih atas dedikasi dan kerja kerasnya!_";

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

    header("Location: lembur.php?status=1&pesan=terima");
    exit();
}
?>