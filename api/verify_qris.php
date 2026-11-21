<?php
// C:\laragon\www\kewirausahaan\api\verify_qris.php
$isApiRequest = true;
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid!']);
    exit;
}

if (empty($_SESSION['admin_logged_in']) || empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Sesi login tidak sah!']);
    exit;
}

if (!isset($pdo)) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database tidak tersedia.']);
    exit;
}

$orderId = intval($_POST['order_id'] ?? 0);
$action = trim($_POST['action'] ?? 'APPROVE'); // APPROVE atau REJECT
$notes = trim($_POST['notes'] ?? '');
$adminId = intval($_SESSION['admin_id']);

if ($orderId <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID pesanan tidak valid!']);
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT o.*, p.id as payment_id, p.status as payment_status_detail FROM orders o LEFT JOIN payments p ON p.order_id = o.id WHERE o.id = ? FOR UPDATE");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch();

    if (!$order) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan!']);
        exit;
    }

    if ($order['payment_status'] === 'PAID') {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Pesanan ini sudah berstatus LUNAS (PAID) sebelumnya!']);
        exit;
    }

    if ($action === 'APPROVE') {
        // Konfirmasi Pembayaran QRIS Lunas
        $updOrder = $pdo->prepare("UPDATE orders SET payment_status = 'PAID', paid_at = NOW(), status = 'COMPLETED' WHERE id = ?");
        $updOrder->execute([$orderId]);

        $updPay = $pdo->prepare("UPDATE payments SET status = 'PAID' WHERE id = ?");
        $updPay->execute([$order['payment_id']]);

        // Catat Payment History
        $insHist = $pdo->prepare("INSERT INTO payment_history (payment_id, previous_status, new_status, changed_by_user_id, reason) VALUES (?, 'WAITING_VERIFICATION', 'PAID', ?, ?)");
        $insHist->execute([$order['payment_id'], $adminId, 'Mutasi GoPay Merchant terverifikasi masuk: ' . ($notes ?: 'Dana sesuai tagihan')]);

        // Catat Admin Verifications
        $insVerif = $pdo->prepare("INSERT INTO admin_verifications (order_id, admin_id, verification_method, notes) VALUES (?, ?, 'MANUAL_MUTATION_CHECK', ?)");
        $insVerif->execute([$orderId, $adminId, 'Verifikasi mutasi GoPay Merchant: ' . ($notes ?: 'Dana cocok')]);

        // Catat Revenue Records (Hanya jika berstatus PAID)
        $insRev = $pdo->prepare("INSERT INTO revenue_records (order_id, payment_method, net_amount) VALUES (?, 'QRIS', ?)");
        $insRev->execute([$orderId, $order['total_amount']]);

        $msg = 'Pembayaran QRIS berhasil disetujui! Status pesanan kini LUNAS (PAID).';

    } else {
        // Penolakan Pembayaran QRIS
        $updOrder = $pdo->prepare("UPDATE orders SET payment_status = 'REJECTED' WHERE id = ?");
        $updOrder->execute([$orderId]);

        $updPay = $pdo->prepare("UPDATE payments SET status = 'REJECTED' WHERE id = ?");
        $updPay->execute([$order['payment_id']]);

        $insHist = $pdo->prepare("INSERT INTO payment_history (payment_id, previous_status, new_status, changed_by_user_id, reason) VALUES (?, 'WAITING_VERIFICATION', 'REJECTED', ?, ?)");
        $insHist->execute([$order['payment_id'], $adminId, 'Ditolak: ' . ($notes ?: 'Bukti transfer tidak valid atau dana tidak ditemukan')]);

        $msg = 'Pembayaran QRIS telah ditolak.';
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'message' => $msg]);
    exit;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Verify QRIS Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Gagal memproses verifikasi QRIS.']);
    exit;
}
