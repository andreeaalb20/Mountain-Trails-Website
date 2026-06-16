-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 24, 2021 at 03:29 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `photogallery`
--
CREATE DATABASE IF NOT EXISTS `photogallery` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `photogallery`;

-- --------------------------------------------------------

--
-- Table structure for table `carousel`
--

CREATE TABLE `carousel` (
  `id` int(11) NOT NULL,
  `file_name` varchar(64) NOT NULL,
  `file_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `carousel`
--

INSERT INTO `carousel` (`id`, `file_name`, `file_description`) VALUES
(1, 'la.jpg', 'Los Angeles'),
(2, 'chicago.jpg', 'Chicago'),
(3, 'ny.jpg', 'New York');

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `title_description` varchar(64) NOT NULL,
  `img` varchar(64) NOT NULL,
  `long_description` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `title`, `title_description`, `img`, `long_description`, `id_user`) VALUES
(1, 'LA Gallery', 'LA Gallery description', 'la.jpg', 'LA Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.', 1),
(2, 'Chicago Gallery', 'Chicago Gallery description', 'chicago.jpg', 'Chicago Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.', 1),
(3, 'NY Gallery', 'NY Gallery description', 'ny.jpg', 'NY Sunt in culpa qui officia deserunt mollit anim id est laborum consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco.', 1),
(4, 'sport gallery', 'short_title_description', '1620657110_lakebetweenpines.jpg', 'gallery long description', 11);

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `id_gallery` int(11) NOT NULL,
  `picture` varchar(127) NOT NULL,
  `short_title_description` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`id`, `id_gallery`, `picture`, `short_title_description`) VALUES
(1, 1, 'bucuralake.jpg', 'Lacul Bucura primavara'),
(2, 1, 'bucuralake2.jpg', 'Lacul Bucura toamna'),
(3, 1, 'retezatwaterfall.jpg', 'Cascada frumoasa'),
(4, 1, 'bucurapeak.jpg', 'Varful Bucura'),
(5, 1, 'lakebetweenpines.jpg', 'Lac intre brazi'),
(6, 4, '1620723540_bucurapeak.jpg', 'bp11'),
(7, 4, '1620723540_retezatwaterfall.jpg', 'rw22'),
(8, 4, '1620723540_bucuralake.jpg', 'bl33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(45) NOT NULL,
  `password` varchar(60) NOT NULL,
  `user_image` varchar(64) DEFAULT NULL,
  `user_short_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user`, `password`, `user_image`, `user_short_description`) VALUES
(1, 'admin', '$2y$10$XDJj.sbvaGKCEhfAEKy1v.NzR5is7.bFHfwvPnmZDesTVPbHj8k2G', 'admin_image.jpg', 'Admin is the strongest/powerfull user on this website'),
(11, 'guest', '$2y$10$c1D3M/gbKnrDFelF5ljf/er4iy8JRzwhh8zFQnODiNu.ND78CsGzG', NULL, NULL),
(12, 'guest2', '$2y$10$ysJpuIq8jbnHx2RxbJwxrOMdlKKFQRUvW2fL8xLG19M6dI1ptWLva', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carousel`
--
ALTER TABLE `carousel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_file_name` (`file_name`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_USER_idx` (`id_user`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ID_GALLERY` (`id_gallery`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_UNIQUE` (`user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carousel`
--
ALTER TABLE `carousel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `FK_ID_USER` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `FK_ID_GALLERY` FOREIGN KEY (`id_gallery`) REFERENCES `galleries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
