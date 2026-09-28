<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-10 col-md-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <h4>Edit Karyawan</h4>
            </div>
            <div class="panel-body">
                <?php
                // menghubungkan koneksi
                include '../koneksi.php';
                // menangkap id yang dikirim melalui url
                $id = $_GET['id'];
                // megambil data pelanggan yang ber id di atas dari tabel pelanggan
                $data = mysqli_query($koneksi, "select * from karyawan where nik='$id'");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <form method="post" action="karyawan_update.php">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control" name="nik" value="<?php echo $d['nik']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <!-- form id pelanggan yang di edit, untuk di kirim ke file aksi -->
                                    <input type="hidden" name="nama" value="<?php echo $d['nama']; ?>">
                                    <input type="text" class="form-control" name="nama" placeholder="Masukkan nama .." value="<?php echo $d['nama']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" class="form-control" name="no_rekening" placeholder="Masukkan nomor rekening .." value="<?php echo $d['no_rekening']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Bagian</label>
                                    <input type="text" class="form-control" name="bagian" placeholder="Masukkan bagian .." value="<?php echo $d['bagian']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select id="gender" name="gender" class="form-control" value="<?php echo $d['gender']; ?>">
                                        <option value="L">L (Laki-laki)</option>
                                        <option value="P">P (Perempuan)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="tanggal_lahir" value="<?php echo $d['tanggal_lahir']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Umur</label>
                                    <input type="number" class="form-control" name="umur" placeholder="Masukkan umur .." value="<?php echo $d['umur']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" class="form-control" name="agama" placeholder="Masukkan agama .." value="<?php echo $d['agama']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Pendidikan</label>
                                    <input type="text" class="form-control" name="pendidikan" placeholder="Masukkan pendidikan .." value="<?php echo $d['pendidikan']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>No. KTP</label>
                                    <input type="text" class="form-control" name="no_ktp" placeholder="Masukkan nomor KTP .." value="<?php echo $d['no_ktp']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>No. HP</label>
                                    <input type="text" class="form-control" name="no_hp" placeholder="Masukkan nomor HP .." value="<?php echo $d['no_hp']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tanggal_masuk" value="<?php echo $d['tanggal_masuk']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Keluar</label>
                                    <input type="date" class="form-control" name="tanggal_keluar" value="<?php echo $d['tanggal_keluar']; ?>">
                                </div>
                                <input type="hidden" name="old_status" value="<?php echo $d['status']; ?>">
                                <div class="form-group">
                                    <label for="status">Status Karyawan</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="" disabled selected>-- Pilih status karyawan --</option>
                                            <option value="0">Aktif</option>
                                            <option value="1">Perlu Diperbarui</option>
                                            <option value="2">Tidak Bekerja</option>
                                        </select>
                                </div>
                                <br />
                                <input type="submit" name="submit" class="btn btn-primary center" value="Simpan">
                            </div>
                        </div>
                    </form>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>