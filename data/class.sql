-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Out-2017 às 13:44
-- Versão do servidor: 5.6.25
-- PHP Version: 5.6.11

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
-- Estrutura da tabela `class`
--

CREATE TABLE IF NOT EXISTS `class` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `class_level` int(11) NOT NULL DEFAULT '0',
  `str_bonus` int(11) NOT NULL DEFAULT '0',
  `int_bonus` int(11) NOT NULL DEFAULT '0',
  `agi_bonus` int(11) NOT NULL DEFAULT '0',
  `dex_bonus` int(11) NOT NULL DEFAULT '0',
  `luk_bonus` int(11) NOT NULL DEFAULT '0',
  `sword_type` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `class`
--

INSERT INTO `class` (`id`, `name`, `class_level`, `str_bonus`, `int_bonus`, `agi_bonus`, `dex_bonus`, `luk_bonus`, `sword_type`) VALUES
(1, 'Aprendiz', 0, 0, 0, 0, 0, 0, 'Espada'),
(2, 'Espadachim', 1, 3, 0, 0, 0, 0, 'Espada'),
(3, 'Mago', 1, 0, 3, 0, 0, 0, 'Cajado'),
(4, 'Arqueiro', 1, 0, 0, 3, 0, 0, 'Arco'),
(5, 'Gatuno', 1, 0, 0, 0, 3, 0, 'Adaga'),
(6, 'Noviço', 1, 0, 3, 0, 0, 0, 'Livro'),
(7, 'Mercador', 1, 0, 0, 0, 0, 3, 'Espada'),
(8, 'Cavaleiro', 2, 5, 0, 0, 0, 0, 'Espada'),
(9, 'Templário', 2, 5, 0, 0, 0, 0, 'Espada e Escudo'),
(10, 'Bruxo', 2, 0, 5, 0, 0, 0, 'Cajado'),
(11, 'Sábio', 2, 0, 5, 0, 0, 0, 'Cajado'),
(12, 'Caçador', 2, 2, 0, 3, 0, 0, 'Arco'),
(13, 'Bardo', 2, 0, 2, 3, 0, 0, 'Violão'),
(14, 'Mercenário', 2, 2, 0, 0, 3, 0, 'Adaga'),
(15, 'Arruaçeiro', 2, 0, 0, 2, 3, 0, 'Adaga'),
(16, 'Sacerdote', 2, 0, 5, 0, 0, 0, 'Livro'),
(17, 'Monge', 2, 5, 0, 0, 0, 0, 'Luvas'),
(18, 'Ferreiro', 2, 3, 0, 0, 0, 2, 'Machado'),
(19, 'Alquimista', 2, 0, 3, 0, 0, 2, 'Livro');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
