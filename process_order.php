<?php
// C:\laragon\www\kewirausahaan\process_order.php
$isApiRequest = true;
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid!']);
    exit;
}

if (!isset($pdo)) {
    echo json_encode(['success' => false, 'message' => 'Koneksi database belum terhubung.']);
    exit;
}

$name = trim($_POST['customer_name'] ?? '');
$class = trim($_POST['customer_class'] ?? '');
$whatsapp = trim($_POST['customer_whatsapp'] ?? '');
$paymentMethod = trim($_POST['payment_method'] ?? 'CASH'); // CASH atau QRIS
$notes = trim($_POST['notes'] ?? '');

// Items bisa single product (backward compatibility) atau multi-items JSON
$productId = intval($_POST['product_id'] ?? 0);
$quantity = max(1, intval($_POST['quantity'] ?? 1));
$variant = trim($_POST['variant'] ?? 'Default');

if (empty($name) || empty($class) || empty($whatsapp) || $productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Mohon lengkapi Nama, Kelas, WhatsApp, dan Produk!']);
    exit;
}

try {
    $pdo->beginTransaction();

    // 1. Ambil info produk
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND is_available = 1 FOR UPDATE");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if (!$product) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan atau stok sedang habis!']);
        exit;
    }

    $unitPrice = !empty($product['promo_price']) ? $product['promo_price'] : $product['price'];
    $totalAmount = $unitPrice * $quantity;
    $orderCode = 'PDL-' . date('ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 4));

    // 2. Token unik verifikasi untuk pembayaran tunai di kasir
    $verificationToken = hash('sha256', $orderCode . microtime(true) . bin2hex(random_bytes(16)));
    $tokenExpires = date('Y-m-d H:i:s', strtotime('+24 hours'));

    // 3. Insert ke header orders
    $sqlOrder = "INSERT INTO orders (order_code, customer_name, customer_class, customer_whatsapp, product_name, quantity, variant, total_price, total_amount, payment_method, payment_status, verification_token, token_expires_at, notes, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDING', ?, ?, ?, 'PENDING')";
    $insOrder = $pdo->prepare($sqlOrder);
    $insOrder->execute([
        $orderCode, $name, $class, $whatsapp, $product['name'], $quantity, $variant, $totalAmount, $totalAmount,
        $paymentMethod, $verificationToken, $tokenExpires, $notes
    ]);
    $orderId = $pdo->lastInsertId();

    // 4. Insert ke detail order_items
    $sqlItem = "INSERT INTO order_items (order_id, product_id, product_name, quantity, variant, unit_price, subtotal)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insItem = $pdo->prepare($sqlItem);
    $insItem->execute([$orderId, $productId, $product['name'], $quantity, $variant, $unitPrice, $totalAmount]);

    // 5. Insert entri awal payments
    $sqlPay = "INSERT INTO payments (order_id, payment_type, amount, status) VALUES (?, ?, ?, 'PENDING')";
    $insPay = $pdo->prepare($sqlPay);
    $insPay->execute([$orderId, $paymentMethod, $totalAmount]);
    $paymentId = $pdo->lastInsertId();

    // 6. Log history status awal
    $sqlHist = "INSERT INTO payment_history (payment_id, previous_status, new_status, reason) VALUES (?, NULL, 'PENDING', 'Order dibuat oleh pembeli')";
    $insHist = $pdo->prepare($sqlHist);
    $insHist->execute([$paymentId]);

    $pdo->commit();

    // Buat format pesan WhatsApp konfirmasi
    $waText = "*HALO ADMIN PATH DE LAURE! PESANAN BARU MASUK:*\n\n";
    $waText .= "🔖 *No. Pesanan:* `{$orderCode}`\n";
    $waText .= "👤 *Pembeli:* {$name} ({$class})\n";
    $waText .= "📱 *WhatsApp:* {$whatsapp}\n";
    $waText .= "👕 *Produk:* {$product['name']} ({$variant}) x {$quantity}\n";
    $waText .= "💵 *Total Tagihan:* Rp " . number_format($totalAmount, 0, ',', '.') . "\n";
    $waText .= "💳 *Metode Bayar:* {$paymentMethod}\n";
    $waText .= "-------------------------------------\n";
    $waText .= "Mohon diproses, terima kasih! 🙏";

    echo json_encode([
        'success' => true,
        'order_id' => $orderId,
        'order_code' => $orderCode,
        'total_amount' => $totalAmount,
        'total_price_formatted' => 'Rp ' . number_format($totalAmount, 0, ',', '.'),
        'payment_method' => $paymentMethod,
        'verification_token' => $verificationToken,
        'wa_url' => "https://wa.me/" . WA_ADMIN . "?text=" . urlencode($waText)
    ]);
    exit;

} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log("Order Process Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Terjadi kendala saat memproses pesanan. Silakan coba kembali.']);
    exit;
}
