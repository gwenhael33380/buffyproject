-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 mai 2022 à 20:30
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `buffyproject`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL,
  `title` varchar(256) CHARACTER SET utf8mb4 NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `id_image` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `id_article` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `comment_content` text NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `alt` varchar(255) DEFAULT NULL,
  `id_article` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `images`
--

INSERT INTO `images` (`id`, `file_name`, `alt`, `id_article`) VALUES
(1, '628667dba76f5_3218720.jpg-r_1920_1080-f_jpg-q_x-xxyxx.jpg', 'image', NULL),
(2, '628243100c19f_coast-6049953_1920.jpg', NULL, NULL),
(3, '6282443398347_1348610.jpg', NULL, NULL),
(4, '62824ed0a30af_1348610.jpg', NULL, NULL),
(5, '62825ac42914e_WRBL23.jpg', NULL, NULL),
(6, '62866b0e7dd7f_buffy_cover.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` char(20) NOT NULL,
  `role_slug` char(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `role_slug`) VALUES
(1, 'Administrateur', 'administrator'),
(2, 'Éditeur', 'editor'),
(3, 'Utilisateur', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_role` int(2) NOT NULL DEFAULT '3',
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `id_image` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `pseudo` (`pseudo`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `id_role`, `first_name`, `last_name`, `pseudo`, `email`, `password`, `id_image`) VALUES
(7, 1, 'Gwen-haël', 'LE CORRE', 'darkscript', 'le.corre.gwen.hael@gmail.com', '$2y$10$5VqRHsdM9IgEOG2/VFW/LO7PGzb7PIvhBsSQRFRZqbXtUF/z6.9T6', 5),
(3, 3, 'Delphine', 'LE CORRE', 'Gwen-hael', '1234@1234.com', '$2y$10$QSUzQhzuq.kLyGq2/R5nLuaK.IYsxg2Jf77FyMjCh6oKVXCS4Y6S.', 2),
(5, 3, 'Delphine', 'LE CORRE', 'dedelibf', 'ozsjugbhdfg@pzosjdfg.com', '$2y$10$z4K3YxHwANpjYcl3cOnrauzhEDCNCb/3rcMvJr1ZC25RfftErkkVC', 1),
(6, 3, 'Lohan', 'LE CORRE', 'lohan', 'gwen.hael@gmail.com', '$2y$10$1VhpEL9WH6aPsHNHONB.NuKjt/FdJGeKzvCFte2i8m9dMANxBr.5i', 4),
(8, 3, 'Otis', 'MAVRAIMENT', 'sauver', '111@111.com', '$2y$10$qagWpdbXTrh2bXk59n9YKeq2cCK8syhyBb8eAi8n1LGx2NnLNDeUm', 1),
(10, 3, 'Lalala', 'FADELE', 'finouche', '1234@1234.fr', '$2y$10$3U2iYCUuxHzlJelwDaCJtuDIgQpuqNjVeT1O4I7dQmeEsNfLhEH8y', 1),
(11, 3, 'Jajajajaj', 'OISJDEFOIKZEFHJ', 'ozihfoizehrfg', '123@123.fr', '$2y$10$7fc2buJaQbSH.b.V7q1VNO37cjCcubF9wcDZVGevUi3W/zhMZIHzm', 1),
(12, 3, 'Marlene', 'SASOEUR', 'miouf', '0123@0123.fr', '$2y$10$tkZ9i2.UoxA9nok7IyFvkOXpkcJrpWdtXP5yrGMqX8/UZhitA5jTK', 1),
(13, 3, 'Gwen-haël', 'LE CORRE', 'tartufle', '01234@01234.fr', '$2y$10$ytQ4WuBT0NZcHU8vXbEWwud854RdS5bUhZWDiuCNoqs0ajGkvNYgy', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
