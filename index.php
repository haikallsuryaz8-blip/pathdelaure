<?php
// C:\laragon\www\kewirausahaan\index.php
// WEBSITE RESMI UPRAK KEWIRAUSAHAAN - PATH DE LAURE (KELOMPOK 3 - XI RPL 2)
require_once __DIR__ . '/config.php';

// Ambil data kategori dengan fallback aman
$categories = [];
$products = [];
$team = [];
$totalOrders = 38;

if (isset($pdo)) {
    try {
        $categories = $pdo->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();
        $products = $pdo->query("SELECT p.*, c.slug as category_slug FROM products p JOIN categories c ON p.category_id = c.id WHERE p.is_available = 1 ORDER BY p.id ASC")->fetchAll();
        $team = $pdo->query("SELECT * FROM team_members ORDER BY id ASC")->fetchAll();
        $totDb = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $totalOrders += $totDb;
    } catch (Exception $e) {
        error_log("Query Catalog Error: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= BRAND_NAME ?> — <?= BRAND_TAGLINE ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- QRCode.js Library untuk render QR Pembeli -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: { 950: '#070709', 900: '#0e0e12', 850: '#131318', 800: '#181820', 700: '#23232e' },
                        amber: { 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706' }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif']
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-dark-950 text-gray-100 antialiased font-sans selection:bg-amber-500 selection:text-dark-950">
    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-dark-950/80 backdrop-blur-xl border-b border-dark-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="#hero" class="text-xl sm:text-2xl font-bold font-display tracking-tight text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                    <?= BRAND_NAME ?>
                </a>
                <span class="hidden md:inline-block px-2.5 py-0.5 text-[10px] uppercase font-bold tracking-widest bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full">Kelompok 3 • XI RPL 2</span>
            </div>
            <div class="hidden lg:flex items-center gap-8 text-sm font-medium text-gray-300">
                <a href="#katalog" class="hover:text-amber-400 transition">Katalog</a>
                <a href="#polyflex" class="hover:text-amber-400 transition">Edukasi Polyflex</a>
                <a href="#bmc" class="hover:text-amber-400 transition">Model BMC</a>
                <a href="#tim" class="hover:text-amber-400 transition">Profil Tim</a>
            </div>
            <div class="flex items-center gap-3">
                <a href="admin/login.php" class="text-xs bg-dark-800 hover:bg-dark-700 text-gray-300 px-3 py-2 rounded-xl border border-dark-700 transition flex items-center gap-1.5">
                    <i class="fa-solid fa-cash-register text-amber-400"></i>
                    <span>Portal Kasir</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="pt-32 pb-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-400 text-xs font-semibold uppercase tracking-wider mb-6">
                Ujian Praktik Kewirausahaan SMK Jakarta Pusat 1
            </span>
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold font-display tracking-tight text-white max-w-4xl mx-auto leading-tight">
                <?= BRAND_TAGLINE ?>
            </h1>
            <p class="mt-6 text-base sm:text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">
                Brand streetwear independen karya siswa XI RPL 2. Menggabungkan estetika modern, bahan Cotton Combed premium, dan teknik sablon Polyflex presisi tinggi.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="#katalog" class="px-7 py-3.5 bg-gradient-to-r from-amber-500 to-amber-600 text-dark-950 font-bold rounded-xl shadow-lg shadow-amber-500/20 hover:scale-105 transition transform text-sm">
                    Jelajahi Katalog Resmi
                </a>
                <a href="#polyflex" class="px-7 py-3.5 bg-dark-900 border border-dark-700 hover:border-amber-500/40 text-gray-200 font-semibold rounded-xl transition text-sm">
                    Pelajari Sablon Polyflex
                </a>
            </div>
        </div>
    </section>

    <!-- Katalog Produk -->
    <section id="katalog" class="py-20 bg-dark-900/50 border-t border-dark-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-bold font-display text-white">Koleksi Merchandise Resmi</h2>
                    <p class="text-sm text-gray-400 mt-2">Pilih merchandise favoritmu, bayar via QRIS GoPay Merchant atau Tunai di Kasir Stand.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($products as $p): ?>
                    <div class="bg-dark-900 border border-dark-800 rounded-2xl overflow-hidden hover:border-amber-500/30 transition duration-300 flex flex-col group">
                        <div class="relative h-64 overflow-hidden bg-dark-800">
                            <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <?php if (!empty($p['badge'])): ?>
                                <span class="absolute top-3 left-3 bg-amber-500 text-dark-950 text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider">
                                    <?= htmlspecialchars($p['badge']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-base font-bold text-white group-hover:text-amber-400 transition"><?= htmlspecialchars($p['name']) ?></h3>
                                <p class="text-xs text-gray-400 mt-2 line-clamp-2"><?= htmlspecialchars($p['description']) ?></p>
                                <div class="mt-3 flex items-center gap-2 text-[11px] text-gray-400">
                                    <span class="bg-dark-800 px-2 py-0.5 rounded border border-dark-700"><?= htmlspecialchars($p['material_info'] ?: 'Premium Material') ?></span>
                                    <span class="bg-dark-800 px-2 py-0.5 rounded border border-dark-700"><?= htmlspecialchars($p['technique_info'] ?: 'Polyflex Cut') ?></span>
                                </div>
                            </div>
                            <div class="mt-5 pt-4 border-t border-dark-800 flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-gray-400">Harga Resmi</span>
                                    <p class="text-lg font-extrabold text-amber-400">Rp <?= number_format($p['promo_price'] ?: $p['price'], 0, ',', '.') ?></p>
                                </div>
                                <button onclick="openCheckoutModal(<?= htmlspecialchars(json_encode($p)) ?>)" class="bg-amber-500 hover:bg-amber-400 text-dark-950 font-bold px-4 py-2 rounded-xl text-xs transition flex items-center gap-1.5 shadow-md shadow-amber-500/20">
                                    <i class="fa-solid fa-bag-shopping"></i> Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Modal Checkout Cerdas -->
    <div id="checkoutModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-dark-900 border border-dark-700 rounded-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl relative">
            <button onclick="closeCheckoutModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white text-lg">&times;</button>
            
            <div id="checkoutStepForm">
                <h3 class="text-xl font-bold font-display text-white mb-1">Form Pemesanan Merchandise</h3>
                <p class="text-xs text-gray-400 mb-4" id="modalProductName"></p>

                <form id="orderForm" onsubmit="submitOrder(event)" class="space-y-4">
                    <input type="hidden" id="orderProductId" name="product_id">
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1">Nama Lengkap Pembeli</label>
                        <input type="text" id="custName" name="customer_name" required placeholder="Contoh: Rian Pratama" class="w-full bg-dark-800 border border-dark-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 mb-1">Kelas / Asal</label>
                            <input type="text" id="custClass" name="customer_class" required placeholder="XI RPL 1 / Guru" class="w-full bg-dark-800 border border-dark-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 mb-1">No. WhatsApp</label>
                            <input type="tel" id="custWa" name="customer_whatsapp" required placeholder="08123456789" class="w-full bg-dark-800 border border-dark-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 mb-1">Varian / Ukuran</label>
                            <select id="custVariant" name="variant" class="w-full bg-dark-800 border border-dark-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                                <option value="Ukuran S">Ukuran S</option>
                                <option value="Ukuran M" selected>Ukuran M</option>
                                <option value="Ukuran L">Ukuran L</option>
                                <option value="Ukuran XL">Ukuran XL</option>
                                <option value="Standard Size">Standard Size (Aksesoris)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 mb-1">Jumlah (Pcs)</label>
                            <input type="number" id="custQty" name="quantity" min="1" value="1" required class="w-full bg-dark-800 border border-dark-700 rounded-xl px-3.5 py-2 text-xs text-white focus:outline-none focus:border-amber-400">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1">Metode Pembayaran</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="border border-dark-700 bg-dark-800/80 p-2.5 rounded-xl cursor-pointer hover:border-amber-400 flex items-center gap-2">
                                <input type="radio" name="payment_method" value="CASH" checked class="text-amber-500">
                                <span class="text-xs font-bold text-white">Tunai / Kasir</span>
                            </label>
                            <label class="border border-dark-700 bg-dark-800/80 p-2.5 rounded-xl cursor-pointer hover:border-amber-400 flex items-center gap-2">
                                <input type="radio" name="payment_method" value="QRIS" class="text-amber-500">
                                <span class="text-xs font-bold text-white">QRIS GoPay</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" id="btnSubmitOrder" class="w-full bg-gradient-to-r from-amber-500 to-amber-600 text-dark-950 font-bold py-3 rounded-xl transition text-xs shadow-lg shadow-amber-500/20">
                        Lanjut ke Pembayaran
                    </button>
                </form>
            </div>

            <!-- Layar Step Pembayaran Tunai (Menampilkan QR Verifikasi Kasir) -->
            <div id="checkoutStepCash" class="hidden text-center py-4">
                <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-bold rounded-full">Pesanan Tunai Tercatat</span>
                <h4 class="text-lg font-bold text-white mt-3" id="cashOrderCode"></h4>
                <p class="text-xs text-gray-400 mt-1">Tunjukkan QR Verifikasi di bawah ini kepada admin di meja kasir stand:</p>
                
                <div class="my-5 p-4 bg-white rounded-2xl inline-block shadow-xl">
                    <div id="cashQrCodeWrapper"></div>
                </div>

                <div class="text-xs text-gray-300 bg-dark-800 p-3 rounded-xl border border-dark-700 max-w-sm mx-auto">
                    Total yang harus dibayarkan: <b class="text-amber-400" id="cashTotalAmount"></b>
                </div>
                <div class="mt-4">
                    <button onclick="location.reload()" class="text-xs text-gray-400 hover:text-white">&larr; Selesai / Pesan Lagi</button>
                </div>
            </div>

            <!-- Layar Step Pembayaran QRIS (Menampilkan Gambar Resmi QRIS GoPay) -->
            <div id="checkoutStepQris" class="hidden text-center py-4">
                <span class="px-3 py-1 bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 text-xs font-bold rounded-full">QRIS GoPay Merchant Resmi</span>
                <h4 class="text-lg font-bold text-white mt-2" id="qrisOrderCode"></h4>
                <p class="text-xs text-gray-400">Total Tagihan: <b class="text-amber-400 text-sm" id="qrisTotalAmount"></b></p>

                <!-- Gambar Resmi QRIS Merchant Path De Laure -->
                <div class="my-4 max-w-[240px] mx-auto rounded-xl overflow-hidden border border-gray-700 shadow-2xl">
                    <img src="assets/images/qris_official.jpg" alt="QRIS Merchant GoPay PATH DE LAURE" class="w-full h-auto">
                </div>
                <p class="text-[11px] text-gray-400">Scan via GoPay, BCA, Mandiri, BRI, ShopeePay, atau BNI ke merchant: <b>PATH DE LAURE, FASHION</b></p>

                <!-- Form Upload Bukti Transfer -->
                <form id="qrisProofForm" onsubmit="submitQrisProof(event)" class="mt-4 text-left space-y-3 bg-dark-800 p-4 rounded-xl border border-dark-700">
                    <input type="hidden" id="qrisProofOrderCode" name="order_code">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-300 mb-1">Unggah Screenshot / Foto Bukti Transfer</label>
                        <input type="file" id="qrisProofFile" name="proof_image" accept="image/*" required class="w-full text-xs text-gray-300 bg-dark-900 border border-dark-700 rounded-lg p-2">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-300 mb-1">No. Referensi / RRN Bank (Opsional)</label>
                        <input type="text" id="qrisRefNo" name="reference_no" placeholder="Contoh: 20261121008912" class="w-full text-xs text-white bg-dark-900 border border-dark-700 rounded-lg p-2 focus:border-amber-400">
                    </div>
                    <button type="submit" id="btnUploadProof" class="w-full bg-cyan-500 hover:bg-cyan-400 text-dark-950 font-bold py-2 rounded-lg text-xs transition">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edukasi Polyflex & BMC -->
    <section id="polyflex" class="py-20 border-t border-dark-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-xs uppercase font-bold tracking-widest text-amber-400">Keunggulan Teknologi Produksi</span>
                    <h2 class="text-3xl font-bold font-display text-white mt-2">Mengapa Sablon Polyflex Heat Press?</h2>
                    <p class="text-sm text-gray-400 mt-4 leading-relaxed">
                        Polyflex printing menggunakan material vinyl sintetis elastis bermutu tinggi yang dipotong menggunakan mesin cutting plotter berpresisi mikron, kemudian direkatkan ke serat katun dengan mesin heat press suhu 160°C.
                    </p>
                    <div class="mt-6 space-y-3">
                        <div class="flex items-center gap-3 text-xs text-gray-300">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">✓</span>
                            <span>Presisi potongan sudut logo sangat tajam tanpa bleed tinta.</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-300">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">✓</span>
                            <span>Daya rekat kuat, tahan cuci berkali-kali tanpa luntur.</span>
                        </div>
                        <div class="flex items-center gap-3 text-xs text-gray-300">
                            <span class="w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">✓</span>
                            <span>Tekstur halus dan elastis, nyaman dipakai seharian di sekolah.</span>
                        </div>
                    </div>
                </div>
                <div class="bg-dark-900 border border-dark-800 rounded-2xl p-6">
                    <h3 class="text-lg font-bold font-display text-white mb-4">9 Blok Business Model Canvas (BMC)</h3>
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="bg-dark-800 p-3 rounded-xl border border-dark-700">
                            <b class="text-amber-400">1. Customer Segments</b>
                            <p class="text-[11px] text-gray-400 mt-1">Siswa SMK, komunitas streetwear, guru.</p>
                        </div>
                        <div class="bg-dark-800 p-3 rounded-xl border border-dark-700">
                            <b class="text-amber-400">2. Value Proposition</b>
                            <p class="text-[11px] text-gray-400 mt-1">Streetwear elegan, sablon polyflex awet.</p>
                        </div>
                        <div class="bg-dark-800 p-3 rounded-xl border border-dark-700">
                            <b class="text-amber-400">3. Channels</b>
                            <p class="text-[11px] text-gray-400 mt-1">Stand bazar sekolah, web mobile, WhatsApp.</p>
                        </div>
                        <div class="bg-dark-800 p-3 rounded-xl border border-dark-700">
                            <b class="text-amber-400">4. Revenue Streams</b>
                            <p class="text-[11px] text-gray-400 mt-1">Penjualan kaos, totebag, dan sticker pack.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Profil Tim 6 Anggota Kelompok 3 -->
    <section id="tim" class="py-20 bg-dark-900/50 border-t border-dark-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs uppercase font-bold tracking-widest text-amber-400">Pengembang & Eksekutif Proyek</span>
            <h2 class="text-3xl font-bold font-display text-white mt-2">Kelompok 3 — XI RPL 2</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mt-12">
                <?php foreach ($team as $m): ?>
                    <div class="bg-dark-900 border border-dark-800 rounded-xl p-4 text-center hover:border-amber-500/30 transition">
                        <img src="<?= htmlspecialchars($m['avatar']) ?>" alt="<?= htmlspecialchars($m['name']) ?>" class="w-16 h-16 rounded-full mx-auto object-cover border-2 border-dark-700 mb-3">
                        <h4 class="text-xs font-bold text-white"><?= htmlspecialchars($m['name']) ?></h4>
                        <p class="text-[10px] text-amber-400 mt-1 font-medium"><?= htmlspecialchars($m['role']) ?></p>
                        <span class="text-[9px] text-gray-400 block mt-1"><?= htmlspecialchars($m['class_name']) ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 bg-dark-950 border-t border-dark-800 text-center text-xs text-gray-400">
        <p>&copy; <?= date('Y') ?> <?= BRAND_NAME ?> • Dibuat untuk Penilaian Ujian Praktik Kewirausahaan SMK Jakarta Pusat 1.</p>
    </footer>

    <!-- JavaScript Interaktif Modal & QR -->
    <script>
    let currentProduct = null;

    function openCheckoutModal(product) {
        currentProduct = product;
        document.getElementById('orderProductId').value = product.id;
        document.getElementById('modalProductName').innerText = product.name + ' — Rp ' + Number(product.promo_price || product.price).toLocaleString('id-ID');
        document.getElementById('checkoutStepForm').classList.remove('hidden');
        document.getElementById('checkoutStepCash').classList.add('hidden');
        document.getElementById('checkoutStepQris').classList.add('hidden');
        document.getElementById('checkoutModal').classList.remove('hidden');
    }

    function closeCheckoutModal() {
        document.getElementById('checkoutModal').classList.add('hidden');
    }

    function submitOrder(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmitOrder');
        btn.disabled = true;
        btn.innerText = 'Memproses Pesanan...';

        const formData = new FormData(document.getElementById('orderForm'));

        fetch('process_order.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerText = 'Lanjut ke Pembayaran';

            if (!data.success) {
                alert(data.message);
                return;
            }

            document.getElementById('checkoutStepForm').classList.add('hidden');

            if (data.payment_method === 'CASH') {
                // Tampilkan Layar Verifikasi QR Tunai
                document.getElementById('cashOrderCode').innerText = data.order_code;
                document.getElementById('cashTotalAmount').innerText = data.total_price_formatted;
                
                const qrContainer = document.getElementById('cashQrCodeWrapper');
                qrContainer.innerHTML = '';
                new QRCode(qrContainer, {
                    text: data.verification_token,
                    width: 200,
                    height: 200,
                    colorDark : "#000000",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.H
                });
                document.getElementById('checkoutStepCash').classList.remove('hidden');
            } else {
                // Tampilkan Layar Pembayaran QRIS GoPay Resmi
                document.getElementById('qrisOrderCode').innerText = data.order_code;
                document.getElementById('qrisTotalAmount').innerText = data.total_price_formatted;
                document.getElementById('qrisProofOrderCode').value = data.order_code;
                document.getElementById('checkoutStepQris').classList.remove('hidden');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerText = 'Lanjut ke Pembayaran';
            alert('Terjadi kesalahan jaringan saat memproses pesanan.');
        });
    }

    function submitQrisProof(e) {
        e.preventDefault();
        const btn = document.getElementById('btnUploadProof');
        btn.disabled = true;
        btn.innerText = 'Mengunggah Bukti...';

        const formData = new FormData(document.getElementById('qrisProofForm'));

        fetch('api/upload_proof.php', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerText = 'Kirim Bukti Pembayaran';
            alert(data.message);
            if (data.success) {
                location.reload();
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerText = 'Kirim Bukti Pembayaran';
            alert('Gagal mengunggah bukti transfer.');
        });
    }
    </script>
</body>
</html>
