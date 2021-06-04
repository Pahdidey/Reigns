-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 04, 2021 at 09:00 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jeudistance`
--

-- --------------------------------------------------------

--
-- Table structure for table `reigns_joueurs`
--

CREATE TABLE `reigns_joueurs` (
  `id` int(11) NOT NULL,
  `objectif` int(11) DEFAULT NULL,
  `proposition` int(11) DEFAULT NULL,
  `role` enum('Roi','Conseiller') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reigns_joueurs`
--

INSERT INTO `reigns_joueurs` (`id`, `objectif`, `proposition`, `role`) VALUES
(1, NULL, NULL, 'Conseiller'),
(2, NULL, NULL, 'Conseiller'),
(3, NULL, NULL, 'Conseiller'),
(4, NULL, NULL, 'Conseiller'),
(5, NULL, NULL, 'Conseiller'),
(6, NULL, NULL, 'Conseiller');

-- --------------------------------------------------------

--
-- Table structure for table `reigns_objectifs`
--

CREATE TABLE `reigns_objectifs` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reigns_objectifs`
--

INSERT INTO `reigns_objectifs` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25);

-- --------------------------------------------------------

--
-- Table structure for table `reigns_participants`
--

CREATE TABLE `reigns_participants` (
  `id` int(11) NOT NULL,
  `id_partie` int(11) NOT NULL,
  `id_joueur` int(11) NOT NULL,
  `points` int(11) DEFAULT NULL,
  `resultat` enum('Victoire','Défaite') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reigns_participants`
--

INSERT INTO `reigns_participants` (`id`, `id_partie`, `id_joueur`, `points`, `resultat`) VALUES
(1, 2, 1, 4, 'Défaite'),
(2, 2, 3, 5, 'Victoire'),
(3, 2, 4, 1, 'Défaite'),
(4, 3, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reigns_parties`
--

CREATE TABLE `reigns_parties` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `etat` enum('En attente','En cours','Terminée') NOT NULL DEFAULT 'En attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reigns_parties`
--

INSERT INTO `reigns_parties` (`id`, `nom`, `etat`) VALUES
(1, 'first', 'Terminée'),
(2, 'GhIpQ', 'Terminée'),
(3, '3vG6o', 'En attente');

-- --------------------------------------------------------

--
-- Table structure for table `reigns_propositions`
--

CREATE TABLE `reigns_propositions` (
  `id` int(11) NOT NULL,
  `id_joueur` int(11) DEFAULT NULL,
  `resultat` enum('Proposée','Choisie','Refusée') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reigns_propositions`
--

INSERT INTO `reigns_propositions` (`id`, `id_joueur`, `resultat`) VALUES
(1, NULL, NULL),
(2, NULL, NULL),
(3, NULL, NULL),
(4, NULL, NULL),
(5, NULL, NULL),
(6, NULL, NULL),
(7, NULL, NULL),
(8, NULL, NULL),
(9, NULL, NULL),
(10, NULL, NULL),
(11, NULL, NULL),
(12, NULL, NULL),
(13, NULL, NULL),
(14, NULL, NULL),
(15, NULL, NULL),
(16, NULL, NULL),
(17, NULL, NULL),
(18, NULL, NULL),
(19, NULL, NULL),
(20, NULL, NULL),
(21, NULL, NULL),
(22, NULL, NULL),
(23, NULL, NULL),
(24, NULL, NULL),
(25, NULL, NULL),
(26, NULL, NULL),
(27, NULL, NULL),
(28, NULL, NULL),
(29, NULL, NULL),
(30, NULL, NULL),
(31, NULL, NULL),
(32, NULL, NULL),
(33, NULL, NULL),
(34, NULL, NULL),
(35, NULL, NULL),
(36, NULL, NULL),
(37, NULL, NULL),
(38, NULL, NULL),
(39, NULL, NULL),
(40, NULL, NULL),
(41, NULL, NULL),
(42, NULL, NULL),
(43, NULL, NULL),
(44, NULL, NULL),
(45, NULL, NULL),
(46, NULL, NULL),
(47, NULL, NULL),
(48, NULL, NULL),
(49, NULL, NULL),
(50, NULL, NULL),
(51, NULL, NULL),
(52, NULL, NULL),
(53, NULL, NULL),
(54, NULL, NULL),
(55, NULL, NULL),
(56, NULL, NULL),
(57, NULL, NULL),
(58, NULL, NULL),
(59, NULL, NULL),
(60, NULL, NULL),
(61, NULL, NULL),
(62, NULL, NULL),
(63, NULL, NULL),
(64, NULL, NULL),
(65, NULL, NULL),
(66, NULL, NULL),
(67, NULL, NULL),
(68, NULL, NULL),
(69, NULL, NULL),
(70, NULL, NULL),
(71, NULL, NULL),
(72, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reigns_joueurs`
--
ALTER TABLE `reigns_joueurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `joueurs_ibfk_1` (`objectif`),
  ADD KEY `proposition` (`proposition`);

--
-- Indexes for table `reigns_objectifs`
--
ALTER TABLE `reigns_objectifs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reigns_participants`
--
ALTER TABLE `reigns_participants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reigns_parties`
--
ALTER TABLE `reigns_parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reigns_propositions`
--
ALTER TABLE `reigns_propositions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_joueur` (`id_joueur`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reigns_objectifs`
--
ALTER TABLE `reigns_objectifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reigns_participants`
--
ALTER TABLE `reigns_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reigns_parties`
--
ALTER TABLE `reigns_parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reigns_propositions`
--
ALTER TABLE `reigns_propositions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reigns_joueurs`
--
ALTER TABLE `reigns_joueurs`
  ADD CONSTRAINT `reigns_joueurs_ibfk_1` FOREIGN KEY (`id`) REFERENCES `jeudistance_joueurs` (`id`);

--
-- Constraints for table `reigns_propositions`
--
ALTER TABLE `reigns_propositions`
  ADD CONSTRAINT `reigns_propositions_ibfk_1` FOREIGN KEY (`id_joueur`) REFERENCES `jeudistance_joueurs` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
