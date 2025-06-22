-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 02:33 AM
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
-- Database: `online_bagis`
--

DELIMITER $$
--
-- Procedures
--
DELIMITER $$

CREATE PROCEDURE `yeni_bagis` (`kid` INT, `kampid` INT, `miktar` DECIMAL(10,2))  
BEGIN
  INSERT INTO bagislar (kullanici_id, kampanya_id, miktar) VALUES (kid, kampid, miktar);
END$$

DELIMITER ;

--
CREATE FUNCTION `toplam_bagis_fonk` (`kampanya` INT) RETURNS DECIMAL(10,2)
BEGIN
  DECLARE toplam DECIMAL(10,2);
  SELECT SUM(miktar) INTO toplam FROM bagislar WHERE kampanya_id = kampanya;
  RETURN toplam;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bagislar`
--

CREATE TABLE `bagislar` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `kampanya_id` int(11) DEFAULT NULL,
  `miktar` decimal(10,2) DEFAULT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `bagislar`
--

INSERT INTO `bagislar` (`id`, `kullanici_id`, `kampanya_id`, `miktar`, `tarih`) VALUES
(4, 4, 1, 500.00, '2025-06-18 23:10:42'),
(5, 1, 2, 100.50, '2025-06-18 23:41:48');

--
-- Triggers `bagislar`
--
DELIMITER $$
CREATE TRIGGER `bagis_ekle_trigger` AFTER INSERT ON `bagislar` FOR EACH ROW BEGIN
  UPDATE kampanyalar SET toplam_bagis = toplam_bagis + NEW.miktar WHERE id = NEW.kampanya_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `bagis_ozet`
-- (See below for the actual view)
--
CREATE TABLE `bagis_ozet` (
`kampanya_id` int(11)
,`toplam_bagis` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `kampanyalar`
--

CREATE TABLE `kampanyalar` (
  `id` int(11) NOT NULL,
  `baslik` varchar(100) DEFAULT NULL,
  `aciklama` text DEFAULT NULL,
  `resim` varchar(255) DEFAULT NULL,
  `toplam_bagis` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kampanyalar`
--

INSERT INTO `kampanyalar` (`id`, `baslik`, `aciklama`, `resim`, `toplam_bagis`) VALUES
(1, 'Yetim Çocuklara Destek', 'Yetim çocuklar için gıda ve kıyafet yardımı.', 'kampanya1.jpg', 500.00),
(2, 'Afet Bölgesine Yardım', 'Deprem bölgesine battaniye ve su yardımı ulaştırın. ', 'kampanya2.jpg', 100.50),
(3, 'Eğitime Destek', 'İhtiyaç sahibi öğrencilere kırtasiye yardımı.', 'kampanya3.jpg', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `adsoyad` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sifre` varchar(100) DEFAULT NULL,
  `rol` enum('kullanici','admin') DEFAULT 'kullanici'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `adsoyad`, `email`, `sifre`, `rol`) VALUES
(4, 'Emira Osmani', 'emiraosmani5@gmail.com', '$2y$10$2QJKmiAHDw0AhmGcE/94y.HkoYxCb8p.S5bLycUYvkfNa/x5.i34i', 'kullanici');

-- --------------------------------------------------------

--
-- Structure for view `bagis_ozet`
--
DROP TABLE IF EXISTS `bagis_ozet`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `bagis_ozet` AS 
SELECT `bagislar`.`kampanya_id` AS `kampanya_id`, sum(`bagislar`.`miktar`) AS `toplam_bagis` 
FROM `bagislar` GROUP BY `bagislar`.`kampanya_id` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bagislar`
--
ALTER TABLE `bagislar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kampanyalar`
--
ALTER TABLE `kampanyalar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bagislar`
--
ALTER TABLE `bagislar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kampanyalar`
--
ALTER TABLE `kampanyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
