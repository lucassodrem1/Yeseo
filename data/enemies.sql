-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 09-Out-2017 às 23:58
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
-- Estrutura da tabela `enemies`
--

CREATE TABLE `enemies` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `boss` int(11) NOT NULL DEFAULT '0',
  `img` varchar(120) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `time` int(11) NOT NULL DEFAULT '10',
  `HP` int(11) NOT NULL DEFAULT '0',
  `physical_defense` int(11) NOT NULL DEFAULT '0',
  `magic_defense` int(11) NOT NULL DEFAULT '0',
  `agility` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `item` int(11) NOT NULL DEFAULT '0',
  `equip` int(11) NOT NULL DEFAULT '0',
  `skill` int(11) NOT NULL DEFAULT '0',
  `itemDropChance` int(11) NOT NULL DEFAULT '100',
  `equipDropChance` int(11) NOT NULL DEFAULT '100',
  `stats_point_amount` int(11) NOT NULL DEFAULT '0',
  `desc` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `enemies`
--

INSERT INTO `enemies` (`id`, `name`, `boss`, `img`, `level`, `time`, `HP`, `physical_defense`, `magic_defense`, `agility`, `gold`, `item`, `equip`, `skill`, `itemDropChance`, `equipDropChance`, `stats_point_amount`, `desc`) VALUES
(1, 'Develing', 1, 'develing.gif', 2, 100, 200, 0, 0, 0, 50, 1, 0, 0, 100, 100, 0, ''),
(1001, 'Poring', 0, 'poring.gif', 1, 60, 45, 0, 0, 0, 3, 1, 0, 0, 70, 100, 0, ''),
(1002, 'Drops', 0, 'drops.gif', 1, 60, 45, 0, 0, 0, 3, 1, 0, 0, 70, 100, 0, ''),
(1003, 'Poring Dourado', 0, 'gold poring.gif', 1, 18, 40, 0, 0, 0, 5, 1, 0, 0, 90, 100, 0, ''),
(2, 'Dolomedes', 1, 'dolomedes.gif', 3, 90, 260, 0, 0, 3, 100, 0, 0, 0, 100, 100, 0, ''),
(2001, 'Fabre', 0, 'fabre.gif', 2, 60, 75, 0, 0, 0, 10, 0, 0, 0, 100, 100, 0, ''),
(2002, 'Chonchon', 0, 'chonchon.gif', 2, 60, 75, 0, 0, 2, 10, 0, 0, 0, 100, 100, 0, ''),
(2003, 'Lunático', 0, 'lunatico.gif', 2, 18, 65, 0, 0, 2, 5, 2, 0, 0, 30, 100, 0, ''),
(3, 'Rocker', 1, 'rocker.gif', 4, 55, 350, 0, 0, 3, 130, 0, 0, 0, 100, 100, 0, ''),
(3001, 'Picky', 0, 'picky.gif', 2, 50, 75, 0, 0, 5, 12, 0, 0, 0, 100, 100, 0, ''),
(3002, 'Zangão', 0, 'zangao.gif', 3, 50, 85, 0, 0, 7, 15, 4, 0, 0, 40, 100, 0, ''),
(3003, 'Condor', 0, 'condor.gif', 3, 30, 100, 0, 0, 7, 15, 3, 0, 0, 30, 100, 0, ''),
(4, 'Tartaruga', 1, 'tartaruga.gif', 5, 47, 500, 3, 0, 1, 200, 0, 0, 0, 100, 100, 0, ''),
(4001, 'Salgueiro', 0, 'salgueiro.gif', 4, 50, 90, 0, 0, 1, 18, 5, 0, 0, 15, 100, 0, ''),
(4002, 'Sapo de Rodda', 0, 'sapo de rodda.gif', 4, 50, 95, 0, 0, 3, 20, 0, 0, 0, 100, 100, 0, ''),
(4003, 'Eclipse', 0, 'eclipe.gif', 3, 15, 80, 0, 0, 10, 10, 0, 0, 0, 25, 100, 0, ''),
(5, 'Majoruros', 1, 'majoruros.gif', 6, 45, 800, 6, 1, 6, 320, 0, 0, 0, 100, 100, 0, ''),
(5001, 'Filhote de Lobo', 0, 'filhote de lobo.gif', 4, 47, 100, 1, 1, 6, 25, 3, 0, 0, 40, 100, 0, ''),
(5002, 'Filhote de Leopardo', 0, 'filhote de leopardo.gif', 4, 45, 110, 1, 1, 7, 28, 3, 0, 0, 45, 100, 0, ''),
(5003, 'Esqueleto', 0, 'esqueleto.gif', 5, 45, 150, 3, 2, 3, 45, 0, 0, 0, 35, 100, 0, ''),
(6, 'Rainha Scaraba', 1, 'rainha scaraba.gif', 7, 40, 920, 4, 6, 12, 380, 0, 0, 0, 100, 100, 0, ''),
(6001, 'Scaraba', 0, 'scaraba.gif', 6, 30, 150, 2, 4, 8, 70, 0, 0, 0, 32, 100, 0, ''),
(6002, 'Scaraba Chifrudo', 0, 'scaraba chifrudo.gif', 6, 30, 180, 2, 4, 8, 38, 0, 0, 0, 100, 100, 0, ''),
(6003, 'Ovo de Scaraba', 0, 'ovo de scaraba.gif', 1, 50, 80, 0, 0, 0, 20, 6, 0, 0, 5, 100, 0, ''),
(7, 'Mandrágora', 1, 'mandragora.gif', 8, 40, 1100, 6, 8, 7, 450, 1, 0, 0, 100, 100, 0, ''),
(7001, 'Sapo Cururu', 0, 'sapo cururu.gif', 7, 30, 180, 1, 2, 8, 40, 0, 0, 0, 100, 100, 0, ''),
(7002, 'Hidra', 0, 'hidra.gif', 7, 30, 200, 1, 2, 0, 42, 1, 0, 0, 74, 100, 0, ''),
(7003, 'Pirralho', 0, 'pirralho.gif', 7, 40, 150, 0, 0, 0, 40, 0, 0, 0, 100, 100, 0, ''),
(8, 'Goblin Steamrider', 1, 'goblin steamrider.gif', 9, 35, 1500, 10, 5, 23, 500, 0, 0, 0, 100, 100, 0, ''),
(8001, 'Goblin Mace', 0, 'goblin mace.gif', 8, 25, 370, 5, 5, 7, 50, 7, 0, 0, 50, 100, 0, ''),
(8002, 'Arqueiro Goblin', 0, 'arqueiro goblin.gif', 8, 25, 400, 6, 3, 9, 55, 7, 0, 0, 50, 100, 0, ''),
(8003, 'Líder Goblin', 0, 'lider goblin.gif', 8, 25, 500, 7, 4, 8, 65 , 7, 0, 0, 60, 100, 0, ''),
(9, 'Goblin Flail', 1, 'goblin flail.gif', 10, 28, 1800, 13, 10, 15, 600, 0, 0, 0, 100, 100, 0, ''),
(9001, 'Goblin de Martelo', 0, 'goblin de martelo.gif', 9, 23, 450, 8, 4, 8, 50, 7, 0, 0, 50, 100, 0, ''),
(9002, 'Goblin de Adaga', 0, 'goblin de adaga.gif', 9, 20, 430, 6, 4, 11, 50, 7, 0, 0, 50, 100, 0, ''),
(9003, 'Goblin de Machado', 0, 'goblin de machado.gif', 9, 20, 650, 10, 7, 9, 65, 7, 0, 0, 60, 100, 0, ''),
(10, 'Pesadelo', 1, 'pesadelo.gif', 15, 14, 3000, 25, 25, 40, 2000, 0, 0, 0, 100, 100, 0, ''),
(10001, 'Esporo Venenoso', 0, 'esporo venenoso.gif', 11, 10, 600, 6, 13, 0, 65, 8, 0, 0, 7, 100, 0, ''),
(10002, 'Pecopeco', 0, 'pecopeco.gif', 11, 10, 680, 12, 12, 17, 180, 0, 0, 0, 70, 100, 0, ''),
(10003, 'Salgueiro Ancião', 0, 'salgueiro anciao.gif', 11, 10, 700, 14, 15, 8, 75, 5, 0, 0, 23, 100, 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enemies`
--
ALTER TABLE `enemies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enemies`
--
ALTER TABLE `enemies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10004;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
