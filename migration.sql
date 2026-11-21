-- =========================================================================
-- DATABASE MIGRATION & RESTRUKTURISASI RELASIONAL RESMI
-- PROYEK UPRAK KEWIRAUSAHAAN: PATH DE LAURE (KELOMPOK 3 - XI RPL 2)
-- SIFAT: AMAN & PRESERVATIF (DATA LAMA DIJAMIN TETAP UTUH & TIDAK TERHAPUS)
-- =========================================================================

-- 1. Penambahan Kolom Baru ke Tabel orders (Non-Destructive)
ALTER TABLE `orders` 
ADD COLUMN IF NOT EXISTS `total_amount` INT NOT NULL DEFAULT 0 AFTER `customer_whatsapp`,
ADD COLUMN IF NOT EXISTS `payment_status` ENUM('PENDING', 'WAITING_VERIFICATION', 'PAID', 'CANCELLED', 'REJECTED') DEFAULT 'PENDING' AFTER `payment_method`,
ADD COLUMN IF NOT EXISTS `verification_token` VARCHAR(64) NULL AFTER `payment_status`,
ADD COLUMN IF NOT EXISTS `token_expires_at` DATETIME NULL AFTER `verification_token`,
ADD COLUMN IF NOT EXISTS `paid_at` DATETIME NULL AFTER `token_expires_at`,
ADD UNIQUE INDEX IF NOT EXISTS `idx_order_token` (`verification_token`);

-- Sinkronisasi data lama orders jika ada
UPDATE `orders` SET `total_amount` = `total_price` WHERE `total_amount` = 0;
UPDATE `orders` SET `payment_status` = 'PAID' WHERE `status` = 'COMPLETED';

-- 2. Tabel Detail Produk Per Pesanan (order_items)
CREATE TABLE IF NOT EXISTS `order_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `product_name` VARCHAR(150) NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `variant` VARCHAR(100) NULL,
    `unit_price` INT NOT NULL,
    `subtotal` INT NOT NULL,
    INDEX `idx_order_id` (`order_id`),
    INDEX `idx_product_id` (`product_id`),
    CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Backfill Data Pesanan Lama ke order_items (Preservasi Data)
INSERT INTO `order_items` (`order_id`, `product_id`, `product_name`, `quantity`, `variant`, `unit_price`, `subtotal`)
SELECT o.`id`, COALESCE(p.`id`, 1), o.`product_name`, o.`quantity`, o.`variant`, 
       CAST((o.`total_price` / GREATEST(o.`quantity`, 1)) AS UNSIGNED), o.`total_price`
FROM `orders` o
LEFT JOIN `products` p ON p.`name` = o.`product_name`
WHERE o.`id` NOT IN (SELECT DISTINCT `order_id` FROM `order_items`);

-- 4. Tabel Transaksi Pembayaran (payments)
CREATE TABLE IF NOT EXISTS `payments` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `payment_type` ENUM('CASH', 'QRIS') NOT NULL,
    `amount` INT NOT NULL,
    `reference_no` VARCHAR(100) NULL,
    `proof_image` VARCHAR(255) NULL,
    `status` ENUM('PENDING', 'WAITING_VERIFICATION', 'PAID', 'REJECTED') DEFAULT 'PENDING',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE INDEX `idx_payment_ref` (`reference_no`),
    INDEX `idx_payment_order` (`order_id`),
    CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel User / Admin Kelompok (users)
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `role` ENUM('ADMIN', 'CASHIER') NOT NULL DEFAULT 'CASHIER',
    `is_active` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Admin Default Kelompok 3 (Password default: admin123, BCRYPT hash)
INSERT INTO `users` (`id`, `username`, `password_hash`, `full_name`, `role`) VALUES
(1, 'haikal', '$2y$10$wT0lQn2qX8d0zL.o2.lBae3eS1o3g9Y2T9qQ2RzB5z7T4Y0u3F8uO', 'Haikal Surya D. (Lead Dev)', 'ADMIN'),
(2, 'aji', '$2y$10$wT0lQn2qX8d0zL.o2.lBae3eS1o3g9Y2T9qQ2RzB5z7T4Y0u3F8uO', 'Aji Irawan (Kasir/Produksi)', 'CASHIER'),
(3, 'alhikam', '$2y$10$wT0lQn2qX8d0zL.o2.lBae3eS1o3g9Y2T9qQ2RzB5z7T4Y0u3F8uO', 'Alhikam Fathul M. (Kasir)', 'CASHIER'),
(4, 'jasir', '$2y$10$wT0lQn2qX8d0zL.o2.lBae3eS1o3g9Y2T9qQ2RzB5z7T4Y0u3F8uO', 'Jasir Fahlery (Kasir)', 'CASHIER'),
(5, 'meisyiah', '$2y$10$wT0lQn2qX8d0zL.o2.lBae3eS1o3g9Y2T9qQ2RzB5z7T4Y0u3F8uO', 'Meisyiah Putri A. (Kasir)', 'CASHIER'),
(6, 'naura', '$2y$10$wT0lQn2qX8d0zL.o2.lBae3eS1o3g9Y2T9qQ2RzB5z7T4Y0u3F8uO', 'Naura Fatimah A. (Kasir)', 'CASHIER')
ON DUPLICATE KEY UPDATE `full_name`=VALUES(`full_name`);

-- 6. Tabel Riwayat Perubahan Status Pembayaran (payment_history)
CREATE TABLE IF NOT EXISTS `payment_history` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `payment_id` INT NOT NULL,
    `previous_status` VARCHAR(50) NULL,
    `new_status` VARCHAR(50) NOT NULL,
    `changed_by_user_id` INT NULL,
    `reason` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_history_payment` (`payment_id`),
    CONSTRAINT `fk_history_payment` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel Verifikasi Kasir / Admin (admin_verifications)
CREATE TABLE IF NOT EXISTS `admin_verifications` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `admin_id` INT NOT NULL,
    `verification_method` ENUM('QR_CAMERA_SCAN', 'MANUAL_MUTATION_CHECK') NOT NULL,
    `notes` TEXT NULL,
    `verified_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_verif_order` (`order_id`),
    INDEX `idx_verif_admin` (`admin_id`),
    CONSTRAINT `fk_verif_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_verif_user` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabel Buku Kas Pendapatan Bersih Resmi (revenue_records)
CREATE TABLE IF NOT EXISTS `revenue_records` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL UNIQUE,
    `payment_method` ENUM('CASH', 'QRIS') NOT NULL,
    `net_amount` INT NOT NULL,
    `recorded_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_revenue_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabel Audit Keamanan Digital (audit_logs)
CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `action_name` VARCHAR(100) NOT NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `details` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
