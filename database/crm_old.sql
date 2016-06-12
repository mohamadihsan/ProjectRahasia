-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2016 at 05:22 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crm`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_rekomendasi`
--

DROP TABLE IF EXISTS `detail_rekomendasi`;
CREATE TABLE IF NOT EXISTS `detail_rekomendasi` (
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_rekomendasi` int(11) DEFAULT NULL,
  `isi_pesan` text,
  KEY `constraint_id_pelanggan` (`id_pelanggan`),
  KEY `constraint_id_rekomendasi` (`id_rekomendasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

DROP TABLE IF EXISTS `detail_transaksi`;
CREATE TABLE IF NOT EXISTS `detail_transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah_pembelian` int(11) NOT NULL,
  KEY `constraint_id_transaksi` (`id_transaksi`),
  KEY `constraint_id_produk` (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_transaksi`, `id_produk`, `jumlah_pembelian`) VALUES
(1, 2, 3),
(1, 1, 1),
(1, 5, 1),
(2, 1, 2),
(3, 2, 1),
(3, 5, 1),
(3, 3, 1),
(4, 2, 1),
(4, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

DROP TABLE IF EXISTS `kategori_produk`;
CREATE TABLE IF NOT EXISTS `kategori_produk` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(30) NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Novel'),
(2, 'Buku Sekolah'),
(3, 'Alat Peraga'),
(4, 'Alat Olahraga'),
(5, 'ATK');

-- --------------------------------------------------------

--
-- Table structure for table `keluhan_saran`
--

DROP TABLE IF EXISTS `keluhan_saran`;
CREATE TABLE IF NOT EXISTS `keluhan_saran` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjek` varchar(30) DEFAULT NULL,
  `tgl_keluhansaran` datetime DEFAULT NULL,
  `isi_keluhansaran` text,
  `status_keluhansaran` char(1) DEFAULT NULL,
  `url_foto_struk` varchar(100) DEFAULT NULL,
  `url_foto_keluhan` varchar(100) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `constraint_id_pelanggan_keluhan` (`id_pelanggan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

DROP TABLE IF EXISTS `pegawai`;
CREATE TABLE IF NOT EXISTS `pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `jabatan` enum('direktur','manager','administrasi','pemasaran','pengunjung','inventori') DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_pegawai` (`id_pegawai`),
  KEY `constratint_id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `id_pegawai`, `nama`, `jabatan`, `id_user`) VALUES
(2, 10112645, 'Mohamad Ihsan', 'direktur', 2),
(3, 10112448, 'Iqbal Aditya Pangestu', 'manager', 3),
(4, 10112637, 'Irfan Rangga Gumilar', 'administrasi', 4),
(5, 10112438, 'Julio Febryanto', 'pemasaran', 5),
(7, 10112711, 'Rismoyo Bayu', 'inventori', 9);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(50) DEFAULT NULL,
  `no_telp` varchar(12) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`),
  KEY `constratint_id_user_pelanggan` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `no_telp`, `id_user`) VALUES
(1, 'Hardo Pratama', 'Jalan Dipati Ukur No 10 Bandung', '085720054204', 6),
(2, 'Annisa Amelia', 'Jalan Simpay Asih No 2 Bandung', '087720054255', 8);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

DROP TABLE IF EXISTS `produk`;
CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` int(11) NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(50) NOT NULL,
  `harga` int(11) DEFAULT NULL,
  `status_produk` char(1) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `kode_produk` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id_produk`),
  UNIQUE KEY `kode_produk` (`kode_produk`),
  KEY `constraint_id_kategori` (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `status_produk`, `id_kategori`, `kode_produk`) VALUES
(1, 'Koala Kumal', 60000, 'D', 1, 'BN0001'),
(2, 'Laskar Pelangi', 80000, 'D', 1, 'BN0002'),
(3, 'Erlangga IPA Terpadu 3A', 45000, 'N', 2, 'BS0001'),
(4, 'Bahasa Inggris 2A', 30000, 'N', 2, 'BS0002'),
(5, 'Molten Bola Voli', 350000, 'D', 4, 'AO0001'),
(8, 'Brontosaurus', 85000, NULL, 1, 'BN003');

-- --------------------------------------------------------

--
-- Table structure for table `promosi`
--

DROP TABLE IF EXISTS `promosi`;
CREATE TABLE IF NOT EXISTS `promosi` (
  `id_promosi` int(11) NOT NULL AUTO_INCREMENT,
  `status` char(1) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_promosi`),
  KEY `constratint_id_pegawai` (`id_pegawai`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rekomendasi`
--

DROP TABLE IF EXISTS `rekomendasi`;
CREATE TABLE IF NOT EXISTS `rekomendasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nilai_rekomendasi` float NOT NULL DEFAULT '0',
  `id_kategori` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id_kategori`),
  KEY `id_kategori_2` (`id_kategori`),
  KEY `id_kategori_3` (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int(11) NOT NULL AUTO_INCREMENT,
  `status_transaksi` char(2) DEFAULT NULL,
  `nama_garansi` varchar(30) DEFAULT NULL,
  `telp_garansi` varchar(12) DEFAULT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`),
  KEY `constraint_id_pegawai_trans` (`id_pegawai`),
  KEY `constraint_id_pelanggan_trans` (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `status_transaksi`, `nama_garansi`, `telp_garansi`, `id_pegawai`, `id_pelanggan`) VALUES
(1, 'L', NULL, NULL, 5, 1),
(2, 'L', NULL, NULL, 4, 1),
(3, 'L', '', NULL, 5, 1),
(4, 'L', NULL, NULL, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`) VALUES
(2, 'direktur', '4fbfd324f5ffcdff5dbf6f019b02eca8'),
(3, 'manager', '1d0258c2440a8d19e716292b231e3190'),
(4, 'administrasi', '15ff3c0a0310a2e3de3e95c8aeb328d0'),
(5, 'pemasaran', '229eaac0894a3379d759a720e0e3410c'),
(6, 'pengunjung', '3fbe7200a4b9a894e16c9d998314dc80'),
(8, 'pengunjung2', 'e55093db9c1fcfc25152e7ca2c6d3cab'),
(9, 'inventori', '4e943c28c3b011e0540ff9a19334953b');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_rekomendasi`
--
ALTER TABLE `detail_rekomendasi`
  ADD CONSTRAINT `constraint_id_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_id_rekomendasi` FOREIGN KEY (`id_rekomendasi`) REFERENCES `rekomendasi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `constraint_id_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_id_transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keluhan_saran`
--
ALTER TABLE `keluhan_saran`
  ADD CONSTRAINT `constraint_id_pelanggan_keluhan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `constratint_id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `constratint_id_user_pelanggan` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `constraint_id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_produk` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `promosi`
--
ALTER TABLE `promosi`
  ADD CONSTRAINT `constratint_id_pegawai` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rekomendasi`
--
ALTER TABLE `rekomendasi`
  ADD CONSTRAINT `constraint_id_kategori_rek` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_produk` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `constraint_id_pegawai_trans` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `constraint_id_pelanggan_trans` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;