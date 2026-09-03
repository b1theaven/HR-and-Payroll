<?php
session_start();

function flash($name)
{
    if (isset($_SESSION[$name])) {
        echo '<div style="padding: 10px; margin-bottom: 10px; border-radius: 5px; color: white; ';
        echo ($_SESSION[$name]['type'] == 'success') ? 'background-color: green;' : 'background-color: red;';
        echo '">';
        echo $_SESSION[$name]['message'];
        echo '</div>';
        unset($_SESSION[$name]);
    }
}

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

include "../koneksi.php";

if (isset($_POST["submit"])) {
    $fileName = $_FILES['file']['name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $target_file = "../uploads/" . basename($_FILES["file"]["name"]);
    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);

    if ($_FILES['file']['error'] == 4) {
        $_SESSION['notif'] = [
            'type' => 'error',
            'message' => 'Error: Silakan unggah file Excel terlebih dahulu sebelum submit.'
        ];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    if ($fileExt != 'xls' && $fileExt != 'xlsx') {
        $_SESSION['notif'] = [
            'type' => 'error',
            'message' => 'Error: File harus berupa Excel (.xls atau .xlsx).'
        ];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    $spreadsheet = IOFactory::load($target_file);
    $sheet = $spreadsheet->getActiveSheet();
    $data = $sheet->toArray();
    $bulan = date('n');
    $tahun = date('Y');
    $total = 0;


    foreach ($data as $i => $row) {
        if ($i === 0) continue;

        if (count($row) < 11) continue;

        list($nik, $nama, $bagian, $gp_hk_24, $ot_20, $gaji_pokok, $tj_jab, $tj_skill, $tj_bagian, $tj_kehadiran, $uang_makan, $potongan_hk, $bpjs_ket, $bpjs_kes, $pensiun, $pph_21, $gp, $cos, $no_ktp) = $row;

        $cek_kosong = ['gp_hk24', 'ot_20', 'tj_jab', 'tj_skill, tj_bagian, tj_kehadiran, uang_makan, potongan_hk, bpjs_ket, bpjs_kes, pensiun, pph_21, gp, cos'];

        foreach ($cek_kosong as $var) {
            if (empty($$var) || trim($$var) === "") {
                $$var = "-";
            }
        }

        $sql = "INSERT INTO slip_gaji (nik, nama, bagian, gp_hk_24, ot_20, gaji_pokok, tj_jab, tj_skill, tj_bagian, tj_kehadiran, uang_makan, potongan_hk, bpjs_ket, bpjs_kes, pensiun, pph_21, gp, cos, no_ktp, bulan, tahun)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
            nama = VALUES(nama),
            bagian = VALUES(bagian),
            gp_hk_24 = VALUES(gp_hk_24),
            ot_20 = ot_20 + VALUES(ot_20), 
            gaji_pokok = VALUES(gaji_pokok),
            tj_jab = VALUES(tj_jab),
            tj_skill = VALUES(tj_skill),
            tj_bagian = VALUES(tj_bagian),
            tj_kehadiran = VALUES(tj_kehadiran),
            uang_makan = VALUES(uang_makan),
            potongan_hk = potongan_hk + VALUES(potongan_hk),
            bpjs_ket = VALUES(bpjs_ket),
            bpjs_kes = VALUES(bpjs_kes),
            pensiun = VALUES(pensiun),
            pph_21 = VALUES(pph_21),
            gp = VALUES(gp),
            cos = VALUES(cos),
            no_ktp = VALUES(no_ktp),
            bulan = VALUES(bulan),
            tahun = VALUES(tahun)";
        $stmt = $koneksi->prepare($sql);

        if (!$stmt) {
            echo "Gagal prepare: " . $koneksi->error . "<br>";
            continue;
        }

        $stmt->bind_param("sssiiiiiiiiiiiiiiisii", $nik, $nama, $bagian, $gp_hk_24, $ot_20, $gaji_pokok, $tj_jab, $tj_skill, $tj_bagian, $tj_kehadiran, $uang_makan, $potongan_hk, $bpjs_ket, $bpjs_kes, $pensiun, $pph_21, $gp, $cos, $no_ktp, $bulan, $tahun);

        if ($stmt->execute()) {
            $total++;
        } else {
            echo "Gagal insert ($nik): " . $stmt->error . "<br>";
        }

        $stmt->close();
    }
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Tidak diketahui';
    $aksi = "Menambahkan $total slip gaji karyawan lewat upload Excel.";
    
    mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
    $_SESSION['notif'] = [
        'type' => 'success',
        'message' => "✅ <b>Selesai</b>. Total slip gaji berhasil dimasukkan: $total"
    ];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <title>Sistem Informasi Slip Gaji PT. SPS</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script type="text/javascript" src="../assets/js/bootstrap.js"></script>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background: url('../assets/images/security-guard.jpeg') no-repeat center center fixed;
            background-size: cover;
            overflow-x: hidden;
            height: 100%;
            min-height: 100%;
        }

        .content {
            padding-bottom: 100px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .container-fluid {
            max-width: 100%;
            overflow: visible;
        }

        .panel {
            overflow-y: auto;
            max-height: 80vh;
        }

        .navbar-inverse {
            z-index: 1;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>

    <?php
    if ($_SESSION['status'] != "login") {
        header("location:../index.php?pesan=belum_login");
    }
    ?>

    <nav class="navbar navbar-inverse" style="border-radius: 0px">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">
                    <img src="../assets/images/logofix.png" alt="Logo" height="25">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="index.php"><i class="glyphicon glyphicon-dashboard"></i> Dashboard</a></li>
                    <li><a href="karyawan.php"><i class="glyphicon glyphicon-user"></i> Karyawan</a></li>
                    <li><a href="slip_gaji.php"><i class="glyphicon glyphicon-usd"></i> Slip Gaji</a></li>
                    <li><a href="arsip_karyawan.php"><i class="glyphicon glyphicon-inbox"></i> Arsip Karyawan</a></li>
                    <li><a href="audit_log.php"><i class="glyphicon glyphicon-eye-open"></i> Audit Log</a></li>
                    <li><a href="calon_karyawan.php"><i class="glyphicon glyphicon-earphone"></i> Calon Karyawan</a></li>
                    <li><a href="user.php"><i class="glyphicon glyphicon-knight"></i> Manage Admin</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            Halo, <b><?php echo $_SESSION['username']; ?></b> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="profil.php"><i class="glyphicon glyphicon-user"></i> Profil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class='panel' data-aos="fade-down" data-aos-delay="200">
            <div class='panel-heading'>
                <h4>Impor slip gaji karyawan dari Excel</h4>
            </div>
            <div class="panel-body">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <?php flash('notif'); ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="file" class="form-label fw-bold">Upload file</label>
                                <input
                                    type="file"
                                    class="form-control"
                                    name="file"
                                    id="file"
                                    placeholder=""
                                    accept='.xls, .xlsx'
                                    aria-describedby="fileHelpId" />
                                <div id="fileHelpId" class="form-text">Allowed File Types: xls, xlsx. Must have header line.</div>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary" name="submit">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel" data-aos="fade-up" data-aos-delay="600">
        <div class="panel-heading">
            <h4>Data Slip Gaji</h4>
        </div>
        <div class="panel-body">
            <div id="chart_div" style="width: 100%; height: 400px;"></div>

            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);
            
                function drawChart() {
                    // Data dari PHP ke JavaScript
                    var data = google.visualization.arrayToDataTable([
                        ['Divisi', 'Jumlah'],
                        <?php
            
                        $query = mysqli_query($koneksi, "SELECT bagian, COUNT(*) as jumlah FROM slip_gaji GROUP BY bagian");
                        while($row = mysqli_fetch_assoc($query)){
                            echo "['" . $row['bagian'] . "', " . $row['jumlah'] . "],";
                        }
                        ?>
                    ]);
            
                    var options = {
                        title: 'Distribusi Slip Gaji Karyawan',
                        is3D: true,
                    };
            
                    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
        </div>
    </div>
    </div>
</body>
    <footer class="footer">
        <div class="container text-center">
            <p class="text-muted">© 2025 Sumber Pelita Sukses</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    </body>
</html>

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .footer {
            background-color: #000;
            color: #fff;
            padding: 15px 0;
            margin-top: auto;
        }
        .footer p {
            margin: 0;
            color: #fff;
        }
    </style>