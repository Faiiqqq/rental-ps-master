-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Feb 2026 pada 19.36
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental_ps`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `kembalikan_stok_ps` (IN `input_id_transaksi` INT)   BEGIN
                UPDATE playstations 
                SET stok = stok + 1 
                WHERE id_ps = (SELECT id_ps FROM transaksis WHERE id_transaksi = input_id_transaksi);
            END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `selesaikan_transaksi` (IN `input_id_transaksi` INT)   BEGIN
                -- 1. Update status transaksi dan waktu selesai
                UPDATE transaksis 
                SET status = 'selesai', 
                    jam_selesai = NOW() 
                WHERE id_transaksi = input_id_transaksi;
            END$$

--
-- Fungsi
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hitung_total_denda` (`input_id_transaksi` INT) RETURNS INT(11) DETERMINISTIC BEGIN
            DECLARE v_batas_kembali DATETIME;
            DECLARE v_denda_per_jam INT DEFAULT 2000;
            DECLARE v_telat_menit INT;
            DECLARE v_hasil_denda INT DEFAULT 0;

            -- Ambil batas_kembali
            SELECT batas_kembali INTO v_batas_kembali 
            FROM transaksis 
            WHERE id_transaksi = input_id_transaksi;

            -- Hitung selisih dalam MENIT
            SET v_telat_menit = TIMESTAMPDIFF(MINUTE, v_batas_kembali, NOW());

            -- Jika telat > 0 menit, hitung denda
            -- Kita gunakan pembulatan ke atas (CEIL) agar 1 menit telat tetap dihitung 1 jam
            IF v_telat_menit > 0 THEN
                SET v_hasil_denda = CEIL(v_telat_menit / 60) * v_denda_per_jam;
            END IF;

            RETURN v_hasil_denda;
        END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_activities`
--

CREATE TABLE `log_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `aksi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_activities`
--

