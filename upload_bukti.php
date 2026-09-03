<?php
header('Content-Type: application/json');

$secret_key = "rizky2004"; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => false, 'message' => 'Method tidak diizinkan']);
    exit;
}

$headers = getallheaders();
$auth_header = $headers['Authorization'] ?? '';

if ($auth_header !== $secret_key) {
    http_response_code(401);
    echo json_encode(['status' => false, 'message' => 'Unauthorized']);
    exit;
}

if (isset($_FILES['bukti'])) {
    $file = $_FILES['bukti'];
    $nama_file = $_POST['nama_file'] ?? $file['name'];
    $target_folder = 'assets/images/';
    
    if (!is_dir($target_folder)) {
        mkdir($target_folder, 0755, true);
    }
    
    $target_path = $target_folder . basename($nama_file);
    
    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        echo json_encode([
            'status' => true,
            'message' => 'File berhasil disimpan di hosting web',
            'filename' => $nama_file
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['status' => false, 'message' => 'Gagal memindahkan file di server web']);
    }
} else {
    http_response_code(400);
    echo json_encode(['status' => false, 'message' => 'Tidak ada file yang dikirim']);
}
?>