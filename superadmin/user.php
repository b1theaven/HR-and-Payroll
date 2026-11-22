<?php 
session_start();
include '../koneksi.php';
include 'header.php';

// Ambil username yang sedang login
$username_login = $_SESSION['username'];

// Ambil semua data admin
$admin_list = mysqli_query($koneksi, "SELECT * FROM admin");
?>

<div class="container">
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "oke") {
            echo "<div class='alert alert-success'>Berhasil menambahkan admin!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "oke2") {
            echo "<div class='alert alert-success'>Berhasil mengedit admin!</div>";
        }
    }
    ?>
    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "hapus") {
            echo "<div class='alert alert-danger'>Berhasil menghapus admin!</div>";
        }
    }
    ?>
        <div class="panel" data-aos="fade-down" data-aos-delay="200">
            <div class="panel-heading">
                <h4>Manage Admin</h4> 
            </div>
            <div class="panel-body">
                <a href="user_tambah.php" class="btn btn-success" style="margin-bottom:15px;">
                    + Tambah Admin
                </a>

                <div class="row">
                    <?php while($row = mysqli_fetch_assoc($admin_list)) : ?>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="card text-center" style="border:1px solid #ddd; border-radius:10px; padding:15px; margin-bottom:20px;">
                                <!-- Foto Profil -->
                                <img src="../assets/images/<?= $row['foto'] ?>" 
                                     alt="Foto Profil" 
                                     style="width:80px; height:80px; border-radius:50%; object-fit:cover; margin-bottom:10px;">

                                <!-- Username -->
                                <div style="margin-top: 10px;">
                                    <label style="font-weight: bold; display: block;">Username</label>
                                </div>
                                <input type="text" value="<?= htmlspecialchars($row['username']) ?>" 
                                       class="form-control" 
                                       readonly 
                                       style="margin-top: 5px; text-align: center;">

                                <!-- Tombol Aksi -->
                                <div style="margin-top:10px;">
                                    <a href="user_edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <?php if($row['username'] !== $username_login) : ?>
                                        <a href="user_hapus.php?id=<?= $row['id'] ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Yakin ingin menghapus admin <?= $row['username'] ?>?')">
                                            Hapus
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

            </div>
        </div>
</div>

<?php include 'footer.php'; ?>
