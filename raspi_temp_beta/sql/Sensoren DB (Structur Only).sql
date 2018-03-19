-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 15. Mrz 2018 um 22:21
-- Server Version: 5.5.52-0+deb8u1
-- PHP-Version: 5.6.26-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `sensoren`
--
CREATE DATABASE IF NOT EXISTS `sensoren` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sensoren`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `basis`
--

DROP TABLE IF EXISTS `basis`;
CREATE TABLE IF NOT EXISTS `basis` (
`Num` int(11) NOT NULL,
  `ID` text NOT NULL,
  `Name` text NOT NULL,
  `Bez` text NOT NULL,
  `langzeit aufzeichnung?` tinyint(1) NOT NULL,
  `offset` float DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `basis_gpio`
--

DROP TABLE IF EXISTS `basis_gpio`;
CREATE TABLE IF NOT EXISTS `basis_gpio` (
`Num` int(11) NOT NULL,
  `IO` text NOT NULL,
  `Pin` text NOT NULL,
  `Name` text NOT NULL,
  `langzeit aufzeichnung?` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `configs`
--

DROP TABLE IF EXISTS `configs`;
CREATE TABLE IF NOT EXISTS `configs` (
`ID` int(11) NOT NULL,
  `KEY_ID` text NOT NULL,
  `VALUE` text NOT NULL,
  `VALUE_2` text NOT NULL,
  `VALUE_3` text NOT NULL,
  `VALUE_4` text NOT NULL,
  `VALUE_5` text NOT NULL,
  `VALUE_6` text NOT NULL,
  `VALUE_7` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `long_data1`
--

DROP TABLE IF EXISTS `long_data1`;
CREATE TABLE IF NOT EXISTS `long_data1` (
`ID` int(11) NOT NULL,
  `Datum` datetime NOT NULL,
  `1OG_KZ` text NOT NULL,
  `1OG_RL` text NOT NULL,
  `1OG_VL` text NOT NULL,
  `BHZG_RL` text NOT NULL,
  `BHZG_VL` text NOT NULL,
  `EG_RL` text NOT NULL,
  `EG_VL` text NOT NULL,
  `ETH_RL` text NOT NULL,
  `ETH_VL` text NOT NULL,
  `HY_HZ_RL` text NOT NULL,
  `HZG_VL` text NOT NULL,
  `HZG_RL` text NOT NULL,
  `HZV_Temp` text NOT NULL,
  `KG_RL` text NOT NULL,
  `KG_VL` text NOT NULL,
  `KG_KZ` text NOT NULL,
  `Solar_RL` text NOT NULL,
  `Solar_VL` text NOT NULL,
  `WW_Sp_RL` text NOT NULL,
  `WW_Sp_VL` text NOT NULL,
  `WW_Sp_Eintritt` text NOT NULL,
  `WW_Sp_Mitte` text NOT NULL,
  `WW_Sp_Austritt` text NOT NULL,
  `Aussen_Temp` text NOT NULL,
  `HY_HZ_VL` text NOT NULL,
  `HY_HV_VL` text NOT NULL,
  `HY_HV_RL` text NOT NULL,
  `Zirk_Pumpe` text NOT NULL,
  `EG_WZ` text
) ENGINE=InnoDB AUTO_INCREMENT=8861 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `long_data_gpio`
--

DROP TABLE IF EXISTS `long_data_gpio`;
CREATE TABLE IF NOT EXISTS `long_data_gpio` (
`ID` int(11) NOT NULL,
  `Datum` datetime NOT NULL,
  `BHZG_KG#OUT` text NOT NULL,
  `BHZG_EG#OUT` text NOT NULL,
  `BHZG_1OG#OUT` text NOT NULL,
  `Zirkulations Pumpe#OUT` text NOT NULL,
  `Heizkoerper Pumpe#IN` text NOT NULL,
  `Fussboden Pumpe#IN` text NOT NULL,
  `Lade Pumpe#IN` text NOT NULL,
  `Zirkulations Pumpe#IN` text NOT NULL,
  `Therme Pumpe#IN` text NOT NULL,
  `BHZG_Schaltung#IN` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=95849 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
`ID` int(11) NOT NULL,
  `BHZG_KG_RANGE` text NOT NULL,
  `BHZG_EG_RANGE` text NOT NULL,
  `BHZG_1OG_RANGE` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `basis`
--
ALTER TABLE `basis`
 ADD PRIMARY KEY (`Num`);

--
-- Indizes für die Tabelle `basis_gpio`
--
ALTER TABLE `basis_gpio`
 ADD PRIMARY KEY (`Num`);

--
-- Indizes für die Tabelle `configs`
--
ALTER TABLE `configs`
 ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `long_data1`
--
ALTER TABLE `long_data1`
 ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `long_data_gpio`
--
ALTER TABLE `long_data_gpio`
 ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `basis`
--
ALTER TABLE `basis`
MODIFY `Num` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT für Tabelle `basis_gpio`
--
ALTER TABLE `basis_gpio`
MODIFY `Num` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT für Tabelle `configs`
--
ALTER TABLE `configs`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT für Tabelle `long_data1`
--
ALTER TABLE `long_data1`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8861;
--
-- AUTO_INCREMENT für Tabelle `long_data_gpio`
--
ALTER TABLE `long_data_gpio`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=95849;
--
-- AUTO_INCREMENT für Tabelle `settings`
--
ALTER TABLE `settings`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
