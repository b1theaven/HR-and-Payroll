<?php include 'header.php'; ?>

<?php
include '../koneksi.php';
$karyawan = mysqli_query($koneksi, "SELECT * FROM karyawan ORDER BY nama ASC");
?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-10 col-md-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <h4>Tambah Slip Gaji Baru</h4>
            </div>
            <div class="panel-body">
                <!-- Form -->
                <form method="post" action="slipgaji_aksi.php">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" id="nik" class="form-control" name="nik" readonly required>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <select class="form-control select2" name="nama" id="nama" required>
                                    <option value="">-- Pilih Nama Karyawan --</option>
                                    <?php while ($k = mysqli_fetch_array($karyawan)) { ?>
                                        <option value="<?= $k['nama'] ?>" data-bagian="<?= $k['bagian'] ?>" data-nik="<?= $k['nik'] ?>" data-no_ktp="<?= $k['no_ktp'] ?>">
                                            <?= $k['nama'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Bagian</label>
                                <input type="text" id="bagian" class="form-control" name="bagian" readonly required>
                            </div>
                            <div class="form-group">
                                <label>GP HK 24</label>
                                <input type="number" id="gp_hk_24" class="form-control" name="gp_hk_24" placeholder="Masukkan GP HK 24 .." required>
                            </div>
                            <div class="form-group">
                                <label>OT 20</label>
                                <input type="number" id="ot_20" class="form-control" name="ot_20" placeholder="Masukkan OT 20 .." required>
                            </div>
                            <div class="form-group">
                                <label>Gaji Pokok</label>
                                <input type="number" id="gaji_pokok" class="form-control" name="gaji_pokok" placeholder="Masukkan gaji pokok .." required>
                            </div>
                            <div class="form-group">
                                <label>Tj. Jab</label>
                                <input type="number" id="tj_jab" class="form-control" name="tj_jab" placeholder="Masukkan tunjangan jab .." required>
                            </div>
                            <div class="form-group">
                                <label>Tj. Skill</label>
                                <input type="number" id="tj_skill" class="form-control" name="tj_skill" placeholder="Masukkan tunjangan skill .." required>
                            </div>
                            <div class="form-group">
                                <label>Tj. Bagian</label>
                                <input type="number" id="tj_bagian" class="form-control" name="tj_bagian" placeholder="Masukkan tunjangan bagian .." required>
                            </div>
                            <div class="form-group">
                                <label>Tj. Kehadiran</label>
                                <input type="number" id="tj_kehadiran" class="form-control" name="tj_kehadiran" placeholder="Masukkan tunjangan kehadiran .." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Uang Makan</label>
                                <input type='number' id="uang_makan" class='form-control' name='uang_makan' placeholder='Masukkan uang makan ..' required>
                            </div>
                            <div class="form-group">
                                <label>Potongan HK</label>
                                <input type="number" id="potongan_hk" class="form-control" name="potongan_hk" placeholder='Masukkan potongan HK ..' required>
                            </div>
                            <div class="form-group">
                                <label>BPJS Ketenagakerjaan</label>
                                <input type="number" id="bpjs_ket" class="form-control" name="bpjs_ket" placeholder="Masukkan tunjangan BPJS ketenagakerjaan .." required>
                            </div>
                            <div class="form-group">
                                <label>BPJS Kesehatan</label>
                                <input type="number" id="bpjs_kes" class="form-control" name="bpjs_kes" placeholder="Masukkan tunjangan BPJS kesehatan .." required>
                            </div>
                            <div class="form-group">
                                <label>Pensiun</label>
                                <input type="number" id="pensiun" class="form-control" name="pensiun" placeholder="Masukkan tunjangan pensiun .." required>
                            </div>
                            <div class="form-group">
                                <label>PPH. 21</label>
                                <input type="number" id="pph_21" class="form-control" name="pph_21" placeholder="Masukkan PPH 21 .." required>
                            </div>
                            <div class="form-group">
                                <label>GP</label>
                                <input type="number" id="gp" class="form-control" name="gp" placeholder="Masukkan GP .." required>
                            </div>
                            <div class="form-group">
                                <label>COS</label>
                                <input type="number" id="cos" class="form-control" name="cos" placeholder="Masukkan COS .." required>
                            </div>
                            <div class="form-group">
                                <label>No. KTP</label>
                                <input type="text" id="no_ktp" class="form-control" name="no_ktp" readonly required>
                            </div>
                            <br />
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- Pilih Nama Karyawan --",
            allowClear: true
        });

        $('#nama').on('change', function() {
            let nik = $(this).find(':selected').data('nik');
            $('#nik').val(nik || '');
        });

        $('#nama').on('change', function() {
            let bagian = $(this).find(':selected').data('bagian');
            $('#bagian').val(bagian || '');
        });

        $('#nama').on('change', function() {
            let no_ktp = $(this).find(':selected').data('no_ktp');
            $('#no_ktp').val(no_ktp || '');
        });
    });
</script>

<?php include 'footer.php'; ?>