<?php include 'header.php'; ?>

<?php
// koneksi database 
include '../koneksi.php';

$query = "
    SELECT 
        DATE_FORMAT(tanggal_masuk, '%Y-%m') AS bulan, 
        SUM(status = 0) AS aktif,
        SUM(status = 1) AS perlu_diperbarui,
        SUM(status = 2) AS tidak_bekerja
    FROM karyawan
    GROUP BY bulan
    ORDER BY bulan ASC
";
$result = mysqli_query($koneksi, $query);

$bulan = [];
$aktif = [];
$perlu_diperbarui = [];
$tidak_bekerja = [];

while ($row = mysqli_fetch_assoc($result)) {
    $bulan[] = $row['bulan'];
    $aktif[] = $row['aktif'];
    $perlu_diperbarui[] = $row['perlu_diperbarui'];
    $tidak_bekerja[] = $row['tidak_bekerja'];
}
?>

<div class="container">
    <div class="alert alert-info text-center">
        <h4 style="margin-bottom: 0px"><b>Selamat datang!</b> Di Sistem Informasi HR dan Payroll PT. SPS.</h4>
    </div>
    <div class="panel" data-aos="fade-down" data-aos-delay="200">
        <div class="panel-heading">
            <h4>Dashboard</h4>
        </div>
        <div class="panel-body">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="panel panel-primary" style="padding: 15px;">
                        <div class="panel-heading">
                            <h1>
                                <i class="glyphicon glyphicon-user"></i>
                                <span class="pull-right">
                                    <?php
                                    $karyawan = mysqli_query($koneksi, "select * from karyawan");
                                    echo mysqli_num_rows($karyawan) . ' orang';
                                    ?>
                                </span>
                            </h1>
                            Jumlah Karyawan
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-success" style="padding: 15px;">
                        <div class="panel-heading">
                            <h1>
                                <i class="glyphicon glyphicon-book"></i>
                                <span class="pull-right">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM karyawan WHERE no_rekening != '-' AND no_rekening != ''");
                                    $data = mysqli_fetch_assoc($query);
                
                                    echo $data['total'] . ' orang';
                                    ?>
                                </span>
                            </h1>
                            Karyawan yang Punya Rekening
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-danger" style="padding: 15px;">
                        <div class="panel-heading">
                            <h1>
                                <i class="glyphicon glyphicon-time"></i>
                                <span class="pull-right">
                                    <?php
                                    $query = mysqli_query($koneksi, "SELECT AVG(umur) as rata2 FROM karyawan");
                                    $data = mysqli_fetch_assoc($query);
                
                                    echo $data['rata2'] ? round($data['rata2'], 0) . ' tahun' : '0 tahun';
                                    ?>
                                </span>
                            </h1>
                            Rata-rata Umur Karyawan
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-warning" style="padding: 15px;">
                        <div class="panel-heading">
                            <h1>
                                <i class="glyphicon glyphicon-stats"></i>
                                <span class="pull-right">
                                    <?php
                                    $laki = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM karyawan WHERE gender = 'L'");
                                    $jml_laki = mysqli_fetch_assoc($laki)['total'];
                
                                    $perempuan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM karyawan WHERE gender = 'P'");
                                    $jml_perempuan = mysqli_fetch_assoc($perempuan)['total'];
                
                                    echo $jml_laki . " L / " . $jml_perempuan . " P";
                                    ?>
                                </span>
                            </h1>
                            Jumlah Karyawan Laki-laki & Perempuan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <div class="panel" data-aos="fade-up" data-aos-delay="600">
        <div class="panel-heading">
            <h4>Status Karyawan</h4> 
        </div>
        <div class="panel-body">
            <canvas id="statusChart" height="120"></canvas>
        </div>
    </div>

    <!-- Load Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($bulan) ?>,
                datasets: [
                    {
                        label: 'Aktif',
                        data: <?= json_encode($aktif) ?>,
                        borderColor: '#28a745',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'Perlu Diperbarui',
                        data: <?= json_encode($perlu_diperbarui) ?>,
                        borderColor: '#ffc107',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: 'Tidak Bekerja',
                        data: <?= json_encode($tidak_bekerja) ?>,
                        borderColor: '#dc3545',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: {
                        display: true,
                        text: 'Perbandingan Status Karyawan per Bulan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
</div>

<?php include 'footer.php'; ?>