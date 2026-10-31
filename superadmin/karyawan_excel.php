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

    $total = 0;


    foreach ($data as $i => $row) {
        if ($i === 0) continue;

        if (count($row) < 11) continue;

        list($nik, $nama, $no_rekening, $bagian, $gender, $tanggal_lahir, $umur, $agama, $pendidikan, $no_ktp, $no_hp, $tanggal_masuk, $tanggal_keluar) = $row;

        $no_hp = str_replace(' ', '', $no_hp);
        if (substr($no_hp, 0, 1) == '0') {
            $no_hp = '62' . substr($no_hp, 1);
        }
        if (empty($no_hp)) {
            $no_hp = null;
        }

        if (empty($no_rekening) || trim($no_rekening) === "") {
            $no_rekening = "-";
        }

        if (is_numeric($tanggal_lahir)) {
            $tanggal_lahir = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_lahir)->format('Y-m-d');
        } else {
            $tanggal_lahir = date('Y-m-d', strtotime($tanggal_lahir));
        }
        if (is_numeric($tanggal_masuk)) {
            $tanggal_masuk = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_masuk)->format('Y-m-d');
        } else {
            // Jika teks, pastikan diformat ulang
            $tanggal_masuk = date('Y-m-d', strtotime($tanggal_masuk));
        }
        if (is_numeric($tanggal_lahir)) {
            $tanggal_keluar = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggal_keluar)->format('Y-m-d');
        } else {
            $tanggal_keluar = date('Y-m-d', strtotime($tanggal_keluar));
        }

        $sql = "INSERT INTO karyawan (nik, nama, no_rekening, bagian, gender, tanggal_lahir, umur, agama, pendidikan, no_ktp, no_hp, tanggal_masuk, tanggal_keluar, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
        ON DUPLICATE KEY UPDATE
            nama = VALUES(nama),
            no_rekening = VALUES(no_rekening),
            bagian = VALUES(bagian),
            gender = VALUES(gender),
            tanggal_lahir = VALUES(tanggal_lahir),
            umur = VALUES(umur),
            agama = VALUES(agama),
            pendidikan = VALUES(pendidikan),
            no_ktp = VALUES(no_ktp),
            no_hp = VALUES(no_hp),
            tanggal_masuk = VALUES(tanggal_masuk),
            tanggal_keluar = VALUES(tanggal_keluar),
            status = VALUES(status)";
        $stmt = $koneksi->prepare($sql);

        if (!$stmt) {
            echo "Gagal prepare: " . $koneksi->error . "<br>";
            continue;
        }

        $stmt->bind_param("ssssssissssss", $nik, $nama, $no_rekening, $bagian, $gender, $tanggal_lahir, $umur, $agama, $pendidikan, $no_ktp, $no_hp, $tanggal_masuk, $tanggal_keluar);

        if ($stmt->execute()) {
            $total++;
        } else {
            echo "Gagal insert ($nik): " . $stmt->error . "<br>";
        }

        $stmt->close();
    }
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Tidak diketahui';
    $aksi = "Menambahkan $total data karyawan lewat upload Excel.";
    
    mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username', '$aksi')");
    $_SESSION['notif'] = [
        'type' => 'success',
        'message' => "✅ <b>Selesai</b>. Total data berhasil dimasukkan: $total"
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

    <!-- menu navigasi -->
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
                <h4>Impor data karyawan dari Excel</h4>
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
            <h4>Data Karyawan</h4>
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
            
                        $query = mysqli_query($koneksi, "SELECT bagian, COUNT(*) as jumlah FROM karyawan GROUP BY bagian");
                        while($row = mysqli_fetch_assoc($query)){
                            echo "['" . $row['bagian'] . "', " . $row['jumlah'] . "],";
                        }
                        ?>
                    ]);
            
                    var options = {
                        title: 'Distribusi Divisi Karyawan',
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