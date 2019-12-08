-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 08 déc. 2019 à 00:58
-- Version du serveur :  10.1.40-MariaDB
-- Version de PHP :  7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `accounts`
--

-- --------------------------------------------------------

--
-- Structure de la table `benevole`
--

CREATE TABLE `benevole` (
  `id` int(11) NOT NULL,
  `date_entree` date DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `sexe` varchar(20) DEFAULT NULL,
  `tache` varchar(50) DEFAULT NULL,
  `date_sortie` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `benevole`
--

INSERT INTO `benevole` (`id`, `date_entree`, `role`, `nom`, `prenom`, `sexe`, `tache`, `date_sortie`) VALUES
  (1, '2019-10-02', 'Stagiaire', 'test', 'test1', 'Homme', 'Tache1', NULL),
  (2, '2019-10-02', 'Benevole', 'test1', 'dfghg', 'Homme', 'Tache2', '2019-10-24'),
  (3, '2019-10-06', 'Benevole', 'nfyjh', 'mgyuj', 'Homme', 'Tache4', NULL),
  (4, '2019-10-06', 'Benevole', 'efdwef', 'iuliul', 'Homme', 'Tache5', NULL),
  (5, '2019-10-06', 'Stagiaire', 'dbdt', 'awedcaef', 'Femme', 'Tache2', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id` int(11) NOT NULL,
  `id_interv` int(11) DEFAULT NULL,
  `interv` varchar(20) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `date_cloture` date DEFAULT NULL,
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
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `id_interv`, `interv`, `date_creation`, `date_cloture`, `description`, `type_appelant`, `mode_interv`, `type_interv`, `langue`, `duree`, `ref_par`, `date_arrivee`, `sexe`, `age`, `situ_finance`, `origine`, `status_canada`, `prob_mentale`, `etat_civil`, `nbr_enfant`, `psy_apres_interv`, `psy_avant_interv`, `motif_consult`) VALUES
  (1, 2, 'interv1', '2019-04-25', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (2, 2, 'interv1', '2019-10-20', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (3, 2, 'interv1', '2019-10-20', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (4, 2, 'interv1', '2019-10-20', '2019-10-24', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (5, 3, 'interv2', '2019-10-20', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (6, 3, 'interv2', '2019-10-20', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (7, 3, 'interv2', '2019-10-20', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (8, 3, 'interv2', '2019-10-20', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Dependance'),
  (9, 1, 'admin', '2019-12-06', NULL, 'test2', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 0, 'Joyeuse', 'Joyeuse', 'Sexualite'),
  (10, 1, 'admin', '2019-12-06', NULL, 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', '0000-00-00', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 'test1', 4, 'Angoissee', 'Joyeuse', 'Dependance');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `comment_subject` varchar(250) NOT NULL,
  `comment_text` text NOT NULL,
  `comment_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `evaluation`
--

CREATE TABLE `evaluation` (
  `id` int(11) NOT NULL,
  `id_interv` int(11) DEFAULT NULL,
  `interv` varchar(50) DEFAULT NULL,
  `trimestre` int(2) DEFAULT NULL,
  `annee` int(4) DEFAULT NULL,
  `note` int(3) DEFAULT NULL,
  `comm` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `evaluation`
--

INSERT INTO `evaluation` (`id`, `id_interv`, `interv`, `trimestre`, `annee`, `note`, `comm`) VALUES
  (5, 2, 'interv1', 3, 2019, 54, 'test'),
  (6, 3, 'interv2', 3, 2019, 85, 'Eval2');

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

CREATE TABLE `rdv` (
  `id` int(11) NOT NULL,
  `id_interv` int(11) DEFAULT NULL,
  `interv` varchar(50) DEFAULT NULL,
  `id_cli` int(11) DEFAULT NULL,
  `date_rdv` date DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rdv`
--

INSERT INTO `rdv` (`id`, `id_interv`, `interv`, `id_cli`, `date_rdv`, `type`) VALUES
  (1, 2, 'interv1', 1, '2019-10-20', NULL),
  (2, 2, 'interv1', 2, '2019-10-20', NULL),
  (3, 2, 'interv1', 3, '2019-10-20', NULL),
  (4, 3, 'interv2', 4, '2019-10-20', NULL),
  (5, 3, 'interv2', 5, '2019-10-20', NULL),
  (6, 3, 'interv2', 6, '2019-10-20', NULL),
  (7, 3, 'interv2', 7, '2019-10-20', NULL),
  (8, 3, 'interv2', 8, '2019-10-20', NULL),
  (9, 3, 'interv2', 7, '2019-10-20', NULL),
  (10, 1, 'admin', 9, '2019-12-06', 'Ecoute'),
  (11, 1, 'admin', 10, '2019-12-06', 'Suivi');

-- --------------------------------------------------------

--
-- Structure de la table `statis`
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
-- Déchargement des données de la table `statis`
--

INSERT INTO `statis` (`id`, `date_ajout`, `description`, `sexe`, `origine`, `langue`, `mode_interv`) VALUES
  (1, '2019-10-18', 'Information', 'Homme', 'Allemagne', 'Anglais', 'Telephone'),
  (2, '2019-10-18', 'Ecoute', 'Femme', 'Argentine', 'Espagnol', 'Face a face'),
  (3, '2019-10-18', 'Ecoute', 'Homme', 'Maroc', 'Francais', 'Face a face'),
  (4, '2019-10-18', 'Impot', 'Femme', 'Australie', 'Anglais', 'Telephone'),
  (5, '2019-10-18', 'Formation', 'Femme', 'Iran', 'Persan', 'Face a face'),
  (6, '2019-10-18', 'Impot', 'Homme', 'Iran', 'Persan', 'Telephone'),
  (7, '2019-10-18', 'Ecoute', 'Homme', 'Andorre', 'Anglais', 'Face a face');

-- --------------------------------------------------------

--
-- Structure de la table `users`
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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `avatar`, `admin`) VALUES
  (1, 'admin', 'admin@multi-ecoute.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 1),
  (2, 'interv1', 'interv1@multi-ecoute.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 0),
  (3, 'interv2', 'interv2@multi-ecoute.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 0),
  (4, 'adjoint', 'adjoint@multi-ecoute.com', '827ccb0eea8a706c4c34a16891f84e7b', '', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `benevole`
--
ALTER TABLE `benevole`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`);

--
-- Index pour la table `evaluation`
--
ALTER TABLE `evaluation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `statis`
--
ALTER TABLE `statis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `benevole`
--
ALTER TABLE `benevole`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `evaluation`
--
ALTER TABLE `evaluation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `rdv`
--
ALTER TABLE `rdv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `statis`
--
ALTER TABLE `statis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
