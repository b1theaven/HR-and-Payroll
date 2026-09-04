<?php
include '../koneksi.php';

// Filter status jika dipanggil dari halaman utama
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$where = "";

if ($status_filter != "") {
    $where = "WHERE tl.status = '$status_filter'";
}

// Query data pengajuan lembur
$data = mysqli_query($koneksi, "
    SELECT 
        tl.*, 
        k.nama 
    FROM tambahan_lembur tl
    LEFT JOIN karyawan k ON tl.nik = k.nik
    $where
    ORDER BY tl.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Lembur_Karyawan_SPS_<?= date('dMY') ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #555;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            border: 1px solid #444;
            padding: 8px 10px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        .text-center {
            text-align: center;
        }
        .footer-sign {
            margin-top: 50px;
            float: right;
            text-align: center;
            width: 200px;
        }
    </style>
</head>
<body>
    <!-- Header Kop Laporan -->
    <div class="header">
        <h2>PT. SUMBER PELITA SUKSES</h2>
        <p><b>LAPORAN REKAPITULASI PENGAJUAN LEMBUR KARYAWAN</b></p>
        <p>Tanggal Cetak: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <!-- Tabel Data Lembur -->
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIK</th>
                <th width="20%">Nama Karyawan</th>
                <th width="15%">Jam Lembur</th>
                <th>Alasan</th>
                <th width="12%">Status</th>
                <th width="18%">Tanggal Request</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($data) == 0) {
                echo '<tr><td colspan="7" class="text-center" style="color: red;">Data pengajuan lembur belum ada.</td></tr>';
            } else {
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                    // Penentuan Label Status
                    if ($d['status'] == 0) {
                        $statusText = '<b style="color: #f0ad4e;">PENDING</b>';
                    } elseif ($d['status'] == 1) {
                        $statusText = '<b style="color: #5cb85c;">DITERIMA</b>';
                    } else {
                        $statusText = '<b style="color: #d9534f;">DITOLAK</b>';
                    }
            ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><?= htmlspecialchars($d['nik']) ?></td>
                        <td><?= htmlspecialchars($d['nama']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($d['jam_mulai']) ?> - <?= htmlspecialchars($d['jam_selesai']) ?></td>
                        <td><?= htmlspecialchars($d['alasan']) ?></td>
                        <td class="text-center"><?= $statusText ?></td>
                        <td class="text-center"><?= date('d-m-Y H:i', strtotime($d['created_at'])) ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <!-- Tanda Tangan Admin/HRD + TTD Digital -->
    <div class="footer-sign">
        <p>Tangerang, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>

        <!-- Gambar Tanda Tangan Digital -->
        <div style="margin: 5px 0;">
            <img src="../assets/images/ttd_admin.png" 
                 alt="Tanda Tangan Digital" 
                 style="width: 120px; height: auto; display: block; margin: 0 auto;">
        </div>

        <p><b>Admin</b></p>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>