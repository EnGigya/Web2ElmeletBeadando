-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2018. Már 05. 23:47
-- Kiszolgáló verziója: 10.1.19-MariaDB
-- PHP verzió: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `web2`
--
CREATE DATABASE IF NOT EXISTS `web2` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `web2`;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `felhasznalok`
--

CREATE TABLE IF NOT EXISTS `felhasznalok` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `csaladi_nev` varchar(45) NOT NULL DEFAULT '',
  `utonev` varchar(45) NOT NULL DEFAULT '',
  `bejelentkezes` varchar(12) NOT NULL DEFAULT '',
  `jelszo` varchar(40) NOT NULL DEFAULT '',
  `jogosultsag` varchar(3) NOT NULL DEFAULT '_1_',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `felhasznalok`
--

INSERT INTO `felhasznalok` (`id`, `csaladi_nev`, `utonev`, `bejelentkezes`, `jelszo`, `jogosultsag`) VALUES
(1, 'Rendszer', 'Admin', 'Admin', sha1('admin'), '__1'),
(2, 'Családi_2', 'Utónév_2', 'Login2', sha1('login2'), '_1_'),
(3, 'Családi_3', 'Utónév_3', 'Login3', sha1('login3'), '_1_'),
(4, 'Családi_4', 'Utónév_4', 'Login4', sha1('login4'), '_1_'),
(5, 'Családi_5', 'Utónév_5', 'Login5', sha1('login5'), '_1_'),
(6, 'Családi_6', 'Utónév_6', 'Login6', sha1('login6'), '_1_'),
(7, 'Családi_7', 'Utónév_7', 'Login7', sha1('login7'), '_1_'),
(8, 'Családi_8', 'Utónév_8', 'Login8', sha1('login8'), '_1_'),
(9, 'Családi_9', 'Utónév_9', 'Login9', sha1('login9'), '_1_'),
(10, 'Családi_10', 'Utónév_10', 'Login10', sha1('login10'), '_1_');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `url` varchar(30) NOT NULL,
  `nev` varchar(30) NOT NULL,
  `szulo` varchar(30) NOT NULL,
  `jogosultsag` varchar(3) NOT NULL,
  `sorrend` tinyint(4) NOT NULL,
  PRIMARY KEY (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- A tábla adatainak kiíratása `menu`
--

INSERT INTO `menu` (`url`, `nev`, `szulo`, `jogosultsag`, `sorrend`) VALUES
('admin', 'Admin', '', '001', 80),
('soapmnb', 'SOAPMNB', 'elerhetoseg', '111', 40),
('belepes', 'Belépés', '', '100', 90),
('elerhetoseg', 'Elérhetőség', '', '111', 20),
('pdf', 'PDF', 'elerhetoseg', '011', 50),
('kilepes', 'Kilépés', '', '011', 70),
('soapszerver', 'SOAPszerver', '', '100', 30),
('nyitolap', 'Nyitólap', '', '111', 10),
('restfulszerver', 'Restfulszerver', '', '100', 60);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
