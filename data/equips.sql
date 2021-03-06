-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 18-Fev-2018 às 23:38
-- Versão do servidor: 5.7.11
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Estrutura da tabela `equips`
--

CREATE TABLE `equips` (
  `id` int(11) NOT NULL,
  `name` varchar(25) NOT NULL,
  `image` varchar(50) NOT NULL,
  `in_store` int(11) NOT NULL DEFAULT '0',
  `floor_level` int(11) NOT NULL DEFAULT '1',
  `price` int(11) NOT NULL DEFAULT '0',
  `slot` varchar(20) NOT NULL,
  `rarity` int(11) NOT NULL DEFAULT '1',
  `sword_type` varchar(12) NOT NULL DEFAULT '',
  `handed` int(11) NOT NULL DEFAULT '1',
  `strength` int(11) NOT NULL DEFAULT '0',
  `intelligence` int(11) NOT NULL DEFAULT '0',
  `agility` int(11) NOT NULL DEFAULT '0',
  `dexterity` int(11) NOT NULL DEFAULT '0',
  `lucky` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `equips`
--

INSERT INTO `equips` (`id`, `name`, `image`, `in_store`, `floor_level`, `price`, `slot`, `rarity`, `sword_type`, `handed`, `strength`, `intelligence`, `agility`, `dexterity`, `lucky`, `desc`) VALUES
(1000, 'Espada do Aprendiz', 'espada do aprendiz.gif', 1, 1, 200, 'arma', 1, 'P', 2, 3, 0, 0, 0, 0, NULL),
(1001, 'Lâmina do Aprendiz', 'lamina do aprendiz.gif', 1, 5, 460, 'arma', 1, 'P', 2, 6, 0, 0, 0, 0, NULL),
(1002, 'Cimitarra do Aprendiz', 'cimitarra do aprendiz', 1, 6, 650, 'arma', 1, 'P', 1, 4, 0, 0, 0, 0, NULL),
(1003, 'Florete', 'florete.gif', 0, 9, 0, 'arma', 2, 'P', 1, 7, 0, 2, 0, 0, NULL),
(1100, 'Cajado do Poder', 'cajado do poder.gif', 1, 2, 200, 'arma', 1, 'M', 2, 0, 3, 0, 0, 0, NULL),
(1101, 'Cajado da Floresta', 'cajado da floresta.gif', 1, 4, 460, 'arma', 1, 'M', 2, 0, 6, 0, 0, 0, NULL),
(1102, 'Cajado do Hipnotizador', 'cajado do hipnotizador.gif', 1, 7, 650, 'arma', 1, 'M', 2, 0, 6, 0, 0, 0, NULL),
(1103, 'Cajado do Vento', 'cajado do vento.gif', 0, 8, 0, 'arma', 2, 'M', 2, 0, 11, 0, 0, 0, NULL),
(1200, 'Arco do Aprendiz', 'arco do aprendiz.gif', 1, 3, 200, 'arma', 1, 'P', 2, 0, 0, 2, 0, 0, NULL),
(1201, 'Arco Composto', 'arco composto.gif', 1, 5, 460, 'arma', 1, 'P', 2, 2, 0, 5, 0, 0, NULL),
(1202, 'Arco de Caça', 'arco de caça.gif', 1, 8, 650, 'arma', 1, 'P', 2, 3, 0, 6, 0, 0, NULL),
(1203, 'Arco de Goblin', 'arco de goblin.gif', 0, 8, 0, 'arma', 2, 'P', 2, 6, 0, 9, 0, 0, NULL),
(1300, 'Adaga de Ferro', 'adaga de ferro.gif', 1, 2, 200, 'arma', 1, 'P', 1, 0, 0, 0, 1, 0, NULL),
(1301, 'Adaga do Aprendiz', 'adaga do aprendiz.gif', 1, 5, 460, 'arma', 1, 'P', 1, 1, 0, 0, 2, 0, NULL),
(1303, 'Adaga Sinistra', 'adaga sinistra.gif', 1, 9, 650, 'arma', 2, 'P', 1, 4, 0, 0, 3, 0, NULL),
(1400, 'Livro do Aprendiz', 'livro do aprendiz.gif', 1, 4, 200, 'arma', 1, 'M', 2, 0, 3, 0, 0, 0, NULL),
(1401, 'Livro da Mãe Terra', 'livro da mae terra.gif', 1, 7, 460, 'arma', 1, 'M', 2, 0, 5, 0, 0, 0, NULL),
(1402, 'Livro do Sol Ardente', 'livro do sol ardente.gif', 0, 10, 0, 'arma', 3, 'M', 2, 0, 23, 5, 5, 0, NULL),
(1500, 'Escudo', 'escudo.gif', 1, 1, 250, 'arma', 1, 'P', 1, 2, 0, 0, 0, 0, NULL),
(1501, 'Escudo do Aprendiz', 'escudo do aprendiz.gif', 1, 7, 460, 'arma', 1, 'P', 1, 3, 0, 0, 0, 0, NULL),
(1502, 'Escudo de Pedra', 'escudo de pedra.gif', 1, 8, 720, 'arma', 1, 'P', 1, 4, 0, 0, 0, 0, NULL),
(1503, 'Escudo da Valquíria', 'escudo da valquíria.gif', 0, 10, 0, 'arma', 2, 'P', 1, 7, 0, 0, 0, 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `equips`
--
ALTER TABLE `equips`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `equips`
--
ALTER TABLE `equips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1504;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
