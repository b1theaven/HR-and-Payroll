<?php
include '../koneksi.php';

// Ambil seluruh data karyawan dari database
$data = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nik ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Data_Karyawan_SPS_<?= date('dMY') ?></title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            font-size: 16px;
        }
        .header p {
            margin: 4px 0 0;
            font-size: 10px;
            color: #555;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table th, .table td {
            border: 1px solid #444;
            padding: 5px 6px;
            font-size: 9.5px;
            word-wrap: break-word;
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
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
        }
        
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    
    <div class="header">
        <h2>PT. SUMBER PELITA SUKSES</h2>
        <p><b>LAPORAN DATA KARYAWAN PERUSAHAAN</b></p>
        <p>Tanggal Cetak: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th>NIK</th>
                <th>Nama Karyawan</th>
                <th>No. Rekening</th>
                <th>Bagian</th>
                <th>JK</th>
                <th>Tgl Lahir / Umur</th>
                <th>Agama</th>
                <th>Pendidikan</th>
                <th>No. KTP</th>
                <th>No. HP</th>
                <th>Tgl Masuk</th>
                <th>Tgl Keluar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($data) == 0) {
                echo '<tr><td colspan="14" class="text-center" style="color: red; font-weight: bold;">Data karyawan belum tersedia.</td></tr>';
            } else {
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                    $jk = strtoupper($d['gender']) === 'L' ? 'L' : 'P';
                    $tgl_lahir = ($d['tanggal_lahir'] && $d['tanggal_lahir'] != '0000-00-00') ? date('d-m-Y', strtotime($d['tanggal_lahir'])) : '-';
                    $tgl_masuk = ($d['tanggal_masuk'] && $d['tanggal_masuk'] != '0000-00-00') ? date('d-m-Y', strtotime($d['tanggal_masuk'])) : '-';
                    $tgl_keluar = ($d['tanggal_keluar'] && $d['tanggal_keluar'] != '0000-00-00') ? date('d-m-Y', strtotime($d['tanggal_keluar'])) : '-';
                    if ($d['status'] == 1) {
                        $statusBadge = '<span style="color: green; font-weight: bold;">Aktif</span>';
                    } else {
                        $statusBadge = '<span style="color: red; font-weight: bold;">Non-Aktif</span>';
                    }
            ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><b><?= htmlspecialchars($d['nik']) ?></b></td>
                        <td><?= htmlspecialchars($d['nama']) ?></td>
                        <td class="text-center"><?= !empty($d['no_rekening']) ? htmlspecialchars($d['no_rekening']) : '-' ?></td>
                        <td><?= htmlspecialchars($d['bagian']) ?></td>
                        <td class="text-center"><?= $jk ?></td>
                        <td class="text-center"><?= $tgl_lahir ?> (<?= $d['umur'] ?> th)</td>
                        <td class="text-center"><?= htmlspecialchars($d['agama']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($d['pendidikan']) ?></td>
                        <td class="text-center"><?= htmlspecialchars($d['no_ktp']) ?></td>
                        <td class="text-center"><?= !empty($d['no_hp']) ? htmlspecialchars($d['no_hp']) : '-' ?></td>
                        <td class="text-center"><?= $tgl_masuk ?></td>
                        <td class="text-center"><?= $tgl_keluar ?></td>
                        <td class="text-center"><?= $statusBadge ?></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

    <div class="footer-sign">
        <p>Tangerang, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        
        <div style="height: 60px; margin: 5px 0;">
            <img src="../assets/images/ttd_superadmin.png" style="width: 100px;">
        </div>

        <p><b>Superadmin</b></p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>