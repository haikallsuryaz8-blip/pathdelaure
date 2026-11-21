<?php
// C:\laragon\www\kewirausahaan\process_order.php
header('Content-Type: application/json');
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid!']);
    exit;
}

$name = trim($_POST['customer_name'] ?? '');
$class = trim($_POST['customer_class'] ?? '');
$whatsapp = trim($_POST['customer_whatsapp'] ?? '');
$product_id = intval($_POST['product_id'] ?? 0);
$quantity = max(1, intval($_POST['quantity'] ?? 1));
$variant = trim($_POST['variant'] ?? 'Default');
$payment = trim($_POST['payment_method'] ?? 'TUNAI / CASH DI SEKOLAH');
$notes = trim($_POST['notes'] ?? '');

if (empty($name) || empty($class) || empty($whatsapp) || $product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Mohon lengkapi Nama, Kelas, WhatsApp, dan Produk!']);
    exit;
}

// Ambil data produk dari database
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ? AND is_available = 1");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    echo json_encode(['success' => false, 'message' => 'Produk tidak ditemukan atau stok habis!']);
    exit;
}

$unitPrice = $product['promo_price'] ?: $product['price'];
$totalPrice = $unitPrice * $quantity;
$orderCode = 'PDL-' . date('ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

// Simpan ke database orders
$sql = "INSERT INTO orders (order_code, customer_name, customer_class, customer_whatsapp, product_name, quantity, variant, total_price, payment_method, notes, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDING')";
$insert = $pdo->prepare($sql);
$insert->execute([
    $orderCode,
    $name,
    $class,
    $whatsapp,
    $product['name'],
    $quantity,
    $variant,
    $totalPrice,
    $payment,
    $notes
]);

// Buat format pesan WhatsApp resmi
$waText = "*HALO ADMIN PATH DE LAURE! SAYA INGIN MEMESAN:*\n\n";
$waText .= "🔖 *No. Pesanan:* `{$orderCode}`\n";
$waText .= "👤 *Nama Pembeli:* {$name}\n";
$waText .= "🏫 *Kelas / Asal:* {$class}\n";
$waText .= "📱 *WhatsApp:* {$whatsapp}\n";
$waText .= "-------------------------------------\n";
$waText .= "👕 *Produk:* {$product['name']}\n";
$waText .= "🎨 *Pilihan Varian / Ukuran:* {$variant}\n";
$waText .= "🔢 *Jumlah:* {$quantity} pcs\n";
$waText .= "💵 *Total Biaya:* Rp " . number_format($totalPrice, 0, ',', '.') . "\n";
$waText .= "💳 *Metode Bayar:* {$payment}\n";
if (!empty($notes)) {
    $waText .= "📝 *Catatan Khusus:* {$notes}\n";
}
$waText .= "-------------------------------------\n";
$waText .= "Mohon segera diproses ya min, terima kasih! 🙏";

$waUrl = "https://wa.me/" . WA_ADMIN . "?text=" . urlencode($waText);

echo json_encode([
    'success' => true,
    'order_code' => $orderCode,
    'total_price_formatted' => 'Rp ' . number_format($totalPrice, 0, ',', '.'),
    'wa_url' => $waUrl
]);
exit;
