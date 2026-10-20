<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-10 col-md-offset-1">
        <div class="panel">
            <div class="panel-heading">
                <h4>Edit Calon Karyawan</h4>
            </div>
            <div class="panel-body">
                <?php
                // menghubungkan koneksi
                include '../koneksi.php';
                // menangkap id yang dikirim melalui url
                $id = $_GET['id'];
                // megambil data calon karyawan yang ber id di atas dari tabel calon karyawan
                $data = mysqli_query($koneksi, "select * from calon_karyawan where id='$id'");
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <form method="post" action="calonkaryawan_update.php">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <!-- form id calon karyawan yang di edit, untuk di kirim ke file aksi -->
                                    <input type="hidden" name="nama" value="<?php echo $d['nama']; ?>">
                                    <input type="text" class="form-control" name="nama" placeholder="Masukkan nama .." value="<?php echo $d['nama']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>No. HP</label>
                                    <input type="text" class="form-control" name="no_hp" placeholder="Masukkan nomor HP .." value="<?php echo $d['no_hp']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <input type="text" class="form-control" name="divisi" placeholder="Masukkan divisi .." value="<?php echo $d['divisi']; ?>">
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
                                <input type="hidden" name="old_status" value="<?php echo $d['status']; ?>">
                                <div class="form-group">
                                    <label for="status">Status Calon Karyawan</label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="" disabled selected>-- Pilih status karyawan --</option>
                                            <option value="0">PENDING</option>
                                            <option value="1">LOLOS</option>
                                            <option value="2">TIDAK LOLOS</option>
                                        </select>
                                </div>
                                <br />
                                <input type="hidden" name="alasan" id="alasanHidden">
                                <input type="submit" name="submit" class="btn btn-primary center" value="Simpan">
                            </div>
                        </div>
                    </form>
                    
                    <div id="modalAlasan" class="modal" style="display:none;">
                        <div class="modal-content">
                            <span class="close" onclick="tutupModal()">&times;</span>

                            <h3>Masukkan Alasan</h3>
                            <p>Jelaskan alasan meloloskan atau menolak pelamar ini.</p>

                            <textarea id="inputAlasan" class="form-control" style="height:120px;"></textarea>

                            <button class="btn btn-primary" onclick="simpanAlasan()">Simpan</button>
                        </div>
                    </div>
                    <style>
                        .modal {
                            position: fixed;
                            z-index: 99999;
                            left:0; top:0;
                            width:100%; height:100%;
                            background: rgba(0,0,0,0.6);
                            display:flex;
                            justify-content:center;
                            align-items:center;
                        }
                        .modal-content {
                            background:#fff;
                            padding:20px;
                            width:400px;
                            border-radius:10px;
                            position:relative;
                        }
                        .close {
                            position:absolute;
                            right:10px;
                            top:5px;
                            font-size:25px;
                            cursor:pointer;
                        }
                </style>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
let harusIsiAlasan = false;

document.getElementById("status").addEventListener("change", function() {
    let status = this.value;

    if (status === "1" || status === "2") {
        harusIsiAlasan = true;
        document.getElementById("modalAlasan").style.display = "flex";
    } else {
        harusIsiAlasan = false;
    }
});

function tutupModal() {
    document.getElementById("modalAlasan").style.display = "none";
}

function simpanAlasan() {
    let alasan = document.getElementById("inputAlasan").value.trim();

    if (alasan === "") {
        alert("Alasan tidak boleh kosong!");
        return;
    }

    // isi otomatis ke input hidden (dibuat di bawah)
    document.getElementById("alasanHidden").value = alasan;

    tutupModal();
}
</script

<?php include 'footer.php'; ?>