-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 30 sep. 2024 à 08:23
-- Version du serveur : 10.11.4-MariaDB-1~deb12u1
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `LPFS_Clinique`
--

-- --------------------------------------------------------

--
-- Structure de la table `Chambres`
--

CREATE TABLE `Chambres` (
  `id_chambre` int(11) NOT NULL,
  `num_chambre` int(11) NOT NULL,
  `type_chambre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Couverture_Sociale`
--

CREATE TABLE `Couverture_Sociale` (
  `num_sécu` bigint(13) NOT NULL,
  `organisme` varchar(50) NOT NULL,
  `assurance` varchar(3) NOT NULL,
  `ald` varchar(3) NOT NULL,
  `nom_mutuelle` varchar(20) NOT NULL,
  `numéro_adhérent` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Hospitalisations`
--

CREATE TABLE `Hospitalisations` (
  `id_admission` int(11) NOT NULL,
  `pré_admission` varchar(50) NOT NULL,
  `date_hospitalisation` date NOT NULL,
  `heure_intervention` time NOT NULL,
  `chambre` int(11) NOT NULL,
  `id_med` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Patients`
--

CREATE TABLE `Patients` (
  `id_patient` int(11) NOT NULL,
  `civilité` varchar(10) NOT NULL,
  `nom_naissance` varchar(30) NOT NULL,
  `nom_épouse` varchar(30) NOT NULL,
  `prénom_patient` varchar(30) NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(50) NOT NULL,
  `code_postal` int(5) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `téléphone` int(10) NOT NULL,
  `carte_identité` mediumblob NOT NULL,
  `carte_vitale` mediumblob NOT NULL,
  `carte_mutuelle` mediumblob NOT NULL,
  `livret_famille` mediumblob NOT NULL,
  `num_sécu` bigint(13) NOT NULL,
  `id_personne1` int(10) NOT NULL,
  `id_personne2` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Personnels`
--

CREATE TABLE `Personnels` (
  `id_personnel` int(11) NOT NULL,
  `identifiant` varchar(20) NOT NULL,
  `motdepasse` varchar(12) NOT NULL,
  `id_rôle` int(11) NOT NULL,
  `id_service` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Personnes_Confiance`
--

CREATE TABLE `Personnes_Confiance` (
  `id_personne` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prénom` varchar(30) NOT NULL,
  `num_tel` int(10) NOT NULL,
  `adresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Personnes_Prévenir`
--

CREATE TABLE `Personnes_Prévenir` (
  `id_personne` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `prénom` varchar(30) NOT NULL,
  `num_tel` int(10) NOT NULL,
  `adresse` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Rôles`
--

CREATE TABLE `Rôles` (
  `id_rôle` int(11) NOT NULL,
  `libelle` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `Services`
--

CREATE TABLE `Services` (
  `id_service` int(11) NOT NULL,
  `libelle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Chambres`
--
ALTER TABLE `Chambres`
  ADD PRIMARY KEY (`id_chambre`);

--
-- Index pour la table `Couverture_Sociale`
--
ALTER TABLE `Couverture_Sociale`
  ADD PRIMARY KEY (`num_sécu`);

--
-- Index pour la table `Hospitalisations`
--
ALTER TABLE `Hospitalisations`
  ADD PRIMARY KEY (`id_admission`),
  ADD KEY `chambre` (`chambre`,`id_patient`),
  ADD KEY `id_med` (`id_med`),
  ADD KEY `id_patient` (`id_patient`);

--
-- Index pour la table `Patients`
--
ALTER TABLE `Patients`
  ADD PRIMARY KEY (`id_patient`),
  ADD KEY `num_sécu` (`num_sécu`,`id_personne1`,`id_personne2`),
  ADD KEY `id_personne1` (`id_personne1`),
  ADD KEY `id_personne2` (`id_personne2`);

--
-- Index pour la table `Personnels`
--
ALTER TABLE `Personnels`
  ADD PRIMARY KEY (`id_personnel`),
  ADD KEY `id_rôle` (`id_rôle`,`id_service`),
  ADD KEY `id_service` (`id_service`);

--
-- Index pour la table `Personnes_Confiance`
--
ALTER TABLE `Personnes_Confiance`
  ADD PRIMARY KEY (`id_personne`);

--
-- Index pour la table `Personnes_Prévenir`
--
ALTER TABLE `Personnes_Prévenir`
  ADD PRIMARY KEY (`id_personne`);

--
-- Index pour la table `Rôles`
--
ALTER TABLE `Rôles`
  ADD PRIMARY KEY (`id_rôle`);

--
-- Index pour la table `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`id_service`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Chambres`
--
ALTER TABLE `Chambres`
  MODIFY `id_chambre` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Hospitalisations`
--
ALTER TABLE `Hospitalisations`
  MODIFY `id_admission` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Patients`
--
ALTER TABLE `Patients`
  MODIFY `id_patient` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Personnels`
--
ALTER TABLE `Personnels`
  MODIFY `id_personnel` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Personnes_Confiance`
--
ALTER TABLE `Personnes_Confiance`
  MODIFY `id_personne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Personnes_Prévenir`
--
ALTER TABLE `Personnes_Prévenir`
  MODIFY `id_personne` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Rôles`
--
ALTER TABLE `Rôles`
  MODIFY `id_rôle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Services`
--
ALTER TABLE `Services`
  MODIFY `id_service` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Hospitalisations`
--
ALTER TABLE `Hospitalisations`
  ADD CONSTRAINT `Hospitalisations_ibfk_1` FOREIGN KEY (`id_med`) REFERENCES `Personnels` (`id_personnel`),
  ADD CONSTRAINT `Hospitalisations_ibfk_2` FOREIGN KEY (`chambre`) REFERENCES `Chambres` (`id_chambre`),
  ADD CONSTRAINT `Hospitalisations_ibfk_3` FOREIGN KEY (`id_patient`) REFERENCES `Patients` (`id_patient`);

--
-- Contraintes pour la table `Patients`
--
ALTER TABLE `Patients`
  ADD CONSTRAINT `Patients_ibfk_1` FOREIGN KEY (`id_personne1`) REFERENCES `Personnes_Confiance` (`id_personne`),
  ADD CONSTRAINT `Patients_ibfk_2` FOREIGN KEY (`id_personne2`) REFERENCES `Personnes_Prévenir` (`id_personne`),
  ADD CONSTRAINT `Patients_ibfk_3` FOREIGN KEY (`num_sécu`) REFERENCES `Couverture_Sociale` (`num_sécu`);

--
-- Contraintes pour la table `Personnels`
--
ALTER TABLE `Personnels`
  ADD CONSTRAINT `Personnels_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `Services` (`id_service`),
  ADD CONSTRAINT `Personnels_ibfk_2` FOREIGN KEY (`id_rôle`) REFERENCES `Rôles` (`id_rôle`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
