-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  sam. 28 déc. 2019 à 18:22
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gesco`
--

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

DROP TABLE IF EXISTS `etudiants`;
CREATE TABLE IF NOT EXISTS `etudiants` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) CHARACTER SET utf8 NOT NULL,
  `prenom` varchar(191) CHARACTER SET utf8 NOT NULL,
  `email` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `date_naissance` date NOT NULL,
  `adresse` text CHARACTER SET utf8 NOT NULL,
  `numero` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule` varchar(191) CHARACTER SET utf8 NOT NULL,
  `niv` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grp` int(11) DEFAULT NULL,
  `sect` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `adresse`, `numero`, `matricule`, `niv`, `grp`, `sect`, `created_at`, `updated_at`) VALUES
(1, 'mouri', 'samy', 'js_mouri@esi.dz', '2002-03-05', 'reghaia rouiba', '0555223311', '19/0001', '1CP', 3, 'A', '2019-11-25 21:34:56', '2019-11-25 21:34:56'),
(2, 'ghaouat', 'maroua', 'jm_ghaouat@esi.dz', '1999-07-04', 'lot ali chenoufui', '0553242212', '19/0002', '1CS', 8, 'B', '2019-11-25 21:50:48', '2019-11-25 21:50:48'),
(3, 'gouttel', 'zakaria', 'jz_gouttel@esi.dz', '2002-04-05', 'reghaia rouiba', '0555223312', '19/0003', '1CP', 7, 'C', '2019-11-25 22:08:09', '2019-11-25 22:08:09'),
(4, 'gouttel', 'zakaria', 'jz_gouttel@esi.dz', '2002-04-05', 'reghaia rouiba', '0555223314', '19/0004', '2CS', 2, 'SIQ', '2019-11-26 11:44:07', '2019-11-26 11:44:07'),
(5, 'mouri', 'samy', 'js_mouri@esi.dz', '2002-03-05', 'reghaia rouiba', '0555223311', '19/0005', '2CP', 1, 'A', '2019-11-26 11:44:08', '2019-11-26 11:44:08'),
(6, 'gouttel', 'zakaria', 'jz_gouttel@esi.dz', '2002-04-05', 'reghaia rouiba', '0555223314', '19/0006', '1CP', 3, 'A', '2019-11-26 11:47:22', '2019-11-26 11:47:22'),
(7, 'mouri', 'samy', 'js_mouri@esi.dz', '2002-03-05', 'reghaia rouiba', '0555223311', '19/0007', '2CP', 2, 'A', '2019-11-26 11:47:23', '2019-11-26 11:47:23'),
(8, 'gouttel', 'zakaria', 'jz_gouttel@esi.dz', '2002-04-05', 'reghaia rouiba', '0555223315', '19/0008', '3CS', NULL, NULL, '2019-11-26 12:25:11', '2019-11-26 12:25:11'),
(9, 'kessi', 'lamia', 'jl_kessi@esi.dz', '2000-12-07', 'lot boufarik', '0560232421', '19/0009', '3CS', NULL, NULL, '2019-11-26 13:17:22', '2019-11-26 13:17:22'),
(10, 'gouttel', 'zakaria', 'jz_gouttel@esi.dz', '2002-04-05', 'reghaia rouiba', '0555223316', '19/0010', '1CS', 4, 'A', '2019-11-26 20:59:04', '2019-11-26 20:59:04'),
(11, 'gouttel', 'zakaria', 'jz_gouttel@esi.dz', '2002-04-05', 'reghaia rouiba', '0555223317', '19/0011', '2CS', 1, 'SIQ', '2019-11-26 20:59:35', '2019-11-26 20:59:35'),
(12, 'gouttel', 'zakaria', 'jz_gouttel@esi.dz', '2002-04-05', 'reghaia rouiba', '0555223318', '19/0012', '1CP', 6, 'B', '2019-11-26 21:01:43', '2019-11-26 21:01:43'),
(13, 'mouri', 'samy', 'js_mouri@esi.dz', '2002-03-05', 'lot reghaia', '0555223366', '19/0013', '3CS', NULL, NULL, '2019-11-27 05:09:12', '2019-11-27 05:09:12'),
(14, 'kadi', 'lamine', 'jl_kadi@esi.dz', '2002-03-05', 'lot reghaia', '0555273367', '19/0014', '1CP', 3, 'A', '2019-11-27 11:14:51', '2019-11-27 11:14:51'),
(15, 'mouri', 'samy', 'js_mouri@esi.dz', '2002-03-05', 'lot reghaia', '0555273767', '19/0015', '1CS', 4, 'A', '2019-11-27 20:50:31', '2019-11-27 20:50:31'),
(16, 'mouri', 'samy', 'js_mouri@esi.dz', '2002-03-05', 'lot reghaia', '0558273767', '19/0016', '3CS', NULL, 'SIT', '2019-11-27 20:52:13', '2019-11-27 20:52:13'),
(17, 'mouri', 'samy', 'js_mouri@esi.dz', '2002-03-05', 'lot reghaia', '0558293767', '19/0017', '2CS', 2, 'SIL', '2019-11-27 20:53:01', '2019-11-27 20:53:01');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_11_16_193745_create_etudiants_table', 1),
(4, '2019_11_16_193915_create_profs_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `profs`
--

DROP TABLE IF EXISTS `profs`;
CREATE TABLE IF NOT EXISTS `profs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(191) CHARACTER SET utf8 NOT NULL,
  `prenom` varchar(191) CHARACTER SET utf8 NOT NULL,
  `email` varchar(191) CHARACTER SET utf8 NOT NULL,
  `liste_grp` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `liste_sect` varchar(191) CHARACTER SET utf8 DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `profs`
--

INSERT INTO `profs` (`id`, `nom`, `prenom`, `email`, `liste_grp`, `liste_sect`, `created_at`, `updated_at`) VALUES
(1, 'dib', 'ahmed', 'dib@esi.dz', '2CS/1', '2CP/A', NULL, NULL),
(2, 'haddadou', 'hamid', 'hamid@esi.dz', '2CS/1', '1CP/A', NULL, NULL),
(3, 'kheloufi', 'khr', 'kheloufi@esi.dz', '2CP/15', '1CS/D', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@esi.dz', NULL, '020782', 0, NULL, NULL, NULL),
(2, 'dib', 'dib@esi.dz', NULL, '020782', 1, NULL, NULL, NULL),
(3, 'haddadou', 'hamid@esi.dz', NULL, '020782', 1, NULL, NULL, NULL),
(4, 'kheloufi', 'kheloufi@esi.dz', NULL, '020782', 1, NULL, NULL, NULL),
(5, 'mouri', 'js_mouri@esi.dz', NULL, '12345', 2, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
