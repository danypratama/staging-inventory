-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2023 at 02:06 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

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
-- Table structure for table `inv_nonppn`
--

CREATE TABLE `inv_nonppn` (
  `id_inv` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(20) NOT NULL,
  `cs_inv` text NOT NULL,
  `tgl_tempo` varchar(25) NOT NULL,
  `sp_disc` int(11) NOT NULL,
  `note_inv` text NOT NULL,
  `kategori_inv` varchar(20) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_transaksi` varchar(30) NOT NULL,
  `dikirim_oleh` varchar(30) NOT NULL,
  `created_date` varchar(20) NOT NULL,
  `user_updated` varchar(20) NOT NULL,
  `updated_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `spk_reg`
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
  `created_date` varchar(25) NOT NULL,
  `user_updated` varchar(25) NOT NULL,
  `updated_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spk_reg`
--

INSERT INTO `spk_reg` (`id_spk_reg`, `id_user`, `id_customer`, `id_inv`, `id_sales`, `id_orderby`, `status_spk`, `no_spk`, `no_po`, `tgl_spk`, `tgl_pesanan`, `note`, `created_date`, `user_updated`, `updated_date`) VALUES
('SPKREG-2305e3737255c7a428', 'USER03595a8447ab', 'CS0087ea6067d9', '', 'SL3bca54585e28', 'ORDER68aa0a74872f', 'Belum Diproses', '001/SPK/V/2023', '', '28/05/2023, 19:05', '28/05/2023', 'Urgent', '28/05/2023, 19:05', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_produk_reg`
--

CREATE TABLE `transaksi_produk_reg` (
  `id_transaksi` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_spk` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `disc` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `user_updated` varchar(25) NOT NULL,
  `updated_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inv_nonppn`
--
ALTER TABLE `inv_nonppn`
  ADD PRIMARY KEY (`id_inv`);

--
-- Indexes for table `spk_reg`
--
ALTER TABLE `spk_reg`
  ADD PRIMARY KEY (`id_spk_reg`);

--
-- Indexes for table `transaksi_produk_reg`
--
ALTER TABLE `transaksi_produk_reg`
  ADD PRIMARY KEY (`id_transaksi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
