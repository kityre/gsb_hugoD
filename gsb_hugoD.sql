-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  mar. 15 jan. 2019 à 22:16
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gsb`
--

-- --------------------------------------------------------

--
-- Structure de la table `etat`
--

DROP TABLE IF EXISTS `etat`;
CREATE TABLE IF NOT EXISTS `etat` (
  `id` char(2) CHARACTER SET latin1 NOT NULL,
  `libelle` varchar(30) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `etat`
--

INSERT INTO `etat` (`id`, `libelle`) VALUES
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('RB', 'Remboursée'),
('VA', 'Validée et mise en paiement');

-- --------------------------------------------------------

--
-- Structure de la table `fichefrais`
--

DROP TABLE IF EXISTS `fichefrais`;
CREATE TABLE IF NOT EXISTS `fichefrais` (
  `idVisiteur` char(4) CHARACTER SET latin1 NOT NULL,
  `mois` char(6) CHARACTER SET latin1 NOT NULL,
  `nbJustificatifs` int(11) DEFAULT NULL,
  `montantValide` decimal(10,2) DEFAULT NULL,
  `dateModif` date DEFAULT NULL,
  `idEtat` char(2) CHARACTER SET latin1 DEFAULT 'CR',
  PRIMARY KEY (`idVisiteur`,`mois`),
  KEY `idEtat` (`idEtat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `fichefrais`
--

INSERT INTO `fichefrais` (`idVisiteur`, `mois`, `nbJustificatifs`, `montantValide`, `dateModif`, `idEtat`) VALUES
('a131', '201809', 2, '100.00', '2019-01-10', 'CL'),
('a131', '201810', 6, '500.00', '2018-10-17', 'VA'),
('a131', '201811', 0, '0.00', '2019-01-10', 'CL'),
('a131', '201901', 0, '0.00', '2019-01-10', 'CR'),
('a17', '201809', 5, '200.00', '2018-10-17', 'CL'),
('a17', '201810', 2, '200.00', '2018-10-17', 'VA'),
('a55', '201809', 0, '0.00', '2019-01-15', 'CL'),
('a55', '201810', NULL, NULL, NULL, 'CR'),
('a55', '201901', 0, '0.00', '2019-01-15', 'CR'),
('a93', '201901', 0, '0.00', '2019-01-15', 'CR'),
('b13', '201809', 4, '70.00', '2019-01-15', 'CL'),
('b13', '201810', 5, '100.00', '2018-10-11', 'VA'),
('b13', '201811', 0, '0.00', '2018-11-28', 'CR'),
('b13', '201901', 0, '0.00', '2019-01-15', 'CR'),
('b16', '201809', 5, '25.00', '2018-10-17', 'CL'),
('b16', '201810', 8, '50.00', '2018-10-11', 'VA'),
('b19', '201810', 1, '10.00', '2018-10-11', 'VA'),
('b25', '201810', 0, '0.00', '2018-10-18', 'CR'),
('b4', '201809', 0, '200.00', '2018-10-18', 'CL'),
('b4', '201810', 0, '0.00', '2018-10-18', 'CR'),
('f21', '201809', 0, '0.00', '2018-10-18', 'CL'),
('f21', '201810', 3, '75.00', '2018-10-18', 'CR');

-- --------------------------------------------------------

--
-- Structure de la table `fraisforfait`
--

