
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
                $data = mysqli_query($koneksi, "SELECT * FROM slip_gaji WHERE id='$id'");
                $d = mysqli_fetch_array($data);
                ?>

                <table class="table table-bordered">
                    <tr><th>NIK</th><td><?= $d['nik']; ?></td></tr>
                    <tr><th>Nama</th><td><?= $d['nama']; ?></td></tr>
                    <tr><th>Bagian</th><td><?= $d['bagian']; ?></td></tr>
                    <tr><th>Bulan</th><td><?= $d['bulan']; ?></td></tr>
                    <tr><th>Tahun</th><td><?= $d['tahun']; ?></td></tr>
                    <tr><th>Gaji Pokok</th><td><?= $d['gaji_pokok']; ?></td></tr>
                    <tr><th>GP HK 24</th><td><?= $d['gp_hk_24']; ?></td></tr>
                    <tr><th>OT 20</th><td><?= $d['ot_20']; ?></td></tr>
                    <tr><th>TJ Jabatan</th><td><?= $d['tj_jab']; ?></td></tr>
                    <tr><th>TJ Skill</th><td><?= $d['tj_skill']; ?></td></tr>
                    <tr><th>TJ Bagian</th><td><?= $d['tj_bagian']; ?></td></tr>
                    <tr><th>TJ Kehadiran</th><td><?= $d['tj_kehadiran']; ?></td></tr>
                    <tr><th>Uang Makan</th><td><?= $d['uang_makan']; ?></td></tr>
                    <tr><th>Potongan HK</th><td><?= $d['potongan_hk']; ?></td></tr>
                    <tr><th>BPJS Ketenagakerjaan</th><td><?= $d['bpjs_ket']; ?></td></tr>
                    <tr><th>BPJS Kesehatan</th><td><?= $d['bpjs_kes']; ?></td></tr>
                    <tr><th>Pensiun</th><td><?= $d['pensiun']; ?></td></tr>
                    <tr><th>PPH 21</th><td><?= $d['pph_21']; ?></td></tr>
                    <tr><th>GP</th><td><?= $d['gp']; ?></td></tr>
                    <tr><th>COS</th><td><?= $d['cos']; ?></td></tr>
                    <tr><th>No KTP</th><td><?= $d['no_ktp']; ?></td></tr>
                </table>

                <a href="slip_gaji.php" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
