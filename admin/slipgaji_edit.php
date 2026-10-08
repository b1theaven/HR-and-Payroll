<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-5 col-md-offset-3">
        <div class="panel">
            <div class="panel-heading">
                <h4>Edit Slip Gaji</h4>
            </div>
            <div class="panel-body">
                <?php
                // menghubungkan koneksi
                include '../koneksi.php';
                // menangkap id yang dikirim melalui url
                $id = $_GET['id'];
                // megambil data karyawan yang ber id di atas dari tabel slip gaji
                $data = mysqli_query($koneksi, "select * from slip_gaji where nik='$id'");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <form method="post" action="slipgaji_update.php">
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" class='form-control' name="nik" value="<?php echo $d['nik']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Bulan Gaji</label>
                            <input type="number" class='form-control' name="bulan" value="<?php echo $d['bulan']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Tahun Gaji</label>
                            <input type="number" class='form-control' name="tahun" value="<?php echo $d['tahun']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <!-- form id karyawan yang di edit, untuk di kirim ke file aksi -->
                            <input type="hidden" name="nama" value="<?php echo $d['nama']; ?>">
                            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama .." value="<?php echo $d['nama']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Bagian</label>
                            <input type="text" class="form-control" name="bagian" placeholder="Masukkan bagian .." value="<?php echo $d['bagian']; ?>">
                        </div>
                        <div class="form-group">
                            <label>GP HK 24</label>
                            <input type="number" class="form-control" name="gp_hk_24" placeholder="Masukkan GP HK 24 .." value="<?php echo $d['gp_hk_24']; ?>">
                        </div>
                        <div class="form-group">
                            <label>OT 20</label>
                            <input type="number" class="form-control" name="ot_20" placeholder="Masukkan OT 20 .." value="<?php echo $d['ot_20']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Gaji Pokok</label>
                            <input type="number" class="form-control" name="gaji_pokok" placeholder="Masukkan gaji pokok .." value="<?php echo $d['gaji_pokok']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tj. Jab</label>
                            <input type="number" class="form-control" name="tj_jab" placeholder="Masukkan tunjangan jab .." value="<?php echo $d['tj_jab']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tj. Skill</label>
                            <input type="number" class="form-control" name="tj_skill" placeholder="Masukkan tunjangan skill .." value="<?php echo $d['tj_skill']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tj. Bagian</label>
                            <input type="number" class="form-control" name="tj_bagian" placeholder="Masukkan tunjangan bagian .." value="<?php echo $d['tj_bagian']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Tj. Kehadiran</label>
                            <input type="number" class="form-control" name="tj_kehadiran" placeholder="Masukkan tunjangan kehadiran .." value="<?php echo $d['tj_kehadiran']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Uang Makan</label>
                            <input type='number' class='form-control' name='uang_makan' placeholder='Masukkan uang makan ..' value='<?php echo $d['uang_makan']; ?>'>
                        </div>
                        <div class="form-group">
                            <label>Potongan HK</label>
                            <input type="number" class="form-control" name="potongan_hk" placeholder='Masukkan potongan HK ..' value="<?php echo $d['potongan_hk']; ?>">
                        </div>
                        <div class="form-group">
                            <label>BPJS Ketenagakerjaan</label>
                            <input type="number" class="form-control" name="bpjs_ket" placeholder="Masukkan tunjangan BPJS ketenagakerjaan .." value="<?php echo $d['bpjs_ket']; ?>">
                        </div>
                        <div class="form-group">
                            <label>BPJS Kesehatan</label>
                            <input type="number" class="form-control" name="bpjs_kes" placeholder="Masukkan tunjangan BPJS kesehatan .." value="<?php echo $d['bpjs_kes']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Pensiun</label>
                            <input type="number" class="form-control" name="pensiun" placeholder="Masukkan tunjangan pensiun .." value="<?php echo $d['pensiun']; ?>">
                        </div>
                        <div class="form-group">
                            <label>PPH. 21</label>
                            <input type="number" class="form-control" name="pph_21" placeholder="Masukkan PPH 21 .." value="<?php echo $d['pph_21']; ?>">
                        </div>
                        <div class="form-group">
                            <label>GP</label>
                            <input type="number" class="form-control" name="gp" placeholder="Masukkan GP .." value="<?php echo $d['gp']; ?>">
                        </div>
                        <div class="form-group">
                            <label>COS</label>
                            <input type="number" class="form-control" name="cos" placeholder="Masukkan COS .." value="<?php echo $d['cos']; ?>">
                        </div>
                        <div class="form-group">
                            <label>No. KTP</label>
                            <input type="text" class="form-control" name="no_ktp" placeholder="Masukkan No. KTP .." value="<?php echo $d['no_ktp']; ?>">
                        </div>
                        <br />
                        <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>