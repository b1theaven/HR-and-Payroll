<?php
include 'header.php';
include '../koneksi.php';
?>

<div class="container">
    <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "terima") {
                    echo "<div class='alert alert-success' style='border-radius: 4px;'><b>✔ Sukses!</b> Permintaan lembur telah disetujui dan notifikasi telah dikirim.</div>";
                } elseif ($_GET['pesan'] == "tolak") {
                    echo "<div class='alert alert-success' style='border-radius: 4px;'><b>✔ Sukses!</b> Permintaan lembur telah ditolak dan notifikasi telah dikirim.</div>";
                }
            }
    ?>
    
<div class="panel" data-aos="fade-down" data-aos-delay="200">
    <div class="panel-heading">
        <h4>Request Lembur User</h4>
    </div>

    <div class="panel-body">
        <?php
            $status_filter = isset($_GET['status']) ? $_GET['status'] : '';
        ?>
        <div class="row mb-3" style="margin-left: 0; margin-right: 0;">
            <div class="col-md-12" style="padding-left: 0; padding-right: 0;">
                <a href="lembur_laporan.php" target="_blank" class="btn btn-info btn-block" style="border-radius: 4px 4px 4px 4px !important;">
                    BUAT LAPORAN
                </a>
            </div>
        </div>
        </br>
        <div class="row mb-3" style="margin-left: 0; margin-right: 0;">
        
            <div class="col-md-4" style="padding-left: 0; padding-right: 0;">
                <a href="?status=1" class="btn btn-success btn-block" style="border-radius: 4px 0 0 4px !important;">
                    DITERIMA
                </a>
            </div>
        
            <div class="col-md-4" style="padding-left: 0; padding-right: 0;">
                <a href="?status=0" class="btn btn-warning btn-block" style="border-radius: 0 !important; color: #fff;">
                    PENDING
                </a>
            </div>
        
            <div class="col-md-4" style="padding-left: 0; padding-right: 0;">
                <a href="?status=2" class="btn btn-danger btn-block" style="border-radius: 0 4px 4px 0 !important;">
                    DITOLAK
                </a>
            </div>
        </div>
        </br>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jam Lembur</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Tanggal Request</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                        <?php
                        $where = "";
                
                        if($status_filter != ""){
                            $where = "WHERE tl.status = '$status_filter'";
                        }
                
                        $data = mysqli_query($koneksi,"
                            SELECT
                                tl.*,
                                k.nama
                            FROM tambahan_lembur tl
                            LEFT JOIN karyawan k
                                ON tl.nik = k.nik
                            $where
                            ORDER BY tl.created_at DESC
                        ");
                
                        if(mysqli_num_rows($data) == 0){
                        ?>
                
                        <tr>
                            <td colspan="8" class="text-center text-danger">
                                Data pengajuan lembur belum ada.
                            </td>
                        </tr>
                
                        <?php
                        } else {
                            $no = 1;
                            while($d = mysqli_fetch_array($data)){
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $d['nik'] ?></td>
                                    <td><?= $d['nama'] ?></td>
                                    <td>
                                        <?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?>
                                    </td>
                                    <td><?= $d['alasan'] ?></td>
                                    <td>
                                        <?php
                                        if($d['status'] == 0){
                                            echo '<span class="label label-warning">PENDING</span>';
                                        } elseif($d['status'] == 1){
                                            echo '<span class="label label-success">DITERIMA</span>';
                                        } else {
                                            echo '<span class="label label-danger">DITOLAK</span>';
                                        }
                                        ?>
                                    </td>
                
                                    <td>
                                        <?= date('d-m-Y H:i', strtotime($d['created_at'])) ?>
                                    </td>
                
                                    <td>
                                        <?php if((int)$d['status'] === 0){ ?>
                                            <a href="lembur_setujui.php?id=<?= $d['id'] ?>"
                                               class="btn btn-success btn-sm"
                                               onclick="return confirm('Setujui pengajuan lembur ini?')">
                                               Setujui
                                            </a>
                
                                            <button
                                                class="btn btn-danger btn-sm"
                                                data-toggle="modal"
                                                data-target="#tolakModal<?= $d['id'] ?>">
                                                Tolak
                                            </button>
                                        <?php } else { ?>
                                            <span class="text-muted">Selesai</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php 
                            }
                        } 
                        ?>
                        </tbody>
                    </table> </div> </div>
                </div>
                
                <?php 
                if(mysqli_num_rows($data) > 0) {
                    mysqli_data_seek($data, 0); 
                    
                    while($d = mysqli_fetch_array($data)){
                    ?>
                        <div class="modal fade" id="tolakModal<?= $d['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="lembur_tolak.php" method="POST">
                                    <div class="modal-content">
                                        
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h4 class="modal-title">Alasan Penolakan (ID: <?= $d['id'] ?>)</h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                            
                                            <div class="form-group" style="text-align: left;">
                                                <label style="font-weight: bold; margin-bottom: 8px;">Masukkan Alasan Penolakan:</label>
                                                <textarea name="alasan_penolakan" class="form-control" rows="4" required placeholder="Tulis alasan penolakan, wajib diisi admin..."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>

<?php include 'footer.php'; ?>