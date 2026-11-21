<?php
// C:\laragon\www\kewirausahaan\index.php
// WEBSITE RESMI UPRAK KEWIRAUSAHAAN - PATH DE LAURE (KELOMPOK 3 - XI RPL 2)
require_once __DIR__ . '/config.php';

// Ambil data kategori
$categories = $pdo->query("SELECT * FROM categories ORDER BY id ASC")->fetchAll();

// Ambil data produk
$products = $pdo->query("SELECT p.*, c.slug as category_slug FROM products p JOIN categories c ON p.category_id = c.id WHERE p.is_available = 1 ORDER BY p.id ASC")->fetchAll();

// Ambil data anggota tim
$team = $pdo->query("SELECT * FROM team_members ORDER BY id ASC")->fetchAll();

// Ambil statistik order
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn() + 38;
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PATH DE LAURE — High-End Streetwear & Creative Merchandise</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        dark: {
                            950: '#070709',
                            900: '#0e0e12',
                            850: '#131318',
                            800: '#181820',
                            700: '#23232e',
                            600: '#323242'
                        },
                        amber: {
                            350: '#fbbf24',
                            450: '#f59e0b',
                            550: '#d97706'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                        display: ['Space Grotesk', 'Syne', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #070709; color: #f4f4f5; }
        .font-display { font-family: 'Space Grotesk', sans-serif; }
        .font-syne { font-family: 'Syne', sans-serif; }
        .glass-panel { background: rgba(19, 19, 24, 0.7); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .glass-nav { background: rgba(7, 7, 9, 0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .glow-gold { box-shadow: 0 0 50px -10px rgba(245, 158, 11, 0.25); }
        .glow-card:hover { box-shadow: 0 10px 40px -10px rgba(245, 158, 11, 0.2); border-color: rgba(245, 158, 11, 0.4); }
        .marquee { display: flex; overflow: hidden; user-select: none; gap: 2rem; }
        .marquee-content { flex-shrink: 0; display: flex; justify-content: space-around; min-width: 100%; gap: 2rem; animation: scroll 25s linear infinite; }
        @keyframes scroll { from { transform: translateX(0); } to { transform: translateX(-100%); } }
        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #070709; }
        ::-webkit-scrollbar-thumb { background: #23232e; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #d97706; }
    </style>
</head>
<body class="selection:bg-amber-400 selection:text-black antialiased overflow-x-hidden">

    <!-- Ambient Gradient Background Orbs -->
    <div class="fixed top-0 left-1/4 w-[600px] h-[600px] bg-gradient-to-br from-amber-500/10 via-amber-600/5 to-transparent rounded-full blur-[140px] pointer-events-none -z-10"></div>
    <div class="fixed bottom-0 right-10 w-[500px] h-[500px] bg-gradient-to-tl from-blue-600/10 via-indigo-500/5 to-transparent rounded-full blur-[140px] pointer-events-none -z-10"></div>

    <!-- Announcement Bar -->
    <div class="bg-gradient-to-r from-dark-950 via-dark-850 to-dark-950 border-b border-white/5 py-2 px-4 text-center text-xs text-zinc-300 relative z-50">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="hidden sm:flex items-center space-x-2 text-zinc-400">
                <i class="fa-solid fa-graduation-cap text-amber-400"></i>
                <span class="font-medium">Uprak Kewirausahaan • Kelompok 3 (XI RPL 2)</span>
            </div>
            <div class="w-full sm:w-auto text-center flex items-center justify-center space-x-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="font-bold text-amber-400 uppercase tracking-widest text-[10px] sm:text-xs">LIMITED DROPS 2026:</span>
                <span class="text-zinc-200 font-medium">Beli Kaos + Totebag Diskon Spesial Bundle!</span>
            </div>
            <div class="hidden sm:block">
                <a href="https://instagram.com/pathdelaure" target="_blank" class="text-zinc-400 hover:text-white transition text-xs font-semibold flex items-center space-x-1">
                    <i class="fa-brands fa-instagram text-amber-400"></i>
                    <span>@pathdelaure</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Sticky Navigation -->
    <header class="sticky top-0 z-40 glass-nav border-b border-white/5 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="#hero" class="flex items-center space-x-3.5 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 via-amber-400 to-yellow-200 text-black flex items-center justify-center font-display font-black text-xl shadow-lg shadow-amber-500/20 group-hover:rotate-6 transition-transform">
                    PDL
                </div>
                <div>
                    <span class="font-syne font-black text-xl tracking-wider text-white block group-hover:text-amber-400 transition-colors">
                        PATH DE LAURE
                    </span>
                    <span class="text-[9px] tracking-[0.25em] text-zinc-400 uppercase font-bold block -mt-0.5">
                        Creative Merchandise
                    </span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden lg:flex items-center space-x-9 text-xs uppercase tracking-widest font-bold text-zinc-300">
                <a href="#katalog" class="hover:text-amber-400 transition-colors">Katalog</a>
                <a href="#fabric" class="hover:text-amber-400 transition-colors">Material & Print</a>
                <a href="#bmc" class="hover:text-amber-400 transition-colors">Model Bisnis (BMC)</a>
                <a href="#alur" class="hover:text-amber-400 transition-colors">Cara Beli</a>
                <a href="#team" class="hover:text-amber-400 transition-colors">Tim RPL</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                <a href="https://instagram.com/pathdelaure" target="_blank" 
                   class="w-10 h-10 rounded-xl bg-dark-800 hover:bg-dark-700 text-zinc-300 hover:text-white flex items-center justify-center border border-white/10 transition">
                    <i class="fa-brands fa-instagram text-base"></i>
                </a>
                <a href="#katalog" 
                   class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-extrabold text-xs uppercase tracking-wider transition shadow-lg shadow-amber-500/20 flex items-center space-x-2 active:scale-95">
                    <i class="fa-solid fa-bolt text-sm"></i>
                    <span>Order Online</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section: Modern Asymmetric Layout -->
    <section id="hero" class="relative pt-12 pb-24 overflow-hidden border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left Hero Copy -->
                <div class="lg:col-span-7 space-y-7 text-center lg:text-left">
                    <div class="inline-flex items-center space-x-2.5 px-4 py-2 rounded-full glass-panel border border-amber-400/30 text-xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
                        <span class="font-bold text-amber-300 uppercase tracking-widest text-[11px]">The Journey Towards Elegance</span>
                    </div>

                    <h1 class="font-syne text-4xl sm:text-6xl xl:text-7xl font-extrabold tracking-tight text-white leading-[1.08]">
                        Eksplorasi Gaya <br>
                        <span class="bg-gradient-to-r from-amber-300 via-amber-400 to-yellow-100 bg-clip-text text-transparent">Streetwear</span> Otentik.
                    </h1>

                    <p class="text-zinc-400 text-base sm:text-lg max-w-xl mx-auto lg:mx-0 font-normal leading-relaxed">
                        Brand merchandise modern karya siswa SMK Jakarta Pusat 1. Memadukan bahan premium <strong>Cotton Combed 24s</strong> dengan presisi tinggi sablon <strong>Polyflex Heat Press</strong>, kanvas totebag tebal, dan aksesoris custom akrilik.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#katalog" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:brightness-110 text-black font-extrabold text-xs uppercase tracking-widest rounded-2xl shadow-xl shadow-amber-500/20 transition flex items-center justify-center space-x-2.5 group">
                            <span>Buka Katalog Produk</span>
                            <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="#bmc" class="w-full sm:w-auto px-7 py-4 glass-panel hover:bg-dark-700 text-zinc-200 font-bold text-xs uppercase tracking-widest rounded-2xl transition flex items-center justify-center space-x-2 border border-white/10">
                            <i class="fa-solid fa-network-wired text-amber-400"></i>
                            <span>Struktur BMC Bisnis</span>
                        </a>
                    </div>

                    <!-- Trust Metric Strip -->
                    <div class="pt-8 border-t border-white/5 grid grid-cols-3 gap-6 text-center lg:text-left">
                        <div>
                            <div class="text-3xl font-black text-white font-display">100%</div>
                            <div class="text-xs text-zinc-400 font-medium mt-1">Polyflex Heat Press</div>
                        </div>
                        <div>
                            <div class="text-3xl font-black text-amber-400 font-display">24s</div>
                            <div class="text-xs text-zinc-400 font-medium mt-1">Heavy Cotton Combed</div>
                        </div>
                        <div>
                            <div class="text-3xl font-black text-emerald-400 font-display"><?= $totalOrders ?>+</div>
                            <div class="text-xs text-zinc-400 font-medium mt-1">Pcs Order Terlayani</div>
                        </div>
                    </div>
                </div>

                <!-- Right Hero Visual Showcase -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md">
                        <!-- Background Glow behind image -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-amber-500/20 to-blue-500/20 rounded-3xl blur-2xl transform rotate-3"></div>

                        <!-- Card Visual -->
                        <div class="relative rounded-3xl bg-dark-900 border border-white/10 p-3 shadow-2xl overflow-hidden group">
                            <div class="relative h-[480px] rounded-2xl overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&auto=format&fit=crop&q=80" 
                                     alt="PATH Signature T-Shirt" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-950 via-dark-950/20 to-transparent"></div>

                                <!-- Floating Badge Top Left -->
                                <div class="absolute top-4 left-4 glass-panel border border-amber-400/40 px-3.5 py-2 rounded-xl flex items-center space-x-2">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-amber-300">Official Drops</span>
                                </div>

                                <!-- Bottom Info Overlay -->
                                <div class="absolute bottom-5 left-5 right-5 p-4 rounded-xl glass-panel border border-white/10 flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold text-zinc-400 tracking-wider block">Signature Item</span>
                                        <h4 class="font-syne font-bold text-white text-base">PATH Minimalist Tee</h4>
                                        <span class="text-sm font-extrabold text-amber-400 font-display">Rp 120.000</span>
                                    </div>
                                    <a href="#katalog" class="w-10 h-10 rounded-xl bg-amber-400 hover:bg-amber-300 text-black flex items-center justify-center transition shadow-md">
                                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Infinite Brand Marquee Strip -->
    <div class="py-4 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 text-black overflow-hidden font-display font-black text-sm tracking-widest uppercase">
        <div class="marquee">
            <div class="marquee-content">
                <span>PATH DE LAURE</span> <span>•</span>
                <span>POLYFLEX PRINTING</span> <span>•</span>
                <span>COTTON COMBED 24S</span> <span>•</span>
                <span>AESTHETIC TOTEBAG</span> <span>•</span>
                <span>ACRYLIC KEYCHAIN</span> <span>•</span>
                <span>WATERPROOF STICKER</span> <span>•</span>
                <span>KELOMPOK 3 XI RPL 2</span> <span>•</span>
                <span>THE JOURNEY TOWARDS ELEGANCE</span> <span>•</span>
            </div>
            <div class="marquee-content" aria-hidden="true">
                <span>PATH DE LAURE</span> <span>•</span>
                <span>POLYFLEX PRINTING</span> <span>•</span>
                <span>COTTON COMBED 24S</span> <span>•</span>
                <span>AESTHETIC TOTEBAG</span> <span>•</span>
                <span>ACRYLIC KEYCHAIN</span> <span>•</span>
                <span>WATERPROOF STICKER</span> <span>•</span>
                <span>KELOMPOK 3 XI RPL 2</span> <span>•</span>
                <span>THE JOURNEY TOWARDS ELEGANCE</span> <span>•</span>
            </div>
        </div>
    </div>

    <!-- Interactive Product Catalog -->
    <section id="katalog" class="py-24 border-b border-white/5 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div>
                    <span class="text-amber-400 text-xs font-bold tracking-[0.2em] uppercase mb-2 block">
                        Official Collection 2026
                    </span>
                    <h2 class="font-syne text-3xl sm:text-5xl font-extrabold text-white">
                        Katalog Produk Terlengkap
                    </h2>
                    <p class="text-zinc-400 text-sm mt-3 max-w-xl">
                        Seluruh item dirancang dengan standar kualitas tinggi, material pilihan, dan diproduksi mandiri oleh tim XI RPL 2.
                    </p>
                </div>

                <!-- Modern Category Filter Tabs -->
                <div class="flex flex-wrap gap-2 mt-6 md:mt-0 glass-panel p-1.5 rounded-2xl border border-white/5">
                    <?php foreach ($categories as $idx => $cat): ?>
                        <button onclick="filterCategory('<?= $cat['slug'] ?>', this)" 
                                class="cat-btn px-4 py-2 rounded-xl text-xs font-bold transition-all <?= $idx === 0 ? 'bg-amber-400 text-black shadow-md shadow-amber-400/20' : 'text-zinc-400 hover:text-white hover:bg-white/5' ?>"
                                data-category="<?= $cat['slug'] ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="productGrid">
                <?php foreach ($products as $prod): ?>
                    <div class="product-item group glass-panel rounded-3xl overflow-hidden flex flex-col transition-all duration-300 glow-card"
                         data-category="<?= $prod['category_slug'] ?>">
                        
                        <!-- Image Container with Hover Zoom -->
                        <div class="relative h-72 overflow-hidden bg-dark-850">
                            <img src="<?= htmlspecialchars($prod['image']) ?>" 
                                 alt="<?= htmlspecialchars($prod['name']) ?>" 
                                 class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 ease-out">
                            
                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-col gap-1.5">
                                <?php if (!empty($prod['badge'])): ?>
                                    <span class="bg-amber-400 text-black text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                        <?= htmlspecialchars($prod['badge']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <span class="absolute top-4 right-4 glass-panel border border-white/10 text-zinc-200 text-[10px] font-bold px-3 py-1 rounded-full flex items-center space-x-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span>Ready Stock</span>
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-6">
                            <div>
                                <h3 class="font-syne font-bold text-xl text-white group-hover:text-amber-400 transition-colors">
                                    <?= htmlspecialchars($prod['name']) ?>
                                </h3>

                                <p class="text-xs text-zinc-400 mt-2.5 line-clamp-2 leading-relaxed">
                                    <?= htmlspecialchars($prod['description']) ?>
                                </p>

                                <!-- Specs Highlights -->
                                <div class="mt-4 pt-3.5 border-t border-white/5 space-y-2 text-[11px] text-zinc-400">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-layer-group text-amber-400/80 w-4"></i>
                                        <span>Bahan: <strong class="text-zinc-200 font-semibold"><?= htmlspecialchars($prod['material_info'] ?: 'Material Premium') ?></strong></span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-fingerprint text-amber-400/80 w-4"></i>
                                        <span>Teknik: <strong class="text-amber-400 font-semibold"><?= htmlspecialchars($prod['technique_info'] ?: 'Polyflex') ?></strong></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Price & Button -->
                            <div class="pt-4 border-t border-white/5 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-zinc-500 uppercase font-bold tracking-wider block">Harga Promo</span>
                                    <div class="flex items-baseline space-x-2">
                                        <?php if ($prod['promo_price']): ?>
                                            <span class="text-2xl font-black text-amber-400 font-display">
                                                Rp <?= number_format($prod['promo_price'], 0, ',', '.') ?>
                                            </span>
                                            <span class="text-xs text-zinc-500 line-through">
                                                Rp <?= number_format($prod['price'], 0, ',', '.') ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-2xl font-black text-white font-display">
                                                Rp <?= number_format($prod['price'], 0, ',', '.') ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <button onclick="openOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>)" 
                                        class="px-5 py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-black font-extrabold text-xs uppercase tracking-wider flex items-center space-x-2 shadow-lg shadow-amber-400/20 active:scale-95 transition">
                                    <span>Pesan</span>
                                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- Material & Printing Tech Showcase (Sesuai Materi Canva) -->
    <section id="fabric" class="py-24 border-b border-white/5 bg-dark-900/60 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <div class="lg:col-span-6 space-y-6">
                    <span class="text-amber-400 text-xs font-bold tracking-[0.2em] uppercase">
                        The Fabric & The Print
                    </span>
                    <h2 class="font-syne text-3xl sm:text-5xl font-extrabold text-white leading-tight">
                        Mengapa Kami Memilih Sablon Polyflex?
                    </h2>
                    <p class="text-zinc-400 text-sm leading-relaxed">
                        Proses pembuatan dilakukan dengan memotong bahan Polyflex presisi sesuai bentuk logo, lalu ditempelkan kuat pada permukaan kaos menggunakan mesin <strong>heat press bersuhu tinggi</strong>. Teknik ini menghasilkan desain yang terlihat sangat rapi, jelas, dan berkarakter unik tanpa menghilangkan kesan minimalis.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                        <div class="glass-panel p-5 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-400 flex items-center justify-center text-lg mb-3">
                                <i class="fa-solid fa-scissors"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">Garis Desain Super Tajam</h4>
                            <p class="text-xs text-zinc-400 mt-1.5">Teknologi vector cut memastikan tidak ada tepi sablon yang bergerigi atau bleber.</p>
                        </div>

                        <div class="glass-panel p-5 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-blue-400/20 text-blue-400 flex items-center justify-center text-lg mb-3">
                                <i class="fa-solid fa-water"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">Daya Rekat Tinggi & Awet</h4>
                            <p class="text-xs text-zinc-400 mt-1.5">Menyatu dengan serat kain Cotton Combed 24s, anti-retak saat dicuci berulang kali.</p>
                        </div>

                        <div class="glass-panel p-5 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-emerald-400/20 text-emerald-400 flex items-center justify-center text-lg mb-3">
                                <i class="fa-solid fa-feather"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">Tekstur Halus & Nyaman</h4>
                            <p class="text-xs text-zinc-400 mt-1.5">Tidak kaku di badan, adem dipakai seharian di iklim tropis Jakarta.</p>
                        </div>

                        <div class="glass-panel p-5 rounded-2xl">
                            <div class="w-10 h-10 rounded-xl bg-purple-400/20 text-purple-400 flex items-center justify-center text-lg mb-3">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h4 class="font-bold text-white text-sm">Standar QC Mandiri</h4>
                            <p class="text-xs text-zinc-400 mt-1.5">Setiap helai kaos dan totebag dicek langsung sebelum dikemas ke pemesan.</p>
                        </div>
                    </div>
                </div>

                <!-- Dual Showcase Images with Floating Stats -->
                <div class="lg:col-span-6 relative">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&auto=format&fit=crop&q=80" 
                             alt="Polyflex Detail" class="rounded-3xl h-80 w-full object-cover border border-white/10 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&auto=format&fit=crop&q=80" 
                             alt="Heat Press Machine" class="rounded-3xl h-80 w-full object-cover border border-white/10 shadow-2xl mt-10">
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Business Model Canvas (BMC) Grid -->
    <section id="bmc" class="py-24 border-b border-white/5 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-amber-400 text-xs font-bold tracking-[0.2em] uppercase">
                    Framework Strategis
                </span>
                <h2 class="font-syne text-3xl sm:text-5xl font-extrabold text-white mt-2">
                    Business Model Canvas (BMC)
                </h2>
                <p class="text-zinc-400 text-sm mt-3">
                    Analisis 9 pilar bisnis PATH DE LAURE untuk memastikan kelayakan operasional dan profitabilitas usaha.
                </p>
            </div>

            <!-- BMC 9-Box Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                
                <!-- 1. Key Partners -->
                <div class="glass-panel p-6 rounded-3xl space-y-3">
                    <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-handshake"></i>
                        <span>1. Key Partners</span>
                    </div>
                    <ul class="text-xs text-zinc-300 space-y-2 font-medium">
                        <li>• Supplier kaos polos lokal (Tanah Abang)</li>
                        <li>• Penyedia akrilik & UV printing laser</li>
                        <li>• Toko polyflex & mesin heat press</li>
                        <li>• Ekspedisi (J&T, SiCepat, GoSend)</li>
                        <li>• OSIS & Event Sekolah</li>
                    </ul>
                </div>

                <!-- 2. Key Activities & Resources -->
                <div class="space-y-4">
                    <div class="glass-panel p-6 rounded-3xl space-y-2.5">
                        <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                            <i class="fa-solid fa-gears"></i>
                            <span>2. Key Activities</span>
                        </div>
                        <ul class="text-xs text-zinc-300 space-y-1.5 font-medium">
                            <li>• Desain grafis apparel</li>
                            <li>• Sablon polyflex mandiri</li>
                            <li>• Konten TikTok & IG</li>
                            <li>• Packaging & Pengiriman</li>
                        </ul>
                    </div>
                    <div class="glass-panel p-6 rounded-3xl space-y-2.5">
                        <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                            <i class="fa-solid fa-microchip"></i>
                            <span>3. Key Resources</span>
                        </div>
                        <ul class="text-xs text-zinc-300 space-y-1.5 font-medium">
                            <li>• Laptop & software Corel/AI</li>
                            <li>• Mesin cutting & heat press</li>
                            <li>• Website e-commerce lokal</li>
                        </ul>
                    </div>
                </div>

                <!-- 3. Value Propositions (Center Hero) -->
                <div class="glass-panel p-6 rounded-3xl border-2 border-amber-400/50 glow-gold space-y-3.5 bg-gradient-to-b from-dark-850 to-dark-900">
                    <div class="text-amber-300 font-extrabold text-xs uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-crown"></i>
                        <span>4. Value Propositions</span>
                    </div>
                    <ul class="text-xs text-zinc-200 space-y-3 font-semibold">
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-check text-amber-400 mt-0.5"></i>
                            <span><strong>Polyflex Sharp:</strong> Sablon presisi tinggi dan awet dicuci.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-check text-amber-400 mt-0.5"></i>
                            <span><strong>Material Adem:</strong> Cotton Combed 24s nyaman untuk harian.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-check text-amber-400 mt-0.5"></i>
                            <span><strong>Harga Pelajar:</strong> Desain distro mewah dengan harga bersahabat.</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-check text-amber-400 mt-0.5"></i>
                            <span><strong>Layanan Custom:</strong> Menerima pesanan kelas & komunitas.</span>
                        </li>
                    </ul>
                </div>

                <!-- 4. Customer Relationships & Channels -->
                <div class="space-y-4">
                    <div class="glass-panel p-6 rounded-3xl space-y-2.5">
                        <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                            <i class="fa-solid fa-heart"></i>
                            <span>5. Customer Relations</span>
                        </div>
                        <ul class="text-xs text-zinc-300 space-y-1.5 font-medium">
                            <li>• Konsultasi ramah via WhatsApp</li>
                            <li>• Diskon bundle hemat</li>
                            <li>• Garansi tukar bila cacat</li>
                        </ul>
                    </div>
                    <div class="glass-panel p-6 rounded-3xl space-y-2.5">
                        <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                            <i class="fa-solid fa-bullhorn"></i>
                            <span>6. Channels</span>
                        </div>
                        <ul class="text-xs text-zinc-300 space-y-1.5 font-medium">
                            <li>• Instagram @pathdelaure</li>
                            <li>• Website Order Direct WA</li>
                            <li>• Bazaar stand di sekolah</li>
                        </ul>
                    </div>
                </div>

                <!-- 5. Customer Segments -->
                <div class="glass-panel p-6 rounded-3xl space-y-3">
                    <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-users"></i>
                        <span>7. Customer Segments</span>
                    </div>
                    <ul class="text-xs text-zinc-300 space-y-2 font-medium">
                        <li>• Siswa/i SMK Jakarta Pusat 1</li>
                        <li>• Pelajar & mahasiswa Jabodetabek</li>
                        <li>• Penikmat fashion streetwear</li>
                        <li>• Komunitas hobi & kelas</li>
                    </ul>
                </div>

            </div>

            <!-- Bottom Row: Cost Structure & Revenue Streams -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div class="glass-panel p-6 rounded-3xl space-y-2">
                    <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-receipt"></i>
                        <span>8. Cost Structure (Alokasi Modal & Biaya)</span>
                    </div>
                    <p class="text-xs text-zinc-300 leading-relaxed font-medium">
                        Bahan baku kaos polos (Rp 42.000/pcs), lembar polyflex per meter, kain kanvas totebag, akrilik, tinta stiker vinyl waterproof, kemasan ziplock/box eksklusif, serta operasional internet dan listrik heat press.
                    </p>
                </div>

                <div class="glass-panel p-6 rounded-3xl space-y-2">
                    <div class="text-amber-400 font-extrabold text-xs uppercase flex items-center space-x-2">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>9. Revenue Streams (Sumber Pemasukan)</span>
                    </div>
                    <p class="text-xs text-zinc-300 leading-relaxed font-medium">
                        Margin keuntungan dari penjualan Kaos (Rp 120k–135k), Totebag (Rp 30k–35k), Gantungan kunci (Rp 7k–10k), Paket stiker (Rp 5k/3pcs), Bundle set (Rp 150k), serta jasa sablon custom merchandise.
                    </p>
                </div>
            </div>

        </div>
    </section>

    <!-- Cara Pemesanan / Order Workflow -->
    <section id="alur" class="py-24 border-b border-white/5 bg-dark-900/40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-amber-400 text-xs font-bold tracking-[0.2em] uppercase">
                    Simple Process
                </span>
                <h2 class="font-syne text-3xl sm:text-5xl font-extrabold text-white mt-1">
                    Cara Mudah Memesan
                </h2>
                <p class="text-zinc-400 text-sm mt-3">
                    Proses pemesanan instan tanpa ribet, langsung terhubung dengan admin tim kami.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-panel p-7 rounded-3xl relative hover:-translate-y-1 transition duration-300">
                    <span class="text-4xl font-black text-amber-400/30 font-display block mb-3">01</span>
                    <h4 class="font-syne font-bold text-white text-base">Pilih Produk</h4>
                    <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Pilih item favoritmu dari katalog, tentukan ukuran kaos atau jumlah varian stiker/keychain.</p>
                </div>

                <div class="glass-panel p-7 rounded-3xl relative hover:-translate-y-1 transition duration-300">
                    <span class="text-4xl font-black text-amber-400/30 font-display block mb-3">02</span>
                    <h4 class="font-syne font-bold text-white text-base">Isi Data Pesanan</h4>
                    <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Klik tombol pesan pada produk, masukkan nama, kelas/sekolah, dan nomor WhatsApp aktif.</p>
                </div>

                <div class="glass-panel p-7 rounded-3xl relative hover:-translate-y-1 transition duration-300">
                    <span class="text-4xl font-black text-amber-400/30 font-display block mb-3">03</span>
                    <h4 class="font-syne font-bold text-white text-base">Konfirmasi WhatsApp</h4>
                    <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Sistem otomatis menyusun invoice dan membuka WhatsApp Admin untuk konfirmasi pembayaran.</p>
                </div>

                <div class="glass-panel p-7 rounded-3xl relative hover:-translate-y-1 transition duration-300">
                    <span class="text-4xl font-black text-emerald-400/40 font-display block mb-3">04</span>
                    <h4 class="font-syne font-bold text-white text-base">Ambil / Kirim</h4>
                    <p class="text-xs text-zinc-400 mt-2 leading-relaxed">Pesanan siap diambil di stand sekolah atau dikirim via kurir langsung ke alamatmu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet The Creators (Kelompok 3 XI RPL 2) -->
    <section id="team" class="py-24 border-b border-white/5 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <span class="text-amber-400 text-xs font-bold tracking-[0.2em] uppercase">
                    The Visionaries
                </span>
                <h2 class="font-syne text-3xl sm:text-5xl font-extrabold text-white mt-1">
                    Kelompok 3 — XI RPL 2
                </h2>
                <p class="text-zinc-400 text-sm mt-3">
                    Kolaborasi 6 siswa Rekayasa Perangkat Lunak SMK Jakarta Pusat 1 di balik kesuksesan brand PATH DE LAURE.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($team as $member): ?>
                    <div class="glass-panel rounded-3xl p-6 flex items-center space-x-4 hover:border-amber-400/40 transition glow-card">
                        <img src="<?= htmlspecialchars($member['avatar']) ?>" 
                             alt="<?= htmlspecialchars($member['name']) ?>" 
                             class="w-16 h-16 rounded-2xl object-cover border border-white/10 flex-shrink-0 shadow-md">
                        <div>
                            <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest block">
                                <?= htmlspecialchars($member['class_name']) ?>
                            </span>
                            <h4 class="font-syne font-bold text-white text-base mt-0.5">
                                <?= htmlspecialchars($member['name']) ?>
                            </h4>
                            <p class="text-xs text-zinc-400 mt-1 font-medium">
                                <?= htmlspecialchars($member['role']) ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark-950 py-12 text-zinc-400 text-xs border-t border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div>
                <span class="font-syne font-black text-white text-xl tracking-wider block">PATH DE LAURE</span>
                <span class="text-zinc-500 text-xs mt-1 block">A Fashion & Creative Merchandise Brand &copy; 2026</span>
                <span class="text-zinc-600 text-[11px] block mt-0.5">Ujian Praktik Kewirausahaan • Kelompok 3 • XI RPL 2 • SMK JAKARTA PUSAT 1</span>
            </div>

            <div class="flex items-center space-x-6 text-xs uppercase tracking-wider font-semibold">
                <a href="https://instagram.com/pathdelaure" target="_blank" class="text-zinc-300 hover:text-amber-400 transition flex items-center space-x-1.5">
                    <i class="fa-brands fa-instagram text-sm text-amber-400"></i>
                    <span>@pathdelaure</span>
                </a>
                <a href="#katalog" class="text-zinc-400 hover:text-white transition">Katalog</a>
                <a href="#bmc" class="text-zinc-400 hover:text-white transition">BMC</a>
                <a href="#team" class="text-zinc-400 hover:text-white transition">Tim</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Order Modal (Glassmorphism) -->
    <div id="orderModal" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md hidden flex items-center justify-center p-4">
        <div class="bg-dark-900 border border-white/10 rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative">
            <button onclick="closeOrderModal()" class="absolute top-5 right-5 text-zinc-400 hover:text-white text-base w-8 h-8 rounded-full bg-dark-800 border border-white/10 flex items-center justify-center transition">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-6">
                <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest block">Checkout Pemesanan</span>
                <h3 class="font-syne font-black text-2xl text-white mt-1" id="modalProductName">Nama Produk</h3>
                <p class="text-xs font-bold text-amber-300 mt-1" id="modalProductPrice">Rp 0</p>
            </div>

            <form id="orderForm" onsubmit="submitOrder(event)" class="space-y-4 text-xs">
                <input type="hidden" name="product_id" id="modalProductId">

                <div>
                    <label class="block font-bold text-zinc-300 mb-1.5">Nama Lengkap Pemesan *</label>
                    <input type="text" name="customer_name" required placeholder="Contoh: Ahmad Rizki"
                           class="w-full bg-dark-800 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-zinc-300 mb-1.5">Kelas / Asal Sekolah *</label>
                        <input type="text" name="customer_class" required placeholder="Contoh: XI RPL 1 / Umum"
                               class="w-full bg-dark-800 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
                    </div>
                    <div>
                        <label class="block font-bold text-zinc-300 mb-1.5">Nomor WhatsApp *</label>
                        <input type="tel" name="customer_whatsapp" required placeholder="Contoh: 081234567890"
                               class="w-full bg-dark-800 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-zinc-300 mb-1.5">Varian / Ukuran Kaos</label>
                        <input type="text" name="variant" placeholder="Contoh: Hitam / Size L"
                               class="w-full bg-dark-800 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
                    </div>
                    <div>
                        <label class="block font-bold text-zinc-300 mb-1.5">Jumlah Order (Pcs)</label>
                        <input type="number" name="quantity" min="1" value="1" required
                               class="w-full bg-dark-800 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-zinc-300 mb-1.5">Metode Pembayaran</label>
                    <select name="payment_method" class="w-full bg-dark-800 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-amber-400 transition">
                        <option value="TUNAI / CASH DI SEKOLAH">Tunai / Cash Langsung di Sekolah (Bazaar)</option>
                        <option value="TRANSFER BANK (BCA / MANDIRI / BRI)">Transfer Bank Resmi</option>
                        <option value="E-WALLET (DANA / GOPAY / OVO)">E-Wallet (Dana / GoPay / OVO / ShopeePay)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-zinc-300 mb-1.5">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" rows="2" placeholder="Catatan khusus sablon / alamat pengiriman..."
                              class="w-full bg-dark-800 border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder-zinc-500 focus:outline-none focus:border-amber-400 transition"></textarea>
                </div>

                <button type="submit" id="btnSubmitOrder"
                        class="w-full py-3.5 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 text-black font-extrabold rounded-2xl shadow-xl shadow-amber-500/20 text-xs uppercase tracking-widest transition flex items-center justify-center space-x-2 mt-4 active:scale-95">
                    <i class="fa-brands fa-whatsapp text-lg"></i>
                    <span>Konfirmasi & Kirim Pesanan ke WhatsApp</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Script Logic -->
    <script>
        function filterCategory(slug, btn) {
            document.querySelectorAll('.cat-btn').forEach(b => {
                b.className = 'cat-btn px-4 py-2 rounded-xl text-xs font-bold transition-all text-zinc-400 hover:text-white hover:bg-white/5';
            });
            btn.className = 'cat-btn px-4 py-2 rounded-xl text-xs font-bold transition-all bg-amber-400 text-black shadow-md shadow-amber-400/20';

            const items = document.querySelectorAll('.product-item');
            items.forEach(item => {
                if (slug === 'all' || item.dataset.category === slug) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        function openOrderModal(product) {
            document.getElementById('modalProductId').value = product.id;
            document.getElementById('modalProductName').innerText = product.name;
            const price = product.promo_price ? product.promo_price : product.price;
            document.getElementById('modalProductPrice').innerText = 'Harga: Rp ' + new Intl.NumberFormat('id-ID').format(price);
            document.getElementById('orderModal').classList.remove('hidden');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }

        async function submitOrder(e) {
            e.preventDefault();
            const btn = document.getElementById('btnSubmitOrder');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Membuat Pesanan...';

            const form = document.getElementById('orderForm');
            const formData = new FormData(form);

            try {
                const res = await fetch('process_order.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await res.json();

                if (result.success) {
                    window.open(result.wa_url, '_blank');
                    closeOrderModal();
                    alert('Pesanan ' + result.order_code + ' berhasil dicatat! Mengalihkan ke WhatsApp admin...');
                    form.reset();
                } else {
                    alert(result.message || 'Gagal memproses pesanan.');
                }
            } catch (err) {
                alert('Terjadi kendala koneksi ke server.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fa-brands fa-whatsapp text-lg mr-2"></i> Konfirmasi & Kirim Pesanan ke WhatsApp';
            }
        }
    </script>

</body>
</html>
