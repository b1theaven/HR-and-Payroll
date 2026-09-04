<?php include 'header.php'; ?>

<div class="container">
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "oke") {
            echo "<div class='alert alert-success'> Calon karyawan telah ditambahkan!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "sukses") {
            echo "<div class='alert alert-success'>Calon karyawan berhasil diedit!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "dihapus") {
            echo "<div class='alert alert-danger'>Calon karyawan berhasil dihapus!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "gagal") {
            echo "<div class='alert alert-danger'>Calon karyawan gagal diedit!</div>";
        }
    }
    ?>
    <div class="panel" data-aos="fade-down" data-aos-delay="200">
        <div class="panel-heading">
            <h4>Data Calon Karyawan</h4>
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline mb-3">
                <input type="text" name="search" class="form-control" placeholder="Cari nama calon karyawan..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="width: 300px; display: inline-block;">
                <button type="submit" class="btn btn-primary ml-2">Cari</button>
            </form>
            </br>
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="1%">No</th>
                    <th>Nama</th>
                    <th>No. HP</th>
                    <th>Gender</th>
                    <th>Umur</th>
                    <th>Divisi</th>
                    <th>Tanggal Lahir</th>
                    <th>CV ATS</th>
                    <th>Surat Lamaran</th>
                    <th>Ijazah</th>
                    <th>KTP</th>
                    <th>SKCK</th>
                    <th>Surat Ket. Sehat</th>
                    <th>Sertifikat Keahlian</th>
                    <th>Status</th>
                    <th width="15%">OPSI</th>
                </tr>
                <?php
                // koneksi database
                include '../koneksi.php';
                // mengambil data pelanggan dari database
                #$data = mysqli_query($koneksi, "select * from karyawan");
                $no = 1;
                $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
                if (!empty($search)) {
                    $query = mysqli_query($koneksi, "SELECT * FROM calon_karyawan WHERE 
        id LIKE '%$search%' OR 
        nama LIKE '%$search%' OR 
        no_hp LIKE '%$search%' OR 
        divisi LIKE '%$search%' OR
        gender LIKE '%$search%' OR
        tanggal_lahir LIKE '%$search%' OR
        status LIKE '%$search%'");
                } else {
                    $query = mysqli_query($koneksi, "SELECT * FROM calon_karyawan");
                }

                if (mysqli_num_rows($query) == 0) {
                    echo "<tr><td colspan='100%' class='text-center text-danger'>Data tidak ditemukan.</td></tr>";
                }

                while ($d = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['nama']; ?></td>
                        <td><?php echo $d['no_hp']; ?></td>
                        <td><?php echo $d['gender']; ?></td>
                        <td><?php echo $d['umur']; ?></td>
                        <td><?php echo $d['divisi']; ?></td>
                        <td><?php echo $d['tanggal_lahir']; ?></td>
                        <td>
                            <?php if ($d['cv']) { ?>
                                <button class="btn btn-sm btn-primary" onclick="lihatPDF('<?= $d['cv'] ?>')">Lihat</button>
                            <?php } else { ?>
                                <span class="text-danger">Tidak ada</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($d['surat_lamaran']) { ?>
                                <button class="btn btn-sm btn-primary" onclick="lihatPDF('<?= $d['surat_lamaran'] ?>')">Lihat</button>
                            <?php } else { ?>
                                <span class="text-danger">Tidak ada</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($d['ijazah']) { ?>
                                <button class="btn btn-sm btn-primary" onclick="lihatPDF('<?= $d['ijazah'] ?>')">Lihat</button>
                            <?php } else { ?>
                                <span class="text-danger">Tidak ada</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($d['ktp']) { ?>
                                <button class="btn btn-sm btn-primary" onclick="lihatPDF('<?= $d['ktp'] ?>')">Lihat</button>
                            <?php } else { ?>
                                <span class="text-danger">Tidak ada</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($d['skck']) { ?>
                                <button class="btn btn-sm btn-primary" onclick="lihatPDF('<?= $d['skck'] ?>')">Lihat</button>
                            <?php } else { ?>
                                <span class="text-danger">Tidak ada</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($d['sehat']) { ?>
                                <button class="btn btn-sm btn-primary" onclick="lihatPDF('<?= $d['sehat'] ?>')">Lihat</button>
                            <?php } else { ?>
                                <span class="text-danger">Tidak ada</span>
                            <?php } ?>
                        </td>
                        <td>
                            <?php if ($d['sertifikat']) { ?>
                                <button class="btn btn-sm btn-primary" onclick="lihatPDF('<?= $d['sertifikat'] ?>')">Lihat</button>
                                <?php } else { ?>
                                <span class="text-danger">Tidak ada</span>
                            <?php } ?>
                        </td>
                        <td>
                        <?php  
                    if($d['status']=="0"){ 
                        echo "<div class='label label-info'>PENDING</div>"; 
                    }else 
                    if($d['status']=="1"){ 
                        echo "<div class='label label-success'>LOLOS</div>"; 
                    }else 
                    if($d['status']=="2"){ 
                        echo "<div class='label label-danger'>TIDAK LOLOS</div>"; 
                    } 
                    ?> 
                        </td>
                        <td>
                            <a href="calonkaryawan_edit.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="calonkaryawan_hapus.php?id=<?php echo $d['id']; ?>" class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>