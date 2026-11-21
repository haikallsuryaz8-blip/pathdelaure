<?php
// C:\laragon\www\kewirausahaan\config.php
// Konfigurasi Database Terpisah Khusus Uprak Kewirausahaan
// Arsitektur Keamanan Dual-Environment: Laragon Lokal & Hosting InfinityFree

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Generate CSRF Token jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Deteksi file kredensial privat .env.php jika ada (Recommended untuk Hosting)
if (file_exists(__DIR__ . '/.env.php')) {
    require_once __DIR__ . '/.env.php';
} else {
    // Deteksi Environment Berdasarkan Server Name
    $isInfinityFree = (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'infinityfreeapp.com') !== false);

    if ($isInfinityFree) {
        // Parameter Default InfinityFree (Akan ditimpa oleh .env.php jika diunggah user)
        defined('DB_HOST') or define('DB_HOST', 'sql105.infinityfree.com');
        defined('DB_USER') or define('DB_USER', 'if0_43446163');
        defined('DB_PASS') or define('DB_PASS', '');
        defined('DB_NAME') or define('DB_NAME', 'if0_43446163_db_kewirausahaan');
        defined('DB_PORT') or define('DB_PORT', 3306);
    } else {
        // Parameter Lokal Laragon
        defined('DB_HOST') or define('DB_HOST', '127.0.0.1');
        defined('DB_USER') or define('DB_USER', 'root');
        defined('DB_PASS') or define('DB_PASS', '');
        defined('DB_NAME') or define('DB_NAME', 'db_kewirausahaan');
        defined('DB_PORT') or define('DB_PORT', 3306);
    }
}

// Parameter Brand Resmi Kelompok 3 (XI RPL 2)
defined('BRAND_NAME') or define('BRAND_NAME', 'PATH DE LAURE');
defined('BRAND_TAGLINE') or define('BRAND_TAGLINE', 'The Journey Towards Elegance');
defined('WA_ADMIN') or define('WA_ADMIN', '6281234567890');
defined('QRIS_NMID') or define('QRIS_NMID', 'ID1026640078006');
defined('QRIS_MERCHANT') or define('QRIS_MERCHANT', 'PATH DE LAURE, FASHION');

// Koneksi PDO Terproteksi (Tidak Membocorkan Kredensial Saat Terjadi Error)
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $e) {
    // Catat log internal, jangan tampilkan kredensial/error raw ke browser klien
    error_log("Koneksi Database Gagal: " . $e->getMessage());
    $dbError = "Layanan database sedang tidak dapat dihubungi. Silakan periksa konfigurasi database Anda.";
    if (isset($isApiRequest) && $isApiRequest === true) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => $dbError]);
        exit;
    }
}
