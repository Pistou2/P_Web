#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------
# ETML
# Auteur  : Merk Yann - Clément Dieperink
# Date    : 14.02.2017
# Summary : Init script for the database used in the P_Web2 Project
-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2017 at 04:27 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.4

DROP DATABASE IF EXISTS db_P_Web;
CREATE DATABASE db_P_Web;
USE db_P_Web;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_p_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_author`
--

CREATE TABLE `t_author` (
  `idAuthor` int(11) NOT NULL,
  `autName` varchar(50) NOT NULL,
  `autFirstname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_author`
--

INSERT INTO `t_author` (`idAuthor`, `autName`, `autFirstname`) VALUES
(1, 'Douglas', 'Adams\r'),
(2, 'Porte', 'Jean\r'),
(3, 'Trou', 'Bouche');

-- --------------------------------------------------------

--
-- Table structure for table `t_books`
--

CREATE TABLE `t_books` (
  `idBook` int(11) NOT NULL,
  `booTitle` varchar(50) NOT NULL,
  `booPageNumber` int(11) NOT NULL,
  `booExtractLink` varchar(50) DEFAULT NULL,
  `booSummary` varchar(5000) DEFAULT NULL,
  `booReleaseYear` int(11) NOT NULL,
  `booPictureLink` varchar(50) DEFAULT NULL,
  `idBookType` int(11) NOT NULL,
  `idAuthor` int(11) NOT NULL,
  `idEditor` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_books`
--

