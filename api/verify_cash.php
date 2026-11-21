<?php
// C:\laragon\www\kewirausahaan\api\verify_cash.php
$isApiRequest = true;
header('Content-Type: application/json');
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid!']);
    exit;
}

// 1. Validasi Autentikasi Admin Kasir
if (empty($_SESSION['admin_logged_in']) || empty($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Sesi login tidak sah! Mohon login kembali sebagai Admin/Kasir.']);
    exit;
}

if (!isset($pdo)) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database tidak tersedia.']);
    exit;
}

$token = trim($_POST['token'] ?? '');
$adminId = intval($_SESSION['admin_id']);

if (empty($token)) {
    echo json_encode(['success' => false, 'message' => 'Token verifikasi QR kosong!']);
    exit;
}

try {
    // 2. Mulai Transaksi Database dengan Row Locking (Anti Race Condition & Double Scan)
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT * FROM orders WHERE verification_token = ? FOR UPDATE");
    $stmt->execute([$token]);
    $order = $stmt->fetch();

    if (!$order) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Token QR tidak valid atau tidak ditemukan dalam sistem!']);
        exit;
    }

    // 3. Pengecekan Status Order
    if ($order['payment_status'] === 'PAID') {
        $pdo->rollBack();
        echo json_encode([
            'success' => false, 
            'message' => 'Pesanan ini SUDAH LUNAS (PAID) sebelumnya pada ' . date('d/m/Y H:i', strtotime($order['paid_at'])) . '!'
        ]);
        exit;
    }

    if ($order['payment_status'] === 'CANCELLED') {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Pesanan ini telah DIBATALKAN (CANCELLED)!']);
        exit;
    }

    // 4. Cek Masa Berlaku Token
    if (!empty($order['token_expires_at']) && strtotime($order['token_expires_at']) < time()) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Token QR verifikasi telah kedaluwarsa! Minta pembeli me-refresh pesanan.']);
        exit;
    }

    // 5. Update Status Orders menjadi PAID
    $updOrder = $pdo->prepare("UPDATE orders SET payment_status = 'PAID', paid_at = NOW(), status = 'COMPLETED' WHERE id = ?");
    $updOrder->execute([$order['id']]);

    // 6. Update Status di Payments
    $updPay = $pdo->prepare("UPDATE payments SET status = 'PAID' WHERE order_id = ?");
    $updPay->execute([$order['id']]);

    // Ambil payment_id
    $stmtPay = $pdo->prepare("SELECT id FROM payments WHERE order_id = ?");
    $stmtPay->execute([$order['id']]);
    $payment = $stmtPay->fetch();
    $paymentId = $payment ? $payment['id'] : null;

    // 7. Catat ke payment_history
    if ($paymentId) {
        $insHist = $pdo->prepare("INSERT INTO payment_history (payment_id, previous_status, new_status, changed_by_user_id, reason) VALUES (?, 'PENDING', 'PAID', ?, 'Diverifikasi tunai via Scan QR oleh Kasir')");
        $insHist->execute([$paymentId, $adminId]);
    }

    // 8. Catat Log Verifikasi Kasir (admin_verifications)
    $insVerif = $pdo->prepare("INSERT INTO admin_verifications (order_id, admin_id, verification_method, notes) VALUES (?, ?, 'QR_CAMERA_SCAN', 'Uang tunai fisik diterima di kasir stand')");
    $insVerif->execute([$order['id'], $adminId]);

    // 9. Catat ke Revenue Records (Buku Kas Resmi Bersih) - UNIQUE CONSTRAINT menjamin tidak double
    $insRev = $pdo->prepare("INSERT INTO revenue_records (order_id, payment_method, net_amount) VALUES (?, 'CASH', ?)");
    $insRev->execute([$order['id'], $order['total_amount']]);

    // 10. Catat Jejak Keamanan (audit_logs)
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
    $details = "Admin ID {$adminId} berhasil memverifikasi tunai untuk Order {$order['order_code']} senilai Rp " . number_format($order['total_amount'], 0, ',', '.');
    $insAudit = $pdo->prepare("INSERT INTO audit_logs (action_name, ip_address, user_agent, details) VALUES ('CASH_QR_VERIFICATION_SUCCESS', ?, ?, ?)");
    $insAudit->execute([$ip, $ua, $details]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Pembayaran Tunai Berhasil Diverifikasi! Status pesanan kini LUNAS (PAID).',
        'order_code' => $order['order_code'],
        'customer_name' => $order['customer_name'],
        'customer_class' => $order['customer_class'],
        'total_amount' => $order['total_amount'],
        'total_amount_formatted' => 'Rp ' . number_format($order['total_amount'], 0, ',', '.')
    ]);
    exit;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Cash Verify Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Gagal memproses verifikasi tunai: Terjadi galat basis data.']);
    exit;
}
