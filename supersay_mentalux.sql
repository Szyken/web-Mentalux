-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2026 at 08:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `supersay_mentalux`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(10) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(32) NOT NULL DEFAULT 'CUSTOMER'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`id`, `username`, `email`, `password`, `role`) VALUES
(7, 'udin', 'udin@gmail.com', '$2y$12$LP.rWzmx.UvmcRdLltZ3.ejCwXd7/ivV433NvoiHu1Upu51Iwaf8O', 'CUSTOMER'),
(8, 'dicky', 'dicky@gmail.com', '$2y$12$Uxn92MHnFAhX8/2iZUEL5OgXnErRv3qE94VKsidzZ5yYWt1MA8U8a', 'Psychologist'),
(9, 'Hanif', 'hanifafan@gmail.com', '$2y$12$a6gTclrMhPCaT4zi485fzOniumgN/JNTZs5Eu6p3Q1YzeHUkzU.2G', 'Admin'),
(11, 'Ferdy', 'ferdyy@gmail.com', '$2y$12$Tq0dUQyjgBGBTt7tJi.W1.rcLNR7CqmLy3oBBpyJu5GVnmEkKjgre', 'Customer'),
(12, 'Messi', 'messi@gmail.com', '$2y$12$b.5/aqDrzLeVFf.tzlodLuUvGidHSjSJRnv0PoryRQ8AEF9q4QOFO', 'Customer'),
(13, 'juna', 'herjuna@gmail.com', '$2y$12$fAypwRbmMsj54jMlJw0b7OxHoKo0.tfK8.9lM1RyXJwK82QiuoGsm', 'Admin'),
(14, 'Ronaldo', 'ronaldo@gmail.com', '$2y$12$bvoivqPC28a5nuw6Ljqh5e1HdPgGNzRbFNXEyl4irgUAvXb0k1POe', 'Customer'),
(16, 'Zidane', 'zidane@gmail.com', '$2y$12$5w./UUilGWW2PStEbJ3TD.s7EVDS.okGIwerZ5cJqzyFK1vCzqPVK', 'Customer'),
(18, 'Alex Ferguson', '108c2019@gmail.com', '$2y$12$rockcQ9xFbGjw1464g9gHu/AIh3jtMfb5qZS.3FL9Yd/woV56EBIW', 'Customer'),
(19, 'Ferdy N', 'ferdyOey@gmail.com', '$2y$12$QsFkVdW2KsoTSg7Z9H4kxOVpF6jDrwICRsuwp37LX/HZm3GoFtPCO', 'Customer'),
(20, 'Yantok', 'yantok@gmail.com', '$2y$12$BsMsO6D53P69tTyvOfzSI.D/lefGC5VixB1T9NEYxsSbL.zIGL/GS', 'Customer'),
(22, 'Ferdy Nugraha', 'ferdy.nugraha@student.umn.ac.id', '$2y$12$OZ8q6vR/UlrU1d0boo1u3eGN8w6sP4ZNkAAMSnFI3wkCj8gq5SKgC', 'Customer'),
(24, 'Amanda Angela', 'amanda@gmail.com', '$2y$12$LWk7OqfT1FM9YXg0CQBCDufk2qr2EFl0o4i3Ni.mXNxDrKhPodR1m', 'Psychologist'),
(26, 'Dharma', 'dharma@gmail.com', '$2y$12$Si0.HjenbKqOLJYDBx52DuLFSzlmdBGVrt.xDyEkI.DgSsGDxhthe', 'Psychologist');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `category`, `image_url`, `summary`, `content`, `created_at`, `updated_at`) VALUES
(1, 'Mengatasi Burnout Kerja', 'Work Life', 'https://images.unsplash.com/photo-1758598497429-6eb3895d5bfa?q=80&w=600&auto=format&fit=crop', 'Merasa lelah terus menerus? Kenali tanda-tanda burnout sebelum terlambat.', '<p>Merasa lelah terus menerus? Itu bukan sekadar capek biasa. Burnout adalah kondisi kelelahan emosional, fisik, dan mental yang disebabkan oleh stres berlebihan dan berkepanjangan.</p><h3>Tanda-tanda Burnout:</h3><ul><li>Kehilangan motivasi kerja.</li><li>Merasa tidak berdaya atau terjebak.</li><li>Menarik diri dari tanggung jawab.</li></ul><p>Cara mengatasinya adalah dengan menetapkan batasan (boundaries) yang jelas antara pekerjaan dan kehidupan pribadi. Mulailah dengan tidak mengecek email di luar jam kerja.</p>', '2026-05-28 10:43:52', '2026-05-28 10:43:52'),
(2, 'Teknik Pernapasan 4-7-8', 'Mindfulness', 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=1200&auto=format&fit=crop', 'Cara cepat menenangkan diri saat panik menyerang dalam hitungan menit.', '<p>Saat panik menyerang, napas kita cenderung pendek dan cepat. Teknik 4-7-8 adalah cara \"reset\" sistem saraf Anda.</p><h3>Caranya:</h3><ol><li>Tarik napas melalui hidung selama <strong>4 detik</strong>.</li><li>Tahan napas selama <strong>7 detik</strong>.</li><li>Hembuskan perlahan melalui mulut selama <strong>8 detik</strong> (seperti meniup lilin).</li></ol><p>Ulangi siklus ini sebanyak 4 kali. Ini akan memaksa detak jantung Anda melambat dan pikiran menjadi lebih tenang.</p>', '2026-05-28 10:43:52', '2026-05-28 10:43:52'),
(3, 'Menjadi Pendengar Baik', 'Relationship', 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?q=80&w=1200&auto=format&fit=crop', 'Bagaimana cara mendukung teman yang sedang mengalami masa sulit.', '<p>Seringkali teman kita curhat bukan butuh solusi, tapi butuh didengar. Menjadi pendengar aktif (Active Listening) adalah kunci hubungan yang sehat.</p><p>Hindari memotong pembicaraan atau langsung menghakimi. Cukup hadir, tatap matanya, dan validasi perasaannya dengan kalimat seperti \"Aku paham itu pasti berat buat kamu\".</p>', '2026-05-28 10:43:52', '2026-05-28 10:43:52');

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
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `consultation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_role` enum('patient','psychologist') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `consultation_id`, `sender_id`, `sender_role`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 8, 'psychologist', 'Halo, selamat datang! 👋\nSaya Dr. Dicky Oktrianda. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?', 1, '2026-05-28 10:26:33'),
(2, 1, 12, 'patient', 'halo dok', 1, '2026-05-28 10:26:39'),
(3, 1, 8, 'psychologist', 'halo apa kabar apakah ada kendala?', 1, '2026-05-28 10:27:17'),
(4, 2, 8, 'psychologist', 'Halo, selamat datang! 👋\nSaya Dr. Dicky Oktrianda. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?', 1, '2026-05-28 10:28:30'),
(5, 2, 12, 'patient', 'halo dok saya mau konsul terkait Wc2026', 1, '2026-05-28 10:28:45'),
(6, 2, 8, 'psychologist', 'terkait apa?', 1, '2026-05-28 10:29:11'),
(7, 2, 12, 'patient', 'ronaldo kontol', 1, '2026-05-28 10:29:21'),
(8, 3, 12, 'psychologist', 'Halo, selamat datang! 👋\nSaya Amanda Angela S.Psi, M.Psi. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?', 0, '2026-05-28 10:30:41'),
(9, 4, 24, 'psychologist', 'Halo, selamat datang! 👋\nSaya Amanda Angela S.Psi, M.Psi. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?', 1, '2026-05-28 10:32:49'),
(10, 4, 12, 'patient', 'tes', 1, '2026-05-28 10:32:53'),
(11, 5, 12, 'psychologist', 'Halo, selamat datang! 👋\nSaya Dharma Novriansyah, M.Psi. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?', 0, '2026-05-28 10:57:41'),
(12, 5, 12, 'patient', 'halo', 0, '2026-05-28 10:57:45'),
(13, 6, 26, 'psychologist', 'Halo, selamat datang! 👋\nSaya Dharma Novriansyah, M.Psi. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?', 1, '2026-05-28 10:59:33'),
(14, 6, 12, 'patient', 'e', 1, '2026-05-28 10:59:36'),
(15, 7, 26, 'psychologist', 'Halo, selamat datang! 👋\nSaya Dharma Novriansyah, M.Psi. Bagaimana perasaan Anda hari ini? Ada yang bisa saya bantu?', 1, '2026-05-28 11:04:05'),
(16, 7, 12, 'patient', 'halo', 1, '2026-05-28 11:04:08'),
(17, 7, 12, 'patient', 'loh kenapa dok?', 1, '2026-05-28 11:04:27'),
(18, 7, 26, 'psychologist', 'taik lu', 1, '2026-05-28 11:04:32'),
(19, 7, 26, 'psychologist', 'oi', 1, '2026-05-28 11:04:43'),
(20, 7, 26, 'psychologist', 'end ga lu', 1, '2026-05-28 11:04:46');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` int(11) NOT NULL,
  `psychologist_id` int(11) DEFAULT NULL,
  `psychologist_name` varchar(255) NOT NULL,
  `status` enum('active','ended') NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `end_requested_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`id`, `patient_id`, `psychologist_id`, `psychologist_name`, `status`, `created_at`, `updated_at`, `end_requested_by`) VALUES
