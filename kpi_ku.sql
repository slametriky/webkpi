-- phpMyAdmin SQL Dump
-- version 4.6.6deb5ubuntu0.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2020 at 08:38 PM
-- Server version: 5.7.32-0ubuntu0.18.04.1
-- PHP Version: 7.2.34-8+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kpi_ku`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gabungan`
--

CREATE TABLE `tbl_gabungan` (
  `id` int(25) NOT NULL,
  `nik` int(100) NOT NULL,
  `id_kpi` int(25) NOT NULL,
  `id_sop` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kpi`
--

CREATE TABLE `tbl_kpi` (
  `id` int(25) NOT NULL,
  `judul_kpi` varchar(250) NOT NULL,
  `batas_tanggal` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_kpi`
--

INSERT INTO `tbl_kpi` (`id`, `judul_kpi`, `batas_tanggal`, `user_id`) VALUES
(11, 'tes3', '2020-02-02', 3),
(12, 'tes123', '2020-02-03', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sop`
--

CREATE TABLE `tbl_sop` (
  `id` int(25) NOT NULL,
  `sop` varchar(350) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `file` varchar(200) NOT NULL,
  `kpi_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `nik` int(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `level` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `nik`, `username`, `password`, `email`, `level`) VALUES
(1, 1, 'user', '$2y$10$LhXqxquz53W/UbSHyQeQGeUx2rK35ouoxEskdVgnWp.tJFjcf.JFu', 'budi@gmail.com', 'user'),
(2, 2, '2', 'c81e728d9d4c2f636f067f89cc14862c', NULL, 'user'),
(3, 3, '3', '$2y$10$LhXqxquz53W/UbSHyQeQGeUx2rK35ouoxEskdVgnWp.tJFjcf.JFu', NULL, 'user'),
(4, 12345, 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL, 'admin');

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
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_gabungan`
--
ALTER TABLE `tbl_gabungan`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_kpi`
--
ALTER TABLE `tbl_kpi`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `tbl_sop`
--
ALTER TABLE `tbl_sop`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
