-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 02, 2021 at 07:42 AM
-- Server version: 8.0.22-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webkpi`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gabungan`
--

CREATE TABLE `tbl_gabungan` (
  `id` int NOT NULL,
  `nik` int NOT NULL,
  `id_kpi` int NOT NULL,
  `id_sop` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kpi`
--

CREATE TABLE `tbl_kpi` (
  `id` int NOT NULL,
  `judul_kpi` varchar(250) NOT NULL,
  `batas_tanggal` date NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_kpi`
--

INSERT INTO `tbl_kpi` (`id`, `judul_kpi`, `batas_tanggal`, `user_id`) VALUES
(11, 'tes3', '2020-02-02', 1),
(12, 'tes123', '2020-02-03', 2),
(19, 'Perbaikan gardu', '2020-02-02', 1),
(20, 'pemasangan listrik', '2020-02-02', 2),
(34, '1', '2020-02-02', 13);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sop`
--

CREATE TABLE `tbl_sop` (
  `id` int NOT NULL,
  `sop` varchar(350) NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `file` varchar(200) NOT NULL,
  `kpi_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_sop`
--

INSERT INTO `tbl_sop` (`id`, `sop`, `status`, `file`, `kpi_id`) VALUES
(32, 'memanjat tiang', 1, '1610984578_c1a3d800fa537521a682.jpg', 20),
(33, 'memanjat tiang', 0, '1610984673_e44fc9e364b1950459fa.jpg', 19),
(35, 'budi', 1, '1611532505_1408ba9bf1b7f9fd8cca.png', 11),
(36, 'tes', 0, '1613299939_76dbb30108d3e76f8a86.png', 11);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int NOT NULL,
  `nik` varchar(16) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nik`, `password`, `level`) VALUES
(1, '1111111111111111', '$2y$10$AZDZjSUAZ9XxgNt1X8fgjOpaI1Yh7jWRuoN4UJFlXYOcnhkniRH8O', 'user'),
(2, '2', '$2y$10$RkBxlN0AjLInoDR/FP9FpunBfDRWuCneRn1.JAMDjG5nBciaXCRyS', 'user'),
(3, '3', '$2y$10$LhXqxquz53W/UbSHyQeQGeUx2rK35ouoxEskdVgnWp.tJFjcf.JFu', 'user'),
(4, '12345', '$2y$10$KxKEKDDATWuJV2tmpsu.gu1YtxaV/tmUrxLS.4e0UensifFHxY6LC', 'admin'),
(13, '1233333333333333', '$2y$10$taKQEk51.MpxjwfgW11WJ.X1kkK9gst06mgui2fX/Z8Asa7t4duYe', 'user'),
(14, '1233333333333339', '$2y$10$ih48JMFVZg5jCFWDS86sbOs0tz2g283Lo6DyI9APLUO8lKLwxodCu', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_info`
--

CREATE TABLE `tbl_user_info` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `nama` varchar(1000) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `handphone` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_user_info`
--

INSERT INTO `tbl_user_info` (`id`, `user_id`, `nama`, `jenis_kelamin`, `handphone`, `email`, `alamat`) VALUES
(1, 3, 'Budi', 'L', '0895352414040', 'riyanriky@gmail.com', 'Jalan pangeran ayin, lrg. Tutwuri Handayani No 58'),
(2, 2, 'andi', 'L', '0895352414040', 'andi@gmail.com', 'palembang'),
(3, 1, 'Robby', 'L', '0895352414040', 'andi@gmail.com', 'palembang'),
(8, 13, 'slamet', 'L', '0895352414040', 'riyanriky@gmail.com', NULL),
(9, 14, 'tes', 'P', '0895352414040', 'riyanriky@gmail.com', NULL),
(10, 4, 'administrator', 'L', '0895352414040', 'riyanriky@gmail.com', 'palembang\r\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_gabungan`
--
ALTER TABLE `tbl_gabungan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nik` (`nik`),
  ADD KEY `id_kpi` (`id_kpi`),
  ADD KEY `id_sop` (`id_sop`);

--
-- Indexes for table `tbl_kpi`
--
ALTER TABLE `tbl_kpi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_sop`
--
ALTER TABLE `tbl_sop`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_gabungan`
--
ALTER TABLE `tbl_gabungan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_kpi`
--
ALTER TABLE `tbl_kpi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_sop`
--
ALTER TABLE `tbl_sop`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_user_info`
--
ALTER TABLE `tbl_user_info`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
