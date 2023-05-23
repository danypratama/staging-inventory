-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2023 at 09:42 AM
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
-- Table structure for table `isi_br_out_reg`
--

CREATE TABLE `isi_br_out_reg` (
  `id_isi_br_out_reg` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_ket_out` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `isi_br_out_reg`
--

INSERT INTO `isi_br_out_reg` (`id_isi_br_out_reg`, `id_user`, `id_produk_reg`, `qty`, `id_ket_out`, `created_date`) VALUES
('BR-OUT-235fa612a9f32405', 'USER03595a8447ab', 'BR-REGe2e00ce0199b', 100, 'KET-OUT-5994e66e943d', '23/05/2023, 14:40');

--
-- Triggers `isi_br_out_reg`
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `isi_br_out_reg`
--
ALTER TABLE `isi_br_out_reg`
  ADD PRIMARY KEY (`id_isi_br_out_reg`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
