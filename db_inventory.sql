-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2023 at 10:43 AM
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
-- Table structure for table `act_br_import`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `act_br_import`
--

INSERT INTO `act_br_import` (`id_act_br_import`, `id_isi_inv_br_import`, `id_produk_reg`, `qty_act`, `id_user`, `created_date`, `updated_date`, `user_updated`) VALUES
('ACT-IMPORT-05d9f054868c8423', 'BR-IMPORT-23c54205625a1305', 'BR-REGffb0b62a09cf', '5400', 'USER03595a8447ab', '23/05/2023, 16:40', '', ''),
('ACT-IMPORT-05ef16c9d87efd23', 'BR-IMPORT-23c54205625a1305', 'BR-REGffb0b62a09cf', '1000000', 'USER03595a8447ab', '23/05/2023, 16:40', '', '');

--
-- Triggers `act_br_import`
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
-- Table structure for table `ganti_merk_reg_in`
--

CREATE TABLE `ganti_merk_reg_in` (
  `id_ganti_merk_in` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `ganti_merk_reg_in`
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
-- Table structure for table `ganti_merk_reg_out`
--

CREATE TABLE `ganti_merk_reg_out` (
  `id_ganti_merk_out` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `ganti_merk_reg_out`
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
-- Table structure for table `inv_br_import`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inv_br_import`
--

INSERT INTO `inv_br_import` (`id_inv_br_import`, `id_user`, `id_supplier`, `no_inv`, `tgl_inv`, `no_order`, `tgl_order`, `shipping_by`, `no_awb`, `tgl_kirim`, `tgl_est`, `status_pengiriman`, `tgl_terima`, `keterangan`, `created_date`) VALUES
('INV-IMPORT1ebd36eefe40', 'USER03595a8447ab', 'SP1407504e42bd', '087', '23/05/2023', '1111', '23/05/2023', 'Udara', '10000', '23/05/2023', '08/05/2023', 'Sudah Diterima', '25/05/2023', 'Barang Diterima Telat 17 hari', '23/05/2023, 11:53'),
('INV-IMPORT414edd954c45', 'USER47100114a730', 'SP0d8111e5dcf6', '1321313', '23/05/2023', '12121', '23/05/2023', 'Udara', '31313131313131', '23/05/2023', '02/06/2023', 'Belum Dikirim', '', 'Mohon tunggu / silahkan hubungi supplier kembali', '23/05/2023, 10:52');

-- --------------------------------------------------------

--
-- Table structure for table `inv_br_in_lokal`
--

CREATE TABLE `inv_br_in_lokal` (
  `id_inv_br_in_lokal` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_sp` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(20) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inv_br_in_lokal`
--

INSERT INTO `inv_br_in_lokal` (`id_inv_br_in_lokal`, `id_user`, `id_sp`, `no_inv`, `tgl_inv`, `created_date`) VALUES
('INV-LOKAL29304ecbc0fa', 'USER03595a8447ab', 'SP75d3d772951e', '087', '24/05/2023', '23/05/2023, 11:54'),
('INV-LOKAL6849e61df660', 'USER47100114a730', 'SP5d25a18a4094', '1321313', '23/05/2023', '23/05/2023, 11:06'),
('INV-LOKAL858a05c1222d', 'USER34e2f73c9751', 'SP0d8111e5dcf6', '1548726', '26/05/2023', '26/05/2023, 8:29');

-- --------------------------------------------------------

--
-- Table structure for table `inv_nonppn`
--

CREATE TABLE `inv_nonppn` (
  `id_inv_nonppn` varchar(50) NOT NULL,
  `no_inv` varchar(50) NOT NULL,
  `tgl_inv` varchar(30) NOT NULL,
  `cs_inv` text NOT NULL,
  `tgl_tempo` varchar(30) NOT NULL,
  `sp_disc` decimal(3,1) NOT NULL,
  `note_inv` text NOT NULL,
  `kategori_inv` varchar(20) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_transaksi` varchar(30) NOT NULL,
  `dikirim_oleh` varchar(30) NOT NULL,
  `user_created` varchar(30) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_updated` varchar(20) NOT NULL,
  `updated_date` varchar(20) NOT NULL,
  `status_simpan` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inv_nonppn`
--

INSERT INTO `inv_nonppn` (`id_inv_nonppn`, `no_inv`, `tgl_inv`, `cs_inv`, `tgl_tempo`, `sp_disc`, `note_inv`, `kategori_inv`, `ongkir`, `total_harga`, `status_transaksi`, `dikirim_oleh`, `user_created`, `created_date`, `user_updated`, `updated_date`, `status_simpan`) VALUES
('NONPPN-2306620aa528e65e08', '017/KM/VI/2023', '08/06/2023', 'abc', '08/06/2023', 0.0, 'Kirim Gojek', 'Reguler', 0, 0, 'Belum Dikirim', '', 'Dany Pratama Saputro', '2023-06-08 13:26:16', '', '', 0),
('NONPPN-23069682d31f534208', '020/KM/VI/2023', '08/06/2023', 'abc', '08/06/2023', 0.0, 'Kirim Gojek', 'Reguler', 0, 0, 'Belum Dikirim', '', 'Dany Pratama Saputro', '2023-06-08 13:31:34', '', '', 0),
('NONPPN-23069e9565e4f2b908', '016/KM/VI/2023', '08/06/2023', 'abc', '08/06/2023', 0.0, 'Kirim Gojek', 'Reguler', 0, 0, 'Belum Dikirim', '', '', '2023-06-08 12:21:01', '', '', 0),
('NONPPN-2306a27320d92a9c08', '015/KM/VI/2023', '08/06/2023', 'abc', '08/06/2023', 0.0, 'Kirim Gojek', 'Reguler', 0, 0, 'Belum Dikirim', '', '', '2023-06-08 11:52:50', '', '', 0),
('NONPPN-2306ab522967e52c08', '019/KM/VI/2023', '08/06/2023', 'abc', '08/06/2023', 0.0, 'Kirim Gojek', 'Reguler', 0, 0, 'Belum Dikirim', '', 'Dany Pratama Saputro', '2023-06-08 13:30:42', '', '', 0),
('NONPPN-2306e33ff6d4d0b008', '018/KM/VI/2023', '08/06/2023', 'abc', '08/06/2023', 0.0, 'Kirim Gojek', 'Reguler', 0, 0, 'Belum Dikirim', '', 'Dany Pratama Saputro', '2023-06-08 13:27:54', '', '', 0);

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
('BR-OUT-2327b6cf35acba05', 'USER47100114a730', 'BR-REGffb0b62a09cf', 500, 'KET-OUT-3be1123e6e26', '23/05/2023, 14:57'),
('BR-OUT-235fa612a9f32405', 'USER03595a8447ab', 'BR-REGe2e00ce0199b', 100, 'KET-OUT-5994e66e943d', '23/05/2023, 14:40'),
('BR-OUT-2383b0ba6f6d3e05', 'USER03595a8447ab', 'BR-REGffb0b62a09cf', 300, 'KET-OUT-3be1123e6e26', '23/05/2023, 14:53');

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

-- --------------------------------------------------------

--
-- Table structure for table `isi_br_tambahan`
--

CREATE TABLE `isi_br_tambahan` (
  `id_isi_br_tambahan` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_ket_in` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `isi_br_tambahan`
--

INSERT INTO `isi_br_tambahan` (`id_isi_br_tambahan`, `id_user`, `id_produk_reg`, `qty`, `id_ket_in`, `created_date`) VALUES
('BR-TAMBAHAN-23e9119de3836505', 'USER03595a8447ab', 'BR-REGffb0b62a09cf', 1000, 'Pilih...', '23/05/2023, 11:55');

--
-- Triggers `isi_br_tambahan`
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
-- Table structure for table `isi_inv_br_import`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `isi_inv_br_import`
--

INSERT INTO `isi_inv_br_import` (`id_isi_inv_br_import`, `id_inv_br_import`, `id_produk_reg`, `qty`, `id_user`, `created_date`, `updated_date`, `user_updated`) VALUES
('BR-IMPORT-23c54205625a1305', 'INV-IMPORT414edd954c45', 'BR-REG6d4d12f6c304', 1000, 'USER03595a8447ab', '23/05/2023, 16:39', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `isi_inv_br_in_lokal`
--

CREATE TABLE `isi_inv_br_in_lokal` (
  `id_isi_inv_br_in_lokal` varchar(50) NOT NULL,
  `id_inv_br_in_lokal` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `isi_inv_br_in_lokal`
--

INSERT INTO `isi_inv_br_in_lokal` (`id_isi_inv_br_in_lokal`, `id_inv_br_in_lokal`, `id_user`, `id_produk_reg`, `qty`, `created_date`) VALUES
('BR-LOKAL-2374f539a708ab05', 'INV-LOKAL29304ecbc0fa', 'USER03595a8447ab', 'BR-REGffb0b62a09cf', 1000, '23/05/2023, 11:55');

--
-- Triggers `isi_inv_br_in_lokal`
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
-- Table structure for table `isi_produk_set_marwa`
--

CREATE TABLE `isi_produk_set_marwa` (
  `id_isi_set_marwa` varchar(50) NOT NULL,
  `id_set_marwa` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `isi_produk_set_marwa`
--

INSERT INTO `isi_produk_set_marwa` (`id_isi_set_marwa`, `id_set_marwa`, `id_produk`, `qty`) VALUES
('BR-SET-MRW-3b692d8521ec', 'SETMRW608112486bb9', 'BR-REGffb0b62a09cf', 1000),
('BR-SET-MRW-a68c1d2ebad8', 'SETMRW608112486bb9', 'BR-REG6d4d12f6c304', 1100);

-- --------------------------------------------------------

--
-- Table structure for table `keterangan_in`
--

CREATE TABLE `keterangan_in` (
  `id_ket_in` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `ket_in` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `keterangan_out`
--

CREATE TABLE `keterangan_out` (
  `id_ket_out` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `ket_out` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `keterangan_out`
--

INSERT INTO `keterangan_out` (`id_ket_out`, `id_user`, `ket_out`, `created_date`) VALUES
('KET-OUT-3be1123e6e26', 'USER03595a8447ab', 'Riject', '23/05/2023, 10:15');

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
  `menu_cancel` varchar(20) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `user_updated` varchar(25) NOT NULL,
  `updated_date` varchar(25) NOT NULL,
  `user_cancel` varchar(50) NOT NULL,
  `date_cancel` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spk_reg`
--

INSERT INTO `spk_reg` (`id_spk_reg`, `id_user`, `id_customer`, `id_inv`, `id_sales`, `id_orderby`, `status_spk`, `no_spk`, `no_po`, `tgl_spk`, `tgl_pesanan`, `note`, `menu_cancel`, `created_date`, `user_updated`, `updated_date`, `user_cancel`, `date_cancel`) VALUES
('SPKREG-23062d62bd096b9406', 'USER03595a8447ab', 'CS015858a52568', '', 'SL1bb8c1f9e592', 'ORDERa55599e088ce', 'Cancel Order', '001/SPK/VI/2023', '001', '06/06/2023, 19:49', '06/06/2023', 'Harga Tidak Cocok', 'Dalam Proses', '06/06/2023, 19:49', '', '', 'dany_pratama', '06/06/2023, 19:53:29'),
('SPKREG-230660a24114639608', 'USER03595a8447ab', 'CS015858a52568', 'NONPPN-23069682d31f534208', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Invoice Sudah Diterbitkan', '003/SPK/VI/2023', '172/PO-dsa/VI/2023', '08/06/2023, 9:11', '08/06/2023', '', '', '08/06/2023, 9:11', '', '', '', ''),
('SPKREG-2306d338fb231a7307', 'USER03595a8447ab', 'CS01111c859db5', 'NONPPN-23069682d31f534208', 'SL1bb8c1f9e592', 'ORDERa55599e088ce', 'Invoice Sudah Diterbitkan', '002/SPK/VI/2023', 'PO IUD IMPLANT BATUBARA', '07/06/2023, 8:42', '07/06/2023', '', '', '07/06/2023, 8:42', '', '', '', ''),
('SPKREG-2306f6b9f4deb64308', 'USER03595a8447ab', 'CS018b7ca30d99', '', 'SL1bb8c1f9e592', 'ORDERe51d8b7e2db9', 'Belum Diproses', '004/SPK/VI/2023', '001', '08/06/2023, 14:34', '08/06/2023', '', '', '08/06/2023, 14:34', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `stock_produk_reguler`
--

CREATE TABLE `stock_produk_reguler` (
  `id_stock_prod_reg` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock_produk_reguler`
--

INSERT INTO `stock_produk_reguler` (`id_stock_prod_reg`, `id_user`, `id_produk_reg`, `stock`, `created_date`) VALUES
('STOCKREG194c62c4f0f1', 'USER34e2f73c9751', 'BR-REGb74bb17fa836', 700, '24/05/2023, 17:09'),
('STOCKREG40bcdec3c8d0', 'USER03595a8447ab', 'BR-REG6d4d12f6c304', 900, '23/05/2023, 17:06'),
('STOCKREGb175abd5c42f', 'USER03595a8447ab', 'BR-REGffb0b62a09cf', 998893, '23/05/2023, 11:51');

-- --------------------------------------------------------

--
-- Table structure for table `tb_customer`
--

CREATE TABLE `tb_customer` (
  `id_cs` varchar(25) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_cs` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `updated_date` varchar(50) NOT NULL,
  `user_updated` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_customer`
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
('CS0aaa83f3c50d', '', 'PT. Mitra Medika Sejahterabersama', '', '08xx', 'Pasar Segar Paal Ruko Blok Rc. No 11, Jl. Yos Sudarso No 12 Paal Dua, Tikala Manado', '', '', ''),
('CS0c4c20e98a3c', '', 'Ibu Susan ( Toko Berkah )', '', '08xx', 'Jakarta', '', '', ''),
('CS0ce9f7c1a16b', '', 'PT. Sigra Duta Medical', '', '', 'Jl. Purnama No. 3 A , Kota Baru Jambi', '', '', ''),
('CS0dcca0062d19', '', 'Bapak Richard', '', '08xx', 'Jakarta', '', '', ''),
('CS0e232d568a2f', '', 'PT. Medtek', '', '', 'Delta Building Blok A-11 Jl. Suryopranoto No 1-9 Jakarta Pusat', '', '', ''),
('CS107272547638', '', 'Bapak Guntur', '', '08xx', 'Jakarta', '', '', ''),
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
-- Table structure for table `tb_kat_penjualan`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kat_penjualan`
--

INSERT INTO `tb_kat_penjualan` (`id_kat_penjualan`, `id_user`, `nama_kategori`, `min_stock`, `max_stock`, `created_date`, `updated_date`, `user_updated`) VALUES
('KATPENJ64328641f032', 'USER47100114a730', 'Fast Market ', 1000, 50000, '23/05/2023, 10:25', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kat_produk`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kat_produk`
--

INSERT INTO `tb_kat_produk` (`id_kat_produk`, `id_user`, `nama_kategori`, `id_merk`, `no_izin_edar`, `created_date`, `updated_date`, `user_updated`) VALUES
('KATPROD2ec542dacb2a', 'USER47100114a730', 'Surgical Instrument', 'MERK2ce36179b1d3', '2121231313131313', '23/05/2023, 10:18', '', ''),
('KATPROD4e8e83106dc2', 'USER34e2f73c9751', 'iud', 'MERK36d48fe7aff0', 'AKL12548621', '26/05/2023, 15:46', '', ''),
('KATPROD536974b61951', 'USER03595a8447ab', 'Operating Scissors - Saffa', '', '1111111', '23/05/2023, 11:44', '', ''),
('KATPRODada57ad8f3e1', 'USER47100114a730', 'Operating Scissors - Saffa', 'Marwa', '212123131313188', '23/05/2023, 10:18', '23/05/2023, 11:42', 'USER03595a8447ab'),
('KATPRODef22e44d1e27', 'USER47100114a730', 'SS', 'MERK2ce36179b1d3', '2121231313131313', '23/05/2023, 10:15', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lokasi_produk`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_lokasi_produk`
--

INSERT INTO `tb_lokasi_produk` (`id_lokasi`, `id_user`, `nama_lokasi`, `no_lantai`, `nama_area`, `no_rak`, `created_date`, `updated_date`, `user_updated`) VALUES
('LOK172cba11ee8d', 'USER03595a8447ab', 'P1-15', '1', 'Surgical', '12', '', '', ''),
('LOK2f313907fa89', 'USER34e2f73c9751', 'kma ', '3', 'IUD', '45', '26/05/2023, 15:48', '', ''),
('LOK5a52042305bc', 'USER03595a8447ab', 'kma ', '2', 'Forceps', '1-1', '15/03/2023, 17:04', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_merk`
--

CREATE TABLE `tb_merk` (
  `id_merk` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_merk` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_merk`
--

INSERT INTO `tb_merk` (`id_merk`, `id_user`, `nama_merk`, `created_date`) VALUES
('MERK2ce36179b1d3', 'USER03595a8447ab', 'Saffa', '11/03/2023, 17:57'),
('MERK36d48fe7aff0', 'USER03595a8447ab', 'Marwa', '13/03/2023, 11:32');

-- --------------------------------------------------------

--
-- Table structure for table `tb_orderby`
--

CREATE TABLE `tb_orderby` (
  `id_orderby` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `order_by` varchar(20) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_orderby`
--

INSERT INTO `tb_orderby` (`id_orderby`, `id_user`, `order_by`, `created_date`) VALUES
('ORDERa55599e088ce', 'USER47100114a730', 'Email', '24/05/2023, 16:52'),
('ORDERe51d8b7e2db9', 'USER03595a8447ab', 'Whatsapp', '24/05/2023, 16:30');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk_grade`
--

CREATE TABLE `tb_produk_grade` (
  `id_grade` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_grade` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_produk_grade`
--

INSERT INTO `tb_produk_grade` (`id_grade`, `id_user`, `nama_grade`, `created_date`) VALUES
('GRADE51ee38cc29ad', 'USER03595a8447ab', 'Reguler', '15/03/2023, 16:29');

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk_reguler`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_produk_reguler`
--

INSERT INTO `tb_produk_reguler` (`id_produk_reg`, `id_user`, `id_merk`, `id_kat_produk`, `id_kat_penjualan`, `id_grade`, `id_lokasi`, `kode_produk`, `nama_produk`, `harga_produk`, `gambar`, `created_date`, `updated_date`, `user_updated`, `register_value`) VALUES
('BR-REG072519133768', 'USER03595a8447ab', 'MERK36d48fe7aff0', 'KATPRODf77d30badbc6', 'KATPENJ3a92d8708967', 'GRADE51ee38cc29ad', 'LOK172cba11ee8d', 'M-DF18', 'Thumb Dressing Forceps 18 cm', 15000, 'IMG641e801508f53.jpg', '16/03/2023, 19:58', '06/04/2023, 9:21', '', 0),
('BR-REG2fa92bf1f42b', 'USER03595a8447ab', 'MERK2ce36179b1d3', 'KATPRODafef61dd4c39', 'KATPENJ3a92d8708967', 'GRADE51ee38cc29ad', 'LOK172cba11ee8d', 'M-MAYO17', 'Mayo Scissors 17 CM', 15000, 'IMG641ea85d5bd0a.jpg', '25/03/2023, 14:53', '', '', 0),
('BR-REG6d4d12f6c304', 'USER03595a8447ab', 'MERK2ce36179b1d3', 'KATPRODf77d30badbc6', 'KATPENJ3a92d8708967', 'GRADE51ee38cc29ad', 'LOK172cba11ee8d', 'S-DF18', 'Thumb Dressing Forceps 18 cm', 20000, 'IMG642e2cd2f0809.jpg', '06/04/2023, 9:22', '', '', 1),
('BR-REGb74bb17fa836', 'USER34e2f73c9751', 'MERK2ce36179b1d3', 'KATPRODef22e44d1e27', 'KATPENJ64328641f032', 'GRADE51ee38cc29ad', 'LOK5a52042305bc', '95846', 'dressing drum ', 450000, 'IMG646de1a77cbb0.jpg', '24/05/2023, 17:06', '', '', 1),
('BR-REGd5137f56b7b4', 'USER03595a8447ab', 'MERK36d48fe7aff0', 'KATPRODafef61dd4c39', 'KATPENJ3a92d8708967', 'GRADE51ee38cc29ad', 'LOK5a52042305bc', 'M-COTTONPLIER', 'Meriam Cotton Plier', 15000, 'IMG641e7adc19849.jpg', '25/03/2023, 11:35', '25/03/2023, 12:00', '', 0),
('BR-REGe2e00ce0199b', 'USER03595a8447ab', 'MERK2ce36179b1d3', 'KATPRODf77d30badbc6', 'KATPENJ3a92d8708967', 'GRADE51ee38cc29ad', 'LOK172cba11ee8d', 'M-DF16', 'Thumb Dressing Forceps 16 cm', 7500, 'IMG641e90d9b5fcf.jpg', '16/03/2023, 19:20', '25/03/2023, 13:12', '', 0),
('BR-REGffb0b62a09cf', 'USER47100114a730', 'MERK2ce36179b1d3', 'KATPRODafef61dd4c39', 'KATPENJ3a92d8708967', 'GRADE51ee38cc29ad', 'LOK5a52042305bc', '1111', 'Abc', 428000, 'IMG642e73886c763.jpg', '06/04/2023, 14:24', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_produk_set_marwa`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_produk_set_marwa`
--

INSERT INTO `tb_produk_set_marwa` (`id_set_marwa`, `kode_set_marwa`, `nama_set_marwa`, `id_user`, `id_lokasi`, `id_merk`, `harga_set_marwa`, `stock`, `created_date`, `updated_date`, `user_updated`) VALUES
('SETMRW608112486bb9', '001', 'Minor', 'USER03595a8447ab', 'LOK172cba11ee8d', 'MERK2ce36179b1d3', 30000, 2, '23/05/2023, 17:11', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sales`
--

CREATE TABLE `tb_sales` (
  `id_sales` varchar(50) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `nama_sales` varchar(30) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_sales`
--

INSERT INTO `tb_sales` (`id_sales`, `id_user`, `nama_sales`, `no_telp`, `created_date`) VALUES
('SL1bb8c1f9e592', 'USER03595a8447ab', 'Agung', '08111', '24/05/2023, 14:19');

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id_sp`, `id_user`, `nama_sp`, `no_telp`, `alamat`, `created_date`, `updated_date`, `user_updated`) VALUES
('SP0d8111e5dcf6', '', 'Sulina', '08xxxx', 'Jakarta', '06/03/2023, 2:59', '', ''),
('SP1407504e42bd', '', 'Patwal Surgical', '081xxxxx', 'Pakistan', '08/03/2023, 13:55', '08/03/2023, 13:58', ''),
('SP5d25a18a4094', '', 'Permanent Medical', '081xx', ' Pakistan ', '', '', ''),
('SP75d3d772951e', '', 'China Alibaba', '0xxxx', 'China', '', '10/03/2023, 9:16', '');

-- --------------------------------------------------------

--
-- Table structure for table `tmp_produk_spk`
--

CREATE TABLE `tmp_produk_spk` (
  `id_tmp` varchar(50) NOT NULL,
  `id_spk` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `status_tmp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tmp_produk_spk`
--

INSERT INTO `tmp_produk_spk` (`id_tmp`, `id_spk`, `id_produk`, `qty`, `status_tmp`) VALUES
('20235efae4e3a79306', 'SPKREG-2306f6b9f4deb64308', 'BR-REGffb0b62a09cf', 1007, 1);

--
-- Triggers `tmp_produk_spk`
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
-- Table structure for table `transaksi_produk_reg`
--

CREATE TABLE `transaksi_produk_reg` (
  `id_transaksi` varchar(50) NOT NULL,
  `id_spk` varchar(50) NOT NULL,
  `id_produk` varchar(50) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `disc` decimal(3,1) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_produk_reg`
--

INSERT INTO `transaksi_produk_reg` (`id_transaksi`, `id_spk`, `id_produk`, `harga`, `qty`, `disc`, `total_harga`, `created_date`) VALUES
('TRX-230619f22d4c2f4c08', 'SPKREG-2306d338fb231a7307', 'BR-REGb74bb17fa836', 450000, 100, 0.0, 0, '2023-06-08 09:12:07'),
('TRX-2306340aac2bcf8e08', 'SPKREG-230660a24114639608', 'BR-REGffb0b62a09cf', 428000, 100, 0.0, 0, '2023-06-08 09:12:00'),
('TRX-23063a5deb8e19a408', 'SPKREG-2306d338fb231a7307', 'BR-REGffb0b62a09cf', 428000, 7598, 0.0, 0, '2023-06-08 09:12:07'),
('TRX-2306f79ed7680fae08', 'SPKREG-230660a24114639608', 'BR-REGb74bb17fa836', 450000, 100, 0.0, 0, '2023-06-08 09:12:00');

--
-- Triggers `transaksi_produk_reg`
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
-- Table structure for table `trx_cancel`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trx_cancel`
--

INSERT INTO `trx_cancel` (`id_trx_cancel`, `id_spk`, `id_produk`, `harga`, `qty`, `disc`, `total_harga`, `created_date`) VALUES
('TRX-230678c31cdd8ff506', 'SPKREG-23062d62bd096b9406', 'BR-REGb74bb17fa836', 450000, 100, 0.0, 0, '2023-06-06 19:53:29');

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
-- Dumping data for table `tr_set_marwa`
--

INSERT INTO `tr_set_marwa` (`id_tr_set_marwa`, `id_set_marwa`, `qty`, `id_user`, `created_date`) VALUES
('TR-SET-MRW-2323ee30974ea95c05', 'SETMRW608112486bb9', 2, 'USER03595a8447ab', '23/05/2023, 17:15');

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
  `id_tr_set_marwa` varchar(50) NOT NULL,
  `id_set_marwa` varchar(50) NOT NULL,
  `id_produk_reg` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `id_user` varchar(50) NOT NULL,
  `created_date` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tr_set_marwa_isi`
--

INSERT INTO `tr_set_marwa_isi` (`id_tr_set_marwa_isi`, `id_tr_set_marwa`, `id_set_marwa`, `id_produk_reg`, `qty`, `id_user`, `created_date`) VALUES
('TR-ISI-SET-MRW-2323dac079f3086805', 'TR-SET-MRW-2323ee30974ea95c05', 'SETMRW608112486bb9', 'BR-REG6d4d12f6c304', 2, 'USER03595a8447ab', '23/05/2023, 17:15'),
('TR-ISI-SET-MRW-2323ee30974ea95c05', 'TR-SET-MRW-2323ee30974ea95c05', 'SETMRW608112486bb9', 'BR-REGffb0b62a09cf', 2, 'USER03595a8447ab', '23/05/2023, 17:15');

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

-- --------------------------------------------------------

--
-- Table structure for table `user`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `id_user_role`, `nama_user`, `jenkel`, `email`, `username`, `password`, `created_date`) VALUES
('USER03595a8447ab', 'RL98cb89863ece', 'Dany Pratama Saputro', 'Laki-Laki', 'pratamadany87@gmail.com', 'dany_pratama', '$2y$10$2SooH9kLwLo.fcVq9yXOAOljSTfX2zFG4eUs7IKMPBhv.2Ec/jYEm', '07/03/2023, 9:32'),
('USER34e2f73c9751', 'RL98cb89863ece', 'Abidah', 'Perempuan', 'abidah@gmail.com', 'Abidah', '$2y$10$BtF3UJG/S.HBJ1W.TaPy8OwxO3ry15ctjzaPhipHVK8eQv8lr0DTO', '23/05/2023, 17:27'),
('USER47100114a730', 'RLf278f224eb37', 'Paijo', 'Laki-Laki', 'firmansyahas@hotmail.com', 'Firmansyah13', '$2y$10$GdptgMT/.caxIDdPzmCltuSXcg43nQweyPuJELUaW7dooM.pD/JxG', '07/03/2023, 9:36');

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_history`
--

INSERT INTO `user_history` (`id_history`, `id_user`, `login_time`, `logout_time`, `ip_login`, `perangkat`, `jenis_perangkat`, `lokasi`, `status_perangkat`) VALUES
('HIS0032debdef12', 'USER47100114a730', '06/06/2023 17:51:52', '', '110.138.89.254', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HIS0067aa877a20', 'USER03595a8447ab', '03/06/2023 10:13:40', '', '110.138.83.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS0406bcd8995f', 'USER34e2f73c9751', '25/05/2023 8:03:20', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS07e3a3adf44c', 'USER47100114a730', '02/06/2023 6:20:39', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HIS0be4dcae2c22', 'USER47100114a730', '23/05/2023 11:20:45', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS0d3b834789c6', 'USER47100114a730', '02/06/2023 17:32:03', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_2 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HIS130abc404849', 'USER34e2f73c9751', '26/05/2023 9:35:24', '', '110.138.92.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS1433744e3f20', 'USER47100114a730', '23/05/2023 10:14:26', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS18a9956e557e', 'USER03595a8447ab', '07/06/2023 8:36:27', '2023/06/07 9:24:46', '125.160.234.251', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Offline'),
('HIS197edeca5663', 'USER47100114a730', '25/05/2023 9:00:48', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS1f982dd2f54d', 'USER47100114a730', '06/06/2023 17:51:52', '', '110.138.89.254', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HIS26c340adec2a', 'USER47100114a730', '25/05/2023 13:06:02', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS28d3de1dc028', 'USER03595a8447ab', '23/05/2023 17:05:40', '', '180.244.166.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS39a99f93e968', 'USER03595a8447ab', '29/05/2023 9:10:29', '', '110.138.93.247', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS3d085f572541', 'USER03595a8447ab', '31/05/2023 15:59:35', '', '110.138.94.146', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS4336312cc383', 'USER03595a8447ab', '23/05/2023 14:52:26', '', '110.138.80.148', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS448965bcd4d7', 'USER03595a8447ab', '02/06/2023 19:13:23', '', '103.155.168.17', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36', 'Mobile', 'Karawang,Indonesia\n', 'Online'),
('HIS4a91337fde93', 'USER34e2f73c9751', '29/05/2023 13:39:29', '', '110.138.89.200', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS5e58834b05d2', 'USER47100114a730', '23/05/2023 14:57:02', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS5e90966c60da', 'USER34e2f73c9751', '29/05/2023 9:19:37', '', '110.138.89.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS61beed25c823', 'USER34e2f73c9751', '25/05/2023 14:58:20', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS6ca5203a7330', 'USER03595a8447ab', '24/05/2023 16:43:23', '', '125.160.230.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS7846a686d478', 'USER47100114a730', '23/05/2023 10:37:46', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS7bdd837926d1', 'USER03595a8447ab', '26/05/2023 8:41:51', '', '110.138.87.166', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS85a5ddfd7a2f', 'USER47100114a730', '24/05/2023 16:52:13', '', '110.138.85.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS876cd0b32b8b', 'USER47100114a730', '25/05/2023 13:06:01', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIS8dd4eaf0fb8f', 'USER47100114a730', '03/06/2023 8:41:31', '', '112.215.235.250', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HIS9e2d8d0ae92e', 'USER34e2f73c9751', '26/05/2023 15:44:49', '', '110.138.92.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISa2e6b85fe592', 'USER03595a8447ab', '23/05/2023 17:28:14', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISa968ef15a554', 'USER34e2f73c9751', '24/05/2023 16:55:05', '', '114.79.3.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISaa49f46a5c35', 'USER34e2f73c9751', '29/05/2023 9:50:45', '', '110.138.89.108', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISb00ba4b820bf', 'USER03595a8447ab', '25/05/2023 12:00:43', '2023/05/25 12:02:22', '180.242.71.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Offline'),
('HISb56f6e52db24', 'USER34e2f73c9751', '26/05/2023 8:28:28', '', '110.138.92.44', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISb89ed5fb6c5b', 'USER47100114a730', '06/06/2023 9:49:44', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/113.0.5672.121 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HISbcf16947601e', 'USER03595a8447ab', '03/06/2023 9:27:55', '', '110.138.83.9', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISc02b5b55aeb6', 'USER03595a8447ab', '23/05/2023 11:42:32', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISc56e0c456135', 'USER34e2f73c9751', '24/05/2023 16:14:52', '', '114.79.3.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISc6fbc3189b82', 'USER47100114a730', '05/06/2023 15:05:40', '', '110.138.87.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HIScf6427638413', 'USER34e2f73c9751', '25/05/2023 9:14:32', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISd301cefd97d8', 'USER47100114a730', '07/06/2023 8:13:12', '', '111.95.61.0', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/114.0.5735.99 Mobile/15E148 Safari/604.1', 'Mobile', 'Bekasi,Indonesia\n', 'Online'),
('HISd45648941fe5', 'USER03595a8447ab', '08/06/2023 15:12:18', '2023/06/08 15:43:02', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', ',\r\n', 'Offline'),
('HISd673d360fc81', 'USER03595a8447ab', '05/06/2023 16:44:15', '', '125.160.230.98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISde56ba9d3cff', 'USER47100114a730', '25/05/2023 10:30:40', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISe216e588033b', 'USER03595a8447ab', '06/06/2023 10:08:13', '', '110.138.81.127', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36', 'Mobile', 'Jakarta,Indonesia\n', 'Online'),
('HISe6bdfb3d29d4', 'USER47100114a730', '24/05/2023 16:23:17', '', '110.138.85.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISecc1060510da', 'USER34e2f73c9751', '25/05/2023 14:39:16', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISf21ec41fa931', 'USER03595a8447ab', '24/05/2023 8:26:10', '', '125.160.230.41', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISf69d5157c157', 'USER03595a8447ab', '23/05/2023 16:35:16', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISf9ee9e35dba2', 'USER47100114a730', '25/05/2023 9:12:21', '', '110.138.89.28', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISfdcc159257d5', 'USER03595a8447ab', '06/06/2023 17:35:49', '', '110.138.93.104', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online'),
('HISfe52bb262bf2', 'USER03595a8447ab', '23/05/2023 15:01:39', '', '125.160.225.145', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36', 'Desktop', 'Jakarta,Indonesia\n', 'Online');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user_role` char(20) NOT NULL,
  `role` varchar(20) DEFAULT NULL,
  `created_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_user_role`, `role`, `created_date`) VALUES
('RL3375d09e45b3', 'Admin Gudang', '06/03/2023, 13:52'),
('RL98cb89863ece', 'Super Admin', '04/03/2023, 9:35'),
('RLf278f224eb37', 'Manager Gudang', '06/03/2023, 13:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `act_br_import`
--
ALTER TABLE `act_br_import`
  ADD PRIMARY KEY (`id_act_br_import`);

--
-- Indexes for table `ganti_merk_reg_in`
--
ALTER TABLE `ganti_merk_reg_in`
  ADD PRIMARY KEY (`id_ganti_merk_in`);

--
-- Indexes for table `ganti_merk_reg_out`
--
ALTER TABLE `ganti_merk_reg_out`
  ADD PRIMARY KEY (`id_ganti_merk_out`);

--
-- Indexes for table `inv_br_import`
--
ALTER TABLE `inv_br_import`
  ADD PRIMARY KEY (`id_inv_br_import`);

--
-- Indexes for table `inv_br_in_lokal`
--
ALTER TABLE `inv_br_in_lokal`
  ADD PRIMARY KEY (`id_inv_br_in_lokal`);

--
-- Indexes for table `inv_nonppn`
--
ALTER TABLE `inv_nonppn`
  ADD PRIMARY KEY (`id_inv_nonppn`),
  ADD UNIQUE KEY `no_inv` (`no_inv`);

--
-- Indexes for table `isi_br_out_reg`
--
ALTER TABLE `isi_br_out_reg`
  ADD PRIMARY KEY (`id_isi_br_out_reg`);

--
-- Indexes for table `isi_br_tambahan`
--
ALTER TABLE `isi_br_tambahan`
  ADD PRIMARY KEY (`id_isi_br_tambahan`);

--
-- Indexes for table `isi_inv_br_import`
--
ALTER TABLE `isi_inv_br_import`
  ADD PRIMARY KEY (`id_isi_inv_br_import`);

--
-- Indexes for table `isi_inv_br_in_lokal`
--
ALTER TABLE `isi_inv_br_in_lokal`
  ADD PRIMARY KEY (`id_isi_inv_br_in_lokal`);

--
-- Indexes for table `isi_produk_set_marwa`
--
ALTER TABLE `isi_produk_set_marwa`
  ADD PRIMARY KEY (`id_isi_set_marwa`);

--
-- Indexes for table `keterangan_in`
--
ALTER TABLE `keterangan_in`
  ADD PRIMARY KEY (`id_ket_in`);

--
-- Indexes for table `keterangan_out`
--
ALTER TABLE `keterangan_out`
  ADD PRIMARY KEY (`id_ket_out`);

--
-- Indexes for table `spk_reg`
--
ALTER TABLE `spk_reg`
  ADD PRIMARY KEY (`id_spk_reg`),
  ADD KEY `id_spk_reg` (`id_spk_reg`);

--
-- Indexes for table `stock_produk_reguler`
--
ALTER TABLE `stock_produk_reguler`
  ADD PRIMARY KEY (`id_stock_prod_reg`);

--
-- Indexes for table `tb_customer`
--
ALTER TABLE `tb_customer`
  ADD PRIMARY KEY (`id_cs`);

--
-- Indexes for table `tb_kat_penjualan`
--
ALTER TABLE `tb_kat_penjualan`
  ADD PRIMARY KEY (`id_kat_penjualan`);

--
-- Indexes for table `tb_kat_produk`
--
ALTER TABLE `tb_kat_produk`
  ADD PRIMARY KEY (`id_kat_produk`);

--
-- Indexes for table `tb_lokasi_produk`
--
ALTER TABLE `tb_lokasi_produk`
  ADD PRIMARY KEY (`id_lokasi`);

--
-- Indexes for table `tb_orderby`
--
ALTER TABLE `tb_orderby`
  ADD PRIMARY KEY (`id_orderby`);

--
-- Indexes for table `tb_produk_grade`
--
ALTER TABLE `tb_produk_grade`
  ADD PRIMARY KEY (`id_grade`);

--
-- Indexes for table `tb_produk_reguler`
--
ALTER TABLE `tb_produk_reguler`
  ADD PRIMARY KEY (`id_produk_reg`);

--
-- Indexes for table `tb_produk_set_marwa`
--
ALTER TABLE `tb_produk_set_marwa`
  ADD PRIMARY KEY (`id_set_marwa`);

--
-- Indexes for table `tb_sales`
--
ALTER TABLE `tb_sales`
  ADD PRIMARY KEY (`id_sales`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id_sp`);

--
-- Indexes for table `tmp_produk_spk`
--
ALTER TABLE `tmp_produk_spk`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indexes for table `transaksi_produk_reg`
--
ALTER TABLE `transaksi_produk_reg`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `trx_cancel`
--
ALTER TABLE `trx_cancel`
  ADD PRIMARY KEY (`id_trx_cancel`);

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

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `role_user` (`id_user_role`);

--
-- Indexes for table `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_user_role`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `role_user` FOREIGN KEY (`id_user_role`) REFERENCES `user_role` (`id_user_role`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
