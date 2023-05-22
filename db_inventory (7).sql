-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2023 at 11:55 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `tr_set_marwa`
--

CREATE TABLE `tr_set_marwa` (
  `id_tr_set_marwa` varchar(50) NOT NULL,
  `id_set_marwa` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tr_set_marwa`
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
-- Table structure for table `tr_set_marwa_isi`
--

CREATE TABLE `tr_set_marwa_isi` (
  `id_tr_set_marwa_isi` varchar(50) NOT NULL,
  `id_set_marwa` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `tr_set_marwa_isi`
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tr_set_marwa`
--
ALTER TABLE `tr_set_marwa`
  ADD PRIMARY KEY (`id_tr_set_marwa`);

--
-- Indexes for table `tr_set_marwa_isi`
--
ALTER TABLE `tr_set_marwa_isi`
  ADD PRIMARY KEY (`id_tr_set_marwa_isi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
