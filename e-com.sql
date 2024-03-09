-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2023 at 05:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-com`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(8) NOT NULL,
  `nom_produit` varchar(255) NOT NULL,
  `prix_unitaire` double NOT NULL,
  `totaleC` double NOT NULL,
  `quantiteC` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(8) NOT NULL,
  `nom_categorie` varchar(255) NOT NULL,
  `datecreation` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_categorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `nom_categorie`, `datecreation`, `image_categorie`) VALUES
(8, 'Phones', '2023-12-13 22:22:58', 'Cat1.png'),
(9, 'Techx', '2023-12-14 09:18:09', 'geor.jpg'),
(16, 'pc', '2023-12-24 16:35:16', 'download.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `id_produit` int(8) NOT NULL,
  `nom_categorie` varchar(255) NOT NULL,
  `id_categorie` int(8) NOT NULL,
  `id_scategorie` int(8) NOT NULL,
  `nom_scategorie` varchar(255) NOT NULL,
  `nom_produit` varchar(255) NOT NULL,
  `prix_produit` double NOT NULL,
  `description` text NOT NULL,
  `image_produit` varchar(255) NOT NULL,
  `quantite` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`id_produit`, `nom_categorie`, `id_categorie`, `id_scategorie`, `nom_scategorie`, `nom_produit`, `prix_produit`, `description`, `image_produit`, `quantite`) VALUES
(28, '', 8, 6, '', 'rog', 0, 'good phone yes', 'h732.png', 0),
(30, '', 8, 6, '', 'iphone 15', 1000, 'wqdsqdqsd', 'iphone.jpg', 100),
(31, '', 9, 7, '', 'samsung s22', 2000, '', 'S22.jpg', 0),
(32, '', 9, 7, '', 'Asus Zephuris', 7000, '', 'zephirus.jpg', 2),
(33, '', 9, 7, '', 'Google Pixel 7', 1000, 'dsq', 'pxel.png', 11),
(34, '', 8, 6, '', 'S23', 20002, 'yesDEAZEA', 'S22.jpg', 10),
(35, '', 8, 6, '', 'SS', 12992, 'The iPhone 11 has a 6.1-inch (15 cm) IPS LCD with a resolution is 1792 × 828 pixels (1.4 megapixels) at a pixel density of 326 PPI with a maximum brightness of 625 nits and a 1400:1 contrast ratio and it is equivalent to the iPhone XR. It supports Dolby Vision, HDR10, True-Tone, and a wide color gamut.', 'iphone11.jpg', 0),
(36, '', 8, 6, '', 'Iphone 11', 2500, 'dsqdsqdsqd', 'iphone11.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `scategorie`
--

CREATE TABLE `scategorie` (
  `id_scategorie` int(8) NOT NULL,
  `id_categorie` int(8) NOT NULL,
  `nom_scategorie` varchar(255) NOT NULL,
  `image_scategorie` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scategorie`
--

INSERT INTO `scategorie` (`id_scategorie`, `id_categorie`, `nom_scategorie`, `image_scategorie`) VALUES
(6, 8, 'Iphones', 'apple.png'),
(7, 9, 'Samsungxw', 'samsung.png'),
(10, 16, 'e', 'pcgamer.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(8) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image_user` varchar(255) NOT NULL,
  `Role` int(1) NOT NULL DEFAULT 2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nom`, `password`, `email`, `image_user`, `Role`) VALUES
(3, 'Admin', '$2y$10$460rnLJj6Iy0p2JDlX3dx.8iLn5LlRzJy598NnSeVg85LuuQvVuRC', 'root@admin.com', 'Gabes1 (1).jpg', 1),
(19, 'php', '$2y$10$haRDc9qNpNKmHhNq3JDEi.lraNCr2GMWJL9Fq.Ga37BX3kaEHDHoC', 'phplove@php.com', 'download.jpeg', 2),
(20, 'man', 'love', 'php1@php2.com', 'assets/image/User/apple.png', 2),
(21, 'php2', 'bob', 'php11@php2.com', '', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`);

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_produit`);

--
-- Indexes for table `scategorie`
--
ALTER TABLE `scategorie`
  ADD PRIMARY KEY (`id_scategorie`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(8) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_produit` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `scategorie`
--
ALTER TABLE `scategorie`
  MODIFY `id_scategorie` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
