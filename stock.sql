-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 03, 2022 at 01:14 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stock`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitecoms`
--

DROP TABLE IF EXISTS `activitecoms`;
CREATE TABLE IF NOT EXISTS `activitecoms` (
  `idActiviteC` int(11) NOT NULL AUTO_INCREMENT,
  `idComs` int(11) NOT NULL,
  `IdVenteAct` varchar(250) NOT NULL,
  `Description` text NOT NULL,
  `Stock` int(11) NOT NULL,
  `Espece` int(11) NOT NULL,
  `dateActC` date NOT NULL,
  `heureActC` time NOT NULL,
  PRIMARY KEY (`idActiviteC`),
  KEY `idComs` (`idComs`),
  KEY `IdVenteAct` (`IdVenteAct`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activitecoms`
--

INSERT INTO `activitecoms` (`idActiviteC`, `idComs`, `IdVenteAct`, `Description`, `Stock`, `Espece`, `dateActC`, `heureActC`) VALUES
(1, 2, '73239', 'Nouvelle vente', 732000, 0, '2022-05-03', '13:27:50'),
(2, 2, '79179', 'Nouvelle vente', 620000, 620000, '2022-05-03', '13:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `activitesolde`
--

DROP TABLE IF EXISTS `activitesolde`;
CREATE TABLE IF NOT EXISTS `activitesolde` (
  `idActSolde` int(11) NOT NULL AUTO_INCREMENT,
  `coms` int(11) NOT NULL,
  `titreComs` varchar(250) NOT NULL,
  `descriptionActSolde` text NOT NULL,
  `NewEspece` int(11) NOT NULL,
  `dateActSolde` date NOT NULL,
  `heureActSolde` time NOT NULL,
  PRIMARY KEY (`idActSolde`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activitesolde`
--

INSERT INTO `activitesolde` (`idActSolde`, `coms`, `titreComs`, `descriptionActSolde`, `NewEspece`, `dateActSolde`, `heureActSolde`) VALUES
(1, 1, 'RETIRE', 'Versement', 232000, '2022-05-03', '13:36:16'),
(2, 1, 'AJOUT 200000 Ar', 'Hampiana', 432000, '2022-05-03', '13:39:13');

-- --------------------------------------------------------

--
-- Table structure for table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
CREATE TABLE IF NOT EXISTS `personnel` (
  `idPerso` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(250) DEFAULT NULL,
  `login` varchar(250) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `prenom` varchar(250) DEFAULT NULL,
  `status` varchar(250) NOT NULL,
  `post` varchar(10) NOT NULL,
  `dernierCo` bigint(20) NOT NULL,
  `inscription` date NOT NULL,
  PRIMARY KEY (`idPerso`),
  KEY `idPerso` (`idPerso`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`idPerso`, `image`, `login`, `mdp`, `nom`, `prenom`, `status`, `post`, `dernierCo`, `inscription`) VALUES
(1, NULL, 'Ric28', '5ebe2294ecd0e0f08eab7690d2a6ee69', 'Ratovonirina', 'Eric', 'OK', 'ADMIN', 1651578608, '2021-09-22'),
(2, NULL, 'Onja28', '05c8bc3622901fe98f4611e6c591d65a', '', 'Onja', 'OK', 'COMS', 1651508290, '2022-04-08');

-- --------------------------------------------------------

--
-- Table structure for table `productactivite`
--

DROP TABLE IF EXISTS `productactivite`;
CREATE TABLE IF NOT EXISTS `productactivite` (
  `idProductAct` int(11) NOT NULL AUTO_INCREMENT,
  `idProduitA` int(11) NOT NULL,
  `idPerso` int(11) NOT NULL,
  `descAP` text NOT NULL,
  `SoldeT` int(11) NOT NULL,
  `dateACP` date NOT NULL,
  `heureACP` time NOT NULL,
  PRIMARY KEY (`idProductAct`),
  KEY `idProduitA` (`idProduitA`),
  KEY `idPerso` (`idPerso`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productactivite`
--

INSERT INTO `productactivite` (`idProductAct`, `idProduitA`, `idPerso`, `descAP`, `SoldeT`, `dateACP`, `heureACP`) VALUES
(1, 1, 1, 'AJOUT DE NOUVEAU PRODUIT', 112000, '2022-05-03', '13:26:22'),
(2, 2, 1, 'AJOUT DE NOUVEAU PRODUIT', 1352000, '2022-05-03', '13:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `idProduit` int(11) NOT NULL AUTO_INCREMENT,
  `NameProduit` varchar(250) NOT NULL,
  `PrixProduit` int(11) NOT NULL,
  `NombreProduit` int(11) NOT NULL,
  `Admin` int(11) NOT NULL,
  `DateProduit` date NOT NULL,
  `HeureProduit` time NOT NULL,
  PRIMARY KEY (`idProduit`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`idProduit`, `NameProduit`, `PrixProduit`, `NombreProduit`, `Admin`, `DateProduit`, `HeureProduit`) VALUES
(1, 'Itel 5606', 56000, 0, 1, '2022-05-03', '13:26:22'),
(2, 'Tecno Spark 7', 620000, 1, 1, '2022-05-03', '13:27:07');

-- --------------------------------------------------------

--
-- Table structure for table `solde`
--

DROP TABLE IF EXISTS `solde`;
CREATE TABLE IF NOT EXISTS `solde` (
  `idSolde` int(11) NOT NULL AUTO_INCREMENT,
  `Espece` int(11) NOT NULL,
  `Stock` int(11) NOT NULL,
  PRIMARY KEY (`idSolde`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `solde`
--

INSERT INTO `solde` (`idSolde`, `Espece`, `Stock`) VALUES
(1, 432000, 620000);

-- --------------------------------------------------------

--
-- Table structure for table `vendrecoms`
--

DROP TABLE IF EXISTS `vendrecoms`;
CREATE TABLE IF NOT EXISTS `vendrecoms` (
  `idVent` int(11) NOT NULL AUTO_INCREMENT,
  `idProduitVent` int(11) NOT NULL,
  `Quantite` int(11) NOT NULL,
  `TotalVent` int(11) NOT NULL,
  PRIMARY KEY (`idVent`),
  KEY `idProduitVent` (`idProduitVent`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ventfaite`
--

DROP TABLE IF EXISTS `ventfaite`;
CREATE TABLE IF NOT EXISTS `ventfaite` (
  `idVenteFaite` int(11) NOT NULL AUTO_INCREMENT,
  `numVente` varchar(10) NOT NULL,
  `idComs` int(11) NOT NULL,
  `idProduitV` int(11) NOT NULL,
  `QtV` int(11) NOT NULL,
  `DateVF` date NOT NULL,
  `heureVF` time NOT NULL,
  PRIMARY KEY (`idVenteFaite`),
  KEY `numVente` (`numVente`),
  KEY `idComs` (`idComs`),
  KEY `idProduitV` (`idProduitV`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ventfaite`
--

INSERT INTO `ventfaite` (`idVenteFaite`, `numVente`, `idComs`, `idProduitV`, `QtV`, `DateVF`, `heureVF`) VALUES
(1, '73239', 2, 2, 1, '2022-05-03', '13:27:50'),
(2, '79179', 2, 1, 2, '2022-05-03', '13:35:44');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
