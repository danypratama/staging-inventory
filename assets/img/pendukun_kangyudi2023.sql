-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 16, 2024 at 10:48 AM
-- Server version: 8.0.35-cll-lve
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pendukun_kangyudi2023`
--

-- --------------------------------------------------------

--
-- Table structure for table `kec_krw`
--

CREATE TABLE `kec_krw` (
  `id_kec_krw` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kecamatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `craeted_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kec_krw`
--

INSERT INTO `kec_krw` (`id_kec_krw`, `nama_kecamatan`, `craeted_date`) VALUES
('Kec_Krw2312009a2a9e18', 'Batujaya', '2023-12-18 22:18:42'),
('Kec_Krw23121219e76418', 'Pangkalan', '2023-12-18 22:21:44'),
('Kec_Krw2312139cba3118', 'Pedes', '2023-12-18 22:21:57'),
('Kec_Krw23121471bb2818', 'Cikampek', '2023-12-18 22:19:10'),
('Kec_Krw23121846e9f018', 'Jatisari', '2023-12-18 22:19:50'),
('Kec_Krw231222d5b9bc18', 'Cibuaya', '2023-12-18 22:19:02'),
('Kec_Krw2312328d1a0a18', 'Banyusari', '2023-12-18 22:18:21'),
('Kec_Krw231233744ff318', 'Purwasari', '2023-12-18 22:22:06'),
('Kec_Krw23124677446f18', 'Kutawaluya', '2023-12-18 22:21:16'),
('Kec_Krw23124a3e315618', 'Karawang Barat', '2023-12-18 22:20:27'),
('Kec_Krw2312591ee89918', 'Ciampel', '2023-12-18 22:18:49'),
('Kec_Krw23125a33e01718', 'Klari', '2023-12-18 22:20:43'),
('Kec_Krw23125b0d8c2218', 'Majalaya', '2023-12-18 22:15:24'),
('Kec_Krw23125b3a6aac18', 'Cilamaya Wetan', '2023-12-18 22:19:32'),
('Kec_Krw23127486da7b18', 'Pakisjaya', '2023-12-18 22:21:39'),
('Kec_Krw23127695e05918', 'Telukjambe Barat', '2023-12-18 22:23:35'),
('Kec_Krw23127d6ecfe218', 'Telagasari', '2023-12-18 22:23:05'),
('Kec_Krw23127f04d05418', 'Tirtamulya', '2023-12-18 22:24:26'),
('Kec_Krw23129160602018', 'Tegalwaru', '2023-12-18 22:23:00'),
('Kec_Krw23129248c83718', 'Jayakerta', '2023-12-18 22:20:05'),
('Kec_Krw2312b02f2f6f18', 'Cilebar', '2023-12-18 22:19:44'),
('Kec_Krw2312b19cd4cf18', 'Tirtajaya', '2023-12-18 22:24:15'),
('Kec_Krw2312b34a9adc18', 'Kota Baru', '2023-12-18 22:21:06'),
('Kec_Krw2312b8c6cb7718', 'Rawamerta', '2023-12-18 22:22:19'),
('Kec_Krw2312c7fd2a1c18', 'Telukjambe Timur', '2023-12-18 22:23:46'),
('Kec_Krw2312d2d5a4ad18', 'Rengasdengklok', '2023-12-18 22:22:40'),
('Kec_Krw2312dc33944e18', 'Tempuran', '2023-12-18 22:24:02'),
('Kec_Krw2312ed8f583618', 'Cilamaya Kulon', '2023-12-18 22:19:22'),
('Kec_Krw2312edac471318', 'Lemahabang', '2023-12-18 22:21:27'),
('Kec_Krw2312fbf2342a18', 'Karawang Timur', '2023-12-18 22:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `kec_pwk`
--

CREATE TABLE `kec_pwk` (
  `id_kec_pwk` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kecamatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `craeted_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kec_pwk`
--

INSERT INTO `kec_pwk` (`id_kec_pwk`, `nama_kecamatan`, `craeted_date`) VALUES
('Kec_Pwk23120417617818', 'Sukasari', '2023-12-18 22:28:39'),
('Kec_Pwk23121fbbc19918', 'Tegalwaru', '2023-12-18 22:29:02'),
('Kec_Pwk231225a8522d18', 'Kiarapedes', '2023-12-18 22:30:13'),
('Kec_Pwk23122efbb4c118', 'Darangdan', '2023-12-18 22:29:33'),
('Kec_Pwk23125dc521e218', 'Cibatu', '2023-12-18 22:31:21'),
('Kec_Pwk23126794295918', 'Bungursari', '2023-12-18 22:31:32'),
('Kec_Pwk231267e2184d18', 'Campaka', '2023-12-18 22:31:16'),
('Kec_Pwk231269797f8818', 'Plered', '2023-12-18 22:29:08'),
('Kec_Pwk23126db9473218', 'Babakancikao', '2023-12-18 22:31:06'),
('Kec_Pwk23126eef54c118', 'Maniis', '2023-12-18 22:28:48'),
('Kec_Pwk2312844b8a9d18', 'Purwakarta', '2023-12-18 22:30:49'),
('Kec_Pwk23128cadfda518', 'Bojong', '2023-12-18 22:29:48'),
('Kec_Pwk2312a9ca738218', 'Sukatani', '2023-12-18 22:29:24'),
('Kec_Pwk2312bce14fe918', 'Pasawahan', '2023-12-18 22:30:19'),
('Kec_Pwk2312c788f5ee18', 'Wanayasa', '2023-12-18 22:29:57'),
('Kec_Pwk2312e277a34118', 'Jatiluhur', '2023-12-18 22:28:25'),
('Kec_Pwk2312f588c9b118', 'Pondok Salam', '2023-12-18 22:30:42');

-- --------------------------------------------------------

--
-- Table structure for table `pendukung_krw`
--

CREATE TABLE `pendukung_krw` (
  `id_pendukung_krw` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kec_krw` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pendukung` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `alasan` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendukung_krw`
