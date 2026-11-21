<?php
// C:\laragon\www\kewirausahaan\config.php
// Konfigurasi Cerdas: Support Localhost (MySQL) & Cloud Render (SQLite Auto-Fallback)

define('WA_ADMIN', '6281234567890');
define('BRAND_NAME', 'PATH DE LAURE');
define('BRAND_TAGLINE', 'A Fashion & Creative Merchandise Brand — The Journey Towards Elegance');

$pdo = null;

// Coba koneksi MySQL lokal jika ada
if (getenv('DB_CONNECTION') !== 'sqlite' && file_exists('C:/laragon')) {
    try {
        $pdo = new PDO(
            "mysql:host=127.0.0.1;port=3306;dbname=db_kewirausahaan;charset=utf8mb4",
            'root',
            '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    } catch (Exception $e) {
        $pdo = null;
    }
}

// Jika di cloud (Render) atau MySQL tidak nyala, gunakan SQLite mandiri yang tidak pernah gagal
if (!$pdo) {
    $dbFile = __DIR__ . '/kewirausahaan.sqlite';
    $needInit = !file_exists($dbFile);
    
    $pdo = new PDO("sqlite:" . $dbFile, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

    if ($needInit) {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT NOT NULL UNIQUE
            );

            CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER NOT NULL,
                name TEXT NOT NULL,
                slug TEXT NOT NULL,
                price INTEGER NOT NULL,
                promo_price INTEGER NULL,
                badge TEXT NULL,
                description TEXT NOT NULL,
                material_info TEXT NULL,
                technique_info TEXT NULL,
                image TEXT NOT NULL,
                is_available INTEGER DEFAULT 1
            );

            CREATE TABLE IF NOT EXISTS orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_code TEXT NOT NULL UNIQUE,
                customer_name TEXT NOT NULL,
                customer_class TEXT NOT NULL,
                customer_whatsapp TEXT NOT NULL,
                product_name TEXT NOT NULL,
                quantity INTEGER NOT NULL DEFAULT 1,
                variant TEXT NULL,
                total_price INTEGER NOT NULL,
                payment_method TEXT NOT NULL,
                notes TEXT NULL,
                status TEXT DEFAULT 'PENDING',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS team_members (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                role TEXT NOT NULL,
                class_name TEXT NOT NULL,
                avatar TEXT NULL
            );

            INSERT OR IGNORE INTO categories (id, name, slug) VALUES 
            (1, 'All Collection', 'all'),
            (2, 'T-Shirt & Apparel', 'tshirt'),
            (3, 'Totebag', 'totebag'),
            (4, 'Keychain', 'keychain'),
            (5, 'Sticker Pack', 'sticker'),
            (6, 'Special Bundle', 'bundle');

            INSERT OR IGNORE INTO products (id, category_id, name, slug, price, promo_price, badge, description, material_info, technique_info, image, is_available) VALUES
            (1, 2, 'PATH Signature Minimalist T-Shirt', 'path-signature-tshirt', 135000, 120000, 'Best Seller', 'Kaos streetwear premium dengan sablon logo minimalis PATH DE LAURE. Desain eksklusif dan breathable untuk pemakaian harian yang elegan.', 'Cotton Combed 24s Heavyweight', 'Polyflex Heat Press Printing', 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&auto=format&fit=crop&q=80', 1),
            (2, 2, 'PATH Oversized Graphic T-Shirt', 'path-oversized-graphic', 135000, NULL, 'New Arrival', 'Kaos siluet oversized modern dengan grafis berani di bagian punggung. Memancarkan aura kreativitas dan kebebasan berekspresi.', 'Cotton Combed 24s Premium', 'Polyflex Precision Cut', 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&auto=format&fit=crop&q=80', 1),
            (3, 3, 'PATH Canvas Aesthetic Totebag', 'path-aesthetic-totebag', 35000, 30000, 'Popular', 'Totebag bahan kanvas tebal ramah lingkungan dengan kompartemen luas untuk laptop, buku sekolah, dan daily essentials.', 'Kanvas Twill Tebal (Durable)', 'Screen Printing / Polyflex', 'https://images.unsplash.com/photo-1597484662317-9bd7bdda2907?w=800&auto=format&fit=crop&q=80', 1),
            (4, 4, 'PATH Acrylic Custom Keychain', 'path-acrylic-keychain', 10000, 7000, 'Hot Item', 'Gantungan kunci akrilik bening 2 sisi dengan potongan presisi tinggi. Cocok untuk gantungan kunci motor, tas ransel, maupun hadiah sahabat.', 'Akrilik Bening 3mm (Double Sided)', 'Laser Cutting & UV Print', 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&auto=format&fit=crop&q=80', 1),
            (5, 5, 'PATH Vinyl Die-Cut Sticker Trio', 'path-sticker-trio', 5000, NULL, 'Favorite', 'Paket hemat 3 pcs stiker vinyl die-cut anti air dan tahan sinar matahari. Daya rekat kuat, cocok ditempel di laptop, tumbler, dan helm.', 'Vinyl Glossy Waterproof', 'Die-Cut Precision Machine', 'https://images.unsplash.com/photo-1572375992501-4b0892d50c69?w=800&auto=format&fit=crop&q=80', 1),
            (6, 5, 'PATH Community Sticker Pack (30 Pcs)', 'path-sticker-pack-30', 25000, NULL, 'Value Pack', 'Paket koleksi stiker lengkap berisi 30 pcs desain unik merchandise PATH DE LAURE untuk kolektor dan komunitas.', 'Vinyl Waterproof Premium', 'Cutting Stiker Otomatis', 'https://images.unsplash.com/photo-1589384267710-7a25bc2f2050?w=800&auto=format&fit=crop&q=80', 1),
            (7, 6, 'PATH Exclusive Bundle (Cloth + Totebag)', 'path-exclusive-bundle', 150000, NULL, 'Special Offer', 'Paket bundling paling hemat! Dapatkan 1 T-Shirt Eksklusif + 1 Totebag Kanvas Aesthetic + Bonus 2 Stiker Die-cut gratis.', 'Cotton Combed + Canvas Twill', 'Full Polyflex Custom', 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=800&auto=format&fit=crop&q=80', 1);

            INSERT OR IGNORE INTO team_members (id, name, role, class_name, avatar) VALUES
            (1, 'Haikal Surya D.', 'Lead Developer & Finance Strategist', 'XI RPL 2', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80'),
            (2, 'Aji Irawan', 'Production & Material Specialist', 'XI RPL 2', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80'),
            (3, 'Alhikam Fathul Mubin', 'Quality Control & Distribution', 'XI RPL 2', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80'),
            (4, 'Jasir Fahlery', 'Creative Design & Branding', 'XI RPL 2', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format&fit=crop&q=80'),
            (5, 'Meisyiah Putri Auliyah', 'Social Media & Marketing', 'XI RPL 2', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&auto=format&fit=crop&q=80'),
            (6, 'Naura Fatimah Azzahra', 'Customer Relations & Partnerships', 'XI RPL 2', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&auto=format&fit=crop&q=80');
        ");
    }
}
