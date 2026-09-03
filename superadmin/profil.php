<?php
session_start();
include '../koneksi.php';

$idadmin = $_SESSION['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM admin WHERE id='$idadmin'"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. Update username
    if (isset($_POST['username'])) {
        $username = $_POST['username'];
        mysqli_query($koneksi, "UPDATE admin SET username='$username' WHERE id='$idadmin'");
    }

    // 2. Update foto / hapus foto
    if (isset($_POST['hapus_foto'])) {
        // Hapus foto jika bukan default
        if ($data['foto'] != 'default.jpg') {
            @unlink("../assets/images/" . $data['foto']);
        }
        mysqli_query($koneksi, "UPDATE admin SET foto='default.jpg' WHERE id='$idadmin'");
    } elseif (!empty($_FILES['foto']['name'])) {
        $nama_file = $_FILES['foto']['name'];
        $tmp_file = $_FILES['foto']['tmp_name'];
        $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
        $foto_baru = "admin_" . time() . "." . $ext;

        move_uploaded_file($tmp_file, "../assets/images/" . $foto_baru);

        // Hapus foto lama jika bukan default
        if ($data['foto'] != 'default.jpg') {
            @unlink("../assets/images/" . $data['foto']);
        }

        mysqli_query($koneksi, "UPDATE admin SET foto='$foto_baru' WHERE id='$idadmin'");
    }

    // 3. Update password jika diisi
    $pass1 = $_POST['password'] ?? '';
    $pass2 = $_POST['password2'] ?? '';
    if ($pass1 !== "" || $pass2 !== "") {
        if ($pass1 === $pass2) {
            $hash = md5($pass1);
            mysqli_query($koneksi, "UPDATE admin SET password='$hash' WHERE id='$idadmin'");
        } else {
            // Password tidak cocok
            header("Location: profil.php?pesan=gagal");
            exit;
        }
    }

    header("Location: profil.php?pesan=oke");
    exit;
}
?>

<?php include 'header.php'; ?>
<style>
.profile-pic {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: #eee;
    display: block;
    margin: 20px auto 5px;
    object-fit: cover;
}
.upload-link {
    display: block;
    text-align: center;
    color: #61BFDD;
    cursor: pointer;
    font-weight: bold;
    margin-bottom: 20px;
}
input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border: 1px solid #ccc;
    border-radius: 6px;
}
.button-group {
    text-align: right;
    margin-top: 20px;
}
.button-group button {
    padding: 8px 16px;
    border-radius: 6px;
    border: none;
    margin-left: 10px;
}
</style>
<div class='container'>
<?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "oke") {
            echo "<div class='alert alert-success'>Profil berhasil dirubah!</div>";
        }
    }
?>
<?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "gagal") {
            echo "<div class='alert alert-danger'>Konfirmasi sandi tidak sama!</div>";
        }
    }
?>
    <div class="panel" data-aos="fade-down" data-aos-delay="200">
            <div class="panel-heading">
                <h4>Profil Saya</h4>
            </div>
            <div class="panel-body">
                <form method="POST" enctype="multipart/form-data">
            
                    <!-- Foto -->
                    <img src="../assets/images/<?= $data['foto'] ?>" class="profile-pic" id="preview">
                    <label class="upload-link">
                        <input type="file" name="foto" accept="image/*" onchange="previewImage(event)" style="display:none">
                        Upload
                    </label>
            
                    <!-- Username -->
                    <label>Nickname</label>
                    <input type="text" name="username" value="<?= $data['username'] ?>" class='form-control' readonly>
            
                   <!-- Password -->
                    <div class="form-group">
                      <label>Password</label>
                      <div style="position:relative;">
                          <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password">
                          <span style="position:absolute; right:10px; top:8px; cursor:pointer;"
                                onmousedown="showPass('password','eyeIcon1')"
                                onmouseup="hidePass('password','eyeIcon1')"
                                onmouseleave="hidePass('password','eyeIcon1')">
                              <i id="eyeIcon1" class="glyphicon glyphicon-eye-open"></i>
                          </span>
                      </div>
                    </div>
                    
                    <!-- Konfirmasi -->
                    <div class="form-group">
                      <label>Konfirmasi Password</label>
                      <div style="position:relative;">
                          <input type="password" id="password2" name="password2" class="form-control" placeholder="Konfirmasi password">
                          <span style="position:absolute; right:10px; top:8px; cursor:pointer;"
                                onmousedown="showPass('password2','eyeIcon2')"
                                onmouseup="hidePass('password2','eyeIcon2')"
                                onmouseleave="hidePass('password2','eyeIcon2')">
                              <i id="eyeIcon2" class="glyphicon glyphicon-eye-open"></i>
                          </span>
                      </div>
                    </div>
                    
                    <script>
                    function showPass(inputId, iconId){
                        document.getElementById(inputId).type = "text";
                        document.getElementById(iconId).className = "glyphicon glyphicon-eye-close";
                    }
                    function hidePass(inputId, iconId){
                        document.getElementById(inputId).type = "password";
                        document.getElementById(iconId).className = "glyphicon glyphicon-eye-open";
                    }
                    </script>
            
                    <!-- Hapus foto -->
                    <div>
                        <input type="checkbox" name="hapus_foto" id="hapus_foto">
                        <label for="hapus_foto">Hapus foto & gunakan default</label>
                    </div>
            
                    <div class="button-group">
                        <a href="index.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-info">Save</button>
                    </div>
                </form>
            </div>
    </div>
</div>

<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
<?php include 'footer.php'; ?>