(1, 12, 8, 'Dr. Dicky Oktrianda', 'ended', '2026-05-28 10:26:33', '2026-05-28 10:27:44', NULL),
(2, 12, 8, 'Dr. Dicky Oktrianda', 'ended', '2026-05-28 10:28:30', '2026-05-28 10:29:30', NULL),
(3, 12, NULL, 'Amanda Angela S.Psi, M.Psi', 'ended', '2026-05-28 10:30:41', '2026-05-28 10:32:38', NULL),
(4, 12, 24, 'Amanda Angela S.Psi, M.Psi', 'ended', '2026-05-28 10:32:49', '2026-05-28 10:39:02', NULL),
(5, 12, NULL, 'Dharma Novriansyah, M.Psi', 'ended', '2026-05-28 10:57:41', '2026-05-28 10:59:24', NULL),
(6, 12, 26, 'Dharma Novriansyah, M.Psi', 'ended', '2026-05-28 10:59:33', '2026-05-28 10:59:42', NULL),
(7, 12, 26, 'Dharma Novriansyah, M.Psi', 'ended', '2026-05-28 11:04:05', '2026-05-28 11:04:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_13_074758_create_psychologists_table', 1),
(6, '2025_12_13_083419_add_status_to_psychologist_certificates_table', 2),
(7, '2026_05_29_000001_create_consultations_table', 2),
(8, '2026_05_29_000002_create_chat_messages_table', 2),
(9, '2026_05_29_000003_create_articles_table', 3),
(10, '2026_05_29_000004_add_end_requested_by_to_consultations_table', 4);

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
-- Table structure for table `psychologists`
--

