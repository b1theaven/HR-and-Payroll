<?php
session_start();
include '../koneksi.php';
$username2 = $_SESSION['username'];

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']);
$role     = mysqli_real_escape_string($koneksi, $_POST['role']);

mysqli_query($koneksi, "INSERT INTO admin (username, password, role, foto) 
                        VALUES ('$username', '$password', '$role', 'default.jpg')");
                        
$aksi = "Menambah admin dengan username $username.";

mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username2', '$aksi')");
header("Location: user.php?pesan=oke");
exit();
?>