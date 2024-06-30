-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 14, 2024 at 11:37 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `armdruecken`
--

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `MatchID` int(11) NOT NULL,
  `SiegerID` int(11) DEFAULT NULL,
  `VerliererID` int(11) DEFAULT NULL,
  `DatumUhrzeit` datetime DEFAULT NULL,
  `ZeitInSekunden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`MatchID`, `SiegerID`, `VerliererID`, `DatumUhrzeit`, `ZeitInSekunden`) VALUES
(1, 1, 2, '2024-06-13 10:00:00', 120),
(2, 2, 1, '2024-06-13 11:00:00', 150),
(3, 1, 3, '2024-06-13 10:02:00', 23),
(4, 1, 1, '2024-06-13 10:11:00', 1),
(5, 1, 3, '2024-06-13 12:01:00', 54),
(6, 2, 1, '2024-06-12 12:47:54', 15),
(7, 2, 1, '2024-06-11 12:47:54', 23),
(8, 2, 1, '2024-06-12 12:47:54', 15),
(9, 2, 1, '2024-06-10 12:47:54', 23),
(10, 4, 1, '2024-06-13 13:20:00', 25),
(11, 3, 2, '2024-06-13 14:07:00', 12),
(12, 5, 1, '2024-06-13 14:48:00', 35);

-- --------------------------------------------------------

--
-- Table structure for table `personen`
--

CREATE TABLE `personen` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Passwort` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personen`
--

INSERT INTO `personen` (`ID`, `Name`, `Passwort`) VALUES
(1, 'Linus', '1234'),
(2, 'Bogdan', '5678'),
(3, 'Rehner', 'wow'),
(4, 'Papa', '12345'),
(5, 'Mama', ''),
(6, 'hi', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`MatchID`),
  ADD KEY `SiegerID` (`SiegerID`),
  ADD KEY `VerliererID` (`VerliererID`);

--
-- Indexes for table `personen`
--
ALTER TABLE `personen`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `MatchID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `personen`
--
ALTER TABLE `personen`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`SiegerID`) REFERENCES `personen` (`ID`),
  ADD CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`VerliererID`) REFERENCES `personen` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
