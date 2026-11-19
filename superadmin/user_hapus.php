<?php
session_start();
$username2 = $_SESSION['username'];
// Koneksi ke database
include '../koneksi.php';

// Pastikan ada parameter id
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data untuk cek apakah ada foto profil
    $query = $koneksi->prepare("SELECT username, foto FROM admin WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $result = $query->get_result();
    $data = $result->fetch_assoc();
    $username = $data['username'];
    // Jika ada foto dan bukan default, hapus dari folder
    if (!empty($data['foto']) && file_exists("../assets/images/" . $data['foto'])) {
        unlink("../assets/images/" . $data['foto']);
    }

    // Hapus data dari database
    $aksi = "Menghapus admin dengan username $username.";
    mysqli_query($koneksi, "INSERT INTO audit_log (username, aksi) VALUES ('$username2', '$aksi')");
    $delete = $koneksi->prepare("DELETE FROM admin WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();
    
    // Redirect kembali ke halaman manage admin
    header("Location: user.php?pesan=hapus");
    exit;
} else {
    // Jika tidak ada id, kembalikan ke halaman manage admin
    header("Location: user.php");
    exit;
}
