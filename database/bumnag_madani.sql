-- ============================================
-- BUMNag Madani Lubuk Malako Database Schema
-- Untuk MySQL / MariaDB (cPanel Hosting)
-- ============================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================
-- Struktur Tabel: migrations
-- ============================================
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: users
-- ============================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: password_reset_tokens
-- ============================================
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: sessions
-- ============================================
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: cache
-- ============================================
DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: jobs
-- ============================================
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: profil_bumnag
-- ============================================
DROP TABLE IF EXISTS `profil_bumnag`;
CREATE TABLE `profil_bumnag` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_bumnag` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'BUMNag Madani Lubuk Malako',
  `sejarah` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `misi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `struktur_organisasi` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_berdiri` year DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: laporan_keuangan
-- ============================================
DROP TABLE IF EXISTS `laporan_keuangan`;
CREATE TABLE `laporan_keuangan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `periode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` year NOT NULL,
  `bulan` enum('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pendapatan` decimal(15,2) NOT NULL DEFAULT 0.00,
  `pengeluaran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `laba_rugi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `aset` decimal(15,2) NOT NULL DEFAULT 0.00,
  `kewajiban` decimal(15,2) NOT NULL DEFAULT 0.00,
  `modal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `keterangan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dokumen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `laporan_keuangan_tahun_index` (`tahun`),
  KEY `laporan_keuangan_is_published_index` (`is_published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: berita
-- ============================================
DROP TABLE IF EXISTS `berita`;
CREATE TABLE `berita` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ringkasan` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `konten` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `penulis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` timestamp NULL DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `berita_slug_unique` (`slug`),
  KEY `berita_is_published_index` (`is_published`),
  KEY `berita_published_at_index` (`published_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- Struktur Tabel: pengumuman
-- ============================================
DROP TABLE IF EXISTS `pengumuman`;
CREATE TABLE `pengumuman` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `prioritas` enum('rendah','sedang','tinggi') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sedang',
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `lampiran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengumuman_is_active_index` (`is_active`),
  KEY `pengumuman_tanggal_mulai_index` (`tanggal_mulai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- Data Awal: profil_bumnag
-- ============================================
INSERT INTO `profil_bumnag` (`id`, `nama_bumnag`, `sejarah`, `visi`, `misi`, `struktur_organisasi`, `alamat`, `telepon`, `email`, `website`, `tahun_berdiri`, `created_at`, `updated_at`) VALUES
(1, 'BUMNag Madani Lubuk Malako', 'BUMNag Madani Lubuk Malako didirikan pada tahun 2020 dengan tujuan untuk memajukan perekonomian masyarakat nagari melalui pengelolaan usaha yang profesional dan berkelanjutan. Sebagai badan usaha milik nagari, BUMNag berkomitmen untuk memberikan kontribusi nyata bagi kesejahteraan masyarakat Lubuk Malako. Berdiri atas dasar semangat gotong royong dan kemandirian ekonomi, BUMNag Madani telah menjadi motor penggerak ekonomi lokal yang mengelola berbagai unit usaha strategis.', 'Menjadi Badan Usaha Milik Nagari yang profesional, mandiri, dan berkontribusi nyata dalam meningkatkan kesejahteraan masyarakat Lubuk Malako.', '1. Mengelola usaha secara profesional, transparan, dan akuntabel\n2. Meningkatkan pendapatan asli nagari melalui diversifikasi usaha\n3. Memberdayakan potensi ekonomi lokal dan sumber daya masyarakat\n4. Memberikan pelayanan terbaik kepada masyarakat\n5. Membangun kemitraan strategis dengan berbagai pihak', 'Direktur: H. Ahmad Yani, S.E.\nSekretaris: Dewi Sartika, S.Pd.\nBendahara: Ir. Budi Santoso\nKepala Unit Usaha: Rini Wulandari, S.M.', 'Jl. Raya Lubuk Malako No. 123, Kecamatan Lubuk Malako, Kabupaten Solok Selatan, Sumatera Barat', '(0755) 123456', 'info@bumnagmadani.id', 'https://bumnagmadani.id', 2020, NOW(), NOW());

-- ============================================
-- Catatan Deployment cPanel:
-- ============================================
-- 1. Upload file ini ke cPanel dan import via phpMyAdmin
-- 2. Update file .env dengan kredensial database MySQL:
--    DB_CONNECTION=mysql
--    DB_HOST=localhost
--    DB_DATABASE=nama_database
--    DB_USERNAME=username_db
--    DB_PASSWORD=password_db
-- 3. Jalankan: php artisan db:seed (untuk data sampel lengkap)
-- 4. Atau import data sampel secara manual sesuai kebutuhan
-- 5. Set document root ke folder public/
-- ============================================
