-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 01, 2024 at 06:12 PM
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
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `muskelgruppen`
--

CREATE TABLE `muskelgruppen` (
  `muskel_id` int(11) NOT NULL,
  `muskel_b` varchar(50) DEFAULT NULL,
  `muskel_g` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `muskelgruppen`
--

INSERT INTO `muskelgruppen` (`muskel_id`, `muskel_b`, `muskel_g`) VALUES
(1, 'Brust', 'M'),
(2, 'Obere Brust', 'M'),
(3, 'Seitliche Schulter', 'K'),
(4, 'Vordere Schulter', 'K'),
(5, 'Hintere Schulter ', 'K'),
(6, 'Bizeps', 'K'),
(7, 'Trizeps', 'K'),
(8, 'Brachialis', 'K'),
(9, 'Unterarme', 'K'),
(10, 'Bauchmuskel', 'G'),
(11, 'Seitliche Bauchmuskel', 'M'),
(12, 'Trapez', 'G'),
(13, 'Latissimus', 'G'),
(14, 'Unterer Rücken', 'G'),
(15, 'Gesäßmuskel', 'M'),
(16, 'Beinbeuger', 'M'),
(17, 'Quadrizeps', 'G'),
(18, 'Waden', 'M');

-- --------------------------------------------------------

--
-- Table structure for table `nutzer`
--

CREATE TABLE `nutzer` (
  `nutzer_id` int(11) NOT NULL,
  `f_name` varchar(50) DEFAULT NULL,
  `l_name` varchar(50) DEFAULT NULL,
  `e_mail` varchar(125) DEFAULT NULL,
  `geb_datum` date DEFAULT NULL,
  `pas` varchar(255) NOT NULL DEFAULT 'default_password'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutzer`
--

INSERT INTO `nutzer` (`nutzer_id`, `f_name`, `l_name`, `e_mail`, `geb_datum`, `pas`) VALUES
(1, 'Linus', 'Behrens', 'linus@behrens-familie.de', '2005-10-14', '$2y$10$fudaFNcW/1j004rm0OsjbOFzewaU6LC02j5nIaeIRbeiX31ygePVa');

-- --------------------------------------------------------

--
-- Table structure for table `nutzerapp`
--

CREATE TABLE `nutzerapp` (
  `größe` float DEFAULT NULL,
  `gewicht` float DEFAULT NULL,
  `datum` date DEFAULT NULL,
  `nutzerapp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutzerapp`
--

INSERT INTO `nutzerapp` (`größe`, `gewicht`, `datum`, `nutzerapp_id`) VALUES
(183, 68, '2024-07-01', 1),
(183, 63, '2024-06-01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `nutzer_nutzerapp`
--

CREATE TABLE `nutzer_nutzerapp` (
  `nutzer_id` int(11) DEFAULT NULL,
  `nutzerapp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutzer_nutzerapp`
--

INSERT INTO `nutzer_nutzerapp` (`nutzer_id`, `nutzerapp_id`) VALUES
(1, 1),
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `nutzer_workout`
--

CREATE TABLE `nutzer_workout` (
  `nutzer_id` int(11) DEFAULT NULL,
  `workout_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutzer_workout`
--

INSERT INTO `nutzer_workout` (`nutzer_id`, `workout_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `workout`
--

CREATE TABLE `workout` (
  `workout_id` int(11) NOT NULL,
  `split` varchar(255) DEFAULT NULL,
  `zeit` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout`
--

INSERT INTO `workout` (`workout_id`, `split`, `zeit`) VALUES
(4, 'Push', '2024-07-01 16:49:05');

-- --------------------------------------------------------

--
-- Table structure for table `workout_übungen`
--

CREATE TABLE `workout_übungen` (
  `workout_id` int(11) DEFAULT NULL,
  `übung_id` int(11) DEFAULT NULL,
  `reps` int(11) DEFAULT NULL,
  `sets` int(11) DEFAULT NULL,
  `gewicht` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_übungen`
--

INSERT INTO `workout_übungen` (`workout_id`, `übung_id`, `reps`, `sets`, `gewicht`) VALUES
(4, 1, 10, 1, 40);

-- --------------------------------------------------------

--
-- Table structure for table `übungen`
--

CREATE TABLE `übungen` (
  `übung_id` int(11) NOT NULL,
  `übung_b` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `übungen`
--

INSERT INTO `übungen` (`übung_id`, `übung_b`) VALUES
(1, 'Bankdrücken'),
(2, 'Schrägbankdrücken'),
(3, 'Dips'),
(4, 'Trizeps-Pushdows'),
(5, 'Seitheben'),
(6, 'Front-Raises'),
(7, 'French-press'),
(8, 'Butterfly'),
(9, 'Chestfly'),
(10, 'Liegestütz'),
(11, 'Trizeps-Extention'),
(12, 'Arnold-Press'),
(13, 'Hyperextension'),
(14, 'Deadlift'),
(15, 'Kreuzheben'),
(16, 'Rückenstrecker'),
(17, 'Reverse-Flys'),
(18, 'Face-Pull'),
(19, 'Hantelrudern'),
(20, 'Shrugs'),
(21, 'Farmerswalk'),
(22, 'Aufrecht-Rudern'),
(23, 'Klimmzüge'),
(24, 'Latzug-geraden-Griff'),
(25, 'Rudern'),
(26, 'Kurzhantelrudern'),
(27, 'T-Bar Rudern'),
(28, 'Curls'),
(29, 'Hammer-Curl'),
(30, 'Curls-im-Sitzen'),
(31, 'Spider-Curls'),
(32, 'Reverse-Curls'),
(33, 'Passiv-Hängen'),
(34, 'Aktiv-Hängen'),
(35, 'Sit-Ups'),
(36, 'Leg-raises');

-- --------------------------------------------------------

--
-- Table structure for table `übungen_muskelgruppen`
--

CREATE TABLE `übungen_muskelgruppen` (
  `übung` int(11) DEFAULT NULL,
  `muskelgruppe1` int(11) DEFAULT NULL,
  `muskelgruppe2` int(11) DEFAULT NULL,
  `muskelgruppe3` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `übungen_muskelgruppen`
--

INSERT INTO `übungen_muskelgruppen` (`übung`, `muskelgruppe1`, `muskelgruppe2`, `muskelgruppe3`) VALUES
(1, 1, 7, 4),
(2, 2, 4, 7),
(3, 7, 1, 0),
(4, 7, 0, 0),
(5, 3, 12, 0),
(6, 4, 0, 0),
(7, 7, 0, 0),
(8, 1, 2, 0),
(9, 2, 2, 0),
(10, 1, 7, 4),
(11, 7, 0, 0),
(12, 4, 0, 0),
(13, 14, 15, 16),
(14, 14, 12, 9),
(15, 14, 12, 9),
(16, 14, 0, 0),
(17, 5, 0, 0),
(18, 5, 6, 0),
(19, 5, 13, 12),
(20, 12, 9, 0),
(21, 12, 9, 0),
(22, 12, 9, 0),
(23, 13, 6, 9),
(24, 13, 6, 9),
(25, 13, 8, 12),
(26, 13, 8, 9),
(27, 13, 8, 9),
(28, 6, 9, 0),
(29, 8, 6, 9),
(30, 6, 9, 0),
(31, 6, 9, 0),
(32, 8, 9, 6),
(33, 9, 0, 0),
(34, 9, 13, 0),
(35, 10, 0, 0),
(36, 10, 9, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `muskelgruppen`
--
ALTER TABLE `muskelgruppen`
  ADD PRIMARY KEY (`muskel_id`);

--
-- Indexes for table `nutzer`
--
ALTER TABLE `nutzer`
  ADD PRIMARY KEY (`nutzer_id`);

--
-- Indexes for table `nutzerapp`
--
ALTER TABLE `nutzerapp`
  ADD PRIMARY KEY (`nutzerapp_id`);

--
-- Indexes for table `workout`
--
ALTER TABLE `workout`
  ADD PRIMARY KEY (`workout_id`);

--
-- Indexes for table `übungen`
--
ALTER TABLE `übungen`
  ADD PRIMARY KEY (`übung_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `muskelgruppen`
--
ALTER TABLE `muskelgruppen`
  MODIFY `muskel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `nutzer`
--
ALTER TABLE `nutzer`
  MODIFY `nutzer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `nutzerapp`
--
ALTER TABLE `nutzerapp`
  MODIFY `nutzerapp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `workout`
--
ALTER TABLE `workout`
  MODIFY `workout_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `übungen`
--
ALTER TABLE `übungen`
  MODIFY `übung_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
