<?php
$host = "sumberpelitasukses.my.id";
$user = "sumberp1_admin";
$pass = "rizky2004";
$dbname = "sumberp1_test";

$conn = new mysqli($host, $user, $pass, $dbname);
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file_bukti']) && $id > 0) {
    $targetDir = "assets/images/";
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $ext = strtolower(pathinfo($_FILES['file_bukti']['name'], PATHINFO_EXTENSION));
    $allowed = array('jpg', 'jpeg', 'png', 'pdf');

    if (in_array($ext, $allowed)) {
        $newFileName = "Bukti_Cuti_" . $id . "_" . time() . "." . $ext;
        $targetFilePath = $targetDir . $newFileName;

        if (move_uploaded_file($_FILES['file_bukti']['tmp_name'], $targetFilePath)) {
            $stmt = $conn->prepare("UPDATE potongan_cuti SET bukti = ? WHERE id = ?");
            $stmt->bind_param("si", $newFileName, $id);
            $stmt->execute();

            $message = "<div style='color: green; font-weight: bold;'>Berkas bukti berhasil diunggah! Anda dapat menutup halaman ini.</div>";
        } else {
            $message = "<div style='color: red;'>Gagal mengunggah berkas ke server.</div>";
        }
    } else {
        $message = "<div style='color: red;'>Format file ditolak. Gunakan format JPG, PNG, atau PDF.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Bukti Cuti - PT. Sumber Pelita Sukses</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; text-align: center; }
        .card { background: white; max-width: 400px; margin: 30px auto; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .btn { background: #007bff; color: white; padding: 12px 20px; border: none; border-radius: 6px; cursor: pointer; font-size: 16px; width: 100%; margin-top: 15px; }
        input[type="file"] { margin: 15px 0; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Upload Bukti Cuti</h2>
        <p>Silakan pilih foto Surat Keterangan / Dokumen Resmi Anda:</p>
        
        <?= $message ?>

        <?php if ($id > 0): ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="file_bukti" accept="image/*,.pdf" required><br>
            <button type="submit" class="btn">Unggah Berkas</button>
        </form>
        <?php else: ?>
        <p style="color:red;">ID Pengajuan tidak ditemukan.</p>
        <?php endif; ?>
    </div>
</body>
</html>