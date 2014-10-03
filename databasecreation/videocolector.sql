-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2014 at 02:42 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `videocolector`
--

-- --------------------------------------------------------

--
-- Table structure for table `coments`
--

CREATE TABLE IF NOT EXISTS `coments` (
  `idComent` int(11) NOT NULL AUTO_INCREMENT,
  `coment` varchar(1000) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `idVideo` int(11) NOT NULL,
  `warnings` int(11) NOT NULL,
  PRIMARY KEY (`idComent`),
  KEY `idUsuario` (`idUsuario`,`idVideo`),
  KEY `idVideo` (`idVideo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Usuario`
--

CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) NOT NULL,
  `UserEmail` varchar(200) NOT NULL,
  `avatar` varchar(500) NOT NULL,
  `pass` varchar(100) NOT NULL,
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `UKUserEmail` (`UserEmail`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;



--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `idVideo` int(11) NOT NULL AUTO_INCREMENT,
  `VideoName` varchar(200) NOT NULL,
  `Puntuacion` int(11) NOT NULL,
  `Votes` int(11) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `VideoType` varchar(100) NOT NULL,
  `warnings` int(11) NOT NULL,
  `UpDate` date NOT NULL,
  PRIMARY KEY (`idVideo`),
  KEY `idUsuario` (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `video`
--

-- Constraints for dumped tables
--

--
-- Constraints for table `coments`
--
ALTER TABLE `coments`
  ADD CONSTRAINT `fk_usuario_coment` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`),
  ADD CONSTRAINT `fk_video_coment` FOREIGN KEY (`idVideo`) REFERENCES `video` (`idVideo`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `fk_usuario_video` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
