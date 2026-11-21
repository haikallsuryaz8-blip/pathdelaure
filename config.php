<?php
// C:\laragon\www\kewirausahaan\config.php
// Konfigurasi Database Terpisah Khusus Uprak Kewirausahaan

define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_kewirausahaan');
define('DB_PORT', 3306);

// Nomor WhatsApp Admin Pemesanan
define('WA_ADMIN', '6281234567890'); // Ganti dengan nomor WA aktif pengurus
define('BRAND_NAME', 'PATH DE LAURE');
define('BRAND_TAGLINE', 'A Fashion & Creative Merchandise Brand — The Journey Towards Elegance');

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
    die("Koneksi Database Kewirausahaan Gagal: " . $e->getMessage());
}
