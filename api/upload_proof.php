<?php
// C:\laragon\www\kewirausahaan\api\upload_proof.php
$isApiRequest = true;
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid!']);
    exit;
}

if (!isset($pdo)) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database tidak tersedia.']);
    exit;
}

$orderCode = trim($_POST['order_code'] ?? '');
$referenceNo = trim($_POST['reference_no'] ?? '');

if (empty($orderCode) || empty($_FILES['proof_image'])) {
    echo json_encode(['success' => false, 'message' => 'Nomor pesanan dan berkas bukti transfer wajib disertakan!']);
    exit;
}

// 1. Cek Order di Database
$stmt = $pdo->prepare("SELECT o.*, p.id as payment_id FROM orders o LEFT JOIN payments p ON p.order_id = o.id WHERE o.order_code = ?");
$stmt->execute([$orderCode]);
$order = $stmt->fetch();

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan!']);
    exit;
}

if ($order['payment_status'] === 'PAID') {
    echo json_encode(['success' => false, 'message' => 'Pesanan ini sudah berstatus LUNAS (PAID)!']);
    exit;
}

// 2. Validasi Nomor Referensi Anti-Duplicate
if (!empty($referenceNo)) {
    $stmtRef = $pdo->prepare("SELECT id FROM payments WHERE reference_no = ? AND order_id != ?");
    $stmtRef->execute([$referenceNo, $order['id']]);
    if ($stmtRef->fetch()) {
        echo json_encode(['success' => false, 'message' => 'Nomor referensi pembayaran ini sudah pernah digunakan pada pesanan lain!']);
        exit;
    }
}

// 3. Validasi Berkas Foto Bukti Transfer
$file = $_FILES['proof_image'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'Gagal mengunggah berkas. Kode error: ' . $file['error']]);
    exit;
}

if ($file['size'] > 3 * 1024 * 1024) { // Maks 3MB
    echo json_encode(['success' => false, 'message' => 'Ukuran berkas terlalu besar! Maksimal 3MB.']);
    exit;
}

$allowedMimes = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($file['tmp_name']);

if (!isset($allowedMimes[$mime])) {
    echo json_encode(['success' => false, 'message' => 'Format berkas tidak valid! Hanya menerima format JPG, PNG, atau WEBP.']);
    exit;
}

$extension = $allowedMimes[$mime];
$newFilename = 'qris_' . date('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . $extension;
$targetDir = __DIR__ . '/../uploads/qris/';

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

$targetPath = $targetDir . $newFilename;

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'message' => 'Gagal memindahkan berkas bukti transfer ke server.']);
    exit;
}

try {
    $pdo->beginTransaction();

    $proofUrl = 'uploads/qris/' . $newFilename;

    // Update Payments
    $updPay = $pdo->prepare("UPDATE payments SET reference_no = ?, proof_image = ?, status = 'WAITING_VERIFICATION' WHERE id = ?");
    $updPay->execute([$referenceNo ?: null, $proofUrl, $order['payment_id']]);

    // Update Orders
    $updOrd = $pdo->prepare("UPDATE orders SET payment_status = 'WAITING_VERIFICATION' WHERE id = ?");
    $updOrd->execute([$order['id']]);

    // Insert Payment History
    $insHist = $pdo->prepare("INSERT INTO payment_history (payment_id, previous_status, new_status, reason) VALUES (?, 'PENDING', 'WAITING_VERIFICATION', 'Pelanggan telah mengunggah bukti pembayaran QRIS')");
    $insHist->execute([$order['payment_id']]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi admin kelompok.',
        'proof_url' => $proofUrl
    ]);
    exit;

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Upload Proof DB Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui status pembayaran di database.']);
    exit;
}
