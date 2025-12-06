-- ============================================
-- SQL untuk Insert User Testing
-- E-Commerce U-Market
-- ============================================
-- 
-- Password untuk semua user: password123
-- Password sudah di-hash dengan bcrypt
--
-- Cara menggunakan:
-- 1. Buka phpMyAdmin
-- 2. Pilih database: ecommerce_umarket
-- 3. Klik tab SQL
-- 4. Copy-paste query di bawah
-- 5. Klik Go/Execute
-- ============================================

-- Hapus user test jika sudah ada (optional)
-- DELETE FROM users WHERE email IN ('admin@umarket.com', 'budi@umarket.com', 'siti@umarket.com', 'ahmad@umarket.com');

-- Insert User Admin
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES (
    'Administrator',
    'admin@umarket.com',
    '$2y$12$wicGahBbAdndbiW28oXwr.TY3XvcffTugvVqFWGYsF56l227mBz3i', -- password123
    'admin',
    NOW(),
    NOW(),
    NOW()
);

-- Insert User Pengguna 1
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES (
    'Budi Santoso',
    'budi@umarket.com',
    '$2y$12$wicGahBbAdndbiW28oXwr.TY3XvcffTugvVqFWGYsF56l227mBz3i', -- password123
    'pengguna',
    NOW(),
    NOW(),
    NOW()
);

-- Insert User Pengguna 2
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES (
    'Siti Nurhaliza',
    'siti@umarket.com',
    '$2y$12$wicGahBbAdndbiW28oXwr.TY3XvcffTugvVqFWGYsF56l227mBz3i', -- password123
    'pengguna',
    NOW(),
    NOW(),
    NOW()
);

-- Insert User Pengguna 3
INSERT INTO users (name, email, password, role, email_verified_at, created_at, updated_at) 
VALUES (
    'Ahmad Fauzi',
    'ahmad@umarket.com',
    '$2y$12$wicGahBbAdndbiW28oXwr.TY3XvcffTugvVqFWGYsF56l227mBz3i', -- password123
    'pengguna',
    NOW(),
    NOW(),
    NOW()
);

-- ============================================
-- Verifikasi (Optional - untuk cek data)
-- ============================================
-- SELECT id, name, email, role, created_at FROM users;

