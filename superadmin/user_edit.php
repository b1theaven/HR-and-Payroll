<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-10 col-md-offset-1">
        <div class="panel" data-aos="fade-down" data-aos-delay="200" style="width: 100%; height: auto;">
            <div class="panel-heading">
                <h4>Edit Admin</h4>
            </div>
            <div class="panel-body">
                <?php
                include '../koneksi.php';
                $id = $_GET['id'];
                $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE id='$id'");
                $data = mysqli_fetch_assoc($query);
                ?>

                <form action="user_edit_aksi.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data['id'] ?>">

                    <!-- Foto -->
                    <img src="../assets/images/<?= $data['foto'] ?>" class="profile-pic" id="preview">
                    <label class="upload-link">
                        <input type="file" name="foto" accept="image/*" onchange="previewImage(event)" style="display:none">
                        Upload
                    </label>

                    <!-- Username -->
                    <label>Nickname</label>
                    <input type="text" name="username" value="<?= $data['username'] ?>">

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

                    <!-- Role -->
                    <input type="hidden" name="old_role" value="<?= $data['role']; ?>">
                    <div class="form-group">
                        <label for="status">Role</label>
                            <select class="form-control" name="role" id="role">
                                <option value="" disabled selected>-- Pilih role administrator --</option>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Super Admin</option>
                            </select>
                    </div>
                    
                    <!-- Hapus foto -->
                    <div>
                        <input type="checkbox" name="hapus_foto" id="hapus_foto">
                        <label for="hapus_foto">Hapus foto & gunakan default</label>
                    </div>
                    <div class="button-group">
                        <a href="user.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-info">Save</button>
                    </div>
                </form>
            </div>
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

<?php include 'footer.php'; ?>
