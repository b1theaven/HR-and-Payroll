<?php
// nama host, Username, password dan nama database
$koneksi = mysqli_connect("", "", "", "" , "");
// Periksa Koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
error_reporting(0);
ini_set('display_errors', 0);