INSERT INTO `log_activities` (`id`, `id_user`, `aksi`, `deskripsi`, `ip_address`, `created_at`, `updated_at`) VALUES
(1, 2, 'Login', 'User operator berhasil login.', '127.0.0.1', '2026-02-12 17:59:48', '2026-02-12 17:59:48'),
(2, 2, 'Logout', 'User operator logout.', '127.0.0.1', '2026-02-12 18:01:31', '2026-02-12 18:01:31'),
(3, 3, 'Login', 'User Faiq berhasil login.', '127.0.0.1', '2026-02-12 18:01:35', '2026-02-12 18:01:35'),
(4, 3, 'PS Baru', 'Menambahkan tipe baru: ps3', '127.0.0.1', '2026-02-12 18:01:52', '2026-02-12 18:01:52'),
(5, 3, 'PS Baru', 'Menambahkan tipe baru: ps4', '127.0.0.1', '2026-02-12 18:02:01', '2026-02-12 18:02:01'),
(6, 3, 'Order Rental', 'Membuat pesanan baru ID #1 (Total: Rp 3,000)', '127.0.0.1', '2026-02-12 18:09:09', '2026-02-12 18:09:09'),
(7, 3, 'Logout', 'User Faiq logout.', '127.0.0.1', '2026-02-12 18:09:13', '2026-02-12 18:09:13'),
(8, 2, 'Login', 'User operator berhasil login.', '127.0.0.1', '2026-02-12 18:09:18', '2026-02-12 18:09:18'),
(9, 2, 'Approve Rental', 'Operator menyetujui transaksi ID #1', '127.0.0.1', '2026-02-12 18:09:21', '2026-02-12 18:09:21'),
(10, 2, 'Logout', 'User operator logout.', '127.0.0.1', '2026-02-12 18:09:23', '2026-02-12 18:09:23'),
(11, 3, 'Login', 'User Faiq berhasil login.', '127.0.0.1', '2026-02-12 18:09:27', '2026-02-12 18:09:27'),
(12, 3, 'Ajukan Kembali', 'Pelanggan mengajukan pengembalian ID #1. Denda: Rp 4,000', '127.0.0.1', '2026-02-12 18:13:07', '2026-02-12 18:13:07'),
(13, 3, 'Logout', 'User Faiq logout.', '127.0.0.1', '2026-02-12 18:13:12', '2026-02-12 18:13:12'),
(14, 2, 'Login', 'User operator berhasil login.', '127.0.0.1', '2026-02-12 18:13:18', '2026-02-12 18:13:18'),
(15, 2, 'Transaksi Selesai', 'Operator menyelesaikan transaksi ID #1 dan stok dikembalikan.', '127.0.0.1', '2026-02-12 18:13:20', '2026-02-12 18:13:20'),
(16, 2, 'Order Rental', 'Membuat pesanan baru ID #2 (Total: Rp 6,000)', '127.0.0.1', '2026-02-12 18:14:49', '2026-02-12 18:14:49'),
(17, 2, 'Approve Rental', 'Operator menyetujui transaksi ID #2', '127.0.0.1', '2026-02-12 18:15:25', '2026-02-12 18:15:25'),
(18, 2, 'Logout', 'User operator logout.', '127.0.0.1', '2026-02-12 18:15:27', '2026-02-12 18:15:27'),
(19, 3, 'Login', 'User Faiq berhasil login.', '127.0.0.1', '2026-02-12 18:15:33', '2026-02-12 18:15:33'),
(20, 3, 'Ajukan Kembali', 'Pelanggan mengajukan pengembalian ID #2. Denda: Rp 0', '127.0.0.1', '2026-02-12 18:15:35', '2026-02-12 18:15:35'),
(21, 3, 'Logout', 'User Faiq logout.', '127.0.0.1', '2026-02-12 18:28:36', '2026-02-12 18:28:36'),
(22, 2, 'Login', 'User operator berhasil login.', '127.0.0.1', '2026-02-12 18:28:40', '2026-02-12 18:28:40'),
(23, 2, 'Transaksi Selesai', 'Operator menyelesaikan transaksi ID #2 dan stok dikembalikan.', '127.0.0.1', '2026-02-12 18:33:26', '2026-02-12 18:33:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_12_021240_create_playstations_table', 1),
(5, '2026_02_12_021248_create_transaksis_table', 1),
(6, '2026_02_12_225910_create_trigger_stok_playstation', 1),
(7, '2026_02_12_233528_create_procedure_selesaikan_transaksi', 1),
(8, '2026_02_13_000556_create_function_hitung_denda', 1),
(9, '2026_02_13_005113_create_log_activities_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `playstations`
--

CREATE TABLE `playstations` (
  `id_ps` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `hargaPerJam` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `playstations`
--

INSERT INTO `playstations` (`id_ps`, `tipe`, `hargaPerJam`, `stok`, `created_at`, `updated_at`) VALUES
(1, 'ps3', 3000, 1, '2026-02-12 18:01:52', '2026-02-12 18:01:52'),
(2, 'ps4', 4000, 10, '2026-02-12 18:02:01', '2026-02-12 18:02:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
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
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Lgzlekeyhc9zVMrWJlSks93XGMuCSYuRUTbFj8nM', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidjZ5NUdPUzR5UEwxdmpRYzd1bFl0R0FXUHB4MjNLaUs1R3Y4TnBmMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo5OiJkYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1770921206);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksis`
--

CREATE TABLE `transaksis` (
  `id_transaksi` bigint(20) UNSIGNED NOT NULL,
  `id_ps` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `jam_mulai` datetime NOT NULL,
  `batas_kembali` datetime NOT NULL,
  `jam_selesai` datetime DEFAULT NULL,
  `lama_jam` int(11) DEFAULT NULL,
  `total_bayar` int(11) NOT NULL DEFAULT 0,
  `status` enum('menunggu','main','return_req','selesai','ditolak','batal') NOT NULL DEFAULT 'menunggu',
  `denda` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksis`
--

INSERT INTO `transaksis` (`id_transaksi`, `id_ps`, `id_user`, `jam_mulai`, `batas_kembali`, `jam_selesai`, `lama_jam`, `total_bayar`, `status`, `denda`, `created_at`, `updated_at`) VALUES
(1, 1, 3, '2026-02-12 23:00:00', '2026-02-13 00:00:00', '2026-02-13 01:13:20', 1, 3000, 'selesai', 4000, '2026-02-12 18:09:09', '2026-02-12 18:13:07'),
(2, 1, 2, '2026-02-13 01:14:00', '2026-02-13 03:14:00', '2026-02-13 01:33:26', 2, 6000, 'selesai', 0, '2026-02-12 18:14:49', '2026-02-12 18:15:35');

--
-- Trigger `transaksis`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok_ps` AFTER UPDATE ON `transaksis` FOR EACH ROW BEGIN
            IF NEW.status = 'main' AND OLD.status != 'main' THEN
                UPDATE playstations
                SET stok = stok - 1
                WHERE id_ps = NEW.id_ps;
            END IF;
        END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tambah_stok_ps` AFTER UPDATE ON `transaksis` FOR EACH ROW BEGIN
            IF NEW.status = 'selesai' AND OLD.status != 'selesai' THEN
                UPDATE playstations
                SET stok = stok + 1
                WHERE id_ps = NEW.id_ps;
            END IF;
        END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','operator','pelanggan') NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$12$KtUIz2T9j.0NXMvojIHxGukPqW8ox4uI4H2hJTwZP.Q/o/cb2v5K.', 'admin', NULL, '2026-02-12 17:59:40', '2026-02-12 17:59:40'),
(2, 'operator', 'operator@gmail.com', '$2y$12$yMAZyBvXylpqcmkM8JPjs.bUbkZQ78fbXqZsCm8Fs8aLNa.vP1eFu', 'operator', NULL, '2026-02-12 17:59:40', '2026-02-12 17:59:40'),
(3, 'Faiq', 'faiq@gmail.com', '$2y$12$Zkc9B.9FFZxfZczTnq6Xc./ugI/TIlyJ4RZXvbXee9LrFkFGpsTBW', 'pelanggan', NULL, '2026-02-12 17:59:40', '2026-02-12 17:59:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_activities`
--
ALTER TABLE `log_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_activities_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `playstations`
--
ALTER TABLE `playstations`
  ADD PRIMARY KEY (`id_ps`),
  ADD UNIQUE KEY `playstations_tipe_unique` (`tipe`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `transaksis_id_ps_foreign` (`id_ps`),
  ADD KEY `transaksis_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_activities`
--
ALTER TABLE `log_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `playstations`
--
ALTER TABLE `playstations`
  MODIFY `id_ps` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id_transaksi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `log_activities`
--
ALTER TABLE `log_activities`
  ADD CONSTRAINT `log_activities_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_id_ps_foreign` FOREIGN KEY (`id_ps`) REFERENCES `playstations` (`id_ps`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksis_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