INSERT INTO `t_books` (`idBook`, `booTitle`, `booPageNumber`, `booExtractLink`, `booSummary`, `booReleaseYear`, `booPictureLink`, `idBookType`, `idAuthor`, `idEditor`, `idUser`) VALUES
(1, 'H2G2', 2042, 'H2G2.pdf', 'Quarante-Deux.', 1978, 'h2g2.jpg', 3, 1, 1, 1),
(2, 'Un nom de livre incroyable et exceptionnel', 41, 'twilight.pdf', 'Il é nul en vré', 2018, 'nopenopenope.jpg', 1, 2, 2, 1),
(3, 'Les bouche trous pour les nuls 1', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(4, 'Les bouche trous pour les nuls 2', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(5, 'Les bouche trous pour les nuls 3', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(6, 'Les bouche trous pour les nuls 4', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(7, 'Les bouche trous pour les nuls 5', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(8, 'Les bouche trous pour les nuls 6', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(9, 'Les bouche trous pour les nuls 7', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(10, 'Les bouche trous pour les nuls 8', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(11, 'Les bouche trous pour les nuls 9', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(12, 'Les bouche trous pour les nuls A', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(13, 'Les bouche trous pour les nuls B', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(14, 'Les bouche trous pour les nuls C', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(15, 'Les bouche trous pour les nuls D', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(16, 'Les bouche trous pour les nuls E', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(17, 'Les bouche trous pour les nuls F', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(18, 'Les bouche trous pour les nuls G', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(19, 'Les bouche trous pour les nuls H', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(20, 'Les bouche trous pour les nuls I', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(21, 'Les bouche trous pour les nuls II', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(22, 'Les bouche trous pour les nuls III', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(23, 'Les bouche trous pour les nuls IV', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(24, 'Les bouche trous pour les nuls V', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(25, 'Les bouche trous pour les nuls VI', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(26, 'Les bouche trous pour les nuls VII', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(27, 'Les bouche trous pour les nuls VIII', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(28, 'Les bouche trous pour les nuls IX', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(29, 'Les bouche trous pour les nuls X', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(30, 'Les bouche trous pour les nuls xD', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(31, 'Les bouche trous pour les nuls xptdr', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(32, 'Les bouche trous pour les nuls ctrédrol', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(33, 'Les bouche trous pour les nuls j\'ai plus d\'idées :', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(34, 'Les bouche trous pour les nuls Harambe 2', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(35, 'Les bouche trous pour les nuls Foxtrot 1', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(36, 'Les bouche trous pour les nuls Squawk 7500', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(37, 'Les bouche trous pour les nuls Dernier volume', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(38, 'Les bouche trous pour les nuls dernier dernier vol', 123, '', '', 2017, 'template.png', 5, 3, 3, 3),
(39, 'Les bouche trous pour les nuls :-:', 123, '', '', 2017, 'template.png', 5, 3, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `t_booktype`
--

CREATE TABLE `t_booktype` (
  `idBookType` int(11) NOT NULL,
  `btName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_booktype`
--

INSERT INTO `t_booktype` (`idBookType`, `btName`) VALUES
(1, 'BD\r'),
(2, 'Manga\r'),
(3, 'Broché\r'),
(4, 'Numérique\r'),
(5, 'Autre');

-- --------------------------------------------------------

--
-- Table structure for table `t_categorize`
--

CREATE TABLE `t_categorize` (
  `idBook` int(11) NOT NULL,
  `idCategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_categorize`
--

INSERT INTO `t_categorize` (`idBook`, `idCategory`) VALUES
(2, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_category`
--

CREATE TABLE `t_category` (
  `idCategory` int(11) NOT NULL,
  `catName` varchar(30) NOT NULL,
  `catDescription` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_category`
--

INSERT INTO `t_category` (`idCategory`, `catName`, `catDescription`) VALUES
(1, 'Pour enfants', 'Ya encore des enfants qui lisent des livrent?\r'),
(2, 'Aventure', '#LitlleGirlsLivesMatter\r'),
(3, 'Policier', '/Ennuyant\r'),
(4, 'Fantastique', '/LSD\r'),
(5, 'Sport', '\r'),
(6, 'Voyage', '\r'),
(7, 'Anglais', 'onli ife iou spique nglish\r'),
(8, 'Allemand', 'Ja Nein Kurrywurst Kartofeln das Auto\r'),
(9, 'SJW', '(Choix par défaut si vous vous sentez offensé du manque de votre propre catégorie)\r'),
(10, 'Informatique', 'o/\r'),
(11, 'Nature / Extérieur', '\r'),
(12, 'Economie/Droit', '\r'),
(13, 'Hotel?', 'Trivago');

-- --------------------------------------------------------

--
-- Table structure for table `t_editor`
--

CREATE TABLE `t_editor` (
  `idEditor` int(11) NOT NULL,
  `ediName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_editor`
--

INSERT INTO `t_editor` (`idEditor`, `ediName`) VALUES
(1, 'DENOËL\r'),
(2, 'Lé livr ct mieu aven éditions\r'),
(3, 'Bouche-Trou inc');

-- --------------------------------------------------------

--
-- Table structure for table `t_rating`
--

CREATE TABLE `t_rating` (
  `ratRating` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idBook` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_rating`
--

INSERT INTO `t_rating` (`ratRating`, `idUser`, `idBook`) VALUES
(5, 1, 1),
(1, 1, 2),
(5, 2, 1),
(3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_user`
--

CREATE TABLE `t_user` (
  `idUser` int(11) NOT NULL,
  `useNickname` varchar(30) NOT NULL,
  `useRegisteryDate` date NOT NULL,
  `usePassword` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_user`
--

INSERT INTO `t_user` (`idUser`, `useNickname`, `useRegisteryDate`, `usePassword`) VALUES
(1, 'merkya@etml.educanet2.ch', '2000-04-06', '$2y$10$Ll.a7InX8WJwPt1rsiW.ou7Yu2wBYG9l9dgpOo9lfKg\r'),
(2, 'dieperincl@etml.educanet2.ch', '2042-12-24', '$2y$10$Tu7EqEO/9.stUUz.Vn03VO3PEuwjYOIGRGaGJVSDT73\r'),
(3, 'webmaster@noreply-sharebook.no', '2017-05-09', '$2y$10$FTOuGsUe.KLDFcVeIHkKM.1lECsrcbHR1C21FiyF5arJzeBa/US72');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_author`
--
ALTER TABLE `t_author`
  ADD PRIMARY KEY (`idAuthor`);

--
-- Indexes for table `t_books`
--
ALTER TABLE `t_books`
  ADD PRIMARY KEY (`idBook`),
  ADD KEY `FK_t_books_idBookType` (`idBookType`),
  ADD KEY `FK_t_books_idAuthor` (`idAuthor`),
  ADD KEY `FK_t_books_idEditor` (`idEditor`),
  ADD KEY `FK_t_books_idUser` (`idUser`);

--
-- Indexes for table `t_booktype`
--
ALTER TABLE `t_booktype`
  ADD PRIMARY KEY (`idBookType`);

--
-- Indexes for table `t_categorize`
--
ALTER TABLE `t_categorize`
  ADD PRIMARY KEY (`idBook`,`idCategory`),
  ADD KEY `FK_t_categorize_idCategory` (`idCategory`);

--
-- Indexes for table `t_category`
--
ALTER TABLE `t_category`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indexes for table `t_editor`
--
ALTER TABLE `t_editor`
  ADD PRIMARY KEY (`idEditor`);

--
-- Indexes for table `t_rating`
--
ALTER TABLE `t_rating`
  ADD PRIMARY KEY (`idUser`,`idBook`),
  ADD KEY `FK_t_rating_idBook` (`idBook`);

--
-- Indexes for table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_author`
--
ALTER TABLE `t_author`
  MODIFY `idAuthor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_books`
--
ALTER TABLE `t_books`
  MODIFY `idBook` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `t_booktype`
--
ALTER TABLE `t_booktype`
  MODIFY `idBookType` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `t_category`
--
ALTER TABLE `t_category`
  MODIFY `idCategory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `t_editor`
--
ALTER TABLE `t_editor`
  MODIFY `idEditor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `t_books`
--
ALTER TABLE `t_books`
  ADD CONSTRAINT `FK_t_books_idAuthor` FOREIGN KEY (`idAuthor`) REFERENCES `t_author` (`idAuthor`),
  ADD CONSTRAINT `FK_t_books_idBookType` FOREIGN KEY (`idBookType`) REFERENCES `t_booktype` (`idBookType`),
  ADD CONSTRAINT `FK_t_books_idEditor` FOREIGN KEY (`idEditor`) REFERENCES `t_editor` (`idEditor`),
  ADD CONSTRAINT `FK_t_books_idUser` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

--
-- Constraints for table `t_categorize`
--
ALTER TABLE `t_categorize`
  ADD CONSTRAINT `FK_t_categorize_idBook` FOREIGN KEY (`idBook`) REFERENCES `t_books` (`idBook`),
  ADD CONSTRAINT `FK_t_categorize_idCategory` FOREIGN KEY (`idCategory`) REFERENCES `t_category` (`idCategory`);

--
-- Constraints for table `t_rating`
--
ALTER TABLE `t_rating`
  ADD CONSTRAINT `FK_t_rating_idBook` FOREIGN KEY (`idBook`) REFERENCES `t_books` (`idBook`),
  ADD CONSTRAINT `FK_t_rating_idUser` FOREIGN KEY (`idUser`) REFERENCES `t_user` (`idUser`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
