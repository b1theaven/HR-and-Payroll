<?php
include '../koneksi.php';

$nama_bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

$bulan_filter = isset($_GET['bulan']) ? intval($_GET['bulan']) : '';
$tahun_filter = isset($_GET['tahun']) ? intval($_GET['tahun']) : '';

$where = [];
if ($bulan_filter !== 0 && $bulan_filter !== '') {
    $where[] = "bulan = '$bulan_filter'";
}
if ($tahun_filter !== 0 && $tahun_filter !== '') {
    $where[] = "tahun = '$tahun_filter'";
}

$where_clause = "";
if (count($where) > 0) {
    $where_clause = "WHERE " . implode(" AND ", $where);
}

$data = mysqli_query($koneksi, "SELECT * FROM slip_gaji $where_clause ORDER BY tahun DESC, bulan DESC, nama ASC");
$periode_text = "SEMUA PERIODE";
if ($bulan_filter != '' && $tahun_filter != '') {
    $periode_text = "PERIODE: " . strtoupper($nama_bulan[$bulan_filter] ?? '') . " " . $tahun_filter;
} elseif ($tahun_filter != '') {
    $periode_text = "PERIODE TAHUN: " . $tahun_filter;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan_Rekapitulasi_Gaji_SPS_<?= date('dMY') ?></title>
    <style>
        @page {
            size: A4 landscape;
            margin: 6mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            color: #222;
            margin: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 2px solid #222;
            padding-bottom: 8px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            text-transform: uppercase;
            font-size: 15px;
        }
        .header p {
            margin: 3px 0 0;
            font-size: 10px;
            color: #444;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .table th, .table td {
            border: 1px solid #333;
            padding: 4px 5px;
            font-size: 8.5px;
            word-wrap: break-word;
        }
        .table th {
            background-color: #e9ecef;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .footer-sign {
            margin-top: 25px;
            float: right;
            text-align: center;
            width: 200px;
        }

        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>PT. SUMBER PELITA SUKSES</h2>
        <p><b>LAPORAN REKAPITULASI SLIP GAJI KARYAWAN</b></p>
        <p><b><?= $periode_text ?></b> | Tanggal Cetak: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th width="2%">No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Bagian</th>
                <th>Bulan/Thn</th>
                <th>Gaji Pokok</th>
                <th>Tj. Jab</th>
                <th>Tj. Skill</th>
                <th>Tj. Bagian</th>
                <th>Tj. Hadir</th>
                <th>U. Makan</th>
                <th>Pot. HK</th>
                <th>BPJS Ket</th>
                <th>BPJS Kes</th>
                <th>Pensiun</th>
                <th>PPh 21</th>
                <th>COS</th>
                <th>Gaji Bersih (THP)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($data) == 0) {
                echo '<tr><td colspan="18" class="text-center" style="color: red; font-weight: bold;">Data slip gaji tidak ditemukan.</td></tr>';
            } else {
                $no = 1;
                $tot_gaji_pokok = $tot_tj_jab = $tot_tj_skill = $tot_tj_bagian = 0;
                $tot_tj_kehadiran = $tot_uang_makan = $tot_pot_hk = $tot_bpjs_ket = 0;
                $tot_bpjs_kes = $tot_pensiun = $tot_pph21 = $tot_cos = $tot_gp = 0;

                while ($d = mysqli_fetch_array($data)) {
                    $tot_gaji_pokok  += $d['gaji_pokok'];
                    $tot_tj_jab      += $d['tj_jab'];
                    $tot_tj_skill    += $d['tj_skill'];
                    $tot_tj_bagian   += $d['tj_bagian'];
                    $tot_tj_kehadiran+= $d['tj_kehadiran'];
                    $tot_uang_makan  += $d['uang_makan'];
                    $tot_pot_hk      += $d['potongan_hk'];
                    $tot_bpjs_ket    += $d['bpjs_ket'];
                    $tot_bpjs_kes    += $d['bpjs_kes'];
                    $tot_pensiun     += $d['pensiun'];
                    $tot_pph21       += $d['pph_21'];
                    $tot_cos         += $d['cos'];
                    $tot_gp          += $d['gp'];

                    $bln_nama = $nama_bulan[$d['bulan']] ?? $d['bulan'];
            ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center"><b><?= htmlspecialchars($d['nik']) ?></b></td>
                        <td><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= htmlspecialchars($d['bagian']) ?></td>
                        <td class="text-center"><?= $bln_nama ?>/<?= $d['tahun'] ?></td>
                        <td class="text-right"><?= number_format($d['gaji_pokok'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($d['tj_jab'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($d['tj_skill'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($d['tj_bagian'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($d['tj_kehadiran'], 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($d['uang_makan'], 0, ',', '.') ?></td>
                        <td class="text-right" style="color: red;"><?= number_format($d['potongan_hk'], 0, ',', '.') ?></td>
                        <td class="text-right" style="color: red;"><?= number_format($d['bpjs_ket'], 0, ',', '.') ?></td>
                        <td class="text-right" style="color: red;"><?= number_format($d['bpjs_kes'], 0, ',', '.') ?></td>
                        <td class="text-right" style="color: red;"><?= number_format($d['pensiun'], 0, ',', '.') ?></td>
                        <td class="text-right" style="color: red;"><?= number_format($d['pph_21'], 0, ',', '.') ?></td>
                        <td class="text-right" style="color: red;"><?= number_format($d['cos'], 0, ',', '.') ?></td>
                        <td class="text-right" style="font-weight: bold; background-color: #f8f9fa;">
                            Rp <?= number_format($d['gp'], 0, ',', '.') ?>
                        </td>
                    </tr>
            <?php
                }
            ?>
            
            <tr style="background-color: #e2e3e5; font-weight: bold;">
                <td colspan="5" class="text-center">TOTAL KESELURUHAN</td>
                <td class="text-right"><?= number_format($tot_gaji_pokok, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_tj_jab, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_tj_skill, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_tj_bagian, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_tj_kehadiran, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_uang_makan, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_pot_hk, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_bpjs_ket, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_bpjs_kes, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_pensiun, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_pph21, 0, ',', '.') ?></td>
                <td class="text-right"><?= number_format($tot_cos, 0, ',', '.') ?></td>
                <td class="text-right" style="color: #004085;">Rp <?= number_format($tot_gp, 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="footer-sign">
        <p>Tangerang, <?= date('d F Y') ?></p>
        <p>Mengetahui,</p>
        
        <div style="height: 55px; margin: 5px 0;">
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