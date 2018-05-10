-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 10-Out-2017 às 00:07
-- Versão do servidor: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yeseo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `floor_enemies`
--

CREATE TABLE `floor_enemies` (
  `id` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL,
  `enemy_id` int(11) NOT NULL,
  `chance` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `floor_enemies`
--

INSERT INTO `floor_enemies` (`id`, `floor_id`, `enemy_id`, `chance`) VALUES
(1, 1, 1001, 70),
(2, 1, 1002, 25),
(3, 1, 1003, 5),
(4, 2, 2001, 70),
(5, 2, 2002, 25),
(6, 2, 2003, 5),
(7, 3, 3001, 70),
(8, 3, 3002, 25),
(9, 3, 3003, 5),
(10, 4, 4001, 70),
(11, 4, 4002, 25),
(12, 4, 4003, 5),
(13, 5, 5001, 70),
(14, 5, 5002, 25),
(15, 5, 5003, 5),
(16, 6, 6001, 70),
(17, 6, 6002, 25),
(18, 6, 6003, 5),
(19, 7, 7001, 70),
(20, 7, 7002, 25),
(21, 7, 7003, 5),
(22, 8, 8001, 70),
(23, 8, 8002, 25),
(24, 8, 8003, 5),
(25, 9, 9001, 70),
(26, 9, 9002, 25),
(27, 9, 9003, 5),
(28, 10, 10001, 70),
(29, 10, 10002, 25),
(30, 10, 10003, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `floor_enemies`
--
ALTER TABLE `floor_enemies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `floor_enemies`
--
ALTER TABLE `floor_enemies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
