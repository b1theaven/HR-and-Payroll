<?php
session_start();
include '../koneksi.php';

$id       = $_POST['id'];
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password'];
$role = isset($_POST['role']) && $_POST['role'] !== '' ? $_POST['role'] : $_POST['old_role'];

// Ambil data lama
$dataLama = mysqli_query($koneksi, "SELECT * FROM admin WHERE id='$id'");
$d = mysqli_fetch_assoc($dataLama);

// Cek apakah password diubah
if (!empty($password)) {
    $password = md5($password);
    $update_password = ", password='$password'";
} else {
    $update_password = "";
}

// Cek upload foto
if (!empty($_FILES['foto']['name'])) {
    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];

    $ext  = pathinfo($foto, PATHINFO_EXTENSION);
    $nama_baru = "foto_" . time() . "." . $ext;
    move_uploaded_file($tmp, "../assets/images/" . $nama_baru);

    // Jika bukan default, hapus foto lama
    if ($d['foto'] != 'default.png' && file_exists("../assets/images/" . $d['foto'])) {
        unlink("../assets/images/" . $d['foto']);
    }

    $update_foto = ", foto='$nama_baru'";
} else {
    $update_foto = "";
}

// Update data
mysqli_query($koneksi, "UPDATE admin SET username='$username', role='$role' $update_password $update_foto WHERE id='$id'");

header("Location: user.php?pesan=oke2");
exit();
?>
