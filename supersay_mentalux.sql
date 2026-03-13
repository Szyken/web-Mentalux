-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2026 at 07:00 AM
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
(3, '0', 'ferdy@gmail.com', '$2y$12$u2J', 'CUSTOMER'),
(4, '0', 'juna@gmail.com', '$2y$12$hSzy7SYBc', 'CUSTOMER'),
(5, '0', 'hanif@gmail.com', '$2y$12$5Qt0xWRvecGydf4JNC1om.mbkRk2oIoXT1gjJfXtGAerm3r4Ickcq', 'CUSTOMER'),
(6, '', 'carla@gmail.com', '$2y$12$jHDd2rFYs2njvu/7RQ3B4.sJNJAjtNiHorOnxnVBejwC/MVfmAz1i', 'CUSTOMER'),
(7, 'udin', 'udin@gmail.com', '$2y$12$LP.rWzmx.UvmcRdLltZ3.ejCwXd7/ivV433NvoiHu1Upu51Iwaf8O', 'CUSTOMER'),
(8, 'dicky', 'dicky@gmail.com', '$2y$12$Uxn92MHnFAhX8/2iZUEL5OgXnErRv3qE94VKsidzZ5yYWt1MA8U8a', 'Psychologist'),
(9, 'Hanif', 'hanifafan@gmail.com', '$2y$12$a6gTclrMhPCaT4zi485fzOniumgN/JNTZs5Eu6p3Q1YzeHUkzU.2G', 'Admin'),
(10, 'dickyy', 'dickyy@gmail.com', '$2y$10$zQ36/qS1EayrEWjfKzZXh.mSuxgu4MTGEZTy5MNEn600//cyvw4oG', 'Psychologist'),
(11, 'Ferdy', 'ferdyy@gmail.com', '$2y$12$Tq0dUQyjgBGBTt7tJi.W1.rcLNR7CqmLy3oBBpyJu5GVnmEkKjgre', 'Customer'),
(12, 'Messi', 'messi@gmail.com', '$2y$12$b.5/aqDrzLeVFf.tzlodLuUvGidHSjSJRnv0PoryRQ8AEF9q4QOFO', 'Customer'),
(13, 'juna', 'herjuna@gmail.com', '$2y$12$fAypwRbmMsj54jMlJw0b7OxHoKo0.tfK8.9lM1RyXJwK82QiuoGsm', 'Admin'),
(14, 'Ronaldo', 'ronaldo@gmail.com', '$2y$12$bvoivqPC28a5nuw6Ljqh5e1HdPgGNzRbFNXEyl4irgUAvXb0k1POe', 'Customer'),
(15, 'Maldini', 'maldini@gmail.com', '$2y$12$/Wdf5yxABrGeL5qq2RtqP.3NIoYB1Ztld0W.DhM6NPq24l42s9xAO', 'Admin'),
(16, 'Zidane', 'zidane@gmail.com', '$2y$12$5w./UUilGWW2PStEbJ3TD.s7EVDS.okGIwerZ5cJqzyFK1vCzqPVK', 'Psychologist'),
(17, 'Pep', 'pep@gmail.com', '$2y$12$UWO6XHEBVri4wN65KdqiUO8PY1JCD6i17Yf8gvKRhVcwX6d9Pfgqy', 'Psychologist'),
(18, 'Alex Ferguson', '108c2019@gmail.com', '$2y$12$rockcQ9xFbGjw1464g9gHu/AIh3jtMfb5qZS.3FL9Yd/woV56EBIW', 'Customer'),
(19, 'Ferdy N', 'ferdyOey@gmail.com', '$2y$12$QsFkVdW2KsoTSg7Z9H4kxOVpF6jDrwICRsuwp37LX/HZm3GoFtPCO', 'Customer'),
(20, 'Yantok', 'yantok@gmail.com', '$2y$12$BsMsO6D53P69tTyvOfzSI.D/lefGC5VixB1T9NEYxsSbL.zIGL/GS', 'Customer'),
(21, 'Ferdy', 'ferdy1@gmail.com', '$2y$12$Wf5BcX3E7wSWbmTEXw4yD.yVROycZ4xZSmIcsZfuwP1yvrEzoANHa', 'Psychologist'),
(22, 'Ferdy Nugraha', 'ferdy.nugraha@student.umn.ac.id', '$2y$12$OZ8q6vR/UlrU1d0boo1u3eGN8w6sP4ZNkAAMSnFI3wkCj8gq5SKgC', 'Customer'),
(23, 'Rio', 'rio@gmail.com', '$2y$12$nKANZg64Lh7tiq/Kz8QklOKDUb2SI1bm8ls66OVG07aBj7ame9xgi', 'Customer');

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
(5, '2025_12_13_083419_add_status_to_psychologist_certificates_table', 2);

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
(8, 9, '(Dummy) Sertifikat Psikolog.pdf', 'certificate_9_1765616877.pdf', 'approved', NULL, '2025-12-13 02:07:57'),
(11, 21, 'Antaboga_Ferdy Nugraha Oey.pdf', 'certificate_21_1765861803.pdf', 'approved', NULL, '2025-12-15 22:10:03');

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
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
