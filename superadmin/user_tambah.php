<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-10 col-md-offset-1">
        <div class="panel" data-aos="fade-down" data-aos-delay="200" style="width: 100%; height: 600px;">
            <div class="panel-heading">
                <h4>Tambah Admin</h4> 
            </div>
            <div class="panel-body">
                <form action="user_tambah_aksi.php" method="post">
                    
                    <!-- Username -->
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username" maxlength="15" required>
                        <small class="text-muted">Maksimal 15 karakter</small>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>

                    <!-- Role -->
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="superadmin">Super Admin</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="user.php" class="btn btn-default">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
