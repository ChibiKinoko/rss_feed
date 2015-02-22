-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Feb 22, 2015 at 04:47 PM
-- Server version: 5.5.33-MariaDB
-- PHP Version: 5.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `rss_feed`
--
DROP DATABASE IF EXISTS `rss_feed`;

CREATE DATABASE  `rss_feed`;

USE `rss_feed`;

-- --------------------------------------------------------

--
-- Table structure for table `flux`
--
DROP TABLE IF EXISTS `flux`;

CREATE TABLE IF NOT EXISTS `flux` (
`id_flux` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `name_flux` varchar(255) DEFAULT NULL,
  `url` varchar(1000) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--
DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
`id_user` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `password`, `name`, `lastname`) VALUES
(1, 'laure@laure.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'Laure', 'MENG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `flux`
--
ALTER TABLE `flux`
 ADD PRIMARY KEY (`id_flux`), ADD UNIQUE KEY `id_flux` (`id_flux`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id_user`), ADD UNIQUE KEY `id_user` (`id_user`), ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `flux`
--
ALTER TABLE `flux`
MODIFY `id_flux` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