--

INSERT INTO `pendukung_krw` (`id_pendukung_krw`, `id_kec_krw`, `nama_pendukung`, `alamat`, `alasan`, `created_date`) VALUES
('Pendukung2312196616e220', 'Kec_Krw23129248c83718', 'Damion Adam', 'Hello\r\nFirst of all i would like to congratulate you for taking a wonderful stepof starting your own business.\r\nI wish you all the greatness for http://pendukungkangyudi.com.\r\nIf you ever feel low or ', 'Hi\r\nFirst of all i would like to congratulate you for taking a wonderful stepof starting your own business.\r\nI wish you all the greatness for http://pendukungkangyudi.com.\r\nIf you ever feel low or confused in terms of marketing your business digitall', '2023-12-21 04:44:14'),
('Pendukung2312cbb5e4f918', 'Kec_Krw23125b0d8c2218', 'Dany Pratama Saputro', 'Perum CKM Blok A7/14 Rt.22 Rw.08', 'Insyaa Allah Amanah', '2023-12-19 00:07:36'),
('Pendukung2312fd201cd418', 'Kec_Krw23125b0d8c2218', 'Apriani Irmawati ', 'Perum CKM Blok A7/14 Rt.22 Rw.08 Desa Bengle', 'Insyaa Allah Amanah ', '2023-12-19 00:29:45'),
('Pendukung2401ff01558d02', 'Kec_Krw231222d5b9bc18', 'Helena Bevins', 'Hello pendukungkangyudi.com Team,\r\n\r\nI hope you are doing well, We are pioneer in male enhancement products and on our 10th anniversary we are offering 15% Off on our Highly recommended Male products ', 'Hello pendukungkangyudi.com Team,\r\n\r\nI hope you are doing well, We are pioneer in male enhancement products and on our 10th anniversary we are offering 15% Off on our Highly recommended Male products to  officials [Only for new customers]\r\n\r\nExperien', '2024-01-03 05:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `pendukung_pwk`
--

CREATE TABLE `pendukung_pwk` (
  `id_pendukung_pwk` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `id_kec_pwk` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pendukung` varchar(75) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `alasan` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pendukung_pwk`
--

INSERT INTO `pendukung_pwk` (`id_pendukung_pwk`, `id_kec_pwk`, `nama_pendukung`, `alamat`, `alasan`, `created_date`) VALUES
('Pendukung23123ed2b83124', 'Kec_Pwk2312f588c9b118', 'Florine Frahm', 'want to be on top 10 Google rankings without any upfront payment? I&#039;m John, an SEO expert.\r\n Email me at razibarkai1643@gmail.com with your site and keywords, and I&#039;ll assess it.\r\nI won&#039', 'want to be on top 10 Google rankings without any upfront payment? I&#039;m John, an SEO expert.\r\n Email me at razibarkai1643@gmail.com with your site and keywords, and I&#039;ll assess it.\r\nI won&#039;t charge until you reach the top 10. Nothing to l', '2023-12-25 05:50:57'),
('Pendukung2312d05b184320', 'Kec_Pwk23121fbbc19918', 'Chris Oberle', 'Hello,\r\n\r\nDiscover how to Rank pendukungkangyudi.com on Google #1 Page Right away by Using &quot;Copy &amp; Paste&quot; Strategy.\r\n\r\nVisit here to get the secret now - https://www.successpath.top/93ea', 'Hello,\r\n\r\nLearn how to Rank pendukungkangyudi.com on Google #1 Page Instantly by Using &quot;Copy &amp; Paste&quot; Tactic.\r\n\r\nClick this link to unlock the secret for yourself - https://www.successpath.top/93ea59a3?ref=pendukungkangyudi.com\r\n\r\n\r\nTha', '2023-12-20 23:03:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kec_krw`
--
ALTER TABLE `kec_krw`
  ADD PRIMARY KEY (`id_kec_krw`);

--
-- Indexes for table `kec_pwk`
--
ALTER TABLE `kec_pwk`
  ADD PRIMARY KEY (`id_kec_pwk`);

--
-- Indexes for table `pendukung_krw`
--
ALTER TABLE `pendukung_krw`
  ADD PRIMARY KEY (`id_pendukung_krw`);

--
-- Indexes for table `pendukung_pwk`
--
ALTER TABLE `pendukung_pwk`
  ADD PRIMARY KEY (`id_pendukung_pwk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