CREATE TABLE `psychologists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `specialist` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `session` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `psychologists`
--

INSERT INTO `psychologists` (`id`, `name`, `role`, `specialist`, `image`, `desc`, `session`, `price`, `created_at`, `updated_at`) VALUES
(1, 'Dr. Dicky Oktrianda', 'Dokter Jiwa (Psychiatrist)', 'Medical Psychiatry', 'img/psikolog/drDicky.png', 'Seorang dokter yang memfokuskan keahliannya pada bidang kesehatan jiwa dan penanganan kondisi psikis secara medis.', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(2, 'Amanda Angela S.Psi, M.Psi', 'Psikolog Klinis', 'Adult & Trauma', 'img/psikolog/drAmanda.png', 'Psikolog alumnus Universitas Surabaya (2013) dan Unpad (2018), berpengalaman menangani trauma mendalam.', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(3, 'Patricia Elfira Finny S.Psi', 'Psikolog Klinis', 'General Mental Health', 'img/psikolog/drPatricia.png', 'Berpengalaman 9 tahun memberikan layanan konsultasi terkait kesehatan mental dan pengembangan diri.', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(4, 'Mila Rahmawati M.Psi', 'Psikolog Klinis Dewasa', 'Family & Marriage', 'img/psikolog/drMila.jpg', 'Berpengalaman 13 tahun menangani masalah rumah tangga, pasangan, dan kecemasan pada orang dewasa.', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(5, 'Munazilah S.Psi, M.Psi', 'Psikolog Klinis', 'Self Development', 'img/psikolog/drMunazilah.jpg', 'Memiliki pengalaman 6 tahun membantu individu menemukan potensi terbaik dan mengatasi hambatan mental.', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(6, 'Ayu Hidayati M.Psi', 'Psikolog Klinis', 'Stress & Burnout', 'img/psikolog/drAyu.jpg', 'Ahli dalam manajemen stres pekerjaan, burnout, dan keseimbangan hidup (work-life balance).', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(7, 'Bayu Prasetya Yudha S.Psi', 'Psikolog Klinis', 'Men\'s Mental Health', 'img/psikolog/drBayu.png', 'Psikolog yang fokus membantu pria dan dewasa muda dalam mengelola emosi dan tekanan sosial.', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(8, 'Dharma Novriansyah, M.Psi', 'Psikolog Klinis', 'Behavioral Therapy', 'img/psikolog/drDharma.png', 'Memberikan layanan konseling dengan pendekatan praktis dan terapi perilaku kognitif (CBT).', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32'),
(9, 'Giavanny P. M.Psi', 'Psikolog Anak & Remaja', 'Child & Teen', 'img/psikolog/drGiavanny.png', 'Memiliki pemahaman mendalam pada proses tumbuh kembang anak dan masalah emosi remaja.', '2 Hours', 'Rp 200.000', '2025-12-13 00:49:32', '2025-12-13 00:49:32');

-- --------------------------------------------------------

--
-- Table structure for table `psychologist_certificates`
--

CREATE TABLE `psychologist_certificates` (
  `id` int(11) NOT NULL,
  `psychologist_id` int(11) NOT NULL,
  `certificate_name` varchar(255) NOT NULL,
  `certificate_path` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `reject_reason` text DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `psychologist_certificates`
--

INSERT INTO `psychologist_certificates` (`id`, `psychologist_id`, `certificate_name`, `certificate_path`, `status`, `reject_reason`, `uploaded_at`) VALUES
(8, 9, '(Dummy) Sertifikat Psikolog.pdf', 'certificate_9_1765616877.pdf', 'pending', NULL, '2025-12-13 02:07:57');

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
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_consultation_id_created_at_index` (`consultation_id`,`created_at`),
  ADD KEY `chat_messages_consultation_id_is_read_index` (`consultation_id`,`is_read`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultations_patient_id_index` (`patient_id`),
  ADD KEY `consultations_psychologist_id_index` (`psychologist_id`),
  ADD KEY `consultations_status_index` (`status`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
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
-- Indexes for table `psychologists`
--
ALTER TABLE `psychologists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `psychologist_certificates`
--
ALTER TABLE `psychologist_certificates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `psychologist_id` (`psychologist_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `psychologists`
--
ALTER TABLE `psychologists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `psychologist_certificates`
--
ALTER TABLE `psychologist_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `psychologist_certificates`
--
ALTER TABLE `psychologist_certificates`
  ADD CONSTRAINT `psychologist_certificates_ibfk_1` FOREIGN KEY (`psychologist_id`) REFERENCES `account` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
