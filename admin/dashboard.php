<?php
// C:\laragon\www\kewirausahaan\admin\dashboard.php
require_once __DIR__ . '/../config.php';

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handler Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: login.php');
    exit;
}

$activeTab = $_GET['tab'] ?? 'pending';

// Query Ringkasan Pendapatan Bersih (Hanya yang PAID)
$totCash = 0;
$totQris = 0;
$totOrders = 0;
$ordersList = [];

if (isset($pdo)) {
    // Total Cash PAID
    $stmtCash = $pdo->query("SELECT COALESCE(SUM(net_amount), 0) FROM revenue_records WHERE payment_method = 'CASH'");
    $totCash = $stmtCash->fetchColumn();

    // Total QRIS PAID
    $stmtQris = $pdo->query("SELECT COALESCE(SUM(net_amount), 0) FROM revenue_records WHERE payment_method = 'QRIS'");
    $totQris = $stmtQris->fetchColumn();

    // Total Orders
    $stmtTot = $pdo->query("SELECT COUNT(*) FROM orders");
    $totOrders = $stmtTot->fetchColumn();

    // Filter Tab
    if ($activeTab === 'paid') {
        $stmtOrd = $pdo->prepare("SELECT o.*, p.reference_no, p.proof_image, u.full_name as verifier_name FROM orders o LEFT JOIN payments p ON p.order_id = o.id LEFT JOIN admin_verifications av ON av.order_id = o.id LEFT JOIN users u ON u.id = av.admin_id WHERE o.payment_status = 'PAID' ORDER BY o.paid_at DESC");
    } elseif ($activeTab === 'qris_review') {
        $stmtOrd = $pdo->prepare("SELECT o.*, p.reference_no, p.proof_image FROM orders o LEFT JOIN payments p ON p.order_id = o.id WHERE o.payment_status = 'WAITING_VERIFICATION' ORDER BY o.id DESC");
    } else {
        // Pending
        $stmtOrd = $pdo->prepare("SELECT o.*, p.reference_no, p.proof_image FROM orders o LEFT JOIN payments p ON p.order_id = o.id WHERE o.payment_status = 'PENDING' ORDER BY o.id DESC");
    }
    $stmtOrd->execute();
    $ordersList = $stmtOrd->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir & Manajemen Pembayaran — <?= BRAND_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen">
    <!-- Navbar -->
    <header class="bg-gray-900 border-b border-gray-800 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="../index.php" class="font-bold text-amber-400 tracking-wider text-base md:text-lg"><?= BRAND_NAME ?></a>
                <span class="text-xs bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded-full font-medium">Panel Kasir</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-white"><?= htmlspecialchars($_SESSION['admin_name']) ?></p>
                    <p class="text-[10px] text-gray-400"><?= htmlspecialchars($_SESSION['admin_role']) ?></p>
                </div>
                <a href="scanner.php" class="bg-amber-500 hover:bg-amber-400 text-gray-950 px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5 shadow-md shadow-amber-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Buka Scan QR Tunai
                </a>
                <a href="?action=logout" class="text-gray-400 hover:text-red-400 text-xs transition">Keluar</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <!-- Kartu Metrik Omset Riil -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <span class="text-xs text-gray-400 font-medium">Uang Tunai di Kasir Stand</span>
                <p class="text-2xl font-bold text-emerald-400 mt-1">Rp <?= number_format($totCash, 0, ',', '.') ?></p>
                <span class="text-[11px] text-gray-400">Verifikasi fisik via Scan QR</span>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <span class="text-xs text-gray-400 font-medium">Dana Saldo GoPay Merchant</span>
                <p class="text-2xl font-bold text-cyan-400 mt-1">Rp <?= number_format($totQris, 0, ',', '.') ?></p>
                <span class="text-[11px] text-gray-400">Verifikasi mutasi rekening</span>
            </div>
            <div class="bg-gray-900 border border-amber-500/20 bg-amber-500/[0.02] rounded-xl p-4">
                <span class="text-xs text-amber-400 font-medium">Total Omset Lunas (PAID)</span>
                <p class="text-2xl font-bold text-amber-400 mt-1">Rp <?= number_format($totCash + $totQris, 0, ',', '.') ?></p>
                <span class="text-[11px] text-gray-400"><?= $totOrders ?> total pesanan tercatat</span>
            </div>
        </div>

        <!-- Tab Navigasi -->
        <div class="flex items-center gap-2 border-b border-gray-800 pb-3 mb-4 overflow-x-auto text-xs font-semibold">
            <a href="?tab=pending" class="px-4 py-2 rounded-lg transition <?= $activeTab === 'pending' ? 'bg-amber-500 text-gray-950 font-bold' : 'bg-gray-900 text-gray-400 hover:text-white' ?>">
                Menunggu Kasir (Pending)
            </a>
            <a href="?tab=qris_review" class="px-4 py-2 rounded-lg transition <?= $activeTab === 'qris_review' ? 'bg-amber-500 text-gray-950 font-bold' : 'bg-gray-900 text-gray-400 hover:text-white' ?>">
                Review Bukti QRIS
            </a>
            <a href="?tab=paid" class="px-4 py-2 rounded-lg transition <?= $activeTab === 'paid' ? 'bg-amber-500 text-gray-950 font-bold' : 'bg-gray-900 text-gray-400 hover:text-white' ?>">
                Riwayat Lunas (PAID)
            </a>
        </div>

        <!-- Tabel Pesanan -->
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-gray-950 text-gray-400 uppercase border-b border-gray-800">
                        <tr>
                            <th class="px-4 py-3">Order</th>
                            <th class="px-4 py-3">Pembeli</th>
                            <th class="px-4 py-3">Barang</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Metode</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <?php if (empty($ordersList)): ?>
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400">Tidak ada pesanan pada kategori ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ordersList as $o): ?>
                                <tr class="hover:bg-gray-800/40 transition">
                                    <td class="px-4 py-3 font-mono font-bold text-amber-400"><?= htmlspecialchars($o['order_code']) ?></td>
                                    <td class="px-4 py-3">
                                        <div class="font-medium text-white"><?= htmlspecialchars($o['customer_name']) ?></div>
                                        <div class="text-[10px] text-gray-400"><?= htmlspecialchars($o['customer_class']) ?> • <?= htmlspecialchars($o['customer_whatsapp']) ?></div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div><?= htmlspecialchars($o['product_name']) ?></div>
                                        <div class="text-[10px] text-gray-400">Varian: <?= htmlspecialchars($o['variant'] ?: '-') ?> (<?= $o['quantity'] ?> pcs)</div>
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-white">Rp <?= number_format($o['total_amount'] ?: $o['total_price'], 0, ',', '.') ?></td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $o['payment_method'] === 'QRIS' ? 'bg-cyan-500/10 text-cyan-400 border border-cyan-500/30' : 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' ?>">
                                            <?= htmlspecialchars($o['payment_method']) ?>
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <?php if ($o['payment_status'] === 'PAID'): ?>
                                            <span class="text-emerald-400 font-semibold flex items-center gap-1">✓ LUNAS</span>
                                            <?php if (!empty($o['verifier_name'])): ?>
                                                <div class="text-[9px] text-gray-400">Oleh: <?= htmlspecialchars($o['verifier_name']) ?></div>
                                            <?php endif; ?>
                                        <?php elseif ($o['payment_status'] === 'WAITING_VERIFICATION'): ?>
                                            <span class="text-amber-400 font-semibold animate-pulse">Butuh Review</span>
                                        <?php else: ?>
                                            <span class="text-gray-400">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <?php if ($o['payment_status'] === 'WAITING_VERIFICATION'): ?>
                                            <div class="flex items-center justify-end gap-1.5">
                                                <?php if (!empty($o['proof_image'])): ?>
                                                    <a href="../<?= htmlspecialchars($o['proof_image']) ?>" target="_blank" class="px-2 py-1 bg-gray-800 hover:bg-gray-700 text-gray-200 rounded text-[11px] font-medium transition">Bukti</a>
                                                <?php endif; ?>
                                                <button onclick="verifyQRIS(<?= $o['id'] ?>, 'APPROVE')" class="px-2.5 py-1 bg-emerald-600 hover:bg-emerald-500 text-white rounded text-[11px] font-bold transition">Terima</button>
                                                <button onclick="verifyQRIS(<?= $o['id'] ?>, 'REJECT')" class="px-2 py-1 bg-red-600/80 hover:bg-red-500 text-white rounded text-[11px] font-medium transition">Tolak</button>
                                            </div>
                                        <?php elseif ($o['payment_status'] === 'PENDING' && $o['payment_method'] === 'CASH'): ?>
                                            <a href="scanner.php" class="px-2 py-1 bg-amber-500/20 text-amber-300 hover:bg-amber-500/30 rounded text-[11px] font-semibold transition">Scan Kasir</a>
                                        <?php else: ?>
                                            <span class="text-gray-400 text-[10px]">Tervalidasi</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
    function verifyQRIS(orderId, action) {
        const confirmMsg = action === 'APPROVE' ? 'Konfirmasi bahwa dana QRIS telah benar-benar masuk ke mutasi GoPay Merchant?' : 'Tolak bukti pembayaran ini?';
        if (!confirm(confirmMsg)) return;

        fetch('../api/verify_qris.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ order_id: orderId, action: action })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
            if (data.success) location.reload();
        })
        .catch(() => alert('Terjadi kesalahan jaringan!'));
    }
    </script>
</body>
</html>
