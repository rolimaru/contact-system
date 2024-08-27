-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2024 at 10:18 AM
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
-- Database: `contact-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `phone`, `company`, `email`, `user_id`) VALUES
(5, 'User Friend', '121212', 'User Company', 'userFrindemail@gmail.com', 2),
(8, 'Harry Potter', '63 22222 2222', 'Griffins', 'harry@gmail.com', 1),
(13, 'Betta Mole', '0999 999 99', 'Fish Dev', 'fishdev@gmail.com', 1),
(14, 'Edith Kai', '292 999 223', 'MotoCross', 'checkme@gmail.com', 1),
(15, 'test', '121', 'test', 'test@aewaeaw', 1),
(16, 'Sung Jin', '333 333 333', 'Solo Level', 'mrsung@webstar.com', 1),
(17, 'John Doe', '3232 3232', 'unOrdinary', 'johndoe@this.com', 1),
(18, 'Shin Mae', '1231', 'Solo l', 'ewrwqrwerw@ewe', 1),
(19, 'Haya Bumm', '6565656 656', 'Mobile League', 'hayabusaw@ml.com', 1),
(20, 'Silver Rayleigh', '111 111 1111', 'One Piece Inc.', 'darkkings@pirates.com', 1),
(21, 'Uzumaki Naruto', '999 999 000', 'Naruto Dept.', 'naruto@me.com', 1),
(22, 'Feng Shaw', '991 112 3232', 'Ultimate Scans', 'reader@gmail.com', 1),
(23, 'Hinata Hyug', '321321', 'Hyuga Company Inc.', 'hinala@main.js', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`) VALUES
(1, 'roli', 'rolimaru@mail.com', '$2y$10$llxrwuJaAYtH.ymkJiZZDOG2YdgRnvsQ4Vmk2wWn2QAUbkWz9U/1m'),
(2, 'user', 'user@mail.com', '$2y$10$DzXpjrNvo6CG8oWHWNAzCOAGMuF1IKDA.JwPoHUDOXSZZfex0slGu'),
(3, 'Jane', 'jane@try.com', '$2y$10$gXRaKjmNJY9kZBLyMdE6xuXTm3sa5qcn0UdkuRGv7W2ynrH85Z1bW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
