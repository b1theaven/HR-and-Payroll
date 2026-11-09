<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-6 col-md-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h4>Detail Slip Gaji</h4>
            </div>
            <div class="panel-body">
                <?php
                include '../koneksi.php';
                $id = $_GET['id'];
                $bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
                $tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

                $data = mysqli_query($koneksi, "SELECT * FROM slip_gaji WHERE nik='$id' AND bulan='$bulan' AND tahun='$tahun'");
                $d = mysqli_fetch_array($data);

                $prev = mysqli_query($koneksi, "
                SELECT bulan, tahun FROM slip_gaji 
                WHERE nik='$id' 
                    AND (tahun < '$tahun' OR (tahun = '$tahun' AND bulan < '$bulan'))
                ORDER BY tahun DESC, bulan DESC 
                LIMIT 1
                ");

                $prev_data = mysqli_fetch_array($prev);

                $next = mysqli_query($koneksi, "
                SELECT bulan, tahun FROM slip_gaji 
                WHERE nik='$id' 
                    AND (tahun > '$tahun' OR (tahun = '$tahun' AND bulan > '$bulan'))
                ORDER BY tahun ASC, bulan ASC 
                LIMIT 1
                ");

                $next_data = mysqli_fetch_array($next);
                ?>
                <div class="text-center">
                    <strong><?= date("F", mktime(0, 0, 0, $bulan, 10)) ?> <?= $tahun ?></strong>
                </div>
                </br>
                </br>
                <table class="table table-bordered">
                    <tr>
                        <th>NIK</th>
                        <td><?= $d['nik']; ?></td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td><?= $d['nama']; ?></td>
                    </tr>
                    <tr>
                        <th>Bagian</th>
                        <td><?= $d['bagian']; ?></td>
                    </tr>
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>Rp. <?= number_format($d['gaji_pokok'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>GP HK 24</th>
                        <td>Rp. <?= number_format($d['gp_hk_24'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>OT 20</th>
                        <td>Rp. <?= number_format($d['ot_20'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Tj. Jabatan</th>
                        <td>Rp. <?= number_format($d['tj_jab'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Tj. Skill</th>
                        <td>Rp. <?= number_format($d['tj_skill'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Tj. Bagian</th>
                        <td>Rp. <?= number_format($d['tj_bagian'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Tj. Kehadiran</th>
                        <td>Rp. <?= number_format($d['tj_kehadiran'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Uang Makan</th>
                        <td>Rp. <?= number_format($d['uang_makan'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Potongan HK</th>
                        <td>Rp. <?= number_format($d['potongan_hk'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>BPJS Ketenagakerjaan</th>
                        <td>Rp. <?= number_format($d['bpjs_ket'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>BPJS Kesehatan</th>
                        <td>Rp. <?= number_format($d['bpjs_kes'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>Pensiun</th>
                        <td>Rp. <?= number_format($d['pensiun'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>PPH 21</th>
                        <td>Rp. <?= number_format($d['pph_21'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>GP</th>
                        <td>Rp. <?= number_format($d['gp'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>COS</th>
                        <td>Rp. <?= number_format($d['cos'], 0, ',', '.'); ?></td>
                    </tr>
                    <tr>
                        <th>No. KTP</th>
                        <td><?= $d['no_ktp']; ?></td>
                    </tr>
                </table>

                <a href="slip_gaji.php" class="btn btn-danger">Kembali</a>
                <a href="cetak_pdf.php?id=<?php echo $d['nik']; ?>" class="btn btn-info">Print</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>