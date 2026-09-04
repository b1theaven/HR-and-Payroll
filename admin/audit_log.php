<?php include 'header.php'; ?>

<div class="container">
    <br />
    <br />
    <br />
    <div class="col-md-10 col-md-offset-1">
        <div class="panel" data-aos="fade-down" data-aos-delay="200" style="width: 100%; height: 600px;">
            <div class="panel-heading">
                <h4>Audit Log</h4>
            </div>
            <div class="panel-body">
                <?php
                include '../koneksi.php';
                $logs = mysqli_query($koneksi, "SELECT * FROM audit_log ORDER BY waktu DESC");
                while ($log = mysqli_fetch_assoc($logs)) {
                    echo "<p><b>" . htmlspecialchars($log['username']) . "</b> - " . 
                         htmlspecialchars($log['aksi']) . " <br><small>{$log['waktu']}</small></p><hr>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