DROP TABLE IF EXISTS `fraisforfait`;
CREATE TABLE IF NOT EXISTS `fraisforfait` (
  `id` char(3) CHARACTER SET latin1 NOT NULL,
  `libelle` char(20) CHARACTER SET latin1 DEFAULT NULL,
  `montant` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `fraisforfait`
--

INSERT INTO `fraisforfait` (`id`, `libelle`, `montant`) VALUES
('ETP', 'Forfait Etape', '110.00'),
('KM', 'Frais Kilométrique', '0.62'),
('NUI', 'Nuitée Hôtel', '80.00'),
('REP', 'Repas Restaurant', '25.00');

-- --------------------------------------------------------

--
-- Structure de la table `lignefraisforfait`
--

DROP TABLE IF EXISTS `lignefraisforfait`;
CREATE TABLE IF NOT EXISTS `lignefraisforfait` (
  `idVisiteur` char(4) CHARACTER SET latin1 NOT NULL,
  `mois` char(6) CHARACTER SET latin1 NOT NULL,
  `idFraisForfait` char(3) CHARACTER SET latin1 NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  PRIMARY KEY (`idVisiteur`,`mois`,`idFraisForfait`),
  KEY `idFraisForfait` (`idFraisForfait`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `lignefraisforfait`
--

INSERT INTO `lignefraisforfait` (`idVisiteur`, `mois`, `idFraisForfait`, `quantite`) VALUES
('a131', '201809', 'ETP', 0),
('a131', '201810', 'ETP', 5),
('a131', '201810', 'KM', 5),
('a131', '201810', 'NUI', 8),
('a131', '201810', 'REP', 6),
('a131', '201811', 'ETP', 0),
('a131', '201811', 'KM', 0),
('a131', '201811', 'NUI', 0),
('a131', '201811', 'REP', 0),
('a131', '201901', 'ETP', 2),
('a131', '201901', 'KM', 0),
('a131', '201901', 'NUI', 0),
('a131', '201901', 'REP', 0),
('a17', '201810', 'ETP', 30),
('a17', '201810', 'KM', 4),
('a17', '201810', 'NUI', 4),
('a17', '201810', 'REP', 3),
('a55', '201901', 'ETP', 30),
('a55', '201901', 'KM', 2),
('a55', '201901', 'NUI', 8),
('a55', '201901', 'REP', 15),
('a93', '201901', 'ETP', 5),
('a93', '201901', 'KM', 3),
('a93', '201901', 'NUI', 15),
('a93', '201901', 'REP', 8),
('b13', '201809', 'ETP', 3),
('b13', '201809', 'KM', 3),
('b13', '201809', 'NUI', 3),
('b13', '201809', 'REP', 3),
('b13', '201901', 'ETP', 3),
('b13', '201901', 'KM', 44),
('b13', '201901', 'NUI', 54),
('b13', '201901', 'REP', 78),
('f21', '201809', 'ETP', 17),
('f21', '201809', 'KM', 0),
('f21', '201809', 'NUI', 0),
('f21', '201809', 'REP', 0),
('f21', '201810', 'ETP', 0),
('f21', '201810', 'KM', 0),
('f21', '201810', 'NUI', 0),
('f21', '201810', 'REP', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lignefraishorsforfait`
--

DROP TABLE IF EXISTS `lignefraishorsforfait`;
CREATE TABLE IF NOT EXISTS `lignefraishorsforfait` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idVisiteur` char(4) CHARACTER SET latin1 NOT NULL,
  `mois` char(6) CHARACTER SET latin1 NOT NULL,
  `libelle` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `dateM` date DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idVisiteur` (`idVisiteur`,`mois`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `lignefraishorsforfait`
--

INSERT INTO `lignefraishorsforfait` (`id`, `idVisiteur`, `mois`, `libelle`, `dateM`, `montant`) VALUES
(4, 'a17', '201810', 'test2', '2018-10-02', '5.00'),
(6, 'f21', '201810', 'testfin', '2018-10-02', '200.00'),
(7, 'a131', '201810', 'testfin', '2018-10-02', '200.00'),
(8, 'b13', '201809', 'test1', '2018-11-28', '50.00'),
(9, 'b13', '201809', 'test2', '2018-11-29', '50.00'),
(10, 'b13', '201809', 'REFUSER test1', '2018-11-22', '50.00'),
(11, 'a131', '201901', 'test', '2018-11-02', '0.00'),
(12, 'a55', '201901', 'cadeau noel', '2018-11-02', '150.00'),
(13, 'a55', '201901', 'Repas nouvelle ans', '2018-12-02', '50.00'),
(14, 'a93', '201901', 'aaaa', '2019-01-02', '30.00'),
(15, 'b13', '201901', 'aasas', '2019-12-02', '150.00');

-- --------------------------------------------------------

--
-- Structure de la table `typevisiteur`
--

DROP TABLE IF EXISTS `typevisiteur`;
CREATE TABLE IF NOT EXISTS `typevisiteur` (
  `id` char(2) CHARACTER SET latin1 NOT NULL,
  `libelle` char(20) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `typevisiteur`
--

INSERT INTO `typevisiteur` (`id`, `libelle`) VALUES
('CO', 'Comptable'),
('VI', 'Visiteur');

-- --------------------------------------------------------

--
-- Structure de la table `visiteur`
--

DROP TABLE IF EXISTS `visiteur`;
CREATE TABLE IF NOT EXISTS `visiteur` (
  `id` char(4) CHARACTER SET latin1 NOT NULL,
  `nom` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `prenom` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `login` char(20) CHARACTER SET latin1 DEFAULT NULL,
  `mdp` char(32) CHARACTER SET latin1 DEFAULT NULL,
  `adresse` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `cp` char(5) CHARACTER SET latin1 DEFAULT NULL,
  `ville` char(30) CHARACTER SET latin1 DEFAULT NULL,
  `dateEmbauche` date DEFAULT NULL,
  `idTypeVisiteur` char(2) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_visiteur_idTypeVisiteur` (`idTypeVisiteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Déchargement des données de la table `visiteur`
--

INSERT INTO `visiteur` (`id`, `nom`, `prenom`, `login`, `mdp`, `adresse`, `cp`, `ville`, `dateEmbauche`, `idTypeVisiteur`) VALUES
('a131', 'Villechalane', 'Louis', 'v', 'd41d8cd98f00b204e9800998ecf8427e', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21', 'VI'),
('a17', 'Comptable', 'Test', 'c', 'd41d8cd98f00b204e9800998ecf8427e', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23', 'CO'),
('a55', 'Bedos', 'Christian', 'cbedos', '26ec3c585ee973005c2744742d920dc3', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12', 'VI'),
('a93', 'Tusseau', 'Louis', 'ltusseau', 'f85f3127fc55f0ad7433b6879bc05f4e', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01', 'VI'),
('b13', 'Bentot', 'Pascal', 'pbentot', 'ae5d0d7637be4083a245f980a2189d97', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09', 'VI'),
('b16', 'Bioret', 'Luc', 'lbioret', '566ea5a9b3a6f186928cc20711f13fa8', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11', 'VI'),
('b19', 'Bunisset', 'Francis', 'fbunisset', '969c2fe5ac918a86a664b2041d5bc295', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21', 'VI'),
('b25', 'Bunisset', 'Denise', 'dbunisset', '03b01d4e2f53d838a2228e6cd57b8578', '23 rue Manin', '75019', 'paris', '2010-12-05', 'VI'),
('b28', 'Cacheux', 'Bernard', 'bcacheux', 'f6b78ee75c60c4becd5ed3daaca14127', '114 rue Blanche', '75017', 'Paris', '2009-11-12', 'VI'),
('b34', 'Cadic', 'Eric', 'ecadic', '36b98727aece53010ddde58639294427', '123 avenue de la République', '75011', 'Paris', '2008-09-23', 'VI'),
('b4', 'Charoze', 'Catherine', 'ccharoze', 'fce14894825737b9850d2bfccf0adf02', '100 rue Petit', '75019', 'Paris', '2005-11-12', 'VI'),
('b50', 'Clepkens', 'Christophe', 'cclepkens', '9ac1d70eef6e5f225b1db64eabaa4374', '12 allée des Anges', '93230', 'Romainville', '2003-08-11', 'VI'),
('b59', 'Cottin', 'Vincenne', 'vcottin', 'e509e3ed6ac643ac405aba9c40ebc591', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18', 'VI'),
('c14', 'Daburon', 'François', 'fdaburon', '44fda4ffdcf80a5f0c07fd0c82dafa4b', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11', 'VI'),
('c3', 'De', 'Philippe', 'pde', 'd5d01f0959b81d8e99e0ff5ecec858f7', '13 rue Barthes', '94000', 'Créteil', '2010-12-14', 'VI'),
('c54', 'Debelle', 'Michel', 'mdebelle', '5583dc317a2427151176da897d02847c', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23', 'VI'),
('d13', 'Debelle', 'Jeanne', 'jdebelle', 'b7d60232b71cf9cbbfffa53cac58c2b6', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11', 'VI'),
('d51', 'Debroise', 'Michel', 'mdebroise', '7101579c34d26bb94798fa096c577a8b', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17', 'VI'),
('e22', 'Desmarquest', 'Nathalie', 'ndesmarquest', '77f0798fb878eba2d41a92187db41370', '14 Place d Arc', '45000', 'Orléans', '2005-11-12', 'VI'),
('e24', 'Desnost', 'Pierre', 'pdesnost', 'f22a9af3e65d9b3942f242cb559374ae', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05', 'VI'),
('e39', 'Dudouit', 'Frédéric', 'fdudouit', '09723e8247fbdda4d2dda2d15d160dfd', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01', 'VI'),
('e49', 'Duncombe', 'Claude', 'cduncombe', '4b66fd37213456e6d58e79993a446241', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10', 'VI'),
('e5', 'Enault-Pascreau', 'Céline', 'cenault', '8c2cfac2fc5e3b1100842b3573720cc8', '25 place de la gare', '23200', 'Gueret', '1995-09-01', 'VI'),
('e52', 'Eynde', 'Valérie', 'veynde', 'ea33b05db1515b43c387050ef64e687b', '3 Grand Place', '13015', 'Marseille', '1999-11-01', 'VI'),
('f21', 'Finck', 'Jacques', 'jfinck', 'ec5014f6a2f2631952b6c677409a29fe', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10', 'VI'),
('f39', 'Frémont', 'Fernande', 'ffremont', '8774099cc05fd213276773425739ed85', '4 route de la mer', '13012', 'Allauh', '1998-10-01', 'VI'),
('f4', 'Gest', 'Alain', 'agest', '8167f1d92b7c2666aaf0d6f77cbc761d', '30 avenue de la mer', '13025', 'Berre', '1985-11-01', 'VI');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `fichefrais`
--
ALTER TABLE `fichefrais`
  ADD CONSTRAINT `fichefrais_ibfk_1` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`id`),
  ADD CONSTRAINT `fichefrais_ibfk_2` FOREIGN KEY (`idVisiteur`) REFERENCES `visiteur` (`id`);

--
-- Contraintes pour la table `lignefraisforfait`
--
ALTER TABLE `lignefraisforfait`
  ADD CONSTRAINT `lignefraisforfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`),
  ADD CONSTRAINT `lignefraisforfait_ibfk_2` FOREIGN KEY (`idFraisForfait`) REFERENCES `fraisforfait` (`id`);

--
-- Contraintes pour la table `lignefraishorsforfait`
--
ALTER TABLE `lignefraishorsforfait`
  ADD CONSTRAINT `lignefraishorsforfait_ibfk_1` FOREIGN KEY (`idVisiteur`,`mois`) REFERENCES `fichefrais` (`idVisiteur`, `mois`);

--
-- Contraintes pour la table `visiteur`
--
ALTER TABLE `visiteur`
  ADD CONSTRAINT `FK_visiteur_idTypeVisiteur` FOREIGN KEY (`idTypeVisiteur`) REFERENCES `typevisiteur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
