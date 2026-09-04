<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-10 col-md-offset-1">
        <div class="panel" data-aos="fade-down" data-aos-delay="200">
            <div class="panel-heading">
                <h4>Tambah Karyawan Baru</h4>
            </div>
            <div class="panel-body">
                <!-- Form -->
                <form method="post" action="karyawan_aksi.php" onsubmit="return validateForm();">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" id="nik" class="form-control" name="nik" placeholder="Masukkan NIK .." required>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="nama" class="form-control" name="nama" placeholder="Masukkan nama .." required>
                            </div>
                            <div class="form-group">
                                <label>No. Rekening</label>
                                <input type="text" id="no_rekening" class="form-control" name="no_rekening" placeholder="Masukkan nomor rekening (opsional) ..">
                            </div>
                            <div class="form-group">
                                <label>Bagian</label>
                                <input type="text" id="bagian" class="form-control" name="bagian" placeholder="Masukkan bagian .." required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" class="form-control" required>
                                    <option value="L">L (Laki-laki)</option>
                                    <option value="P">P (Perempuan)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" id="tanggal_lahir" class="form-control" name="tanggal_lahir" required>
                            </div>
                            <div class="form-group">
                                <label>Umur</label>
                                <input type="number" id="umur" class="form-control" name="umur" placeholder="Masukkan umur .." required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" id="agama" class="form-control" name="agama" placeholder="Masukkan agama .." required>
                            </div>
                            <div class="form-group">
                                <label>Pendidikan</label>
                                <input type="text" id="pendidikan" class="form-control" name="pendidikan" placeholder="Masukkan pendidikan terahir .." required>
                            </div>
                            <div class="form-group">
                                <label>No. KTP</label>
                                <input type="text" id="no_ktp" class="form-control" name="no_ktp" placeholder="Masukkan nomor KTP .." required>
                            </div>
                            <div class="form-group">
                                <label>No. HP</label>
                                <input type="text" id="no_hp" class="form-control" name="no_hp" placeholder="Masukkan nomor HP (opsional) ..">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Masuk</label>
                                <input type="date" id="tanggal_masuk" class="form-control" name="tanggal_masuk" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Keluar</label>
                                <input type="date" id="tanggal_keluar" class="form-control" name="tanggal_keluar" required>
                            </div>
                    <br />
                    <input type="submit" class="btn btn-primary center" value="Simpan">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        let nik = document.getElementById("nik").value.trim();
        let nama = document.getElementById("nama").value.trim();
        let no_rekening = document.getElementById("no_rekening").value.trim();
        let bagian = document.getElementById("bagian").value.trim();
        let gender = document.getElementById("gender").value.trim();
        let tanggal_lahir = document.getElementById("tanggal_lahir").value.trim();
        let umur = document.getElementById("umur").value.trim();
        let agama = document.getElementById("agama").value.trim();
        let pendidikan = document.getElementById("pendidikan").value.trim();
        let no_ktp = document.getElementById("no_ktp").value.trim();
        let no_hp = document.getElementById("no_hp").value.trim();

        if (nik === "" || nama === "" || no_rekening === "" || bagian === "" || gender === "" || tanggal_lahir === "" || umur === "" || agama === "" || pendidikan === "" || no_ktp === "" || no_hp === "") {
            alert("Semua kolom harus diisi!");
            return false;
        }

        return true;
    }
</script>

<?php include 'footer.php'; ?>