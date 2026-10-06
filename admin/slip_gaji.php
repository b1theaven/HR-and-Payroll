<?php include 'header.php'; ?>

<div class="container">
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "oke") {
            echo "<div class='alert alert-success'>Slip gaji telah ditambahkan!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "sukses") {
            echo "<div class='alert alert-success'>Slip gaji berhasil diedit!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "terhapus") {
            echo "<div class='alert alert-danger'>Slip gaji berhasil dihapus!</div>";
        }
    }
    ?>
    <div class="panel" data-aos="fade-down" data-aos-delay="200">
        <div class="panel-heading">
            <h4>Slip Gaji Karyawan</h4>
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
                    <th>Bagian</th>
                    <th>Gaji Pokok</th>
                    <th>No. KTP</th>
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
                    $query = mysqli_query($koneksi, "SELECT * FROM slip_gaji WHERE 
        nik LIKE '%$search%' OR 
        nama LIKE '%$search%' OR 
        bagian LIKE '%$search%' OR 
        no_ktp LIKE '%$search%'");
                } else {
                    $query = mysqli_query($koneksi, "SELECT * FROM slip_gaji");
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
                        <td><?php echo $d['bagian']; ?></td>
                        <td><?php echo number_format($d['gaji_pokok'], 0, ',', '.'); ?></td>
                        <td><?php echo $d['no_ktp']; ?></td>
                        <td>
                            <a href="slipgaji_detail.php?id=<?php echo $d['nik']; ?>" class="btn btn-sm btn-success">Detail</a>
                            <a href="slipgaji_edit.php?id=<?php echo $d['nik']; ?>" class="btn btn-sm btn-info">Edit</a>
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