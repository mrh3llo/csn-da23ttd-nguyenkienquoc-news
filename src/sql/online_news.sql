-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2025 at 09:18 AM
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
-- Database: `online_news`
--

-- --------------------------------------------------------

--
-- Table structure for table `BAI_BAO`
--

CREATE TABLE `BAI_BAO` (
  `MA_BAI_BAO` varchar(10) NOT NULL,
  `TIEU_DE_BAI_BAO` text NOT NULL,
  `NOI_DUNG_BAI_BAO` text NOT NULL,
  `NGAY_DANG_BAI_BAO` date NOT NULL,
  `MA_TAC_GIA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PHAN_LOAI`
--

CREATE TABLE `PHAN_LOAI` (
  `MA_PHAN_LOAI` varchar(5) NOT NULL,
  `TEN_PHAN_LOAI` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `PHAN_LOAI_BAI_BAO`
--

CREATE TABLE `PHAN_LOAI_BAI_BAO` (
  `MA_BAI_BAO` varchar(10) NOT NULL,
  `MA_PHAN_LOAI` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TAC_GIA`
--

CREATE TABLE `TAC_GIA` (
  `MA_TAC_GIA` varchar(10) NOT NULL,
  `TEN_TAC_GIA` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TAI_KHOAN`
--

CREATE TABLE `TAI_KHOAN` (
  `TEN_TAI_KHOAN` varchar(30) NOT NULL,
  `MAIL_TAI_KHOAN` varchar(100) NOT NULL,
  `MAT_KHAU_TAI_KHOAN` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `TAI_KHOAN`
--

INSERT INTO `TAI_KHOAN` (`TEN_TAI_KHOAN`, `MAIL_TAI_KHOAN`, `MAT_KHAU_TAI_KHOAN`) VALUES
('kquoc', 'quoc@mail.com', '733f0190277afd8a18946e7e0bf14982');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BAI_BAO`
--
ALTER TABLE `BAI_BAO`
  ADD PRIMARY KEY (`MA_BAI_BAO`),
  ADD KEY `TAC_GIA_BAI_BAO` (`MA_TAC_GIA`);

--
-- Indexes for table `PHAN_LOAI`
--
ALTER TABLE `PHAN_LOAI`
  ADD PRIMARY KEY (`MA_PHAN_LOAI`);

--
-- Indexes for table `PHAN_LOAI_BAI_BAO`
--
ALTER TABLE `PHAN_LOAI_BAI_BAO`
  ADD KEY `PHAN_LOAI_BAI_BAO` (`MA_BAI_BAO`),
  ADD KEY `THUOC_PHAN_LOAI` (`MA_PHAN_LOAI`);

--
-- Indexes for table `TAC_GIA`
--
ALTER TABLE `TAC_GIA`
  ADD PRIMARY KEY (`MA_TAC_GIA`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `BAI_BAO`
--
ALTER TABLE `BAI_BAO`
  ADD CONSTRAINT `TAC_GIA_BAI_BAO` FOREIGN KEY (`MA_TAC_GIA`) REFERENCES `TAC_GIA` (`MA_TAC_GIA`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `PHAN_LOAI_BAI_BAO`
--
ALTER TABLE `PHAN_LOAI_BAI_BAO`
  ADD CONSTRAINT `PHAN_LOAI_BAI_BAO` FOREIGN KEY (`MA_BAI_BAO`) REFERENCES `BAI_BAO` (`MA_BAI_BAO`),
  ADD CONSTRAINT `THUOC_PHAN_LOAI` FOREIGN KEY (`MA_PHAN_LOAI`) REFERENCES `PHAN_LOAI` (`MA_PHAN_LOAI`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
