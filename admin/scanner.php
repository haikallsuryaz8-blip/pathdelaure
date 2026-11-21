<?php
// C:\laragon\www\kewirausahaan\admin\scanner.php
require_once __DIR__ . '/../config.php';

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scanner Kamera Kasir Tunai — <?= BRAND_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- HTML5 QR Code Scanner Library via CDN -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-gray-900 border-b border-gray-800 p-4 flex items-center justify-between">
        <a href="dashboard.php" class="text-xs text-amber-400 font-semibold flex items-center gap-1">
            &larr; Dashboard Kasir
        </a>
        <span class="text-xs font-bold text-gray-200">Kamera HP Verifikasi Tunai</span>
    </header>

    <main class="flex-1 max-w-lg mx-auto w-full p-4 flex flex-col justify-center">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-5 shadow-2xl">
            <div class="text-center mb-4">
                <h1 class="text-lg font-bold text-white">Scan QR Verifikasi Tunai</h1>
                <p class="text-xs text-gray-400 mt-1">Arahkan kamera ke layar HP pembeli untuk memvalidasi pembayaran tunai di kasir stand.</p>
            </div>

            <!-- Viewport Kamera Scanner -->
            <div id="reader" class="overflow-hidden rounded-xl bg-black border border-gray-700 w-full min-h-[280px]"></div>

            <div id="scanResult" class="mt-4 p-4 rounded-xl hidden text-xs font-medium"></div>

            <!-- Fallback Input Manual Jika Kamera Diblokir Browser -->
            <div class="mt-5 pt-4 border-t border-gray-800/80">
                <p class="text-[11px] text-gray-400 mb-2 text-center">Atau masukkan Token/Order Code secara manual:</p>
                <div class="flex gap-2">
                    <input type="text" id="manualToken" placeholder="Masukkan Token QR..." class="flex-1 bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    <button onclick="submitManualToken()" class="bg-amber-500 text-gray-950 font-bold px-3 py-2 rounded-lg text-xs hover:bg-amber-400 transition">Proses</button>
                </div>
            </div>
        </div>
    </main>

    <script>
    let isProcessing = false;

    function onScanSuccess(decodedText, decodedResult) {
        if (isProcessing) return;
        isProcessing = true;
        processVerification(decodedText);
    }

    function submitManualToken() {
        const val = document.getElementById('manualToken').value.trim();
        if (!val) { alert('Token tidak boleh kosong!'); return; }
        processVerification(val);
    }

    function processVerification(tokenString) {
        const resultBox = document.getElementById('scanResult');
        resultBox.className = 'mt-4 p-4 rounded-xl text-xs font-medium bg-amber-500/10 border border-amber-500/30 text-amber-300 block text-center';
        resultBox.innerHTML = 'Memvalidasi pembayaran tunai ke sistem...';

        fetch('../api/verify_cash.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ token: tokenString })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                resultBox.className = 'mt-4 p-4 rounded-xl text-xs font-medium bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 block';
                resultBox.innerHTML = `
                    <div class="font-bold text-sm text-emerald-400 mb-1">✓ LUNAS (PAID)</div>
                    <div>No. Order: <b>${data.order_code}</b></div>
                    <div>Pembeli: <b>${data.customer_name} (${data.customer_class})</b></div>
                    <div>Total Diterima: <b class="text-amber-400">${data.total_amount_formatted}</b></div>
                    <div class="mt-2 text-[10px] text-gray-400">${data.message}</div>
                `;
            } else {
                resultBox.className = 'mt-4 p-4 rounded-xl text-xs font-medium bg-red-500/10 border border-red-500/30 text-red-400 block';
                resultBox.innerHTML = `<b>Peringatan:</b> ${data.message}`;
            }
            setTimeout(() => { isProcessing = false; }, 3000);
        })
        .catch(err => {
            resultBox.className = 'mt-4 p-4 rounded-xl text-xs font-medium bg-red-500/10 border border-red-500/30 text-red-400 block';
            resultBox.innerHTML = 'Gagal menghubungi server verifikasi.';
            setTimeout(() => { isProcessing = false; }, 3000);
        });
    }

    // Inisialisasi Kamera Belakang HP
    const html5QrcodeScanner = new Html5QrcodeScanner("reader", { 
        fps: 10, 
        qrbox: { width: 220, height: 220 },
        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
    });
    html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>
