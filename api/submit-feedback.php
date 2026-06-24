<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method tidak diizinkan']);
    exit;
}

$nama  = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$pesan = trim($_POST['pesan'] ?? '');

if (empty($nama) || empty($email) || empty($pesan)) {
    echo json_encode(['success' => false, 'message' => 'Semua field wajib diisi']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid']);
    exit;
}

$conn = getDB();
$stmt = $conn->prepare("INSERT INTO feedback (nama, email, pesan) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $nama, $email, $pesan);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Feedback berhasil dikirim']);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal menyimpan feedback']);
}

$stmt->close();
$conn->close();
?>
