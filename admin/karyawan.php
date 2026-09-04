<?php include 'header.php'; ?>

<div class="container">
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "sukses") {
            echo "<div class='alert alert-success'>Karyawan berhasil diedit!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "diarsipkan") {
            echo "<div class='alert alert-danger'>Karyawan berhasil diarsipkan!</div>";
        }
    }
    ?>
    <div class="panel" data-aos="fade-down" data-aos-delay="200">
        <div class="panel-heading">
            <h4>Data Karyawan</h4>
        </div>
        <div class="panel-body">
            <form method="GET" class="form-inline mb-3">
                <input type="text" name="search" class="form-control" placeholder="Cari karyawan..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" style="width: 300px; display: inline-block;">
                <button type="submit" class="btn btn-primary ml-2">Cari</button>
            </form>
            </br>
            <table class="table table-bordered table-striped">
                <tr>
                    <th width="1%">No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>No. Rekening</th>
                    <th>Divisi</th>
                    <th>Gender</th>
                    <th>Tanggal Lahir</th>
                    <th>Umur</th>
                    <th>Agama</th>
                    <th>Pendidikan</th>
                    <th>No. KTP</th>
                    <th>No. HP</th>
                    <th>Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
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
                    $query = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE 
        nik LIKE '%$search%' OR 
        nama LIKE '%$search%' OR 
        no_rekening LIKE '%$search%' OR 
        bagian LIKE '%$search%' OR
        gender LIKE '%$search%' OR
        tanggal_lahir LIKE '%$search%' OR
        umur LIKE '%$search%' OR
        agama LIKE '%$search%' OR
        pendidikan LIKE '%$search%' OR
        no_ktp LIKE '%$search%' OR
        no_hp LIKE '%$search%' OR
        tanggal_masuk LIKE '%$search%' OR
        tanggal_keluar LIKE '%$search%' OR
        status LIKE '%$search%'");
                } else {
                    $query = mysqli_query($koneksi, "SELECT * FROM karyawan");
                }

                if (mysqli_num_rows($query) == 0) {
                    echo "<tr><td colspan='100%' class='text-center text-danger'>Data tidak ditemukan.</td></tr>";
                }

                // mengubah data ke array dan menampilkannya dengan perulangan while
                while ($d = mysqli_fetch_array($query)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['nik']; ?></td>
                        <td><?php echo $d['nama']; ?></td>
                        <td><?php echo $d['no_rekening']; ?></td>
                        <td><?php echo $d['bagian']; ?></td>
                        <td><?php echo $d['gender']; ?></td>
                        <td><?php echo $d['tanggal_lahir']; ?></td>
                        <td><?php echo $d['umur']; ?></td>
                        <td><?php echo $d['agama']; ?></td>
                        <td><?php echo $d['pendidikan']; ?></td>
                        <td><?php echo $d['no_ktp']; ?></td>
                        <td><?php echo $d['no_hp']; ?></td>
                        <td><?php echo $d['tanggal_masuk']; ?></td>
                        <td><?php echo $d['tanggal_keluar']; ?></td>
                        <td>
                        <?php  
                    if($d['status']=="0"){ 
                        echo "<div class='label label-success'>AKTIF</div>"; 
                    }else 
                    if($d['status']=="1"){ 
                        echo "<div class='label label-info'>PERLU DIPERBARUI</div>"; 
                    }else 
                    if($d['status']=="2"){ 
                        echo "<div class='label label-danger'>TIDAK BEKERJA</div>"; 
                    } 
                    ?> 
                        </td>
                        <td>
                            <a href="karyawan_edit.php?id=<?php echo $d['nik']; ?>" class="btn btn-sm btn-info">Edit</a>
                            <a href="karyawan_arsip.php?id=<?php echo $d['nik']; ?>" class="btn btn-sm btn-danger">Arsip</a>
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