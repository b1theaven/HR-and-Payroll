<?php
include "koneksi.php";

$today = date('Y-m-d');

$sql1 = "UPDATE karyawan 
         SET status = 1 
         WHERE tanggal_keluar <= ? 
         AND status = 0";
$stmt1 = $koneksi->prepare($sql1);
$stmt1->bind_param("s", $today);
$stmt1->execute();
$stmt1->close();

$sql2 = "UPDATE karyawan 
         SET status = 2 
         WHERE tanggal_keluar <= DATE_SUB(?, INTERVAL 1 YEAR) 
         AND status = 1";
$stmt2 = $koneksi->prepare($sql2);
$stmt2->bind_param("s", $today);
$stmt2->execute();
$stmt2->close();

echo "Update selesai";
?>