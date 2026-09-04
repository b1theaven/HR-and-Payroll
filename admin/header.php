<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
    <title>Sistem Informasi HR dan Payroll PT. SPS</title>
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

    <!-- cek apakah sudah login -->
    <?php
    session_start();
    if ($_SESSION['status'] != "login") {
        header("location:../index.php?pesan=belum_login");
    }
    if($_SESSION['role'] != 'admin'){
    header("location:../index.php?pesan=belum_login");
    exit;
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
                    <li><a href="cuti.php?status=0"><i class="glyphicon glyphicon-briefcase"></i> Pengajuan Cuti</a></li>
                    <li><a href="lembur.php?status=0"><i class="glyphicon glyphicon-tasks"></i> Pengajuan Lembur</a></li>
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
    <!-- akhir menu navigasi -->