-- Inisialisasi Tabel & Data Awal db_kewirausahaan
CREATE DATABASE IF NOT EXISTS db_kewirausahaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_kewirausahaan;

-- 1. Tabel Kategori Produk
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- 2. Tabel Produk
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL,
    price INT NOT NULL,
    promo_price INT NULL,
    badge VARCHAR(50) NULL,
    description TEXT NOT NULL,
    material_info VARCHAR(255) NULL,
    technique_info VARCHAR(255) NULL,
    image VARCHAR(255) NOT NULL,
    is_available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- 3. Tabel Pesanan Masuk (Order Logs)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(30) NOT NULL UNIQUE,
    customer_name VARCHAR(100) NOT NULL,
    customer_class VARCHAR(50) NOT NULL,
    customer_whatsapp VARCHAR(30) NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    variant VARCHAR(100) NULL,
    total_price INT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    notes TEXT NULL,
    status ENUM('PENDING', 'PROCESSED', 'COMPLETED', 'CANCELLED') DEFAULT 'PENDING',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 4. Tabel Anggota Tim (Kelompok 3)
CREATE TABLE IF NOT EXISTS team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(100) NOT NULL,
    class_name VARCHAR(50) NOT NULL,
    avatar VARCHAR(255) NULL
) ENGINE=InnoDB;

-- Seed Data Kategori
INSERT INTO categories (id, name, slug) VALUES 
(1, 'All Collection', 'all'),
(2, 'T-Shirt & Apparel', 'tshirt'),
(3, 'Totebag', 'totebag'),
(4, 'Keychain', 'keychain'),
(5, 'Sticker Pack', 'sticker'),
(6, 'Special Bundle', 'bundle')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Seed Data Produk Resmi Sesuai Dokumen Canva Kelompok 3
INSERT INTO products (id, category_id, name, slug, price, promo_price, badge, description, material_info, technique_info, image, is_available) VALUES
(1, 2, 'PATH Signature Minimalist T-Shirt', 'path-signature-tshirt', 135000, 120000, 'Best Seller', 'Kaos streetwear premium dengan sablon logo minimalis PATH DE LAURE. Desain eksklusif dan breathable untuk pemakaian harian yang elegan.', 'Cotton Combed 24s Heavyweight', 'Polyflex Heat Press Printing', 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&auto=format&fit=crop&q=80', 1),

(2, 2, 'PATH Oversized Graphic T-Shirt', 'path-oversized-graphic', 135000, NULL, 'New Arrival', 'Kaos siluet oversized modern dengan grafis berani di bagian punggung. Memancarkan aura kreativitas dan kebebasan berekspresi.', 'Cotton Combed 24s Premium', 'Polyflex Precision Cut', 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&auto=format&fit=crop&q=80', 1),

(3, 3, 'PATH Canvas Aesthetic Totebag', 'path-aesthetic-totebag', 35000, 30000, 'Popular', 'Totebag bahan kanvas tebal ramah lingkungan dengan kompartemen luas untuk laptop, buku sekolah, dan daily essentials.', 'Kanvas Twill Tebal (Durable)', 'Screen Printing / Polyflex', 'https://images.unsplash.com/photo-1597484662317-9bd7bdda2907?w=800&auto=format&fit=crop&q=80', 1),

(4, 4, 'PATH Acrylic Custom Keychain', 'path-acrylic-keychain', 10000, 7000, 'Hot Item', 'Gantungan kunci akrilik bening 2 sisi dengan potongan presisi tinggi. Cocok untuk gantungan kunci motor, tas ransel, maupun hadiah sahabat.', 'Akrilik Bening 3mm (Double Sided)', 'Laser Cutting & UV Print', 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&auto=format&fit=crop&q=80', 1),

(5, 5, 'PATH Vinyl Die-Cut Sticker Trio', 'path-sticker-trio', 5000, NULL, 'Favorite', 'Paket hemat 3 pcs stiker vinyl die-cut anti air dan tahan sinar matahari. Daya rekat kuat, cocok ditempel di laptop, tumbler, dan helm.', 'Vinyl Glossy Waterproof', 'Die-Cut Precision Machine', 'https://images.unsplash.com/photo-1572375992501-4b0892d50c69?w=800&auto=format&fit=crop&q=80', 1),

(6, 5, 'PATH Community Sticker Pack (30 Pcs)', 'path-sticker-pack-30', 25000, NULL, 'Value Pack', 'Paket koleksi stiker lengkap berisi 30 pcs desain unik merchandise PATH DE LAURE untuk kolektor dan komunitas.', 'Vinyl Waterproof Premium', 'Cutting Stiker Otomatis', 'https://images.unsplash.com/photo-1589384267710-7a25bc2f2050?w=800&auto=format&fit=crop&q=80', 1),

(7, 6, 'PATH Exclusive Bundle (Cloth + Totebag)', 'path-exclusive-bundle', 150000, NULL, 'Special Offer', 'Paket bundling paling hemat! Dapatkan 1 T-Shirt Eksklusif + 1 Totebag Kanvas Aesthetic + Bonus 2 Stiker Die-cut gratis.', 'Cotton Combed + Canvas Twill', 'Full Polyflex Custom', 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=800&auto=format&fit=crop&q=80', 1)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- Seed Data Anggota Kelompok 3 (XI RPL 2)
INSERT INTO team_members (id, name, role, class_name, avatar) VALUES
(1, 'Haikal Surya D.', 'Lead Developer & Finance Strategist', 'XI RPL 2', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80'),
(2, 'Aji Irawan', 'Production & Material Specialist', 'XI RPL 2', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80'),
(3, 'Alhikam Fathul Mubin', 'Quality Control & Distribution', 'XI RPL 2', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&auto=format&fit=crop&q=80'),
(4, 'Jasir Fahlery', 'Creative Design & Branding', 'XI RPL 2', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&auto=format&fit=crop&q=80'),
(5, 'Meisyiah Putri Auliyah', 'Social Media & Marketing', 'XI RPL 2', 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&auto=format&fit=crop&q=80'),
(6, 'Naura Fatimah Azzahra', 'Customer Relations & Partnerships', 'XI RPL 2', 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&auto=format&fit=crop&q=80')
ON DUPLICATE KEY UPDATE name=VALUES(name);
