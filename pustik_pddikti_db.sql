-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2026 at 06:44 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pustik_pddikti_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_dokumen`
--

CREATE TABLE `jenis_dokumen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_dokumen` varchar(255) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_dokumen`
--

INSERT INTO `jenis_dokumen` (`id`, `nama_dokumen`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Scan KTP Asli', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(2, 'Scan Kartu Keluarga', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(3, 'Scan Akte Kelahiran', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(4, 'Scan Transkrip Nilai', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(5, 'Surat Pernyataan Bermaterai', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pengajuan`
--

CREATE TABLE `jenis_pengajuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pengajuan` varchar(255) NOT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pengajuan`
--

INSERT INTO `jenis_pengajuan` (`id`, `nama_pengajuan`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 'Perubahan Nama', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(2, 'Perubahan NIM', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(3, 'Perubahan Tanggal Lahir', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2024_01_01_000000_create_default_tables', 1),
(2, '2026_01_28_050000_create_master_data_tables', 1),
(3, '2026_01_28_050010_create_pengajus_table', 1),
(4, '2026_01_28_050020_create_pengajuans_table', 1),
(5, '2026_01_28_050030_create_syarat_pengajuans_table', 1),
(6, '2026_01_28_050040_create_dokumen_dan_riwayats_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaju`
--

CREATE TABLE `pengaju` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaju`
--

INSERT INTO `pengaju` (`id`, `nama_lengkap`, `nim`, `nik`, `email`, `no_hp`, `alamat`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Adam Achmad', 'E1E120001', '747100000001', 'adam@uho.ac.id', '081234567890', 'Jl. H.E.A. Mokodompit, Kendari', '$2y$12$S0cu8xvg/bmrn59jHrZetekUG9gDfkbhSCk80KFcKBIsA8X93VnhS', '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pengaju` bigint(20) UNSIGNED NOT NULL,
  `id_jenis_pengajuan` bigint(20) UNSIGNED NOT NULL,
  `id_status_pengajuan` bigint(20) UNSIGNED NOT NULL,
  `keterangan_user` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan`
--

INSERT INTO `pengajuan` (`id`, `id_pengaju`, `id_jenis_pengajuan`, `id_status_pengajuan`, `keterangan_user`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 2, 'Mohon maaf pak, nama saya salah ketik di PDDIKTI.', '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_has_dokumen`
--

CREATE TABLE `pengajuan_has_dokumen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pengajuan` bigint(20) UNSIGNED NOT NULL,
  `id_jenis_dokumen` bigint(20) UNSIGNED NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `file_size_kb` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengajuan_has_dokumen`
--

INSERT INTO `pengajuan_has_dokumen` (`id`, `id_pengajuan`, `id_jenis_dokumen`, `path_file`, `file_type`, `file_size_kb`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'uploads/dummy_ktp.pdf', 'pdf', 500, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(2, 1, 3, 'uploads/dummy_akte.pdf', 'pdf', 1200, '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pengajuan`
--

CREATE TABLE `riwayat_pengajuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pengajuan` bigint(20) UNSIGNED NOT NULL,
  `id_status_pengajuan` bigint(20) UNSIGNED NOT NULL,
  `catatan` text DEFAULT NULL,
  `created_by` varchar(255) NOT NULL DEFAULT 'System',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riwayat_pengajuan`
--

INSERT INTO `riwayat_pengajuan` (`id`, `id_pengajuan`, `id_status_pengajuan`, `catatan`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Pengajuan baru berhasil dikirim oleh mahasiswa.', 'Mahasiswa', '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dm4xqGL6wZN8YHpyWOKeG2k3KrpISwzqqBnBVKkL', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoialJmcXNqS2czU0RrdjFYUURkY3gwaW9aNTJDNmwybmlkSzVpMDM4ZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769579008),
('qqd4AlgTOh6Aaod26o11jVRUo6azSQ4dTeklxu0s', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUk5MOHVHUHU2VzdXbU4xTjhsRWpqZHNlendrMExxWVowdXZiSkhCWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769578907);

-- --------------------------------------------------------

--
-- Table structure for table `status_pengajuan`
--

CREATE TABLE `status_pengajuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_status` varchar(255) NOT NULL,
  `urutan` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_pengajuan`
--

INSERT INTO `status_pengajuan` (`id`, `nama_status`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Draft', 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(2, 'Menunggu Verifikasi', 2, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(3, 'Perbaikan', 3, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(4, 'Diproses ke PDDIKTI', 4, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(5, 'Selesai', 5, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(6, 'Ditolak', 99, '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `syarat_pengajuan`
--

CREATE TABLE `syarat_pengajuan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_jenis_pengajuan` bigint(20) UNSIGNED NOT NULL,
  `id_jenis_dokumen` bigint(20) UNSIGNED NOT NULL,
  `is_wajib` tinyint(1) NOT NULL DEFAULT 1,
  `allowed_types` varchar(255) NOT NULL DEFAULT 'pdf,jpg',
  `max_size_kb` int(11) NOT NULL DEFAULT 2048,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `syarat_pengajuan`
--

INSERT INTO `syarat_pengajuan` (`id`, `id_jenis_pengajuan`, `id_jenis_dokumen`, `is_wajib`, `allowed_types`, `max_size_kb`, `is_aktif`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'pdf,jpg,jpeg', 2048, 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(2, 1, 3, 1, 'pdf', 5120, 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(3, 2, 1, 1, 'pdf,jpg', 2048, 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21'),
(4, 2, 4, 1, 'pdf', 2048, 1, '2026-01-27 21:41:21', '2026-01-27 21:41:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis_pengajuan`
--
ALTER TABLE `jenis_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pengaju`
--
ALTER TABLE `pengaju`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pengaju_nim_unique` (`nim`),
  ADD UNIQUE KEY `pengaju_email_unique` (`email`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_id_pengaju_foreign` (`id_pengaju`),
  ADD KEY `pengajuan_id_jenis_pengajuan_foreign` (`id_jenis_pengajuan`),
  ADD KEY `pengajuan_id_status_pengajuan_foreign` (`id_status_pengajuan`);

--
-- Indexes for table `pengajuan_has_dokumen`
--
ALTER TABLE `pengajuan_has_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengajuan_has_dokumen_id_pengajuan_foreign` (`id_pengajuan`),
  ADD KEY `pengajuan_has_dokumen_id_jenis_dokumen_foreign` (`id_jenis_dokumen`);

--
-- Indexes for table `riwayat_pengajuan`
--
ALTER TABLE `riwayat_pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `riwayat_pengajuan_id_pengajuan_foreign` (`id_pengajuan`),
  ADD KEY `riwayat_pengajuan_id_status_pengajuan_foreign` (`id_status_pengajuan`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `status_pengajuan`
--
ALTER TABLE `status_pengajuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `syarat_pengajuan`
--
ALTER TABLE `syarat_pengajuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `syarat_pengajuan_id_jenis_pengajuan_foreign` (`id_jenis_pengajuan`),
  ADD KEY `syarat_pengajuan_id_jenis_dokumen_foreign` (`id_jenis_dokumen`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_pengajuan`
--
ALTER TABLE `jenis_pengajuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pengaju`
--
ALTER TABLE `pengaju`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengajuan_has_dokumen`
--
ALTER TABLE `pengajuan_has_dokumen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `riwayat_pengajuan`
--
ALTER TABLE `riwayat_pengajuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `status_pengajuan`
--
ALTER TABLE `status_pengajuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `syarat_pengajuan`
--
ALTER TABLE `syarat_pengajuan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `pengajuan_id_jenis_pengajuan_foreign` FOREIGN KEY (`id_jenis_pengajuan`) REFERENCES `jenis_pengajuan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_id_pengaju_foreign` FOREIGN KEY (`id_pengaju`) REFERENCES `pengaju` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengajuan_id_status_pengajuan_foreign` FOREIGN KEY (`id_status_pengajuan`) REFERENCES `status_pengajuan` (`id`);

--
-- Constraints for table `pengajuan_has_dokumen`
--
ALTER TABLE `pengajuan_has_dokumen`
  ADD CONSTRAINT `pengajuan_has_dokumen_id_jenis_dokumen_foreign` FOREIGN KEY (`id_jenis_dokumen`) REFERENCES `jenis_dokumen` (`id`),
  ADD CONSTRAINT `pengajuan_has_dokumen_id_pengajuan_foreign` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `riwayat_pengajuan`
--
ALTER TABLE `riwayat_pengajuan`
  ADD CONSTRAINT `riwayat_pengajuan_id_pengajuan_foreign` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `riwayat_pengajuan_id_status_pengajuan_foreign` FOREIGN KEY (`id_status_pengajuan`) REFERENCES `status_pengajuan` (`id`);

--
-- Constraints for table `syarat_pengajuan`
--
ALTER TABLE `syarat_pengajuan`
  ADD CONSTRAINT `syarat_pengajuan_id_jenis_dokumen_foreign` FOREIGN KEY (`id_jenis_dokumen`) REFERENCES `jenis_dokumen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `syarat_pengajuan_id_jenis_pengajuan_foreign` FOREIGN KEY (`id_jenis_pengajuan`) REFERENCES `jenis_pengajuan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
