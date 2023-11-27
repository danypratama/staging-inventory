-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Agu 2023 pada 16.10
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
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `act_br_import`
--

CREATE TABLE `act_br_import` (
  `id_act_br_import` varchar(50) NOT NULL,
  `id_isi_inv_br_import` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty_act` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `act_br_import`
--

INSERT INTO `act_br_import` (`id_act_br_import`, `id_isi_inv_br_import`, `id_produk_reg`, `qty_act`, `id_user`, `created_date`, `updated_date`, `user_updated`) VALUES
('ACT-IMPORT-05d9f054868c8423', 'BR-IMPORT-23c54205625a1305', 'BR-REGffb0b62a09cf', '5400', 'USER03595a8447ab', '23/05/2023, 16:40', '', ''),
('ACT-IMPORT-05ef16c9d87efd23', 'BR-IMPORT-23c54205625a1305', 'BR-REGffb0b62a09cf', '1000000', 'USER03595a8447ab', '23/05/2023, 16:40', '', '');

--
-- Trigger `act_br_import`
--
DELIMITER $$
CREATE TRIGGER `add_act_br_import` AFTER INSERT ON `act_br_import` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + NEW.qty_act 
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_act_br_import` AFTER DELETE ON `act_br_import` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - OLD.qty_act 
WHERE id_produk_reg = OLD.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_act_br_import` AFTER UPDATE ON `act_br_import` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - OLD.qty_act + NEW.qty_act
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ekspedisi`
--

CREATE TABLE `ekspedisi` (
  `id_ekspedisi` varchar(50) NOT NULL,
  `nama_ekspedisi` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ekspedisi`
--

INSERT INTO `ekspedisi` (`id_ekspedisi`, `nama_ekspedisi`, `created_date`) VALUES
('EKS16367774d65b', 'Tiki', '2023-07-06 19:14:48'),
('EKS2d716c56479c', 'Duta Trans', '2023-07-06 19:14:32'),
('EKS421e093c826c', 'JNT', '2023-07-06 19:14:20'),
('EKS49bd4a65fdc6', 'Anter Aja', '2023-07-06 19:14:42'),
('EKSe86520083a96', 'JNE', '2023-06-22 08:49:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `finance`
--

CREATE TABLE `finance` (
  `id_finance` varchar(50) NOT NULL,
  `id_inv` varchar(50) NOT NULL,
  `id_tagihan` varchar(50) NOT NULL,
  `status_pembayaran` tinyint(1) NOT NULL,
  `jenis_inv` varchar(10) NOT NULL,
  `status_tagihan` tinyint(1) NOT NULL,
  `status_lunas` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `finance`
--

INSERT INTO `finance` (`id_finance`, `id_inv`, `id_tagihan`, `status_pembayaran`, `jenis_inv`, `status_tagihan`, `status_lunas`, `created_date`, `created_by`) VALUES
('FINANCE23080425717015', 'NONPPN-2308710f8d85b71a15', 'BILL2308a466281773c515', 0, 'nonppn', 1, 0, '2023-08-15 16:28:38', ''),
('FINANCE23080ba2128f13', 'NONPPN-2308628afd2bd3f913', 'BILL230816723236941d15', 1, 'nonppn', 1, 1, '2023-08-13 15:39:15', ''),
('FINANCE23081221d3f814', 'NONPPN-2308dc21b048e4aa14', 'BILL230835103b89755f14', 1, 'nonppn', 1, 1, '2023-08-14 10:39:53', ''),
('FINANCE23081b8608da15', 'PPN-23085a1c8d524c3915', 'BILL23084f23258440cd15', 0, 'ppn', 1, 0, '2023-08-15 16:35:07', ''),
('FINANCE23081dc7c5bb14', 'PPN-2308359ae4a577ee14', 'BILL2308bce1297b6cd714', 1, 'ppn', 1, 1, '2023-08-14 11:11:09', ''),
('FINANCE23082249542a13', 'PPN-2308ac77fbf6bc0e13', 'BILL2308bce1297b6cd714', 1, 'ppn', 1, 1, '2023-08-13 15:49:46', ''),
('FINANCE23082aaaf59d15', 'NONPPN-2308c7624de935d514', 'BILL23087436e5a6d62115', 0, 'nonppn', 1, 0, '2023-08-15 16:23:41', ''),
('FINANCE2308497ffc1b15', 'NONPPN-2308c9239a9c560015', 'BILL2308832ca09c922b15', 0, 'nonppn', 1, 0, '2023-08-15 16:33:09', ''),
('FINANCE2308ee9f386613', 'BUM-230890335943a8ac13', 'BILL230835103b89755f14', 1, 'bum', 1, 1, '2023-08-13 15:52:29', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `finance_bank`
--

CREATE TABLE `finance_bank` (
  `id_bank` varchar(50) NOT NULL,
  `nama_bank` varchar(20) NOT NULL,
  `no_rekening` varchar(300) NOT NULL,
  `atas_nama` varchar(300) NOT NULL,
  `logo` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `finance_bank`
--

INSERT INTO `finance_bank` (`id_bank`, `nama_bank`, `no_rekening`, `atas_nama`, `logo`, `created_date`, `created_by`) VALUES
('BNK1ed47dcc', 'Bank Manidiri', 'lOVD6r48yh8XvmNcfuTk+rEinj4sr7ciDXvOkTzKtiGlRGEIg70ORRVhe4+i5413k607fD0ulHKV4ZStQFkGbA==', '99Go4d86bQT2iS6dfAe7YnCp+WfaNnjkg2t6sac+yeJIW20CQ7870Abjsf1UDY0CwdAp2VL6Kta5V2P8e88A+g==', 'mandiri.png', '2023-07-26 17:25:13', 'Hana Febriyanti'),
('BNK40d01672', 'Bank BCA', 'uWah+oEerFtSVZ9hnPcsf4D7UUaC6n85x8x0K4RzgxC2UqGB7BB/yq56hVWF7zh6+povr+QFEQ9GiFyFXloCyw==', 'ZWsrLM/jgjG8T7rry//PDIs0EqZ9ooKsvdDELjxR4RnXES+Fh8RvabrHy66wWIGg5+nEYdQxRKw4D+lmfG+IdA==', 'bca.png', '2023-07-26 17:25:33', 'Hana Febriyanti'),
('BNK5d0fd86f', 'Bank Manidiri', 'Z4OpeZOMEz/n5lB6asCbQ7ALnwA0r5gExDjghabNksFiHFCTO2EiChSdNsS6ohRyliHBRJcxLTLlqF0ZU1jHPQ==', 'yIZAosPPSMAMPHlUNHMnRCk091aHKVnBdCJkXVYpVeZySC6kcI+A2m8SxEroU7I5yfbCRLd56kWJlVTByD9oLw==', 'mandiri.png', '2023-07-26 17:50:03', 'Hana Febriyanti');

-- --------------------------------------------------------

--
-- Struktur dari tabel `finance_bayar`
--

CREATE TABLE `finance_bayar` (
  `id_bayar` varchar(50) NOT NULL,
  `id_bank` varchar(50) NOT NULL,
  `id_tagihan` varchar(50) NOT NULL,
  `id_finance` varchar(50) NOT NULL,
  `id_bukti` varchar(50) NOT NULL,
  `metode_pembayaran` varchar(10) NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `tgl_bayar` varchar(25) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `finance_bayar`
--

INSERT INTO `finance_bayar` (`id_bayar`, `id_bank`, `id_tagihan`, `id_finance`, `id_bukti`, `metode_pembayaran`, `total_bayar`, `tgl_bayar`, `created_date`, `created_by`) VALUES
('BYR23080281896602f615', 'BNK1ed47dcc', 'BILL230816723236941d15', 'FINANCE23080ba2128f13', 'BUKTI23080281896602f615', 'transfer', 1350000, '15/08/2023', '2023-08-15 16:04:08', 'Hana Febriyanti'),
('BYR2308349b9178417114', '', 'BILL230835103b89755f14', 'FINANCE23081221d3f814', '', 'cash', 1225000, '14/08/2023', '2023-08-14 14:21:59', 'Hana Febriyanti'),
('BYR2308b78c3205817914', '', 'BILL2308bce1297b6cd714', 'FINANCE23081dc7c5bb14', '', 'cash', 2497500, '14/08/2023', '2023-08-14 14:22:35', 'Hana Febriyanti'),
('BYR2308b9b43b1474a314', '', 'BILL2308bce1297b6cd714', 'FINANCE23082249542a13', '', 'cash', 1776000, '14/08/2023', '2023-08-14 14:22:22', 'Hana Febriyanti'),
('BYR2308d57b2ca9b7df14', '', 'BILL230835103b89755f14', 'FINANCE2308ee9f386613', '', 'cash', 1775000, '14/08/2023', '2023-08-14 14:21:41', 'Hana Febriyanti');

-- --------------------------------------------------------

--
-- Struktur dari tabel `finance_bukti_tf`
--

CREATE TABLE `finance_bukti_tf` (
  `id_bukti_tf` varchar(50) NOT NULL,
  `tf_bank` varchar(20) NOT NULL,
  `rek_pengirim` bigint(20) NOT NULL,
  `tf_an` varchar(35) NOT NULL,
  `bukti_tf` varchar(100) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `finance_bukti_tf`
--

INSERT INTO `finance_bukti_tf` (`id_bukti_tf`, `tf_bank`, `rek_pengirim`, `tf_an`, `bukti_tf`, `created_date`, `created_by`) VALUES
('BUKTI23080281896602f615', 'BNI', 123456, 'Agung', '003_BILL_VIII_2023_2.jpg', '2023-08-15 16:04:08', 'Hana Febriyanti');

-- --------------------------------------------------------

--
-- Struktur dari tabel `finance_tagihan`
--

CREATE TABLE `finance_tagihan` (
  `id_tagihan` varchar(50) NOT NULL,
  `no_tagihan` varchar(20) NOT NULL,
  `tgl_tagihan` varchar(25) NOT NULL,
  `total_tagihan` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `finance_tagihan`
--

INSERT INTO `finance_tagihan` (`id_tagihan`, `no_tagihan`, `tgl_tagihan`, `total_tagihan`, `created_date`) VALUES
('BILL230816723236941d15', '003/BILL/VIII/2023', '15/08/2023', 1350000, '2023-08-15 16:03:15'),
('BILL230835103b89755f14', '001/BILL/VIII/2023', '14/08/2023', 3000000, '2023-08-14 14:21:28'),
('BILL23084f23258440cd15', '007/BILL/VIII/2023', '15/08/2023', 832500, '2023-08-15 16:35:38'),
('BILL23087436e5a6d62115', '004/BILL/VIII/2023', '15/08/2023', 2350000, '2023-08-15 16:24:31'),
('BILL2308832ca09c922b15', '006/BILL/VIII/2023', '15/08/2023', 1500000, '2023-08-15 16:33:23'),
('BILL2308a466281773c515', '005/BILL/VIII/2023', '15/08/2023', 750000, '2023-08-15 16:28:58'),
('BILL2308bce1297b6cd714', '002/BILL/VIII/2023', '14/08/2023', 4273500, '2023-08-14 14:22:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ganti_merk_reg_in`
--

CREATE TABLE `ganti_merk_reg_in` (
  `id_ganti_merk_in` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `ganti_merk_reg_in`
--
DELIMITER $$
CREATE TRIGGER `add_ganti_merk_reg_in` AFTER INSERT ON `ganti_merk_reg_in` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + NEW.qty 
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_ganti_merk_reg_in` AFTER DELETE ON `ganti_merk_reg_in` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - OLD.qty 
WHERE id_produk_reg = OLD.id_produk_reg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ganti_merk_reg_out`
--

CREATE TABLE `ganti_merk_reg_out` (
  `id_ganti_merk_out` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `ganti_merk_reg_out`
--
DELIMITER $$
CREATE TRIGGER `add_ganti_merk_reg_out` AFTER INSERT ON `ganti_merk_reg_out` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - NEW.qty 
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_ganti_merk_reg_out` AFTER DELETE ON `ganti_merk_reg_out` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty 
WHERE id_produk_reg = OLD.id_produk_reg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_br_import`
--

CREATE TABLE `inv_br_import` (
  `id_inv_br_import` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_supplier` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(50) NOT NULL,
  `no_order` varchar(50) NOT NULL,
  `tgl_order` varchar(50) NOT NULL,
  `shipping_by` varchar(20) NOT NULL,
  `no_awb` varchar(50) NOT NULL,
  `tgl_kirim` varchar(50) NOT NULL,
  `tgl_est` varchar(50) NOT NULL,
  `status_pengiriman` varchar(30) NOT NULL,
  `tgl_terima` varchar(20) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inv_br_import`
--

INSERT INTO `inv_br_import` (`id_inv_br_import`, `id_user`, `id_supplier`, `no_inv`, `tgl_inv`, `no_order`, `tgl_order`, `shipping_by`, `no_awb`, `tgl_kirim`, `tgl_est`, `status_pengiriman`, `tgl_terima`, `keterangan`, `created_date`) VALUES
('INV-IMPORT1ebd36eefe40', 'USER03595a8447ab', 'SP1407504e42bd', '087', '23/05/2023', '1111', '23/05/2023', 'Udara', '10000', '23/05/2023', '08/05/2023', 'Sudah Diterima', '25/05/2023', 'Barang Diterima Telat 17 hari', '23/05/2023, 11:53'),
('INV-IMPORT414edd954c45', 'USER47100114a730', 'SP0d8111e5dcf6', '1321313', '23/05/2023', '12121', '23/05/2023', 'Udara', '31313131313131', '23/05/2023', '02/06/2023', 'Belum Dikirim', '', 'Mohon tunggu / silahkan hubungi supplier kembali', '23/05/2023, 10:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_br_in_lokal`
--

CREATE TABLE `inv_br_in_lokal` (
  `id_inv_br_in_lokal` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_sp` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(20) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inv_br_in_lokal`
--

INSERT INTO `inv_br_in_lokal` (`id_inv_br_in_lokal`, `id_user`, `id_sp`, `no_inv`, `tgl_inv`, `created_date`) VALUES
('INV-LOKAL29304ecbc0fa', 'USER03595a8447ab', 'SP75d3d772951e', '087', '24/05/2023', '23/05/2023, 11:54'),
('INV-LOKAL6849e61df660', 'USER47100114a730', 'SP5d25a18a4094', '1321313', '23/05/2023', '23/05/2023, 11:06'),
('INV-LOKAL858a05c1222d', 'USER34e2f73c9751', 'SP0d8111e5dcf6', '1548726', '26/05/2023', '26/05/2023, 8:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_bukti_terima`
--

CREATE TABLE `inv_bukti_terima` (
  `id_bukti_terima` varchar(50) NOT NULL,
  `id_inv` varchar(50) NOT NULL,
  `bukti_satu` varchar(150) NOT NULL,
  `bukti_dua` varchar(50) NOT NULL,
  `bukti_tiga` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inv_bukti_terima`
--

INSERT INTO `inv_bukti_terima` (`id_bukti_terima`, `id_inv`, `bukti_satu`, `bukti_dua`, `bukti_tiga`, `created_date`) VALUES
('BKTI23073addf8e0381322', 'NONPPN-2307861b90e0dd2222', 'Bukti_Satu2307cda6947f22.jpg', '', '', '2023-07-22 11:23:47'),
('BKTI23075e19e876b75420', 'NONPPN-2307d80dd3993b8220', 'Bukti_Satu2307c847cbf020.jpg', '', '', '2023-07-20 13:38:17'),
('BKTI2307b951a549ff6b25', 'PPN-2307b4684f606d9d12', 'Bukti_Satu2307e6f8832325.jpg', '', '', '2023-07-25 09:24:01'),
('BKTI2307e1cccd59ec5712', 'NONPPN-230719bd68161e2712', 'Bukti_Satu2307841607dc12.jpg', '', '', '2023-07-12 17:04:35'),
('BKTI2307e9000fc097f312', 'BUM-23072df600eb1e0812', 'Bukti_Satu23073a7c0dbe12.jpg', '', '', '2023-07-12 17:13:06'),
('BKTI2308164d1caaf5df12', 'BUM-2308286c3274279112', 'Bukti_Satu23085da3e15c12.jpg', '', '', '2023-08-12 15:45:28'),
('BKTI23083519c692587312', 'BUM-230878fe3a397ee912', 'Bukti_Satu23081bdfba6712.jpg', '', '', '2023-08-12 15:45:04'),
('BKTI230866610ea14dea14', 'PPN-2308359ae4a577ee14', 'Bukti_Satu2308e5b714eb14.jpg', '', '', '2023-08-14 11:10:36'),
('BKTI23086b86fbb072d010', 'PPN-2308a111e43927bc10', 'Bukti_Satu23081bb7e9ba10.jpg', '', '', '2023-08-10 14:00:22'),
('BKTI23087d75b648b1a813', 'NONPPN-2308628afd2bd3f913', 'Bukti_Satu23085337705613.jpg', '', '', '2023-08-13 15:37:57'),
('BKTI23088c9ba296f53414', 'NONPPN-2308dc21b048e4aa14', 'Bukti_Satu2308a3dd18e814.jpg', '', '', '2023-08-14 10:39:41'),
('BKTI2308986b0faf1b4c15', 'PPN-23085a1c8d524c3915', 'Bukti_Satu2308e2086b1715.jpg', '', '', '2023-08-15 16:35:00'),
('BKTI2308a0651fdf294715', 'NONPPN-2308c9239a9c560015', 'Bukti_Satu2308e56f397615.jpg', '', '', '2023-08-15 16:32:59'),
('BKTI2308a88328882a3f15', 'NONPPN-2308710f8d85b71a15', 'Bukti_Satu23080313603515.jpg', '', '', '2023-08-15 16:28:32'),
('BKTI2308a97ff174362613', 'PPN-2308ac77fbf6bc0e13', 'Bukti_Satu2308120b1b9e13.jpg', '', '', '2023-08-13 15:49:36'),
('BKTI2308b3dfedb8b02d14', 'NONPPN-2308c7624de935d514', 'Bukti_Satu2308cffc669114.jpg', '', '', '2023-08-14 08:39:25'),
('BKTI2308be233977f1a713', 'BUM-230890335943a8ac13', 'Bukti_Satu2308bc1a71a713.jpg', '', '', '2023-08-13 15:52:19'),
('BKTI2308faea98566f4111', 'BUM-230841b0329176bd11', 'Bukti_Satu2308b4cb3efb11.jpg', '', '', '2023-08-11 10:16:56'),
('BKTI2313043270fe0829', 'PPN-2307e16c6de85d1f29', 'Bukti_Satu2307a442b06a29.jpg', '', '', '2023-07-29 13:33:29'),
('BKTI2318484a53d79b12', 'BUM-23070133b473a52812', 'Bukti_Satu23070eabe62412.jpg', '', '', '2023-07-12 16:53:09'),
('BKTI232b7d783424ad29', 'BUM-230776a4c774502329', 'Bukti_Satu23073c810c4529.jpg', '', '', '2023-07-29 13:28:34'),
('BKTI2330d21520860012', 'PPN-2307912dad40545212', 'Bukti_Satu2307f45219f812.jpg', '', '', '2023-07-12 16:46:51'),
('BKTI2347914b7f9faf25', 'NONPPN-23078708181dd78f25', 'Bukti_Satu23078258513b25.jpg', '', '', '2023-07-25 10:54:08'),
('BKTI234a4df3ead44912', 'NONPPN-23072ba6d79b7dbb12', 'Bukti_Satu230778ea878c12.jpg', '', '', '2023-07-12 16:46:16'),
('BKTI235b8257bfd5dc25', 'NONPPN-2307932a2dc86e7825', 'Bukti_Satu2307f434e61c25.jpg', '', '', '2023-07-25 09:25:26'),
('BKTI236cd1e79c42ac25', 'NONPPN-230777cf03371b4725', 'Bukti_Satu23075487b61525.jpg', '', '', '2023-07-25 13:29:59'),
('BKTI23f39977132e0e29', 'NONPPN-23074845ef9a130a29', 'Bukti_Satu2307e8aa06e329.jpg', '', '', '2023-07-29 13:22:01'),
('BKTI23fbb365915ea325', 'NONPPN-2307f61d180b572f25', 'Bukti_Satu2307a143373925.jpg', '', '', '2023-07-25 10:46:23'),
('BKTI23ff33730c56a412', 'PPN-2307a219ed763aed12', 'Bukti_Satu230713871fcd12.jpg', '', '', '2023-07-12 16:54:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_bum`
--

CREATE TABLE `inv_bum` (
  `id_inv_bum` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(30) NOT NULL,
  `cs_inv` varchar(50) NOT NULL,
  `tgl_tempo` varchar(30) NOT NULL,
  `sp_disc` decimal(4,1) NOT NULL,
  `note_inv` varchar(150) NOT NULL,
  `kategori_inv` varchar(20) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total_inv` int(11) NOT NULL,
  `status_transaksi` varchar(30) NOT NULL,
  `nama_invoice` varchar(50) NOT NULL,
  `user_created` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL,
  `user_updated` varchar(30) NOT NULL,
  `updated_date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inv_bum`
--

INSERT INTO `inv_bum` (`id_inv_bum`, `no_inv`, `tgl_inv`, `cs_inv`, `tgl_tempo`, `sp_disc`, `note_inv`, `kategori_inv`, `ongkir`, `total_inv`, `status_transaksi`, `nama_invoice`, `user_created`, `created_date`, `user_updated`, `updated_date`) VALUES
('BUM-230890335943a8ac13', '001/BUM/VIII/2023', '13/08/2023', 'Ibu Melly', '13/09/2023', 0.0, '', 'Reguler', 0, 1775000, 'Transaksi Selesai', 'Invoice_Bum', 'Dany Pratama Saputro', '0000-00-00 00:00:00', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_nonppn`
--

CREATE TABLE `inv_nonppn` (
  `id_inv_nonppn` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(30) NOT NULL,
  `cs_inv` varchar(50) NOT NULL,
  `tgl_tempo` varchar(30) NOT NULL,
  `sp_disc` decimal(3,1) NOT NULL,
  `note_inv` text NOT NULL,
  `kategori_inv` varchar(20) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total_inv` int(11) NOT NULL,
  `status_transaksi` varchar(30) NOT NULL,
  `nama_invoice` varchar(50) NOT NULL,
  `user_created` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_updated` varchar(20) NOT NULL,
  `updated_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inv_nonppn`
--

INSERT INTO `inv_nonppn` (`id_inv_nonppn`, `no_inv`, `tgl_inv`, `cs_inv`, `tgl_tempo`, `sp_disc`, `note_inv`, `kategori_inv`, `ongkir`, `total_inv`, `status_transaksi`, `nama_invoice`, `user_created`, `created_date`, `user_updated`, `updated_date`) VALUES
('NONPPN-2308628afd2bd3f913', '001/KM/VIII/2023', '13/08/2023', 'Bapak Ferry', '13/09/2023', 0.0, '', 'Reguler', 0, 1350000, 'Transaksi Selesai', 'Invoice_Non_PPN', 'Dany Pratama Saputro', '2023-08-13 15:22:11', '', ''),
('NONPPN-2308710f8d85b71a15', '004/KM/VIII/2023', '15/08/2023', 'Bapak Ferry', '15/09/2023', 0.0, '', 'Reguler', 0, 750000, 'Transaksi Selesai', 'Invoice_Non_PPN', 'Dany Pratama Saputro', '2023-08-15 16:28:00', '', ''),
('NONPPN-2308c7624de935d514', '002/KM/VIII/2023', '14/08/2023', 'Bapak Ferry', '14/09/2023', 0.0, '', 'Reguler', 0, 2350000, 'Transaksi Selesai', 'Invoice_Non_PPN', 'Dany Pratama Saputro', '2023-08-14 08:38:17', '', ''),
('NONPPN-2308c9239a9c560015', '005/KM/VIII/2023', '15/08/2023', 'Bapak Ferry', '15/09/2023', 0.0, '', 'Reguler', 0, 1500000, 'Transaksi Selesai', 'Invoice_Non_PPN', 'Dany Pratama Saputro', '2023-08-15 16:32:09', '', ''),
('NONPPN-2308dc21b048e4aa14', '003/KM/VIII/2023', '14/08/2023', 'Ibu Melly', '14/09/2023', 0.0, '', 'Reguler', 0, 1225000, 'Transaksi Selesai', 'Invoice_Non_PPN', 'Dany Pratama Saputro', '2023-08-14 08:41:36', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_penerima`
--

CREATE TABLE `inv_penerima` (
  `id_inv_penerima` varchar(50) NOT NULL,
  `id_inv` varchar(50) NOT NULL,
  `nama_penerima` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `tgl_terima` date NOT NULL DEFAULT current_timestamp(),
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inv_penerima`
--

INSERT INTO `inv_penerima` (`id_inv_penerima`, `id_inv`, `nama_penerima`, `alamat`, `tgl_terima`, `created_date`) VALUES
('PNMR230866610ea14dea14', 'PPN-2308359ae4a577ee14', 'Agung', 'Jl. Ciputat Raya No 64 Pondok Pinang Kebayoran Lama Jakarta Selatan', '2023-08-14', '2023-08-14 11:10:36'),
('PNMR23087d75b648b1a813', 'NONPPN-2308628afd2bd3f913', 'Bapak Ferry', 'Jakarta', '2023-08-13', '2023-08-13 15:37:57'),
('PNMR23088c9ba296f53414', 'NONPPN-2308dc21b048e4aa14', 'Ibu Melly', ' Jakarta   ', '2023-08-14', '2023-08-14 10:39:41'),
('PNMR2308986b0faf1b4c15', 'PPN-23085a1c8d524c3915', 'Agung', 'Jl. Lawanggada no. 39 Cirebon', '2023-08-15', '2023-08-15 16:35:00'),
('PNMR2308a0651fdf294715', 'NONPPN-2308c9239a9c560015', 'Bapak Ferry', 'Jakarta', '2023-08-15', '2023-08-15 16:32:59'),
('PNMR2308a88328882a3f15', 'NONPPN-2308710f8d85b71a15', 'Bapak Ferry', 'Jakarta', '2023-08-15', '2023-08-15 16:28:32'),
('PNMR2308a97ff174362613', 'PPN-2308ac77fbf6bc0e13', 'Bapak Ahmad', 'Jl. Ciputat Raya No 64 Pondok Pinang Kebayoran Lama Jakarta Selatan', '2023-08-13', '2023-08-13 15:49:36'),
('PNMR2308b3dfedb8b02d14', 'NONPPN-2308c7624de935d514', 'Bapak Ferry', 'Jakarta', '2023-08-14', '2023-08-14 08:39:25'),
('PNMR2308be233977f1a713', 'BUM-230890335943a8ac13', 'Melly', ' Jakarta   ', '2023-08-13', '2023-08-13 15:52:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inv_ppn`
--

CREATE TABLE `inv_ppn` (
  `id_inv_ppn` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(30) NOT NULL,
  `cs_inv` varchar(50) NOT NULL,
  `tgl_tempo` varchar(30) NOT NULL,
  `sp_disc` decimal(4,1) NOT NULL,
  `note_inv` text NOT NULL,
  `kategori_inv` varchar(20) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total_inv` int(11) NOT NULL,
  `status_transaksi` varchar(30) NOT NULL,
  `nama_invoice` varchar(50) NOT NULL,
  `user_created` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_updated` varchar(30) NOT NULL,
  `updated_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `inv_ppn`
--

INSERT INTO `inv_ppn` (`id_inv_ppn`, `no_inv`, `tgl_inv`, `cs_inv`, `tgl_tempo`, `sp_disc`, `note_inv`, `kategori_inv`, `ongkir`, `total_inv`, `status_transaksi`, `nama_invoice`, `user_created`, `created_date`, `user_updated`, `updated_date`) VALUES
('PPN-2308359ae4a577ee14', '002/KMA/VIII/2023', '14/08/2023', 'PT. Sekarguna Medika', '14/09/2023', 0.0, '', 'Reguler', 0, 2497500, 'Transaksi Selesai', 'Invoice_PPN', 'Dany Pratama Saputro', '2023-08-14 11:09:06', '', ''),
('PPN-23085a1c8d524c3915', '003/KMA/VIII/2023', '15/08/2023', 'PT. Carmella Gustavindo', '15/08/2023', 0.0, '', 'Reguler', 0, 832500, 'Transaksi Selesai', 'Invoice_PPN', 'Dany Pratama Saputro', '2023-08-15 16:34:26', '', ''),
('PPN-2308ac77fbf6bc0e13', '001/KMA/VIII/2023', '13/08/2023', 'PT. Sekarguna Medika', '13/09/2023', 0.0, '', 'Reguler', 0, 1776000, 'Transaksi Selesai', 'Invoice_PPN', 'Dany Pratama Saputro', '2023-08-13 15:41:05', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_br_out_reg`
--

CREATE TABLE `isi_br_out_reg` (
  `id_isi_br_out_reg` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_ket_out` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `isi_br_out_reg`
--

INSERT INTO `isi_br_out_reg` (`id_isi_br_out_reg`, `id_user`, `id_produk_reg`, `qty`, `id_ket_out`, `created_date`) VALUES
('BR-OUT-2327b6cf35acba05', 'USER47100114a730', 'BR-REGffb0b62a09cf', 500, 'KET-OUT-3be1123e6e26', '23/05/2023, 14:57'),
('BR-OUT-235fa612a9f32405', 'USER03595a8447ab', 'BR-REGe2e00ce0199b', 100, 'KET-OUT-5994e66e943d', '23/05/2023, 14:40'),
('BR-OUT-2383b0ba6f6d3e05', 'USER03595a8447ab', 'BR-REGffb0b62a09cf', 300, 'KET-OUT-3be1123e6e26', '23/05/2023, 14:53');

--
-- Trigger `isi_br_out_reg`
--
DELIMITER $$
CREATE TRIGGER `add_br_out_reg` AFTER INSERT ON `isi_br_out_reg` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - NEW.qty 
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_br_out_reg` AFTER DELETE ON `isi_br_out_reg` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty 
WHERE id_produk_reg = OLD.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_br_out_reg` AFTER UPDATE ON `isi_br_out_reg` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty - NEW.qty
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_br_tambahan`
--

CREATE TABLE `isi_br_tambahan` (
  `id_isi_br_tambahan` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_ket_in` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `isi_br_tambahan`
--

INSERT INTO `isi_br_tambahan` (`id_isi_br_tambahan`, `id_user`, `id_produk_reg`, `qty`, `id_ket_in`, `created_date`) VALUES
('BR-TAMBAHAN-23e9119de3836505', 'USER03595a8447ab', 'BR-REGffb0b62a09cf', 1000, 'Pilih...', '23/05/2023, 11:55');

--
-- Trigger `isi_br_tambahan`
--
DELIMITER $$
CREATE TRIGGER `add_br_tambahan` AFTER INSERT ON `isi_br_tambahan` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + NEW.qty 
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_br_tambahan` AFTER DELETE ON `isi_br_tambahan` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - OLD.qty 
WHERE id_produk_reg = OLD.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_br_tambahan` AFTER UPDATE ON `isi_br_tambahan` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - OLD.qty + NEW.qty
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_inv_br_import`
--

CREATE TABLE `isi_inv_br_import` (
  `id_isi_inv_br_import` varchar(50) NOT NULL,
  `id_inv_br_import` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `isi_inv_br_import`
--

INSERT INTO `isi_inv_br_import` (`id_isi_inv_br_import`, `id_inv_br_import`, `id_produk_reg`, `qty`, `id_user`, `created_date`, `updated_date`, `user_updated`) VALUES
('BR-IMPORT-23c54205625a1305', 'INV-IMPORT414edd954c45', 'BR-REG6d4d12f6c304', 1000, 'USER03595a8447ab', '23/05/2023, 16:39', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_inv_br_in_lokal`
--

CREATE TABLE `isi_inv_br_in_lokal` (
  `id_isi_inv_br_in_lokal` varchar(50) NOT NULL,
  `id_inv_br_in_lokal` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `isi_inv_br_in_lokal`
--

INSERT INTO `isi_inv_br_in_lokal` (`id_isi_inv_br_in_lokal`, `id_inv_br_in_lokal`, `id_user`, `id_produk_reg`, `qty`, `created_date`) VALUES
('BR-LOKAL-2374f539a708ab05', 'INV-LOKAL29304ecbc0fa', 'USER03595a8447ab', 'BR-REGffb0b62a09cf', 1000, '23/05/2023, 11:55');

--
-- Trigger `isi_inv_br_in_lokal`
--
DELIMITER $$
CREATE TRIGGER `add_isi_inv_br_lokal` AFTER INSERT ON `isi_inv_br_in_lokal` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + NEW.qty 
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_isi_inv_br_lokal` AFTER DELETE ON `isi_inv_br_in_lokal` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - OLD.qty 
WHERE id_produk_reg = OLD.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_isi_br_lokal` AFTER UPDATE ON `isi_inv_br_in_lokal` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - OLD.qty + NEW.qty
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_produk_set_marwa`
--

CREATE TABLE `isi_produk_set_marwa` (
  `id_isi_set_marwa` varchar(50) NOT NULL,
  `id_set_marwa` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `isi_produk_set_marwa`
--

INSERT INTO `isi_produk_set_marwa` (`id_isi_set_marwa`, `id_set_marwa`, `id_produk`, `qty`) VALUES
('BR-SET-MRW-3b692d8521ec', 'SETMRW608112486bb9', 'BR-REGffb0b62a09cf', 1000),
('BR-SET-MRW-a68c1d2ebad8', 'SETMRW608112486bb9', 'BR-REG6d4d12f6c304', 1100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `keterangan_in`
--

CREATE TABLE `keterangan_in` (
  `id_ket_in` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `ket_in` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keterangan_out`
--

CREATE TABLE `keterangan_out` (
  `id_ket_out` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `ket_out` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keterangan_out`
--

INSERT INTO `keterangan_out` (`id_ket_out`, `id_user`, `ket_out`, `created_date`) VALUES
('KET-OUT-3be1123e6e26', 'USER03595a8447ab', 'Riject', '23/05/2023, 10:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `qr_link`
--

CREATE TABLE `qr_link` (
  `id_link` int(11) NOT NULL,
  `id_produk_qr` varchar(50) NOT NULL,
  `url_qr` varchar(180) NOT NULL,
  `qr_img` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `qr_link`
--

INSERT INTO `qr_link` (`id_link`, `id_produk_qr`, `url_qr`, `qr_img`, `created_date`) VALUES
(1, 'BR-REGac53521f2f53', 'https://staging-inventory.mandirialkesindo.com/detail-produk?id=BR-REGac53521f2f53', 'Mayo Scissors 22 CM.png', '2023-06-12 10:29:00'),
(2, 'BR-REG5778c542e341', 'https://staging-inventory.mandirialkesindo.com/detail-produk?id=BR-REG5778c542e341', 'Thumb Dressing Forceps 19 cm.png', '2023-06-12 10:29:58'),
(3, 'BR-REG6d6493ef01bf', 'https://staging-inventory.mandirialkesindo.com/detail-produk?id=BR-REG6d6493ef01bf', 'Thumb Dressing Forceps 23 cm.png', '2023-06-12 10:54:48'),
(4, 'BR-REG5036d872cb87', 'https://staging-inventory.mandirialkesindo.com/detail-produk.php?id=BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm.png', '2023-06-13 19:12:35'),
(5, 'BR-REG9b682f3c5838', 'https://staging-inventory.mandirialkesindo.com/detail-produk.php?id=BR-REG9b682f3c5838', 'Meriam Cotton Plier 16 cm.png', '2023-06-13 19:13:34'),
(6, 'BR-REG835084308577', 'https://staging-inventory.mandirialkesindo.com/detail-produk.php?id=BR-REG835084308577', 'Thumb Dressing Forceps 18 cm.png', '2023-06-13 19:14:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sph`
--

CREATE TABLE `sph` (
  `id_sph` varchar(50) NOT NULL,
  `no_sph` varchar(25) NOT NULL,
  `tanggal` varchar(25) NOT NULL,
  `customer` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `ttd_oleh` varchar(40) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `perihal` varchar(50) NOT NULL,
  `note` varchar(200) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` varchar(40) NOT NULL,
  `updated_date` varchar(25) NOT NULL,
  `updated_by` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `spk_reg`
--

CREATE TABLE `spk_reg` (
  `id_spk_reg` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_customer` varchar(50) NOT NULL,
  `id_inv` varchar(50) NOT NULL,
  `id_sales` varchar(50) NOT NULL,
  `id_orderby` varchar(50) NOT NULL,
  `status_spk` varchar(25) NOT NULL,
  `no_spk` varchar(25) NOT NULL,
  `no_po` varchar(25) NOT NULL,
  `tgl_spk` varchar(20) NOT NULL,
  `tgl_pesanan` varchar(20) NOT NULL,
  `note` varchar(100) NOT NULL,
  `menu_cancel` varchar(20) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `user_updated` varchar(25) NOT NULL,
  `updated_date` varchar(25) NOT NULL,
  `user_cancel` varchar(50) NOT NULL,
  `date_cancel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `spk_reg`
--

INSERT INTO `spk_reg` (`id_spk_reg`, `id_user`, `id_customer`, `id_inv`, `id_sales`, `id_orderby`, `status_spk`, `no_spk`, `no_po`, `tgl_spk`, `tgl_pesanan`, `note`, `menu_cancel`, `created_date`, `user_updated`, `updated_date`, `user_cancel`, `date_cancel`) VALUES
('SPKREG-23081a8ce1fb680713', 'USER03595a8447ab', 'CS196cd49a4677', 'BUM-230890335943a8ac13', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '003/SPK/VIII/2023', '001', '13/08/2023, 15:50', '13/08/2023', '', '', '13/08/2023, 15:50', '', '', '', ''),
('SPKREG-230824c894fd93ac15', 'USER03595a8447ab', 'CS015858a52568', 'NONPPN-2308c9239a9c560015', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '008/SPK/VIII/2023', '003', '15/08/2023, 16:31', '15/08/2023', '', '', '15/08/2023, 16:31', '', '', '', ''),
('SPKREG-230845183c89f76c14', 'USER03595a8447ab', 'CS196cd49a4677', 'NONPPN-2308dc21b048e4aa14', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '005/SPK/VIII/2023', '005', '14/08/2023, 8:40', '14/08/2023', '', '', '14/08/2023, 8:40', '', '', '', ''),
('SPKREG-2308878a39202e4113', 'USER03595a8447ab', 'CS015858a52568', 'NONPPN-2308628afd2bd3f913', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '001/SPK/VIII/2023', '001', '13/08/2023, 15:21', '13/08/2023', '', '', '13/08/2023, 15:21', '', '', '', ''),
('SPKREG-23088dc84b98639414', 'USER03595a8447ab', 'CS03492a42198f', 'PPN-2308359ae4a577ee14', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '006/SPK/VIII/2023', '', '14/08/2023, 11:05', '14/08/2023', '', '', '14/08/2023, 11:05', '', '', '', ''),
('SPKREG-2308930965c5245b15', 'USER03595a8447ab', 'CS018b7ca30d99', 'PPN-23085a1c8d524c3915', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '009/SPK/VIII/2023', '003', '15/08/2023, 16:34', '15/08/2023', '', '', '15/08/2023, 16:34', '', '', '', ''),
('SPKREG-23089d7623db760213', 'USER03595a8447ab', 'CS03492a42198f', 'PPN-2308ac77fbf6bc0e13', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '002/SPK/VIII/2023', '001', '13/08/2023, 15:40', '13/08/2023', '', '', '13/08/2023, 15:40', '', '', '', ''),
('SPKREG-2308c6c7c91c3b5215', 'USER03595a8447ab', 'CS015858a52568', 'NONPPN-2308710f8d85b71a15', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '007/SPK/VIII/2023', '', '15/08/2023, 16:27', '15/08/2023', '', '', '15/08/2023, 16:27', '', '', '', ''),
('SPKREG-2308d524347b997614', 'USER03595a8447ab', 'CS015858a52568', 'NONPPN-2308c7624de935d514', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '004/SPK/VIII/2023', '004', '14/08/2023, 8:37', '14/08/2023', '', '', '14/08/2023, 8:37', '', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `status_kirim`
--

CREATE TABLE `status_kirim` (
  `id_status_kirim` varchar(50) NOT NULL,
  `id_inv` varchar(50) NOT NULL,
  `jenis_inv` varchar(10) NOT NULL,
  `jenis_pengiriman` varchar(20) NOT NULL,
  `jenis_penerima` varchar(20) NOT NULL,
  `dikirim_driver` varchar(50) NOT NULL,
  `dikirim_ekspedisi` varchar(50) NOT NULL,
  `no_resi` varchar(50) NOT NULL,
  `tgl_kirim` varchar(20) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `status_kirim`
--

INSERT INTO `status_kirim` (`id_status_kirim`, `id_inv`, `jenis_inv`, `jenis_pengiriman`, `jenis_penerima`, `dikirim_driver`, `dikirim_ekspedisi`, `no_resi`, `tgl_kirim`, `created_date`) VALUES
('STATUS-23070a527b13dae225', 'NONPPN-2307f61d180b572f25', 'nonppn', 'Ekspedisi', 'Ekspedisi', '', 'EKSe86520083a96', '123456', '25/07/2023', '2023-07-25 10:46:23'),
('STATUS-230737b1aec71efd25', 'NONPPN-230777cf03371b4725', 'nonppn', 'Ekspedisi', 'Ekspedisi', '', 'EKS421e093c826c', '123456', '25/07/2023', '2023-07-25 13:29:59'),
('STATUS-230742d24e6a3d3629', 'BUM-230776a4c774502329', 'bum', 'Ekspedisi', 'Ekspedisi', '', 'EKS421e093c826c', '123456sfgg', '29/07/2023', '2023-07-29 13:28:34'),
('STATUS-2307741ad6b8a1f112', 'PPN-2307912dad40545212', 'ppn', 'Ekspedisi', '', '', 'EKS421e093c826c', '123456sfgg', '12/07/2023', '2023-07-12 16:46:51'),
('STATUS-23078f910ef4ca1922', 'NONPPN-2307861b90e0dd2222', 'nonppn', 'Driver', 'Customer', 'USER388732b31872', '', '', '22/07/2023', '2023-07-22 11:23:14'),
('STATUS-2307aa73c1fb392212', 'PPN-2307b4684f606d9d12', 'ppn', 'Driver', '', 'USER388732b31872', 'JNT', '123456', '12/07/2023', '2023-07-12 16:46:34'),
('STATUS-2307bf5a72c50e3a12', 'BUM-23072df600eb1e0812', 'bum', 'Driver', '', 'USER388732b31872', 'JNT', '123456', '12/07/2023', '2023-07-12 16:47:21'),
('STATUS-2307bf9a701a5fa229', 'NONPPN-23074845ef9a130a29', 'nonppn', 'Ekspedisi', 'Ekspedisi', '', 'EKSe86520083a96', '123456sfgg', '29/07/2023', '2023-07-29 13:22:01'),
('STATUS-2307c08d7ae48d8120', 'NONPPN-2307d80dd3993b8220', 'nonppn', 'Driver', 'Customer', 'USER388732b31872', '', '', '20/07/2023', '2023-07-20 13:37:57'),
('STATUS-2307c677b669208a12', 'PPN-2307a219ed763aed12', 'ppn', 'Ekspedisi', 'Ekspedisi', '', 'EKS49bd4a65fdc6', '123456', '12/07/2023', '2023-07-12 16:54:46'),
('STATUS-2307ca7450e8190225', 'NONPPN-2307932a2dc86e7825', 'nonppn', 'Ekspedisi', 'Ekspedisi', '', 'EKS421e093c826c', '123456', '25/07/2023', '2023-07-25 09:25:26'),
('STATUS-2307d5e3f9e1aa8d12', 'BUM-23070133b473a52812', 'bum', 'Ekspedisi', 'Ekspedisi', '', 'EKS16367774d65b', '123456', '12/07/2023', '2023-07-12 16:53:09'),
('STATUS-2307e2b9905ba1bc29', 'PPN-2307e16c6de85d1f29', 'ppn', 'Ekspedisi', 'Ekspedisi', '', 'EKS2d716c56479c', '123456dasfaf', '29/07/2023', '2023-07-29 13:33:29'),
('STATUS-2307ed5eedecef5812', 'NONPPN-230719bd68161e2712', 'nonppn', 'Driver', 'Ekspedisi', 'USER388732b31872', 'EKS2d716c56479c', '12345', '12/07/2023', '2023-07-12 16:44:52'),
('STATUS-2307f0d655a5ff8d12', 'NONPPN-23072ba6d79b7dbb12', 'nonppn', 'Ekspedisi', 'Ekspedisi', '', 'EKS2d716c56479c', '123456', '12/07/2023', '2023-07-12 16:46:16'),
('STATUS-2307f26b4a59553825', 'NONPPN-23078708181dd78f25', 'nonppn', 'Ekspedisi', 'Ekspedisi', '', 'EKSe86520083a96', '123456', '25/07/2023', '2023-07-25 10:54:08'),
('STATUS-23080b6c385e533611', 'BUM-230841b0329176bd11', 'bum', 'Driver', '', 'USER388732b31872', '', '', '11/08/2023', '2023-08-11 09:50:53'),
('STATUS-230814fb674edd0712', 'BUM-230878fe3a397ee912', 'bum', 'Driver', '', 'USER388732b31872', '', '', '12/08/2023', '2023-08-12 15:42:30'),
('STATUS-23081c15c2d511ee15', 'NONPPN-2308710f8d85b71a15', 'nonppn', 'Driver', 'Customer', 'USER388732b31872', '', '', '15/08/2023', '2023-08-15 16:28:08'),
('STATUS-230834c684d0458e13', 'NONPPN-2308628afd2bd3f913', 'nonppn', 'Driver', 'Customer', 'USER388732b31872', '', '', '13/08/2023', '2023-08-13 15:35:06'),
('STATUS-23087857dfa6424713', 'PPN-2308ac77fbf6bc0e13', 'ppn', 'Driver', '', 'USER388732b31872', '', '', '13/08/2023', '2023-08-13 15:46:46'),
('STATUS-230878cae76b5edf14', 'PPN-2308359ae4a577ee14', 'ppn', 'Driver', '', 'USER388732b31872', '', '', '14/08/2023', '2023-08-14 11:09:30'),
('STATUS-23088fccddd654cd10', 'PPN-2308a111e43927bc10', 'ppn', 'Driver', '', 'USER388732b31872', '', '', '10/08/2023', '2023-08-10 14:00:00'),
('STATUS-2308ba4dd888f08f14', 'NONPPN-2308c7624de935d514', 'nonppn', 'Driver', 'Customer', 'USER388732b31872', '', '', '14/08/2023', '2023-08-14 08:38:51'),
('STATUS-2308c52949157afc12', 'BUM-2308286c3274279112', 'bum', 'Driver', '', 'USER388732b31872', '', '', '12/08/2023', '2023-08-12 15:42:06'),
('STATUS-2308d1825716834815', 'NONPPN-2308c9239a9c560015', 'nonppn', 'Driver', 'Customer', 'USER388732b31872', '', '', '15/08/2023', '2023-08-15 16:32:28'),
('STATUS-2308de2ec758713615', 'PPN-23085a1c8d524c3915', 'ppn', 'Driver', '', 'USER388732b31872', '', '', '15/08/2023', '2023-08-15 16:34:40'),
('STATUS-2308e57d149938ff14', 'NONPPN-2308dc21b048e4aa14', 'nonppn', 'Driver', 'Customer', 'USER388732b31872', '', '', '14/08/2023', '2023-08-14 10:38:57'),
('STATUS-2308f60f9ba5282e13', 'BUM-230890335943a8ac13', 'bum', 'Driver', '', 'USER388732b31872', '', '', '13/08/2023', '2023-08-13 15:51:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stock_produk_reguler`
--

CREATE TABLE `stock_produk_reguler` (
  `id_stock_prod_reg` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stock_produk_reguler`
--

INSERT INTO `stock_produk_reguler` (`id_stock_prod_reg`, `id_user`, `id_produk_reg`, `stock`, `created_date`) VALUES
('STOCKREG55e46f5fa230', 'USER03595a8447ab', 'BR-REG835084308577', 4600, '13/06/2023, 19:14'),
('STOCKREG8e323a72e891', 'USER03595a8447ab', 'BR-REG9b682f3c5838', 1900, '13/06/2023, 19:14'),
('STOCKREGff8ea8359574', 'USER03595a8447ab', 'BR-REG5036d872cb87', 9200, '13/06/2023, 19:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_customer`
--

CREATE TABLE `tb_customer` (
  `id_cs` varchar(25) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_cs` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_customer`
--

INSERT INTO `tb_customer` (`id_cs`, `id_user`, `nama_cs`, `email`, `no_telp`, `alamat`, `created_date`, `updated_date`, `user_updated`) VALUES
('CS0087ea6067d9', '', 'Manchester Medika', '', '08xx', 'Jakarta', '', '', ''),
('CS01111c859db5', '', 'Toko Medistar', '', '', 'Malang', '', '', ''),
('CS015858a52568', '', 'Bapak Ferry', '', '08xx', 'Jakarta', '', '', ''),
('CS018b7ca30d99', '', 'PT. Carmella Gustavindo', '', '08xx', 'Jl. Lawanggada no. 39 Cirebon', '', '', ''),
('CS01dae1cd848c', '', 'PT. Dhyas Mitra Usaha', '', '', 'Komplek Ruko Kirana Mas No.3 A, Jl. Letda Nasir Bojong Kulur Gunung Putri Bogor', '', '', ''),
('CS03492a42198f', '', 'PT. Sekarguna Medika', '', '08xx', 'Jl. Ciputat Raya No 64 Pondok Pinang Kebayoran Lama Jakarta Selatan', '', '', ''),
('CS04d34e237d6f', '', 'AMS Medika', '', '', 'Jl. Sedap Malam 88 DENPASAR', '', '', ''),
('CS04de86c02cbb', '', 'PT. Sumber Rejeki Medika Jaya', '', '08xx', 'Jl. Adam Malik No. 33 RT.004 Kel. Karang Asam Ulu Kec. Sungai Kunjang - Samarinda', '', '', ''),
('CS0500bb9e6a8c', '', 'PT. Elkaka Putra Mandiri', '', '08xx', 'Jl. P. Batam Raya No. 34 Way Halim Permai Way Halim Kota Bandar Lampung', '', '', ''),
('CS05fd2b75a6bf', '', 'IBU  ISNAINI', '', '08xx', 'MALANG', '', '', ''),
('CS07ae4b60fb9e', '', 'Bapak Hendry ( Sumber Baru )', '', '08xx', 'Jakarta', '', '', ''),
('CS083d4e5de19e', '', 'Bapak Sugiarto', '', '', 'Jakarta', '', '', ''),
('CS08876c29fcb4', '', 'Dany Pratama s', 'adminkma@inventory.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 9:48', '', ''),
('CS0aaa83f3c50d', '', 'PT. Mitra Medika Sejahterabersama', '', '08xx', 'Pasar Segar Paal Ruko Blok Rc. No 11, Jl. Yos Sudarso No 12 Paal Dua, Tikala Manado', '', '', ''),
('CS0ba4a3dd6179', '', 'Dany Pratama m', 'pratamadany87@gmail.com', '085xxxxxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 10:19', '', ''),
('CS0c4c20e98a3c', '', 'Ibu Susan ( Toko Berkah )', '', '08xx', 'Jakarta', '', '', ''),
('CS0ce9f7c1a16b', '', 'PT. Sigra Duta Medical', '', '', 'Jl. Purnama No. 3 A , Kota Baru Jambi', '', '', ''),
('CS0dcca0062d19', '', 'Bapak Richard', '', '08xx', 'Jakarta', '', '', ''),
('CS0e232d568a2f', '', 'PT. Medtek', '', '', 'Delta Building Blok A-11 Jl. Suryopranoto No 1-9 Jakarta Pusat', '', '', ''),
('CS107272547638', '', 'Bapak Guntur', '', '08xx', 'Jakarta', '', '', ''),
('CS111e5626212a', '', 'Dany Pratama cc', 'adminkma@inventory.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 10:13', '', ''),
('CS118b4296eda5', '', 'Bapak Indra', '', '08xx', 'Jakarta', '', '', ''),
('CS12261176f444', '', 'PT. Delta Surya Alkesindo', '', '08xx', 'Jl. Pramuka No. 9 RT 20 Kel.Sungai Lulut Kec. Banjarmasin Kota Banjarmasin', '', '', ''),
('CS13309eb4fb7d', '', 'Bapak Salam', '', '', 'Jakarta', '', '', ''),
('CS14cf2882973d', '', 'PT. Sasyeri Indo Farma', '', '08xx', 'Jl. Raye Abepura - Kotaraja No 29 Jayapura - Papua', '', '', ''),
('CS1883369d8b2e', '', 'Arkha Medika', '', '08xx', 'Jakarta', '', '', ''),
('CS18afb00a0ae6', '', 'Bapak Darmanto', '', '', 'Jakarta', '', '', ''),
('CS196cd49a4677', '', 'Ibu Melly', '', '08xx', ' Jakarta   ', '', '', ''),
('CS1a4f63be6178', '', 'Bapak Eko', '', '08xx', 'Jakarta', '', '', ''),
('CS1b171e3661b8', '', 'PT. Sinar Korindo Group', '', '08xx', 'Sentra Niaga Kalimas Blok B 088, Jl. KH. Noer Ali, Inspeksi Kalimalang Setia Darma Tambun Selatan Kab Bekasi Barat', '', '', ''),
('CS1b24379596a8', '', 'Bapak Sony', '', '08xx', 'Jakarta', '', '', ''),
('CS1b4c43419caa', '', 'Intermedin', '', '', 'Jakarta', '', '', ''),
('CS1ba046d8bc5e', '', 'Bapak Trisno', '', '', 'Jakarta', '', '', ''),
('CS1c00f94b331d', '', 'PT. Alfa Kimia Biomedikatama', '', '08xx', 'Jl. C. Simanjutak No. 12 Yogyakarta', '', '', ''),
('CS1c828bf1a4b4', '', 'PT. Vanaya Indah Perkasa', '', '08xx', 'Ruko Telaga Mas Blok C9-CB Kel. Harapan Baru, Kec, Bekasi Utara, Kota Bekasi', '', '', ''),
('CS1e94262c369f', '', 'PT. DAYA MATAHARI UTAMA', '', '08xxx', 'Jl. Kertomenungal III No. 03 - Surabaya', '', '', ''),
('CS1fcdb8d7d8dd', '', 'PT. Suma Bargen', '', '08xx', 'Jl. Candi Panataran Utara III no 33 Semarang', '', '', ''),
('CS205c8bfb9b9f', '', 'Ami Medical', '', '08xx', 'Jakarta', '', '', ''),
('CS20a2c8a5dd11', '', 'CV. Pyramid', '', '08xx', 'Jakarta  ', '', '', ''),
('CS20c3a42ee9d4', '', 'PT. Trimuri Karya Cipta', '', '-', 'Kota Wisata Commpark B No. 03 RT.001 RW.002 Limusnunggal Cileungsi Kab. Bogor Jawa Barat', '', '', ''),
('CS23978840f170', '', 'PT. Putra Irma Medika', '', '08xx', 'Jl. Projakal No. 122 RT.055 RW.000, Kel. Graha Indah, Kec. Balikpapan Utara Kota Balikpapan Kalimantan Timur', '', '', ''),
('CS24dfb06253d1', '', 'Bapak Wahidin', '', '08xx', 'Jakarta', '', '', ''),
('CS26da9cecad09', '', 'Bapak Renaldy', '', '', 'Cilegon', '', '', ''),
('CS27ae04be16a0', '', 'PT. ERSA MEDIKA USAHATAMA', '', '08xx', 'Blok Babakan RT.007 RW.002 Desa Megu Gede Kec, Weru Kab. Cirebon Jawa Barat', '', '', ''),
('CS27db94853e17', '', 'Indomedifa', '', '', ' Jl. Pemuda No. 4 RT.002 RW.004 Kel. Olo Kec. Padang Barat - Kota Padang ', '', '', ''),
('CS285a919a8672', '', 'PT. Kalica Putra Pratama', '', '', 'Jl. Brigjen Hasan Basry No 3 RT 15 - Banjarmasin', '', '', ''),
('CS28df8ba79cd9', '', 'BPK TOMMI', '', '08xx', 'JAKARTA', '', '', ''),
('CS28dfc50c9558', '', 'Bapak Apri', '', '', 'Jakarta', '', '', ''),
('CS2b79ebb8f671', '', 'PT. ARFA REZQI MEDIKA', '', '-', 'Jl. Puri Gunung Anyar Regency R-21 RT.006. RW.007 Gunung Anyar Tambak Gunung Anyar', '', '', ''),
('CS2bdfdbdebdf0', '', 'MMT Alkes', '', '08xx', 'Jakarta', '', '', ''),
('CS2c0873bca34c', '', 'AL MEDIKA ', '', '08xx', 'REMBANG', '', '', ''),
('CS2f23e5b10125', '', 'Bapak Rochim', '', '08xx', 'Jakarta  ', '', '', ''),
('CS2f47afb8fe6a', '', 'PT. Andalas Sarana Medika', '', '08xx', 'Jl. Ikhlas Raya No. 22, Kel. Kubu Dalam Parak Karakah, Kec. padang Timur - Kota Padang', '', '', ''),
('CS3048708af46d', '', 'NALURI MEDIKA', '', '08xx', 'JAKARTA', '', '', ''),
('CS30fdd1f75cd9', '', 'PT. Bromo Pharindo', '', '08xx', 'Perkantoran Cipulir Baru Lantai 2 No. 2 13-14, Jl. Cileduk Raya No. 2 Ulujami Pesangrahan', '', '', ''),
('CS31bd2ece3e74', '', 'PT. Asma Anugerah Berkah Medikatama', '', '08xx', 'Jl. Ahmad Yani No. 84 Wonokarto Wonogiri Jawa Tengah	', '', '', ''),
('CS32dd207dc43b', '', 'Eterna', '', '08xx', 'Jakarta', '', '', ''),
('CS3459ba8caab9', '', 'Ibu Yuyun', '', '08xx', 'Bekasi', '', '', ''),
('CS34d14a1890ac', '', 'Medica Awong', '', '08xx', 'Jl. Gajah Mada No 218 Jakarta', '', '', ''),
('CS3637abb0efe8', '', 'PT. Lestari Bintang Mandiri', '', '08xx', 'Taman Kebalen Indah Blok E 1 No. 31, Kel. Kebalen Kec. Babelan Bekasi', '', '', ''),
('CS3ada8c24aa45', '', 'PT. Dreal Medika Indonesia', '', '08xx', 'Jl. Panjang No. 35, Kp. Baru Kel. Sukabumi Selatan, Kec. Kebun Jeruk - Jakarta Barat', '', '', ''),
('CS3bf639c2e738', '', 'Bapak Andi', '', '08xx', 'Jakarta', '', '', ''),
('CS3c7ece7d928f', '', 'Ibu Dany Hidayati', '', '08xx', 'Jakarta', '', '07/03/2023, 17:47', ''),
('CS3dd081cd4aec', '', 'Bapak Rumino', '', '08xx', 'Bekasi', '', '', ''),
('CS3de65564dd11', '', 'Toko Berjaya Medilab', '', '08xx', 'Jakarta', '', '', ''),
('CS3e490708d08c', '', 'Ibu Yeni', '', '08xx', 'Jakarta', '', '', ''),
('CS3e72411a5865', '', 'PT. Hana Medilab Optima', '', '08xx', 'Jl. Mayor Oking Kav no 3 RT.001 RW.002 Margahayu, Bekasi Timur Kota Bekasi', '', '', ''),
('CS3e7fcc1c206f', '', 'PT. Argo Semesta Utama', '', '08xx', 'Medan Industrial Estate , Jl. Pelita V No. D10, Kec. Tanjung Morawa Kab. Dele Sedang', '', '', ''),
('CS4030e19b12ab', '', 'YAY. RUMAH SAKIT WIDODO NGAWI', '', '08xx', 'Jl. Yos Sudarso No. 8 RT. 011 RW 001, Margomulyo. Ngawi Jawa Timur\n', '', '', ''),
('CS40774a6572e1', '', 'PT. Purwa Anugerah Setia', '', '', 'Jl. Sharom Raya Utara No 19 RT 005 RW 011 Cipamokolon Rancasari BANDUNG', '', '', ''),
('CS4081c84c70a9', '', 'Bapak Ricky', '', '08xx', 'Jakarta', '', '', ''),
('CS40e24dbe5c3a', '', 'CV. Alkautsar Aflah Mandiri', '', '08xx', 'GRAHA ALKAUTSAR, Jl. Kebahagiaan no 71, Krukut Jakarta Barat', '', '', ''),
('CS4138ada379b3', '', 'PT. Abadi Medika Indonesia', '', '', 'Ruko Sepanjang Town House Blok C No. 16, Kaluaten - Taman Sidoarjo', '', '', ''),
('CS41e8637c304a', '', 'Dany Pratama aaa', 'nay9260@gmail.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 10:10', '', ''),
('CS41f4e591204b', '', 'IBU AYU', '', '08xx', 'JAKARTA', '', '', ''),
('CS45b141ef7310', '', 'PT. STARKLIK WEB INTERNATIONAL', '', '08xx', 'Ruko Emerald Avenue 2, No. 22-23 Jl. Boulevard Bintaro Jaya Tangsel', '', '', ''),
('CS461bad0235d8', '', 'Bapak Yono ( Putra Mandiri )', '', '08xx', 'Jakarta', '', '', ''),
('CS46adbde65e5c', '', 'Ibu Berlian', '', '08xx', 'Jakarta', '', '', ''),
('CS46d88925063f', '', 'PT. Sang Timur Jaya Pratama', '', '08xx', 'Jl. Raya Pejuang Ruko Sentra Niaga Block C No. 1 RT06/07 Kel. Pejuang Kec. Medan Satria Kotas Bekasi', '', '', ''),
('CS46e6e4f0b4a0', '', 'PT. Utama Sejahtera Nusantara', '', '', 'Perumahan Griya Utama Blok K-14 Bangkalan Jawa timur', '', '', ''),
('CS47afaff20b97', '', 'PT. Sumber Murni Alkesindo', '', '', 'Komplek Pergudangan Prima Centre 1 Extension Blok F No. 36 Kedaung Kali Angke, Cengkareng Jakarta Barat', '', '', ''),
('CS48ed82e2aea8', '', 'Ibu Sri Hartati', '', '08xx', 'PR Griya Kemang Manis Blok B No. 7 RT.010 RW.003. 30 Ilir 39 Ilir Barat II Kota Palembang', '', '', ''),
('CS4a61e0b5da18', '', 'PT. Khadijah Zamzam Shafirah', '', '08xx', 'Bumi asri Dawaun B3 No. 21 A, RT 002 RW 007 Dawuan Tengah Tani Kab. Cirebon - Jawa Barat', '', '', ''),
('CS4c43505fa653', '', 'Bapak Syamsul', '', '08xx', 'Jakarta', '', '', ''),
('CS4d76de959d13', '', 'BPK AMIN', '', '08xx', 'JAKARTA', '', '', ''),
('CS4efa2965e852', '', 'Dr. Nengah', '', '08xx', 'Lampung Tengah', '', '', ''),
('CS4f9b6d48b236', '', 'Dr. HILMY', '', '08xx', 'MALANG', '', '', ''),
('CS516ee1b14f86', '', 'Ibu Erna', '', '08xx', 'Jakarta', '', '', ''),
('CS51ac96016de8', '', 'Bapak Budi Oetomo', '', '08xx', 'Gunungsari 4/45 RT. 002/001 Gunung Sari Dukuh Pakis KOTA SURABAYA', '', '', ''),
('CS52fc14c70f2a', '', 'Ibu Sumarni', '', '08xx', 'Jakarta', '', '', ''),
('CS54263e20c194', '', 'AM Medika', '', '081xx', 'Rembang', '', '', ''),
('CS54268da3ed7d', '', 'Toko Azam Medika', '', '', 'Jakarta', '', '', ''),
('CS576983dd48bf', '', 'BPK HADI', '', '08xx', 'JAKARTA', '', '', ''),
('CS598688263c92', '', 'PT. Inti Bios Persada Sejahtera', '', '08xx', 'Jl. Raya Mangga Besar Kompleks Ruko BK.002/002 Tangki, Kec. Taman Sari - Jakarta Barat', '', '', ''),
('CS5aacdabe71e9', '', 'PT. MARCOTILA MEDICA PHARMA', '', '08xx', 'Jl. Bratang Wetan 2 No. 16 Surabaya', '', '', ''),
('CS5f98b801c7d9', '', 'PT. MEDISTRA SEHAT BERJAYA', '', '08xx', 'Jl. Sapta Marga komplek Griya Modfern Blom C No. 68 Guntung Payung, Landasan Ulin Kota Banjarbaru Kalimanta Selatan', '', '', ''),
('CS6149b441703e', '', 'PT. INTERGRASTA ARTHA NUSANTARA', '', '08xx', 'Jl. T. Amir Hamzah Komp. Griya Riatur Indah Blok A No. 154 Helvetia Timur Medan Helvetia', '', '', ''),
('CS61c1f9599949', '', 'PT. Sumber Bahagia Sejahtera Abadi', '', '08xx', 'Jl. Raya Darmo No. 131-133 Wonokromo, Surabaya', '', '', ''),
('CS6711aff76169', '', 'PT. Riyani Jaya Mandiri', '', '08xx', 'Jl. Raya Galaxi No 14 B Palangka Raya', '', '', ''),
('CS673bddd0c7a9', '', 'Mitra Medika', '', '08xx', 'Bekasi', '', '', ''),
('CS686a84c42ea1', '', 'Bapak Rifky', '', '08xx', 'Bekasi', '', '', ''),
('CS69dd4ac2ced8', '', 'PT. PINTOE ACEH MEDICAL', '', '08xx', 'Jl. Teuku Umar No. 442 Banda Aceh', '', '', ''),
('CS6b583cdd769a', '', 'CV. Taida', '', '', 'Jakarta', '', '', ''),
('CS6be555c64e2e', '', 'Bapak Arip Kumianto', '', '08xx', 'Madiun', '', '', ''),
('CS6c4b40994729', '', 'PT. Cahya Intan Medika', '', '', 'Jl. Hanoman I No. 33 Sempidi, Badung - Bali', '', '', ''),
('CS6d60a9dd106a', '', 'Toko Gilang Medika', '', '08xx', 'Jakarta', '', '', ''),
('CS6d7d415977db', '', 'PT. Alkesna Albarindo Utama', '', '08xx', 'Jl. Kemanggisan Utama No. 7 A Kemanggisan Palmerah Jakarta Barat', '', '', ''),
('CS6df6a84aec98', '', 'PT. Dumedpower Indonesia', '', '08xx', 'Jl. Kramat IV No 21 Kenari - Senen Jakarta Pusat', '', '', ''),
('CS6f53cb4c5a17', '', 'BPK RISZA ESKA', '', '08xx', 'KEDIRI', '', '', ''),
('CS715bb858e5a2', '', 'BPK SUYOTO', '', '08xx', 'BEKASI', '', '', ''),
('CS734555d97681', '', 'Bapak Apriansyah', '', '08xx', 'Jakarta', '', '', ''),
('CS749bf0ef3b95', '', 'Ibu Henny', '', '08xx', 'Tanggerang', '', '', ''),
('CS75ce35bcc7c2', '', 'Bpk Guntur ', '', '08xx', 'Jakarta\n', '', '', ''),
('CS7615072add18', '', 'Bapak Darwin', '', '', 'Jl. Gajah Mada No. 219 M . Jakarta', '', '', ''),
('CS761afbf5a567', '', 'Dany Pratama ccc', 'adminkma@gmail.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 10:17', '', ''),
('CS765aead1b7f1', '', 'PT. Rima Surya Pratama', '', '08xx', 'Ruko De Green Square Perumahan Griya Persada Blok R3 No 3-5 RT.006 RW.013 Mangunjaya Tambun Selatan', '', '', ''),
('CS782264e36163', '', 'Bapak Fauzi Usman', '', '08xx', 'Jakarta', '', '', ''),
('CS799382c854af', '', 'Bapak Afis', '', '08xx', 'Jakarta', '', '', ''),
('CS7ae03bdd8f6b', '', 'Hanalab Medika', '', '08xx', 'Bekasi', '', '', ''),
('CS7afe11b1beaa', '', 'PT. Anugrah Tiga Berlian', '', '08xx', 'Jl. Pramuka No. 12 A Palmerah Matraman Jakarta Timur', '', '', ''),
('CS7bc922825e85', '', 'PT. Has Putra Harapan', '', '08xx', 'Jl. RM Soleh No. 38 RT.002 RW.008 Kel.Nagasari Kec. Karawang Barat Kab. Karawag Jawa Barat', '', '', ''),
('CS7c50d3016d30', '', 'CV. Berkah Utama Medika', '', '08xx', 'Komplek Ruko Pejuang Estate Blok P 1 No 15 Pejuang Medan Satria Kota Bekasi', '', '', ''),
('CS7d9ec5e44197', '', 'Bapak Zaki', '', '08xx', 'Bekasi', '', '', ''),
('CS7db0b4f9932e', '', 'IBU JESICA', '', '', 'JAKARTA', '', '', ''),
('CS7e043b7b878c', '', 'Bapak Rudi', '', '08xx', 'Jakarta', '', '', ''),
('CS7e6c9926dbec', '', 'Bapak Frangky', '', '08xx', 'Jakarta', '', '', ''),
('CS7fd28c1bbf00', '', 'BPK HENRY', '', '08xx', 'JAKARTA UTARA', '', '', ''),
('CS8082477c0136', '', 'Bapak Nico', '', '08xx', 'Jakarta', '', '', ''),
('CS810b550d1686', '', 'Bapak Eko ( CV. ALkesindo )', '', '08xx', 'Jakarta', '', '', ''),
('CS8226053da0cc', '', 'Bapak Sukarno', '', '08xx', 'Bekasi', '', '', ''),
('CS82f34918125a', '', 'Ibu Syifa', '', '08xx', 'Jakarta', '', '', ''),
('CS85bbe2a3e0e3', '', 'PT. Sedeka Utama Sejahtera', '', '08xx', 'Jl. Untung Surapati No 38 Ruko Krian Trade Center Kav.K Prambon Sidoarjo', '', '', ''),
('CS87919a4025b1', '', 'Ibu Lala', '', '08xx', 'Bekasi', '', '', ''),
('CS87a2d947c8f1', '', 'PT. Medika Jaya Raksa', '', '08xx', 'Pakuningratan No. 10 Cokrodiningratan Jetis Kota Yogyakarta DIY', '', '', ''),
('CS8904ba9c35b0', '', 'Bapak Budi Alex', '', '08xx', 'Jakarta', '', '', ''),
('CS890e7e56585b', '', 'Hafidz Medika', '', '08xx', 'Jakarta', '', '', ''),
('CS89dd8a6e2e9c', '', 'BPK SUJATI', '', '08xx', 'BALI', '', '', ''),
('CS8e0b1516feb9', '', 'Bapak Dede', '', '08xx', 'Jakarta', '', '', ''),
('CS8f05bd466567', '', 'Bapak Sinung Nugroho', '', '08xx', 'Yogyakarta', '', '', ''),
('CS8f5a54f9ca09', '', 'Dany Pratama', 'nay9260@gmail.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 9:47', '', ''),
('CS913d8765a530', '', 'IPUL MEDIKA', '', '08xx', 'JAKARTA', '', '', ''),
('CS94354ff3ee4b', '', 'PT. Sam Jaya Perkasa', '', '08xx', 'Jl. Pajajaran No. 123 A Bandung', '', '', ''),
('CS94f2959e689a', '', 'PT. Tri Jaya Medika', '', '08xx', 'Jl. Prapen Indah Blok E No. 12 Surabaya', '', '', ''),
('CS95fc2dbf2e71', '', 'Bapak Anyit', '', '08xx', 'Jakarta', '', '', ''),
('CS9a25978779a8', '', 'Ibu Evi', '', '08xx', 'Jakarta', '', '', ''),
('CS9dcde1fd3aa8', '', 'Toko Kafa Medika', '', '08xx', 'Jl. Magelang KM 14 Timur RSUD Sleman, Kec. Sleman , Sleman Yogyakarta', '', '', ''),
('CS9e034129d776', '', 'CV. Anugerah Karya Mandiri', '', '08xx', 'Jl. Bhakti No 46 RT.008 RW.002, Tegal Alur Kali Deres Jakarta Barat', '', '', ''),
('CSa0c488c9498a', '', 'Ibu Sulina', '', '08xx', 'Jakarta', '', '', ''),
('CSa203902a7f30', '', 'GANI MEDIKA', '', '08xx', 'JAKARTA', '', '', ''),
('CSa41b4e5b1f2c', '', 'PT. NUSAMED MEGA HASTOSA', '', '08xx', 'Komplek Padaasih Regency C 5 . Jl. Babakan Muncang Kidul , Padaasih, Cisarua, Kab. Bandung Barat 40553', '', '', ''),
('CSa43d7364d18e', '', 'Bapak Guntur ( AM Medika )', '', '08xx', 'Jakarta', '', '', ''),
('CSa4a6c9a6bc7c', '', 'Marisi Medika', '', '08xx', 'Jakarta', '', '', ''),
('CSa8a225385ab9', '', 'Ghani Medika', '', '08xx', 'Jakarta', '', '', ''),
('CSa952f751f3a4', '', 'Ibu Dely', '', '08xx', 'Makassar', '', '', ''),
('CSac274bb25fad', '', 'Ibu Yuniar', '', '08xx', 'Lampung', '', '', ''),
('CSacbf5e3f81e6', '', 'PT. Amalia Arafah Utama', '', '', 'Jl. Taman Narogong Indah Raya No. 12 Taman Narogong Indah Bekasi', '', '', ''),
('CSad3539021dad', '', 'PT. Murni Putra Lang', '', '08xx', 'Langlang RT 11 RW 04, Kel. Langlang, Kec. Singosari, Kab Malang Singosari, Kab Malang', '', '', ''),
('CSad6440768833', '', 'Bapak Haryanto', '', '08xx', '  Jakarta', '', '', ''),
('CSad9cf6d2d3f8', '', 'Dr. Lisa', '', '08xx', 'MAKASSAR', '', '', ''),
('CSae3d079a29e5', '', 'Herry Medika', '', '08xx', 'Jakarta', '', '', ''),
('CSae997f4e4a33', '', 'Ibu Siska', '', '08xx', 'Jakarta', '', '', ''),
('CSaecbc3e712c3', '', 'Bapak Richard Christian', '', '-', 'Jl. Pajajaran No. 15 Babakan Ciamis Suur - Bandung', '', '', ''),
('CSb482f374a3ff', '', 'PT. Airlangga Jaya Mandiri', '', '08xx', 'Ruko Sentra Niaga . Jl. Raya Pejuang Jaya Blok C No. 7 RT 006 RW 007, Pejuang, Kota Bekasi', '', '', ''),
('CSb62835b09fd3', '', 'Dany Pratama sss', 'nay9260@gmail.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 9:51', '', ''),
('CSb678b686b3d0', '', 'Bapak Yadi', '', '08xx', 'Jakarta', '', '', ''),
('CSbb42582596d0', '', 'Bapak Tono', '', '08xx', 'Jakarta', '', '', ''),
('CSbbe9e763f2da', '', 'PT. Ranaru Solusindo Industri', '', '08xx', 'KP. Tambun Permata Blok 000 No, 30 RT.002 RW.011 Kel.Pusaka Rakyat Kec.Taruma Jaya Kab. Bekasi Jawa Barat', '', '', ''),
('CSbbf34bcbc3d1', '', 'PT. AGRO PRIMALAB INDONESIA', '', '08xx', 'Jl. Raya Sawangan Ruko CBD No. 14 RT 001 RW 11 Mampang Pancoran Mas Depok Jawa Barat', '', '', ''),
('CSbc57b7b8c1f3', '', 'Bapak Awen', '', '08xx', 'Bekasi', '', '', ''),
('CSbddb2f91bc96', '', 'Bapak Marcel', '', '', 'Jakarta', '', '', ''),
('CSbf6b26e3c8a5', '', 'Bapak Yanuar', '', '08xx', 'Semarang', '', '', ''),
('CSc0807a08be0e', '', 'PT.  Jasa Prima Adiguna', '', '08xx', 'Jl. Utan Kayu Raya No. 20A RT.009 RW 002, Jakarta Timur Jakarta Timur', '', '', ''),
('CSc1b8a62d22b5', '', 'Ibu Lan Lan', '', '08xx', 'Jakarta', '', '', ''),
('CSc99b9f0aed79', '', 'PT. Antagena Dwi Medika', '', '08xx', 'Gedung Agnesia, Ruang 603. Jl. Pemuda No. 73B RT.002/006 Jati, Pulo Gadung Jakarta', '', '', ''),
('CSc9f214898df7', '', 'Ibu Tri Bangun Asih', '', '08xx', 'Jakarta', '', '', ''),
('CSced57ee3820c', '', 'BPK APIT', '', '08xx', 'BEKASI', '', '', ''),
('CSd2d911c25794', '', 'CV. Cakrawala Persada', '', '08xx', 'Jl. Cilemahabang Blok Q3 No 65 Cikarang baru Jababeka 2, Cikarang', '', '', ''),
('CSd3b2390cc4fa', '', 'Augustinus Zega', '', '08xx', 'Jakarta', '', '', ''),
('CSd4c176869f1e', '', 'Ibu Magdalena', '', '08xx', 'Makassar', '', '', ''),
('CSd4f8fa6d0797', '', 'BPK SUPRI', '', '08xx', 'JAKARTA', '', '', ''),
('CSd65596d4abcd', '', 'TOKO ASME', '', '08xx', 'CIKARANG', '', '', ''),
('CSd7894a77e605', '', 'PT. Ersa Prima Medika', '', '08xx', 'Jl. Gatot Subroto IV/6X Denpasar', '', '', ''),
('CSd9c9184b7e04', '', 'Bapak Nana', '', '08xx', 'Jakarta', '', '', ''),
('CSdaeba45be96e', '', 'Ibu Momoy', '', '08xx', 'Jakarta', '', '', ''),
('CSdd0e9dc8f2ad', '', 'PT. SUMBER ZHAFRAN ABADI', '', '08xx', 'Perumahan Bumi Kaliwates, Jl. Nusantara Blok GE-7, Kel. Kaliwates Kec. Kaliwates Kabupaten Jember.', '', '', ''),
('CSdd51709d6f83', '', 'CV. Pudak Scientific', '', '08xx', 'Jl. Pudak No. 2-4 BANDUNG', '', '', ''),
('CSdd82f9b382ee', '', 'Dany Pratama SS', 'nay9260@gmail.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 9:49', '', ''),
('CSdd8b62345135', '', 'Bapak Romadani', '', '08xx', 'Lampung', '', '', ''),
('CSdf19a17f0f13', '', 'Ibu Lia ( Glory )', '', '', 'Jakarta', '', '', ''),
('CSe1c0c8d32b9d', '', 'Dr. Maulia Mardani, SPOG, MARS', '', '08xx', 'Jl. Raya Bungur Sari No. 36 Sadang - Purwakarta , Jawa Barat', '', '', ''),
('CSe3cae7b236c3', '', 'Ibu Maria Linggiarty JD', '', '08xx', 'Jl. Biliton No 81, Gubeng Surabaya', '', '', ''),
('CSe45d57b239e9', '', 'PT. Sarana Bani Medical', '', '', 'Jl. Pabuaran RT 005 RW 005 Dayeuhluhur, Warudoyong Kota Sukabumi Jawa Barat', '', '', ''),
('CSe624c8e7d88f', '', 'Leo Medika', '', '08xx', 'Jakarta', '', '', ''),
('CSe647da081cc0', '', 'PT. Karunia Lentera Abadi', '', '08xx', 'Jl. Taman Sari 1 B No. 39 C RT. 008 RW. 001 Maphar JAKARTA PUSAT', '', '', ''),
('CSe7e5b8ed915a', '', 'Bagus Medika', '', '08xx', 'Jakarta', '', '', ''),
('CSea170598556a', '', 'Medika Aneka', '', '08xx', 'Jakarta', '', '', ''),
('CSebae6a1543f6', '', 'BPK DIKA', '', '08xx', 'BEKASI', '', '', ''),
('CSec96ce95b05f', '', 'Bapak Aris', '', '', 'Jakarta', '', '', ''),
('CSecdb51a53305', '', 'PT. Anugerah Intan Medika', '', '', 'Pugeran MJ2/11 Yokyakarta', '', '', ''),
('CSedc9ebe7a7a8', '', 'UD. Prima Alkes', '', '', 'Jl. Dr. Mansur No. 28. Merdeka, Medan Baru. Kota Medan', '', '', ''),
('CSedf583e3998c', '', 'PT. ALMAS BORNEO JAYA', '', '08xx', ' Jl. Tanjung Raya II, Komp. Cendana Permai I A. 14. Pontianak - Kalimantan Barat ', '', '', ''),
('CSee1fe6c963ed', '', 'CV. Mastha Medika Usaha', '', '08xx', 'Sutorejo Utara Gang XI No 11 Dukuh Sutorejo Mulyorejo Kota Surabaya - Jawa Timur', '', '', ''),
('CSee6389fe37cb', '', 'Bapak Lutfy', '', '08xx', 'Depok', '', '', ''),
('CSefea950b00a9', '', 'Bapak Andika Agustoni', '', '08xx', 'Lampung', '', '', ''),
('CSf0bcfad87d8c', '', 'Dany Pratama b', 'adminkma@inventory.com', '085xxx', 'Karawang, Jawa Barat, Indonesia', '10/07/2023, 10:12', '', ''),
('CSf18284d2dda2', '', 'PT. HANESA UNGGUL MEDIKA', '', '08xx', 'Jl. Karya Baru No. 2 RT.004 RW.003 Partittokaya Pontianakn Selatan Kota Pontianak.\n', '', '', ''),
('CSf209d4f31d44', '', 'CV. Sagung Seto', '', '08xx', 'Jl. Pramuka No 27 Jakarta', '', '', ''),
('CSf268eb200509', '', 'PT. Medical Solution Indonesia', '', '08xx', 'Jl. Taman Makam Pahlawan No. 15 RT.000 RW.000 Telo Baru Panakkukang Makassar Selatan', '', '', ''),
('CSf315154b6f16', '', 'Bapak Eka', '', '08xx', 'Jakarta', '', '', ''),
('CSf3efb76da974', '', 'PT. Bintang Lima Medica', '', '08xx', 'Jl. Bau Mahmud No. 73 Sengkang Kab. Wajo Sulawesi Selatan	', '', '', ''),
('CSf4b0d946c0c1', '', 'PT. Duta Adyaksa Pratama', '', '08xx', 'Lebak Indah Blok B3 No. 168 Trondol Kota Serang', '', '', ''),
('CSf63ee42ff076', '', 'UD. Dimensi Alkes Brawijaya', '', '08xx', 'Mojokerto', '', '', ''),
('CSf675e5dbea2b', '', 'CV. Intraco', '', '', 'Jl. Gunung Latimojong No. 128 Makassar', '', '', ''),
('CSf8a046d4feb1', '', 'Bapak Yono', '', '', 'Jakarta', '', '', ''),
('CSf916d0a37079', '', 'PT. Guittara Mahakarya Medika', '', '', 'Grand Galaxy City Ruko Sentra Niaga Blok RSN 5 No. 20 RT.001/RW.005 Jaka Setia Bekasi Selatan', '', '', ''),
('CSf97899eeef86', '', 'PT. SAMUDRA ESTETIKA PERKASA', '', '08xx', 'Rukan Grand Aries Niaga, Jl. Taman Aries Raya Blok E1 No. 5Q Meruya Utara, Kembangan - Jakarta Barat', '', '', ''),
('CSf9bb08f33542', '', 'Toko Fathan', '', '08xx', 'Jakarta', '', '', ''),
('CSfaea1025f5ef', '', 'PT. BINTANG MANDIRI MEDICA', '', '08xx', 'Jl. Diponegoro RT.012 Kampung Baru Kelurahan Majidi Selong Lombok Timur 83612\n', '', '', ''),
('CSfba4b0740c96', '', 'PT. Bumi Indah Sarana Medis', '', '08xx', 'Graha Bumi Indah, Jl. Raya Kali Malang, Kav Agraria No 10 Kel, Duren Sawit Kec. Duren Sawit Jakarta Timur', '', '', ''),
('CSfc057a6ac6d0', '', 'Ibu Debi', '', '', 'Jakarta', '', '', ''),
('CSfe5c0ef98ad5', '', 'PT. Amora Luhur Kumari', '', '08xx', 'Jl. Pramuka No 12 A RT 011 RW 001 Palmerah Matraman Jakarta Timur', '', '', ''),
('CSfea5191fe2e1', '', 'Toko Alkes', '', '08xx', 'Mojokerto', '', '', ''),
('CSff4e1a9f38c2', '', 'PT. Arnetha', '', '08xx', 'Kawasan Ruko Patra Park Blok C No. 10 Jl. Tuparev Sutiwinagin Kedawung Kab. Cirebon Jawa barat', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kat_penjualan`
--

CREATE TABLE `tb_kat_penjualan` (
  `id_kat_penjualan` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `min_stock` int(11) NOT NULL,
  `max_stock` int(11) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kat_penjualan`
--

INSERT INTO `tb_kat_penjualan` (`id_kat_penjualan`, `id_user`, `nama_kategori`, `min_stock`, `max_stock`, `created_date`, `updated_date`, `user_updated`) VALUES
('KATPENJ64328641f032', 'USER47100114a730', 'Fast Market ', 1000, 50000, '23/05/2023, 10:25', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kat_produk`
--

CREATE TABLE `tb_kat_produk` (
  `id_kat_produk` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL,
  `id_merk` varchar(50) NOT NULL,
  `no_izin_edar` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_kat_produk`
--

INSERT INTO `tb_kat_produk` (`id_kat_produk`, `id_user`, `nama_kategori`, `id_merk`, `no_izin_edar`, `created_date`, `updated_date`, `user_updated`) VALUES
('KATPROD2ec542dacb2a', 'USER47100114a730', 'Surgical Instrument', 'MERK2ce36179b1d3', '2121231313131313', '23/05/2023, 10:18', '', ''),
('KATPROD4e8e83106dc2', 'USER34e2f73c9751', 'iud', 'MERK36d48fe7aff0', 'AKL12548621', '26/05/2023, 15:46', '', ''),
('KATPROD536974b61951', 'USER03595a8447ab', 'Operating Scissors - Saffa', '', '1111111', '23/05/2023, 11:44', '', ''),
('KATPRODada57ad8f3e1', 'USER47100114a730', 'Operating Scissors - Saffa', 'Marwa', '212123131313188', '23/05/2023, 10:18', '23/05/2023, 11:42', 'USER03595a8447ab'),
('KATPRODef22e44d1e27', 'USER47100114a730', 'SS', 'MERK2ce36179b1d3', '2121231313131313', '23/05/2023, 10:15', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lokasi_produk`
--

CREATE TABLE `tb_lokasi_produk` (
  `id_lokasi` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_lokasi` varchar(50) NOT NULL,
  `no_lantai` varchar(10) NOT NULL,
  `nama_area` varchar(50) NOT NULL,
  `no_rak` varchar(25) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_lokasi_produk`
--

INSERT INTO `tb_lokasi_produk` (`id_lokasi`, `id_user`, `nama_lokasi`, `no_lantai`, `nama_area`, `no_rak`, `created_date`, `updated_date`, `user_updated`) VALUES
('LOK172cba11ee8d', 'USER03595a8447ab', 'P1-15', '1', 'Surgical', '12', '', '', ''),
('LOK2f313907fa89', 'USER34e2f73c9751', 'kma ', '3', 'IUD', '45', '26/05/2023, 15:48', '', ''),
('LOK5a52042305bc', 'USER03595a8447ab', 'kma ', '2', 'Forceps', '1-1', '15/03/2023, 17:04', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_merk`
--

CREATE TABLE `tb_merk` (
  `id_merk` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_merk` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_merk`
--

INSERT INTO `tb_merk` (`id_merk`, `id_user`, `nama_merk`, `created_date`) VALUES
('MERK2ce36179b1d3', 'USER03595a8447ab', 'Saffa', '11/03/2023, 17:57'),
('MERK36d48fe7aff0', 'USER03595a8447ab', 'Marwa', '13/03/2023, 11:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_orderby`
--

CREATE TABLE `tb_orderby` (
  `id_orderby` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `order_by` varchar(20) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_orderby`
--

INSERT INTO `tb_orderby` (`id_orderby`, `id_user`, `order_by`, `created_date`) VALUES
('ORDERa55599e088ce', 'USER47100114a730', 'Email', '24/05/2023, 16:52'),
('ORDERe51d8b7e2db9', 'USER03595a8447ab', 'Whatsapp', '24/05/2023, 16:30');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_produk_grade`
--

CREATE TABLE `tb_produk_grade` (
  `id_grade` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_grade` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_produk_grade`
--

INSERT INTO `tb_produk_grade` (`id_grade`, `id_user`, `nama_grade`, `created_date`) VALUES
('GRADE51ee38cc29ad', 'USER03595a8447ab', 'Reguler', '15/03/2023, 16:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_produk_reguler`
--

CREATE TABLE `tb_produk_reguler` (
  `id_produk_reg` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_merk` varchar(50) NOT NULL,
  `id_kat_produk` varchar(50) NOT NULL,
  `id_kat_penjualan` varchar(50) NOT NULL,
  `id_grade` varchar(50) NOT NULL,
  `id_lokasi` varchar(50) NOT NULL,
  `kode_produk` varchar(50) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `updated_date` varchar(25) NOT NULL,
  `user_updated` varchar(25) NOT NULL,
  `register_value` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_produk_reguler`
--

INSERT INTO `tb_produk_reguler` (`id_produk_reg`, `id_user`, `id_merk`, `id_kat_produk`, `id_kat_penjualan`, `id_grade`, `id_lokasi`, `kode_produk`, `nama_produk`, `harga_produk`, `gambar`, `created_date`, `updated_date`, `user_updated`, `register_value`) VALUES
('BR-REG5036d872cb87', 'USER03595a8447ab', 'MERK36d48fe7aff0', 'KATPROD2ec542dacb2a', 'KATPENJ64328641f032', 'GRADE51ee38cc29ad', 'LOK172cba11ee8d', 'M-DF14', 'Thumb Dressing Forceps 14 cm', 7500, 'IMG64885d330a1d4.jpg', '13/06/2023, 19:12', '', '', 1),
('BR-REG835084308577', 'USER03595a8447ab', 'MERK2ce36179b1d3', 'KATPROD2ec542dacb2a', 'KATPENJ64328641f032', 'GRADE51ee38cc29ad', 'LOK5a52042305bc', 'M-DF18', 'Thumb Dressing Forceps 18 cm', 15000, 'IMG64885d926c87d.jpg', '13/06/2023, 19:14', '', '', 1),
('BR-REG9b682f3c5838', 'USER03595a8447ab', 'MERK2ce36179b1d3', 'KATPROD2ec542dacb2a', 'KATPENJ64328641f032', 'GRADE51ee38cc29ad', 'LOK5a52042305bc', 'M-COTTON_PLIER', 'Meriam Cotton Plier 16 cm', 10000, 'IMG64885d6e66c3d.jpg', '13/06/2023, 19:13', '', '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_produk_set_marwa`
--

CREATE TABLE `tb_produk_set_marwa` (
  `id_set_marwa` varchar(50) NOT NULL,
  `kode_set_marwa` varchar(50) NOT NULL,
  `nama_set_marwa` varchar(80) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_lokasi` varchar(50) NOT NULL,
  `id_merk` varchar(50) NOT NULL,
  `harga_set_marwa` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_produk_set_marwa`
--

INSERT INTO `tb_produk_set_marwa` (`id_set_marwa`, `kode_set_marwa`, `nama_set_marwa`, `id_user`, `id_lokasi`, `id_merk`, `harga_set_marwa`, `stock`, `created_date`, `updated_date`, `user_updated`) VALUES
('SETMRW608112486bb9', '001', 'Minor', 'USER03595a8447ab', 'LOK172cba11ee8d', 'MERK2ce36179b1d3', 30000, 2, '23/05/2023, 17:11', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_sales`
--

CREATE TABLE `tb_sales` (
  `id_sales` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_sales` varchar(30) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_sales`
--

INSERT INTO `tb_sales` (`id_sales`, `id_user`, `nama_sales`, `no_telp`, `created_date`) VALUES
('SL1bb8c1f9e592', 'USER03595a8447ab', 'Agung', '08111', '24/05/2023, 14:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id_sp` varchar(25) NOT NULL,
  `id_user` varchar(25) NOT NULL,
  `nama_sp` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `alamat` varchar(150) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `updated_date` varchar(25) NOT NULL,
  `user_updated` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_sp`, `id_user`, `nama_sp`, `no_telp`, `alamat`, `created_date`, `updated_date`, `user_updated`) VALUES
('SP0d8111e5dcf6', '', 'Sulina', '08xxxx', 'Jakarta', '06/03/2023, 2:59', '', ''),
('SP1407504e42bd', '', 'Patwal Surgical', '081xxxxx', 'Pakistan', '08/03/2023, 13:55', '08/03/2023, 13:58', ''),
('SP5d25a18a4094', '', 'Permanent Medical', '081xx', ' Pakistan ', '', '', ''),
('SP75d3d772951e', '', 'China Alibaba', '0xxxx', 'China', '', '10/03/2023, 9:16', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tmp_produk_spk`
--

CREATE TABLE `tmp_produk_spk` (
  `id_tmp` varchar(50) NOT NULL,
  `id_spk` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `status_tmp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `tmp_produk_spk`
--
DELIMITER $$
CREATE TRIGGER `add_tmp` AFTER INSERT ON `tmp_produk_spk` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - NEW.qty 
WHERE id_produk_reg = NEW.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_tmp` BEFORE DELETE ON `tmp_produk_spk` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty 
WHERE id_produk_reg = OLD.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_tmp` AFTER UPDATE ON `tmp_produk_spk` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty - NEW.qty
WHERE id_produk_reg = NEW.id_produk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_produk_reg`
--

CREATE TABLE `transaksi_produk_reg` (
  `id_transaksi` varchar(50) NOT NULL,
  `id_spk` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `nama_produk_spk` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `disc` decimal(3,1) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_trx` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi_produk_reg`
--

INSERT INTO `transaksi_produk_reg` (`id_transaksi`, `id_spk`, `id_produk`, `nama_produk_spk`, `harga`, `qty`, `disc`, `total_harga`, `status_trx`, `created_date`) VALUES
('TRX-2308173359b549f913', 'SPKREG-23089d7623db760213', 'BR-REG835084308577', 'Thumb Dressing Forceps 18 cm', 18000, 50, 0.0, 900000, 1, '2023-08-13 15:40:32'),
('TRX-23083d950a53939415', 'SPKREG-2308c6c7c91c3b5215', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 7500, 100, 0.0, 750000, 1, '2023-08-15 16:27:43'),
('TRX-23084e0d4ec8ef7a14', 'SPKREG-2308d524347b997614', 'BR-REG835084308577', 'Thumb Dressing Forceps 18 cm', 15000, 100, 0.0, 1500000, 1, '2023-08-14 08:37:33'),
('TRX-23086545165fd73514', 'SPKREG-230845183c89f76c14', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 7500, 50, 0.0, 375000, 1, '2023-08-14 08:41:06'),
('TRX-230867494b9e5e3913', 'SPKREG-23089d7623db760213', 'BR-REG9b682f3c5838', 'Meriam Cotton Plier 16 cm', 14000, 50, 0.0, 700000, 1, '2023-08-13 15:40:32'),
('TRX-2308724aa8883a0214', 'SPKREG-230845183c89f76c14', 'BR-REG835084308577', 'Thumb Dressing Forceps 19 cm', 17000, 50, 0.0, 850000, 1, '2023-08-14 08:41:06'),
('TRX-2308742e0e3c025013', 'SPKREG-2308878a39202e4113', 'BR-REG9b682f3c5838', 'Meriam Cotton Plier 17 cm', 12000, 50, 0.0, 600000, 1, '2023-08-13 15:21:25'),
('TRX-23087d24a5d8058c14', 'SPKREG-2308d524347b997614', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 8500, 100, 0.0, 850000, 1, '2023-08-14 08:37:33'),
('TRX-2308b8e67bc28ab913', 'SPKREG-2308878a39202e4113', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 7500, 100, 0.0, 750000, 1, '2023-08-13 15:21:25'),
('TRX-2308c5a661e04aed15', 'SPKREG-2308930965c5245b15', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 7500, 100, 0.0, 750000, 1, '2023-08-15 16:34:11'),
('TRX-2308c87ce6b5454e13', 'SPKREG-23081a8ce1fb680713', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 7500, 50, 0.0, 375000, 1, '2023-08-13 15:50:34'),
('TRX-2308d13ac807ced513', 'SPKREG-23081a8ce1fb680713', 'BR-REG835084308577', 'Thumb Dressing Forceps 17 cm', 14000, 100, 0.0, 1400000, 1, '2023-08-13 15:50:34'),
('TRX-2308e064bf1df52615', 'SPKREG-230824c894fd93ac15', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 7500, 200, 0.0, 1500000, 1, '2023-08-15 16:31:22'),
('TRX-2308e1926bc7daf914', 'SPKREG-23088dc84b98639414', 'BR-REG835084308577', 'Thumb Dressing Forceps 18 cm', 15000, 100, 0.0, 1500000, 1, '2023-08-14 11:08:03'),
('TRX-2308e9b51e06ea0114', 'SPKREG-23088dc84b98639414', 'BR-REG5036d872cb87', 'Thumb Dressing Forceps 14 cm', 7500, 100, 0.0, 750000, 1, '2023-08-14 11:08:03');

--
-- Trigger `transaksi_produk_reg`
--
DELIMITER $$
CREATE TRIGGER `add_trx_prod_reg` AFTER INSERT ON `transaksi_produk_reg` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - NEW.qty 
WHERE id_produk_reg = NEW.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_trx_prod_reg` AFTER DELETE ON `transaksi_produk_reg` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty 
WHERE id_produk_reg = OLD.id_produk;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `edit_trx_prod_reg` AFTER UPDATE ON `transaksi_produk_reg` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty - NEW.qty
WHERE id_produk_reg = NEW.id_produk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_produk_sph`
--

CREATE TABLE `transaksi_produk_sph` (
  `id_transaksi` varchar(50) NOT NULL,
  `id_sph` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `nama_produk_sph` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `trx_cancel`
--

CREATE TABLE `trx_cancel` (
  `id_trx_cancel` varchar(50) NOT NULL,
  `id_spk` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `disc` decimal(3,1) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_set_marwa`
--

CREATE TABLE `tr_set_marwa` (
  `id_tr_set_marwa` varchar(50) NOT NULL,
  `id_set_marwa` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tr_set_marwa`
--

INSERT INTO `tr_set_marwa` (`id_tr_set_marwa`, `id_set_marwa`, `qty`, `id_user`, `created_date`) VALUES
('TR-SET-MRW-2323ee30974ea95c05', 'SETMRW608112486bb9', 2, 'USER03595a8447ab', '23/05/2023, 17:15');

--
-- Trigger `tr_set_marwa`
--
DELIMITER $$
CREATE TRIGGER `add_set_marwa` AFTER INSERT ON `tr_set_marwa` FOR EACH ROW BEGIN
UPDATE tb_produk_set_marwa
SET stock = stock + NEW.qty 
WHERE id_set_marwa = NEW.id_set_marwa;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_set_marwa` AFTER DELETE ON `tr_set_marwa` FOR EACH ROW BEGIN
UPDATE tb_produk_set_marwa 
SET stock = stock - OLD.qty 
WHERE id_set_marwa = OLD.id_set_marwa;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tr_set_marwa_isi`
--

CREATE TABLE `tr_set_marwa_isi` (
  `id_tr_set_marwa_isi` varchar(50) NOT NULL,
  `id_tr_set_marwa` varchar(50) NOT NULL,
  `id_set_marwa` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tr_set_marwa_isi`
--

INSERT INTO `tr_set_marwa_isi` (`id_tr_set_marwa_isi`, `id_tr_set_marwa`, `id_set_marwa`, `id_produk_reg`, `qty`, `id_user`, `created_date`) VALUES
('TR-ISI-SET-MRW-2323dac079f3086805', 'TR-SET-MRW-2323ee30974ea95c05', 'SETMRW608112486bb9', 'BR-REG6d4d12f6c304', 2, 'USER03595a8447ab', '23/05/2023, 17:15'),
('TR-ISI-SET-MRW-2323ee30974ea95c05', 'TR-SET-MRW-2323ee30974ea95c05', 'SETMRW608112486bb9', 'BR-REGffb0b62a09cf', 2, 'USER03595a8447ab', '23/05/2023, 17:15');

--
-- Trigger `tr_set_marwa_isi`
--
DELIMITER $$
CREATE TRIGGER `add_set_marwa_isi` AFTER INSERT ON `tr_set_marwa_isi` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock - NEW.qty
WHERE id_produk_reg = NEW.id_produk_reg;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `del_set_marwa_isi` AFTER DELETE ON `tr_set_marwa_isi` FOR EACH ROW BEGIN
UPDATE stock_produk_reguler 
SET stock = stock + OLD.qty
WHERE id_produk_reg = OLD.id_produk_reg;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` char(20) NOT NULL,
  `id_user_role` char(20) NOT NULL,
  `nama_user` varchar(30) NOT NULL,
  `jenkel` varchar(15) NOT NULL,
  `email` varchar(75) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(300) NOT NULL,
  `created_date` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `id_user_role`, `nama_user`, `jenkel`, `email`, `username`, `password`, `created_date`) VALUES
('USER01d72c9a0aa8', 'RL65ac1af47ca0', 'Hana Febriyanti', 'Perempuan', 'adminkma@inventory.com', 'hana', '$2y$10$uMTQoAngEi9h7j2tKqt3jOnIrOlGG5KEEmown/YQ4d4h0RDOUVKcy', '20/07/2023, 13:33'),
('USER03595a8447ab', 'RL98cb89863ece', 'Dany Pratama Saputro', 'Laki-Laki', 'pratamadany87@gmail.com', 'dany_pratama', '$2y$10$2SooH9kLwLo.fcVq9yXOAOljSTfX2zFG4eUs7IKMPBhv.2Ec/jYEm', '07/03/2023, 9:32'),
('USER34e2f73c9751', 'RL98cb89863ece', 'Abidah', 'Perempuan', 'abidah@gmail.com', 'Abidah', '$2y$10$BtF3UJG/S.HBJ1W.TaPy8OwxO3ry15ctjzaPhipHVK8eQv8lr0DTO', '23/05/2023, 17:27'),
('USER388732b31872', 'RLe89c2734a09d', 'Teguh Pambudi', 'Laki-Laki', 'driverkma@gmail.com', 'Teguh', '$2y$10$.HfaVqdg5zUOohlqVm1YKerAL.pKKQ5UXbelX3z0kMSCWaZ77/PS6', '20/06/2023, 11:20'),
('USER47100114a730', 'RLf278f224eb37', 'Paijo', 'Laki-Laki', 'firmansyahas@hotmail.com', 'Firmansyah13', '$2y$10$GdptgMT/.caxIDdPzmCltuSXcg43nQweyPuJELUaW7dooM.pD/JxG', '07/03/2023, 9:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_history`
--

CREATE TABLE `user_history` (
  `id_history` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `login_time` varchar(20) NOT NULL,
  `logout_time` varchar(20) NOT NULL,
  `ip_login` varchar(30) NOT NULL,
  `perangkat` varchar(150) NOT NULL,
  `jenis_perangkat` varchar(10) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `status_perangkat` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_history`
--

INSERT INTO `user_history` (`id_history`, `id_user`, `login_time`, `logout_time`, `ip_login`, `perangkat`, `jenis_perangkat`, `lokasi`, `status_perangkat`) VALUES
('HIS0032debdef12', 'USER47100114a730', '06/06/2023 17:51:52', '', '110.138.89.254', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HIS0067aa877a20', 'USER03595a8447ab', '03/06/2023 10:13:40', '', '110.138.83.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS007b8bf78b14', 'USER01d72c9a0aa8', '12/08/2023 10:01:14', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS020232e26d8b', 'USER03595a8447ab', '25/07/2023 11:25:22', '2023/07/25 16:07:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS0406bcd8995f', 'USER34e2f73c9751', '25/05/2023 8:03:20', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS041e4a1b2526', 'USER01d72c9a0aa8', '24/07/2023 14:56:11', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS0705ffe81dfc', 'USER03595a8447ab', '06/07/2023 17:26:18', '2023/07/06 19:02:45', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS0774fbbfd9d9', 'USER01d72c9a0aa8', '24/07/2023 14:53:14', '2023/07/24 14:55:47', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS07e3a3adf44c', 'USER47100114a730', '02/06/2023 6:20:39', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HIS084205045b54', 'USER03595a8447ab', '05/07/2023 10:19:04', '2023/07/05 16:28:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS08476a9df045', 'USER01d72c9a0aa8', '22/07/2023 11:46:31', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS08e7f23915ec', 'USER03595a8447ab', '28/07/2023 8:39:20', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS0b9b4c9748f3', 'USER03595a8447ab', '28/07/2023 8:21:19', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS0be4dcae2c22', 'USER47100114a730', '23/05/2023 11:20:45', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS0c39db619af4', 'USER01d72c9a0aa8', '01/08/2023 22:10:25', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS0c9bf8904476', 'USER01d72c9a0aa8', '20/07/2023 13:33:55', '2023/07/20 13:34:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS0ce5bd42e9d1', 'USER01d72c9a0aa8', '09/08/2023 9:22:13', '2023/08/09 10:23:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS0d3b834789c6', 'USER47100114a730', '02/06/2023 17:32:03', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HIS0d3b8ac4f214', 'USER03595a8447ab', '10/06/2023 13:06:59', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS0ef8b904614c', 'USER03595a8447ab', '17/06/2023 9:26:13', '2023/06/17 10:58:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS0fff3c23f0ca', 'USER01d72c9a0aa8', '01/08/2023 9:00:10', '2023/08/01 22:10:17', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS1013e6e598e5', 'USER01d72c9a0aa8', '12/08/2023 15:46:50', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS1188230972f0', 'USER03595a8447ab', '08/08/2023 9:32:33', '2023/08/08 16:41:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS11c23651892a', 'USER03595a8447ab', '12/06/2023 10:24:20', '2023/06/12 10:27:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS130abc404849', 'USER34e2f73c9751', '26/05/2023 9:35:24', '', '110.138.92.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS13835fb22f66', 'USER03595a8447ab', '25/07/2023 16:07:54', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS1433744e3f20', 'USER47100114a730', '23/05/2023 10:14:26', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS163f8fd07c90', 'USER01d72c9a0aa8', '14/08/2023 8:31:13', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS18a9956e557e', 'USER03595a8447ab', '07/06/2023 8:36:27', '2023/06/07 9:24:46', '125.160.234.251', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Offline'),
('HIS197edeca5663', 'USER47100114a730', '25/05/2023 9:00:48', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS1b59ca0e9407', 'USER03595a8447ab', '16/06/2023 19:04:55', '2023/06/16 20:11:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS1d1b71f55e95', 'USER03595a8447ab', '11/08/2023 9:48:22', '2023/08/11 16:27:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS1f3674dedc84', 'USER01d72c9a0aa8', '28/07/2023 9:36:17', '2023/07/28 17:31:05', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS1f426a396163', 'USER03595a8447ab', '21/07/2023 13:08:50', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS1f982dd2f54d', 'USER47100114a730', '06/06/2023 17:51:52', '', '110.138.89.254', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HIS202a49ceed9e', 'USER01d72c9a0aa8', '05/08/2023 11:44:25', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS20fc8565c142', 'USER01d72c9a0aa8', '24/07/2023 14:37:45', '2023/07/24 14:52:02', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS20feb108b5be', 'USER03595a8447ab', '22/07/2023 11:21:31', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS210c0aee7b91', 'USER03595a8447ab', '26/07/2023 8:36:52', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS249c96a6e898', 'USER03595a8447ab', '21/07/2023 8:06:40', '2023/07/21 13:08:48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS26c340adec2a', 'USER47100114a730', '25/05/2023 13:06:02', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS271f18346e12', 'USER03595a8447ab', '22/06/2023 15:52:29', '2023/06/22 16:26:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS28d3de1dc028', 'USER03595a8447ab', '23/05/2023 17:05:40', '', '180.244.166.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS29b311fe4481', 'USER01d72c9a0aa8', '28/07/2023 9:09:17', '2023/07/28 9:22:24', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS2a6955dc58d6', 'USER03595a8447ab', '04/07/2023 16:19:05', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS2a6fe5397866', 'USER03595a8447ab', '22/06/2023 8:20:17', '2023/06/22 10:23:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS2b8ff841f392', 'USER03595a8447ab', '17/06/2023 11:33:11', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS2cdfddbfb83f', 'USER03595a8447ab', '19/06/2023 15:11:46', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS2e965651e7f5', 'USER01d72c9a0aa8', '13/08/2023 13:21:58', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS3064654298d9', 'USER03595a8447ab', '03/07/2023 15:58:35', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS3117a0654f8c', 'USER03595a8447ab', '19/06/2023 8:06:00', '2023/06/19 13:08:55', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS31d788a630f9', 'USER03595a8447ab', '03/07/2023 13:06:20', '2023/07/03 13:46:07', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS321f6eca4acc', 'USER01d72c9a0aa8', '13/08/2023 0:49:22', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS32b8ed2fb77c', 'USER01d72c9a0aa8', '04/08/2023 9:12:43', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS33fd93a9aa2b', 'USER03595a8447ab', '06/07/2023 16:49:00', '2023/07/06 17:26:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS34707e86ee7c', 'USER03595a8447ab', '15/06/2023 8:32:10', '2023/06/15 10:13:44', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS3631fb26f517', 'USER03595a8447ab', '06/07/2023 16:11:04', '2023/07/06 16:48:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS36cb0b1c92b3', 'USER01d72c9a0aa8', '20/07/2023 13:34:53', '2023/07/20 15:05:33', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS3801f3a1f2f0', 'USER03595a8447ab', '13/06/2023 18:57:46', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS382d78fcc77c', 'USER03595a8447ab', '28/07/2023 9:24:18', '', '::1', '', 'Desktop', ',\r\n', 'Online'),
('HIS39a99f93e968', 'USER03595a8447ab', '29/05/2023 9:10:29', '', '110.138.93.247', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS3a66baf7466f', 'USER388732b31872', '23/06/2023 17:41:34', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS3c21969e36e6', 'USER03595a8447ab', '28/07/2023 9:24:16', '', '::1', '', 'Desktop', ',\r\n', 'Online'),
('HIS3d085f572541', 'USER03595a8447ab', '31/05/2023 15:59:35', '', '110.138.94.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS3dfd8c9d2ddd', 'USER03595a8447ab', '21/06/2023 8:13:37', '2023/06/21 15:00:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS3e5c3d208f12', 'USER03595a8447ab', '28/07/2023 9:26:42', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS3f6a69160805', 'USER03595a8447ab', '15/08/2023 17:28:57', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS423d8bc0a290', 'USER03595a8447ab', '28/07/2023 9:24:09', '', '::1', '', 'Desktop', ',\r\n', 'Online'),
('HIS4336312cc383', 'USER03595a8447ab', '23/05/2023 14:52:26', '', '110.138.80.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS4359ff64b458', 'USER03595a8447ab', '09/08/2023 8:19:12', '2023/08/09 9:22:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS43ed924e0acd', 'USER01d72c9a0aa8', '24/07/2023 8:09:33', '2023/07/24 14:37:39', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS448965bcd4d7', 'USER03595a8447ab', '02/06/2023 19:13:23', '', '103.155.168.17', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36', 'Mobile', 'Karawang,Indonesia\n', 'Online'),
('HIS4519a20a15d7', 'USER01d72c9a0aa8', '15/08/2023 8:33:34', '2023/08/15 17:28:39', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Offline'),
('HIS45d58c8fa99c', 'USER03595a8447ab', '01/07/2023 9:07:05', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS461326bb9ca0', 'USER01d72c9a0aa8', '01/08/2023 14:19:48', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS46244a4b9633', 'USER03595a8447ab', '14/08/2023 8:30:09', '2023/08/14 11:25:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS477351415a29', 'USER01d72c9a0aa8', '27/07/2023 9:19:32', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS4a495af7492e', 'USER03595a8447ab', '08/07/2023 10:48:56', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS4a90d26033a6', 'USER03595a8447ab', '16/06/2023 8:20:08', '2023/06/16 12:27:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS4a91337fde93', 'USER34e2f73c9751', '29/05/2023 13:39:29', '', '110.138.89.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS4b721ab79c37', 'USER03595a8447ab', '19/06/2023 13:09:19', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS4b8f79c2a745', 'USER03595a8447ab', '08/08/2023 15:11:20', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS4c04b3f15dc0', 'USER03595a8447ab', '22/06/2023 10:23:06', '2023/06/22 13:05:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS4ce7dc0bdcd7', 'USER01d72c9a0aa8', '02/08/2023 8:27:11', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS4e7a1d61da6c', 'USER03595a8447ab', '21/07/2023 15:49:03', '2023/07/21 15:49:07', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS4eb1a9ccc4cf', 'USER01d72c9a0aa8', '07/08/2023 8:17:58', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS512b2d4368d6', 'USER03595a8447ab', '24/06/2023 13:08:31', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS52c2e349c7f5', 'USER03595a8447ab', '13/06/2023 12:14:35', '2023/06/13 13:07:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS54997b521557', 'USER03595a8447ab', '10/07/2023 9:02:17', '2023/07/10 9:28:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS560c59035c11', 'USER01d72c9a0aa8', '25/07/2023 8:05:50', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS5650a4064056', 'USER03595a8447ab', '27/07/2023 8:35:49', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS5999a4620193', 'USER03595a8447ab', '28/07/2023 8:48:20', '2023/07/28 9:24:06', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS5ad2688d8c53', 'USER03595a8447ab', '13/07/2023 10:11:43', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS5e58834b05d2', 'USER47100114a730', '23/05/2023 14:57:02', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS5e90966c60da', 'USER34e2f73c9751', '29/05/2023 9:19:37', '', '110.138.89.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS6158ee01e6e0', 'USER01d72c9a0aa8', '09/08/2023 13:17:49', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS61b1a057e7c6', 'USER01d72c9a0aa8', '21/07/2023 8:09:09', '2023/07/21 15:47:31', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS61beed25c823', 'USER34e2f73c9751', '25/05/2023 14:58:20', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS6418ea829d27', 'USER03595a8447ab', '26/06/2023 14:42:32', '2023/06/26 16:03:38', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS654dc9ef08fc', 'USER01d72c9a0aa8', '15/08/2023 8:14:29', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS6bd964efdb4f', 'USER03595a8447ab', '12/06/2023 15:46:26', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS6ca5203a7330', 'USER03595a8447ab', '24/05/2023 16:43:23', '', '125.160.230.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS6d23d3bc5d28', 'USER03595a8447ab', '21/06/2023 16:14:23', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS6fd50815d51e', 'USER01d72c9a0aa8', '25/07/2023 8:06:23', '2023/07/25 14:11:45', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS7227c6e356ec', 'USER01d72c9a0aa8', '26/07/2023 8:42:17', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS728bcb58dc1e', 'USER01d72c9a0aa8', '21/07/2023 15:50:18', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS731833300acb', 'USER01d72c9a0aa8', '28/07/2023 17:31:08', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS757a8748df63', 'USER03595a8447ab', '11/07/2023 10:54:44', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS77911743c49b', 'USER03595a8447ab', '23/06/2023 14:55:13', '2023/06/23 15:40:46', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS7846a686d478', 'USER47100114a730', '23/05/2023 10:37:46', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS7b761075c34f', 'USER03595a8447ab', '05/07/2023 16:28:56', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS7bdd837926d1', 'USER03595a8447ab', '26/05/2023 8:41:51', '', '110.138.87.166', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS7d2d39858e4b', 'USER03595a8447ab', '29/07/2023 9:12:02', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS7de5c622c0f2', 'USER01d72c9a0aa8', '14/08/2023 11:27:11', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS7df59f4c7f75', 'USER03595a8447ab', '19/06/2023 13:09:20', '2023/06/19 14:56:11', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS7fd57405e811', 'USER03595a8447ab', '15/06/2023 19:02:42', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS80803eea3767', 'USER03595a8447ab', '22/06/2023 13:05:52', '2023/06/22 14:46:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS83dd108e0935', 'USER03595a8447ab', '04/07/2023 8:38:23', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS851318d62c2a', 'USER03595a8447ab', '09/06/2023 13:08:49', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS85a5ddfd7a2f', 'USER47100114a730', '24/05/2023 16:52:13', '', '110.138.85.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS8655420cc25c', 'USER03595a8447ab', '17/06/2023 10:58:58', '2023/06/17 11:33:09', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS876cd0b32b8b', 'USER47100114a730', '25/05/2023 13:06:01', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS87b00ffec8c6', 'USER03595a8447ab', '26/06/2023 8:05:10', '2023/06/26 10:33:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS89a1a8d5de9b', 'USER01d72c9a0aa8', '27/07/2023 8:50:59', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HIS89af8a3edf6f', 'USER03595a8447ab', '20/06/2023 13:32:10', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS89f84b913a5e', 'USER03595a8447ab', '06/07/2023 13:03:24', '2023/07/06 13:39:37', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS8ac3abfbc90a', 'USER03595a8447ab', '17/06/2023 13:14:35', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS8dd4eaf0fb8f', 'USER47100114a730', '03/06/2023 8:41:31', '', '112.215.235.250', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HIS8f38e3c81572', 'USER01d72c9a0aa8', '08/08/2023 13:24:19', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS8fa94334ef41', 'USER03595a8447ab', '28/07/2023 9:24:21', '', '::1', '', 'Desktop', ',\r\n', 'Online'),
('HIS91d4240ce6ff', 'USER03595a8447ab', '20/06/2023 10:33:33', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS9205fec2f23f', 'USER03595a8447ab', '12/06/2023 8:06:06', '2023/06/12 8:45:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS929eb6eb6ac2', 'USER01d72c9a0aa8', '25/07/2023 14:11:54', '2023/07/25 17:18:37', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HIS92f8fe9188fb', 'USER03595a8447ab', '22/07/2023 8:48:11', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS93614e089ff2', 'USER03595a8447ab', '09/06/2023 8:21:51', '2023/06/09 8:54:04', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS948f158cd6f9', 'USER03595a8447ab', '01/08/2023 9:00:01', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS95d2da44610d', 'USER01d72c9a0aa8', '10/08/2023 8:23:16', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HIS968d899e2112', 'USER03595a8447ab', '06/07/2023 13:39:39', '2023/07/06 16:10:59', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS99c4fc383d9f', 'USER03595a8447ab', '13/06/2023 17:32:31', '2023/06/13 17:38:42', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS9a57eb1b1f8f', 'USER03595a8447ab', '06/07/2023 17:26:17', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIS9e2d8d0ae92e', 'USER34e2f73c9751', '26/05/2023 15:44:49', '', '110.138.92.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS9e3e2e8b5d95', 'USER03595a8447ab', '25/07/2023 8:08:52', '2023/07/25 11:25:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIS9f0c2a88456b', 'USER03595a8447ab', '24/07/2023 9:21:36', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISa171a30b15fc', 'USER01d72c9a0aa8', '29/07/2023 13:43:17', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HISa2e6b85fe592', 'USER03595a8447ab', '23/05/2023 17:28:14', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISa4926b2dce45', 'USER03595a8447ab', '19/06/2023 13:09:19', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISa5be59a578d9', 'USER03595a8447ab', '10/08/2023 8:30:01', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISa5c9fa261c8e', 'USER01d72c9a0aa8', '20/07/2023 15:05:39', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HISa846f737243f', 'USER03595a8447ab', '03/07/2023 13:06:19', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISa8df37423139', 'USER01d72c9a0aa8', '31/07/2023 13:12:16', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Online'),
('HISa9545329cf9f', 'USER03595a8447ab', '22/06/2023 16:26:55', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISa968ef15a554', 'USER34e2f73c9751', '24/05/2023 16:55:05', '', '114.79.3.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISaa0a55ae9962', 'USER01d72c9a0aa8', '09/08/2023 8:51:30', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HISaa49f46a5c35', 'USER34e2f73c9751', '29/05/2023 9:50:45', '', '110.138.89.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISab27c8f393e9', 'USER03595a8447ab', '12/08/2023 15:39:35', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISad7211306d7f', 'USER01d72c9a0aa8', '14/08/2023 11:25:31', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISadbf8aeae159', 'USER03595a8447ab', '12/06/2023 10:28:29', '2023/06/12 15:46:21', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISaf67e5cb75ce', 'USER03595a8447ab', '23/06/2023 10:45:43', '2023/06/23 14:55:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISaf8c19d56ead', 'USER03595a8447ab', '06/07/2023 9:24:46', '2023/07/06 13:03:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISb00ba4b820bf', 'USER03595a8447ab', '25/05/2023 12:00:43', '2023/05/25 12:02:22', '180.242.71.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Offline'),
('HISb1305be4f268', 'USER03595a8447ab', '20/06/2023 10:33:33', '2023/06/20 10:56:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISb1362b0e5374', 'USER03595a8447ab', '22/06/2023 14:49:15', '2023/06/22 15:51:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISb21cd355f263', 'USER03595a8447ab', '24/07/2023 8:09:01', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISb54c25fc3d77', 'USER01d72c9a0aa8', '13/08/2023 0:49:09', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISb56f6e52db24', 'USER34e2f73c9751', '26/05/2023 8:28:28', '', '110.138.92.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISb5d8ca70adfb', 'USER01d72c9a0aa8', '11/08/2023 15:44:45', '2023/08/11 16:28:26', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Offline'),
('HISb89ed5fb6c5b', 'USER47100114a730', '06/06/2023 9:49:44', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HISba0fbd8f2b31', 'USER03595a8447ab', '12/06/2023 8:45:47', '2023/06/12 9:39:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISba2241a55ba4', 'USER03595a8447ab', '13/08/2023 15:20:16', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISbc3bb274cdae', 'USER01d72c9a0aa8', '11/08/2023 16:27:56', '2023/08/11 16:28:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISbcf16947601e', 'USER03595a8447ab', '03/06/2023 9:27:55', '', '110.138.83.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISbde5ede8d968', 'USER03595a8447ab', '15/08/2023 16:23:06', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISbf5f0217d558', 'USER03595a8447ab', '09/06/2023 8:54:10', '2023/06/09 13:08:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc02b5b55aeb6', 'USER03595a8447ab', '23/05/2023 11:42:32', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISc0787005fb78', 'USER01d72c9a0aa8', '03/08/2023 8:17:47', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISc0f7040e5d6c', 'USER03595a8447ab', '11/07/2023 9:28:33', '2023/07/11 10:54:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc2120c6d1560', 'USER03595a8447ab', '13/06/2023 17:38:58', '2023/06/13 18:57:40', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc2b6569968e9', 'USER03595a8447ab', '10/07/2023 9:28:09', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISc35d692529ce', 'USER03595a8447ab', '06/07/2023 19:02:47', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISc3b54d76d98b', 'USER03595a8447ab', '17/06/2023 11:33:12', '2023/06/17 13:14:29', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc56e0c456135', 'USER34e2f73c9751', '24/05/2023 16:14:52', '', '114.79.3.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISc65929ec3259', 'USER01d72c9a0aa8', '22/07/2023 8:49:37', '2023/07/22 11:46:25', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HISc6fbc3189b82', 'USER47100114a730', '05/06/2023 15:05:40', '', '110.138.87.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISc705392d39db', 'USER03595a8447ab', '28/07/2023 9:27:01', '2023/07/28 17:50:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc900b13ed19b', 'USER03595a8447ab', '03/07/2023 8:16:41', '2023/07/03 13:06:14', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc977ce8cf239', 'USER03595a8447ab', '16/06/2023 12:27:31', '2023/06/16 19:04:52', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc9b0b7f90486', 'USER03595a8447ab', '13/06/2023 13:08:48', '2023/06/13 16:50:35', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISc9ca0d6a8572', 'USER01d72c9a0aa8', '12/08/2023 21:44:31', '2023/08/12 21:45:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIScb0d2c98acc2', 'USER03595a8447ab', '19/06/2023 13:09:19', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HIScbf766240bb5', 'USER03595a8447ab', '03/07/2023 13:46:19', '2023/07/03 15:54:26', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISce96e6f27236', 'USER03595a8447ab', '24/06/2023 9:10:37', '2023/06/24 9:28:01', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HIScf6427638413', 'USER34e2f73c9751', '25/05/2023 9:14:32', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISd14332f8e704', 'USER03595a8447ab', '13/06/2023 16:50:40', '2023/06/13 17:32:27', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISd301cefd97d8', 'USER47100114a730', '07/06/2023 8:13:12', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/114.0.5735.99 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HISd391d50aeac2', 'USER03595a8447ab', '27/07/2023 9:18:22', '2023/07/27 16:46:50', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISd3ae755a1e4a', 'USER03595a8447ab', '27/06/2023 8:07:54', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISd45648941fe5', 'USER03595a8447ab', '08/06/2023 15:12:18', '2023/06/08 15:43:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISd673d360fc81', 'USER03595a8447ab', '05/06/2023 16:44:15', '', '125.160.230.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISd749ac87ce53', 'USER388732b31872', '28/07/2023 17:50:30', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISd782dc021e2a', 'USER01d72c9a0aa8', '31/07/2023 8:33:06', '2023/07/31 13:12:14', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HISd7a56f79ce55', 'USER01d72c9a0aa8', '08/08/2023 13:05:56', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HISd7b3a1198337', 'USER01d72c9a0aa8', '08/08/2023 9:32:33', '2023/08/08 13:05:42', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Offline'),
('HISd85ff660e0ca', 'USER03595a8447ab', '07/08/2023 8:17:37', '2023/08/07 8:17:51', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISd932fd447e0e', 'USER03595a8447ab', '23/06/2023 15:41:02', '2023/06/23 17:41:22', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISda13dbd24976', 'USER03595a8447ab', '13/06/2023 8:08:52', '2023/06/13 12:14:28', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISda399729e0aa', 'USER03595a8447ab', '28/07/2023 9:26:47', '2023/07/28 9:26:49', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISdaa3cc2cc19d', 'USER03595a8447ab', '20/06/2023 11:21:42', '2023/06/20 13:06:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISdc8bcc7d4831', 'USER01d72c9a0aa8', '24/07/2023 14:54:48', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISdcab5c577511', 'USER03595a8447ab', '07/07/2023 15:23:58', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISdd2b2e60cb92', 'USER03595a8447ab', '26/06/2023 16:03:40', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISddcf38f360f1', 'USER03595a8447ab', '04/07/2023 11:35:31', '2023/07/04 16:19:03', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISde56ba9d3cff', 'USER47100114a730', '25/05/2023 10:30:40', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISdf7efa23ad60', 'USER03595a8447ab', '23/06/2023 8:52:12', '2023/06/23 10:45:39', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISdff99c03f5db', 'USER03595a8447ab', '15/06/2023 13:07:03', '2023/06/15 19:02:36', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISe0572df7a881', 'USER01d72c9a0aa8', '04/08/2023 9:14:57', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISe105e9677672', 'USER03595a8447ab', '28/07/2023 9:24:14', '', '::1', '', 'Desktop', ',\r\n', 'Online'),
('HISe216e588033b', 'USER03595a8447ab', '06/06/2023 10:08:13', '', '110.138.81.127', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HISe4cdb4007366', 'USER03595a8447ab', '20/06/2023 13:32:11', '2023/06/20 16:21:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISe56b64c6baa1', 'USER01d72c9a0aa8', '11/08/2023 8:10:29', '2023/08/11 15:44:43', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Offline'),
('HISe65dcb283b5b', 'USER03595a8447ab', '10/06/2023 8:40:35', '2023/06/10 13:06:53', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISe6bdfb3d29d4', 'USER47100114a730', '24/05/2023 16:23:17', '', '110.138.85.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISea55057b2ac4', 'USER01d72c9a0aa8', '12/08/2023 21:45:36', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online');
INSERT INTO `user_history` (`id_history`, `id_user`, `login_time`, `logout_time`, `ip_login`, `perangkat`, `jenis_perangkat`, `lokasi`, `status_perangkat`) VALUES
('HISeadcddf35132', 'USER388732b31872', '24/06/2023 9:28:09', '2023/06/24 11:54:58', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISecc1060510da', 'USER34e2f73c9751', '25/05/2023 14:39:16', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISefb7835567a2', 'USER01d72c9a0aa8', '07/08/2023 16:21:44', '', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Online'),
('HISf10d251d0941', 'USER03595a8447ab', '12/06/2023 9:39:53', '2023/06/12 9:47:16', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISf1d3ed1a4b99', 'USER03595a8447ab', '20/07/2023 13:35:01', '2023/07/20 14:04:05', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISf21ec41fa931', 'USER03595a8447ab', '24/05/2023 8:26:10', '', '125.160.230.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISf25100f7b35d', 'USER03595a8447ab', '20/06/2023 16:21:12', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISf28dfee6da9c', 'USER01d72c9a0aa8', '03/08/2023 8:15:09', '2023/08/03 14:01:30', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/116.0', 'Desktop', ',\r\n', 'Offline'),
('HISf3bdae1528d5', 'USER03595a8447ab', '15/06/2023 10:13:51', '2023/06/15 13:06:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISf5eebd16a65e', 'USER03595a8447ab', '12/06/2023 9:39:07', '2023/06/12 9:39:41', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISf6520abdaf31', 'USER03595a8447ab', '24/06/2023 14:06:39', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISf69d5157c157', 'USER03595a8447ab', '23/05/2023 16:35:16', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISf9bc0cab4438', 'USER388732b31872', '20/06/2023 11:21:32', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISf9c69bb3ce70', 'USER03595a8447ab', '20/06/2023 13:06:12', '2023/06/20 13:32:08', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISf9ee9e35dba2', 'USER47100114a730', '25/05/2023 9:12:21', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISfa4014c3d946', 'USER03595a8447ab', '20/06/2023 10:56:37', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISfad012c8a3a7', 'USER01d72c9a0aa8', '13/08/2023 0:49:20', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISfb35cc4e512d', 'USER01d72c9a0aa8', '08/08/2023 16:41:21', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISfc06f9312a04', 'USER01d72c9a0aa8', '24/07/2023 14:52:10', '2023/07/24 14:53:08', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115.0', 'Desktop', ',\r\n', 'Offline'),
('HISfc685bca873c', 'USER03595a8447ab', '31/07/2023 8:13:08', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISfdcc159257d5', 'USER03595a8447ab', '06/06/2023 17:35:49', '', '110.138.93.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISfde2cc8069be', 'USER03595a8447ab', '17/06/2023 10:58:57', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISfe52bb262bf2', 'USER03595a8447ab', '23/05/2023 15:01:39', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISfe53e7015d93', 'USER03595a8447ab', '12/07/2023 16:17:01', '', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Online'),
('HISfe8707231f6d', 'USER03595a8447ab', '10/07/2023 8:14:36', '2023/07/10 9:02:15', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISfe9a488028b5', 'USER03595a8447ab', '20/07/2023 14:04:07', '2023/07/20 17:47:31', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISff300b0c9966', 'USER03595a8447ab', '20/06/2023 8:24:55', '2023/06/20 10:33:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` char(20) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id_user_role`, `role`, `created_date`) VALUES
('RL3375d09e45b3', 'Admin Gudang', '06/03/2023, 13:52'),
('RL65ac1af47ca0', 'Finance', '20/07/2023, 13:33'),
('RL98cb89863ece', 'Super Admin', '04/03/2023, 9:35'),
('RLe89c2734a09d', 'Driver', '20/06/2023, 11:20'),
('RLf278f224eb37', 'Manager Gudang', '06/03/2023, 13:52');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `act_br_import`
--
ALTER TABLE `act_br_import`
  ADD PRIMARY KEY (`id_act_br_import`);

--
-- Indeks untuk tabel `ekspedisi`
--
ALTER TABLE `ekspedisi`
  ADD PRIMARY KEY (`id_ekspedisi`);

--
-- Indeks untuk tabel `finance`
--
ALTER TABLE `finance`
  ADD PRIMARY KEY (`id_finance`),
  ADD UNIQUE KEY `id_inv` (`id_inv`),
  ADD KEY `id_finance` (`id_finance`),
  ADD KEY `id_tagihan` (`id_tagihan`);

--
-- Indeks untuk tabel `finance_bank`
--
ALTER TABLE `finance_bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `finance_bayar`
--
ALTER TABLE `finance_bayar`
  ADD PRIMARY KEY (`id_bayar`),
  ADD KEY `id_bayar` (`id_bayar`),
  ADD KEY `id_tagihan` (`id_tagihan`);

--
-- Indeks untuk tabel `finance_bukti_tf`
--
ALTER TABLE `finance_bukti_tf`
  ADD PRIMARY KEY (`id_bukti_tf`);

--
-- Indeks untuk tabel `finance_tagihan`
--
ALTER TABLE `finance_tagihan`
  ADD PRIMARY KEY (`id_tagihan`),
  ADD KEY `id_tagihan` (`id_tagihan`),
  ADD KEY `no_tagihan` (`no_tagihan`);

--
-- Indeks untuk tabel `ganti_merk_reg_in`
--
ALTER TABLE `ganti_merk_reg_in`
  ADD PRIMARY KEY (`id_ganti_merk_in`);

--
-- Indeks untuk tabel `ganti_merk_reg_out`
--
ALTER TABLE `ganti_merk_reg_out`
  ADD PRIMARY KEY (`id_ganti_merk_out`);

--
-- Indeks untuk tabel `inv_br_import`
--
ALTER TABLE `inv_br_import`
  ADD PRIMARY KEY (`id_inv_br_import`),
  ADD KEY `id_inv_br_import` (`id_inv_br_import`),
  ADD KEY `no_inv` (`no_inv`),
  ADD KEY `tgl_inv` (`tgl_inv`);

--
-- Indeks untuk tabel `inv_br_in_lokal`
--
ALTER TABLE `inv_br_in_lokal`
  ADD PRIMARY KEY (`id_inv_br_in_lokal`),
  ADD KEY `no_inv` (`no_inv`),
  ADD KEY `id_sp` (`id_sp`);

--
-- Indeks untuk tabel `inv_bukti_terima`
--
ALTER TABLE `inv_bukti_terima`
  ADD PRIMARY KEY (`id_bukti_terima`),
  ADD UNIQUE KEY `id_inv` (`id_inv`);

--
-- Indeks untuk tabel `inv_bum`
--
ALTER TABLE `inv_bum`
  ADD PRIMARY KEY (`id_inv_bum`),
  ADD UNIQUE KEY `no_inv` (`no_inv`),
  ADD KEY `id_inv_bum` (`id_inv_bum`),
  ADD KEY `cs_inv` (`cs_inv`);

--
-- Indeks untuk tabel `inv_nonppn`
--
ALTER TABLE `inv_nonppn`
  ADD PRIMARY KEY (`id_inv_nonppn`),
  ADD UNIQUE KEY `no_inv` (`no_inv`),
  ADD KEY `id_inv_nonppn` (`id_inv_nonppn`),
  ADD KEY `cs_inv` (`cs_inv`);

--
-- Indeks untuk tabel `inv_penerima`
--
ALTER TABLE `inv_penerima`
  ADD PRIMARY KEY (`id_inv_penerima`),
  ADD UNIQUE KEY `id_inv` (`id_inv`);

--
-- Indeks untuk tabel `inv_ppn`
--
ALTER TABLE `inv_ppn`
  ADD PRIMARY KEY (`id_inv_ppn`),
  ADD UNIQUE KEY `no_inv` (`no_inv`),
  ADD KEY `id_inv_ppn` (`id_inv_ppn`);

--
-- Indeks untuk tabel `isi_br_out_reg`
--
ALTER TABLE `isi_br_out_reg`
  ADD PRIMARY KEY (`id_isi_br_out_reg`);

--
-- Indeks untuk tabel `isi_br_tambahan`
--
ALTER TABLE `isi_br_tambahan`
  ADD PRIMARY KEY (`id_isi_br_tambahan`);

--
-- Indeks untuk tabel `isi_inv_br_import`
--
ALTER TABLE `isi_inv_br_import`
  ADD PRIMARY KEY (`id_isi_inv_br_import`),
  ADD KEY `id_produk_reg` (`id_produk_reg`),
  ADD KEY `id_isi_inv_br_import` (`id_isi_inv_br_import`);

--
-- Indeks untuk tabel `isi_inv_br_in_lokal`
--
ALTER TABLE `isi_inv_br_in_lokal`
  ADD PRIMARY KEY (`id_isi_inv_br_in_lokal`);

--
-- Indeks untuk tabel `isi_produk_set_marwa`
--
ALTER TABLE `isi_produk_set_marwa`
  ADD PRIMARY KEY (`id_isi_set_marwa`);

--
-- Indeks untuk tabel `keterangan_in`
--
ALTER TABLE `keterangan_in`
  ADD PRIMARY KEY (`id_ket_in`);

--
-- Indeks untuk tabel `keterangan_out`
--
ALTER TABLE `keterangan_out`
  ADD PRIMARY KEY (`id_ket_out`);

--
-- Indeks untuk tabel `qr_link`
--
ALTER TABLE `qr_link`
  ADD PRIMARY KEY (`id_link`),
  ADD KEY `id_produk_qr` (`id_produk_qr`);

--
-- Indeks untuk tabel `sph`
--
ALTER TABLE `sph`
  ADD PRIMARY KEY (`id_sph`),
  ADD KEY `no_sph` (`no_sph`);

--
-- Indeks untuk tabel `spk_reg`
--
ALTER TABLE `spk_reg`
  ADD PRIMARY KEY (`id_spk_reg`),
  ADD KEY `id_spk_reg` (`id_spk_reg`),
  ADD KEY `no_spk` (`no_spk`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_inv` (`id_inv`);

--
-- Indeks untuk tabel `status_kirim`
--
ALTER TABLE `status_kirim`
  ADD PRIMARY KEY (`id_status_kirim`),
  ADD UNIQUE KEY `id_inv` (`id_inv`);

--
-- Indeks untuk tabel `stock_produk_reguler`
--
ALTER TABLE `stock_produk_reguler`
  ADD PRIMARY KEY (`id_stock_prod_reg`),
  ADD KEY `id_stock_prod_reg` (`id_stock_prod_reg`),
  ADD KEY `id_produk_reg` (`id_produk_reg`),
  ADD KEY `stock` (`stock`);

--
-- Indeks untuk tabel `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_cs`);

--
-- Indeks untuk tabel `tb_kat_penjualan`
--
ALTER TABLE `tb_kat_penjualan`
  ADD PRIMARY KEY (`id_kat_penjualan`);

--
-- Indeks untuk tabel `tb_kat_produk`
--
ALTER TABLE `tb_kat_produk`
  ADD PRIMARY KEY (`id_kat_produk`);

--
-- Indeks untuk tabel `tb_lokasi_produk`
--
ALTER TABLE `tb_lokasi_produk`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indeks untuk tabel `tb_orderby`
--
ALTER TABLE `tb_orderby`
  ADD PRIMARY KEY (`id_orderby`);

--
-- Indeks untuk tabel `tb_produk_grade`
--
ALTER TABLE `tb_produk_grade`
  ADD PRIMARY KEY (`id_grade`);

--
-- Indeks untuk tabel `tb_produk_reguler`
--
ALTER TABLE `tb_produk_reguler`
  ADD PRIMARY KEY (`id_produk_reg`),
  ADD KEY `id_produk_reg` (`id_produk_reg`),
  ADD KEY `nama_produk` (`nama_produk`),
  ADD KEY `kode_produk` (`kode_produk`);

--
-- Indeks untuk tabel `tb_produk_set_marwa`
--
ALTER TABLE `tb_produk_set_marwa`
  ADD PRIMARY KEY (`id_set_marwa`),
  ADD KEY `id_set_marwa` (`id_set_marwa`),
  ADD KEY `kode_set_marwa` (`kode_set_marwa`),
  ADD KEY `nama_set_marwa` (`nama_set_marwa`);

--
-- Indeks untuk tabel `tb_sales`
--
ALTER TABLE `tb_sales`
  ADD PRIMARY KEY (`id_sales`);

--
-- Indeks untuk tabel `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_sp`);

--
-- Indeks untuk tabel `tmp_produk_spk`
--
ALTER TABLE `tmp_produk_spk`
  ADD PRIMARY KEY (`id_tmp`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_tmp` (`id_tmp`),
  ADD KEY `id_spk` (`id_spk`);

--
-- Indeks untuk tabel `transaksi_produk_reg`
--
ALTER TABLE `transaksi_produk_reg`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `nama_produk_spk` (`nama_produk_spk`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_spk` (`id_spk`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indeks untuk tabel `transaksi_produk_sph`
--
ALTER TABLE `transaksi_produk_sph`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indeks untuk tabel `trx_cancel`
--
ALTER TABLE `trx_cancel`
  ADD PRIMARY KEY (`id_trx_cancel`),
  ADD KEY `id_spk` (`id_spk`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_trx_cancel` (`id_trx_cancel`);

--
-- Indeks untuk tabel `tr_set_marwa`
--
ALTER TABLE `tr_set_marwa`
  ADD PRIMARY KEY (`id_tr_set_marwa`);

--
-- Indeks untuk tabel `tr_set_marwa_isi`
--
ALTER TABLE `tr_set_marwa_isi`
  ADD PRIMARY KEY (`id_tr_set_marwa_isi`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `role_user` (`id_user_role`);

--
-- Indeks untuk tabel `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id_history`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user_role`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `qr_link`
--
ALTER TABLE `qr_link`
  MODIFY `id_link` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `role_user` FOREIGN KEY (`id_user_role`) REFERENCES `user_role` (`id_user_role`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
