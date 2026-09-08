<!DOCTYPE html>
<html>

<head>
    <title>Sistem Informasi HR dan Payroll PT. SPS</title>
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <script type="text/javascript" src="assets/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <style>
        /* --- MODERNDISASI LAYOUT UTAMA --- */
        body {
            background-image: url('assets/images/auth.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        /* --- STYLING JUDUL UTAMA --- */
        .title-container {
            text-align: center;
            margin-bottom: 30px;
            max-width: 800px;
        }
        
        .text-stroke {
            font-weight: 800;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 26px;
            letter-spacing: 1px;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.85);
            line-height: 1.4;
        }

        /* --- STYLING KOTAK LOGIN (PREMIUM CARD) --- */
        .login-wrapper {
            width: 100%;
            max-width: 400px;
        }

        .panel {
            background: rgba(255, 255, 255, 0.96);
            border: none;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            transition: all 0.3s ease;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .panel-body {
            padding: 35px 30px !important;
        }

        /* --- STYLING FORM INPUT & TOMBOL --- */
        .form-group {
            margin-bottom: 22px;
        }

        .form-group label {
            font-weight: 600;
            color: #444;
            font-size: 13px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            height: 44px;
            border-radius: 8px;
            border: 1px solid #ccc;
            padding-left: 15px;
            font-size: 14px;
            box-shadow: none;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2e6da4;
            box-shadow: 0 0 8px rgba(46, 109, 164, 0.25);
            background-color: #fff;
        }

        /* Tombol Log In Premium */
        .btn-primary {
            width: 100%;
            height: 46px;
            border-radius: 8px;
            background-color: #2e6da4;
            border: none;
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(46, 109, 164, 0.3);
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #204d74;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(46, 109, 164, 0.45);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* --- STYLING NOTIFIKASI / ALERT --- */
        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 500;
            padding: 12px 15px;
            font-size: 13.5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            text-align: center;
        }
        
        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
            border-left: 5px solid #a94442;
        }
        
        .alert-info {
            background-color: #d9edf7;
            color: #31708f;
            border-left: 5px solid #31708f;
        }

        /* --- WATERMARK FOOTER --- */
        .developer-footer {
            text-align: center;
            color: #ffffff;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.8);
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="title-container">
        <h2 class="text-stroke">
            Sistem Informasi HR dan Payroll<br>PT. Sumber Pelita Sukses
        </h2>
    </div>

    <div class="login-wrapper">
        
        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "gagal") {
                echo "<div class='alert alert-danger'>🔒 Login gagal! Username dan password salah!</div>";
            } else if ($_GET['pesan'] == "logout") {
                echo "<div class='alert alert-info'>🔓 Anda telah berhasil logout. Terima kasih!</div>";
            } else if ($_GET['pesan'] == "belum_login") {
                echo "<div class='alert alert-danger'>⚠️ Anda harus login untuk mengakses halaman admin.</div>";
            } else if ($_GET['pesan'] == "troll") {
                echo "<div class='alert alert-danger'>🛑 Hayo, mau ngapain?</div>";
            }
        }
        ?>

        <form action="login.php" method="post">
            <div class="panel">
                <div class="panel-body">
                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" placeholder="Masukkan username" required autocomplete="off">
                    </div>
                    
                    <div class="form-group">
                      <label>Password</label>
                      <div style="position:relative;">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                    
                        <span id="toggleEye"
                              style="position:absolute; right:15px; top:12px; cursor:pointer; color: #777; font-size: 16px;"
                              onmousedown="showPassword()" 
                              onmouseup="hidePassword()" 
                              onmouseleave="hidePassword()">
                            <i id="eyeIcon" class="glyphicon glyphicon-eye-open"></i>
                        </span>
                      </div>
                    </div>
                    
                    <script>
                    function showPassword(){
                        document.getElementById("password").type = "text";
                        document.getElementById("eyeIcon").className = "glyphicon glyphicon-eye-close";
                    }
                    function hidePassword(){
                        document.getElementById("password").type = "password";
                        document.getElementById("eyeIcon").className = "glyphicon glyphicon-eye-open";
                    }
                    </script>
                    
                    <input type="submit" class="btn btn-primary" value="Log In">
                </div>
            </div>
        </form>
        
        <div class="developer-footer">
            <span>Dibuat oleh Mohammad Rizky</span>
        </div>
        
    </div>

</body>

</html>