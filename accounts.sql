-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2019 at 03:56 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `accounts`
--

-- --------------------------------------------------------

--
-- Table structure for table `benevole`
--

CREATE TABLE `benevole` (
  `id` int(11) NOT NULL,
  `date_entree` date DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` varchar(20) DEFAULT NULL,
  `tache` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `benevole`
--

INSERT INTO `benevole` (`id`, `date_entree`, `role`, `nom`, `prenom`, `sexe`, `tache`) VALUES
  (1, '2019-10-02', 'Stagiaire', 'test', 'test1', 'Homme', 'Tache1');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `name`) VALUES
  (1, 'N/A'),
  (2, 'N/A'),
  (3, 'N/A'),
  (4, 'N/A'),
  (5, 'N/A'),
  (6, 'N/A'),
  (7, 'N/A'),
  (8, 'N/A'),
  (9, 'N/A'),
  (10, 'N/A'),
  (11, 'N/A'),
  (12, 'N/A'),
  (13, 'N/A'),
  (14, 'N/A'),
  (15, 'N/A'),
  (16, 'N/A'),
  (17, 'N/A'),
  (18, 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_subject` varchar(250) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `id_interv` int(11) DEFAULT NULL,
  `name_interv` varchar(50) DEFAULT NULL,
  `id_cli` int(11) DEFAULT NULL,
  `date_inscription` date DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `type_appelant` varchar(50) DEFAULT NULL,
  `mode_interv` varchar(50) DEFAULT NULL,
  `type_interv` varchar(50) DEFAULT NULL,
  `langue` varchar(50) DEFAULT NULL,
  `duree` varchar(50) DEFAULT NULL,
  `ref_par` varchar(50) DEFAULT NULL,
  `date_arrivee` date DEFAULT NULL,
  `sexe` varchar(50) DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
  `situ_finance` varchar(50) DEFAULT NULL,
  `origine` varchar(50) DEFAULT NULL,
  `status_canada` varchar(50) DEFAULT NULL,
  `prob_mentale` varchar(50) DEFAULT NULL,
  `etat_civil` varchar(50) DEFAULT NULL,
  `nbr_enfant` int(11) DEFAULT NULL,
  `psy_apres_interv` varchar(50) DEFAULT NULL,
  `psy_avant_interv` varchar(50) DEFAULT NULL,
  `motif_consult` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rdv`
--

INSERT INTO `rdv` (`id`, `id_interv`, `name_interv`, `id_cli`, `date_inscription`, `description`, `type_appelant`, `mode_interv`, `type_interv`, `langue`, `duree`, `ref_par`, `date_arrivee`, `sexe`, `age`, `situ_finance`, `origine`, `status_canada`, `prob_mentale`, `etat_civil`, `nbr_enfant`, `psy_apres_interv`, `psy_avant_interv`, `motif_consult`) VALUES
  (1, 1, 'test', 18, '2019-10-02', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance');

-- --------------------------------------------------------

--
-- Table structure for table `statis`
--

CREATE TABLE `statis` (
  `id` int(11) NOT NULL,
  `date_ajout` date DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `sexe` varchar(20) DEFAULT NULL,
  `origine` varchar(50) DEFAULT NULL,
  `langue` varchar(20) DEFAULT NULL,
  `mode_interv` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statis`
--

INSERT INTO `statis` (`id`, `date_ajout`, `description`, `sexe`, `origine`, `langue`, `mode_interv`) VALUES
  (4, '2019-09-30', 'Ecoute', 'Femme', 'origine', 'Espagnol', 'Telephone');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `admin` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `admin`) VALUES
  (1, 'test', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 'images/tissot_t_touch_1_stainless_steel_z_253353_1514226060_acdba1b1.jpg', 1),
  (7, 'test3', 'test3@test3.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 0),
  (12, 'test4', 'test4@test4.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 0),
  (15, 'test7', 'test7@test7.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 1),
  (16, 'test8', 'test8@test8.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 0),
  (21, 'test9', 'test9@test9.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 1),
  (22, 'test16', 'test10@test10.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 1),
  (23, 'test13', 'test13@test13.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 0),
  (24, 'test14', 'test14@test14.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 1),
  (27, 'test15', 'test15@test15.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 2),
  (28, 'test20', 'test20@test20.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `benevole`
--
ALTER TABLE `benevole`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statis`
--
ALTER TABLE `statis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `benevole`
--
ALTER TABLE `benevole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `statis`
--
ALTER TABLE `statis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
