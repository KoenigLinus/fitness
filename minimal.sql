SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------

CREATE TABLE muskel (
  muskelID INT PRIMARY KEY AUTO_INCREMENT,
  bezeichnung varchar(50) DEFAULT NULL,
  groeße varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO muskel (muskelID, bezeichnung, groeße) VALUES
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

CREATE TABLE user (
  userID INT PRIMARY KEY AUTO_INCREMENT,
  name varchar(50) DEFAULT NULL,
  mail varchar(125) DEFAULT NULL,
  birth DEFAULT NULL,
  password varchar(255) NOT NULL DEFAULT 'default_password',
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO user (userID, name, mail, birth, password) VALUES
(1, 'Nanu Bogdan', 'bogtubeSSD@gmail.com', '2005-12-06', 'default_password'),
(2, 'Linus Behrens', 'Linus@behrens-familie.de', '2005-10-14', 'default_password');

-- --------------------------------------------------------

CREATE TABLE userValue (
    userValueID INT PRIMARY KEY AUTO_INCREMENT,
    size float DEFAULT NULL,
    weight float DEFAULT NULL,
    date date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

CREATE TABLE workout (
  workoutID INT PRIMARY KEY AUTO_INCREMENT,
  split varchar(50) DEFAULT NULL,
  date datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO workout (workoutID, split, datum) VALUES
(1, 'Push', '2024-06-30 12:34:56'),
(2, 'Pull', '2024-06-30 12:34:56'),
(3, 'Pull', '2024-06-28 12:34:56');

-- --------------------------------------------------------

CREATE TABLE uebung (
  uebungID INT PRIMARY KEY AUTO_INCREMENT,
  uebung varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO uebung (uebungID, uebung) VALUES
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

CREATE TABLE muskelRELuebung(
    muskelID INT,
    uebungID INT,
    FOREIGN KEY (muskelID) REFERENCES muskel(muskelID),
    FOREIGN KEY (uebungID) REFERENCES uebung(uebungID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO muskelRELuebung (muskelID, uebungID) VALUES
(1, 4),
(3, 1),
(3, 2),
(4, 3);

-- --------------------------------------------------------

CREATE TABLE uebungRELworkout(
    uebungID INT,
    reps INT,
    gewicht INT,
    workoutID INT,
    FOREIGN KEY (uebungID) REFERENCES uebung(uebungID),
    FOREIGN KEY (workoutID) REFERENCES workout(workoutID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO uebungRELworkout (muskelID, reps, gewicht, uebungID) VALUES
(1, 24, 50, 1),
(2, 18, 50, 1),
(3, 10, 0, 1),
(4, 28, 20, 1);

-- --------------------------------------------------------

CREATE TABLE userRELworkout(
    userID INT,
    workoutID INT,
    FOREIGN KEY (userID) REFERENCES userID(userID),
    FOREIGN KEY (workoutID) REFERENCES workout(workoutID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO uebungRELworkout (muskelID, reps, gewicht, uebungID) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

CREATE TABLE userRELuserValue(
    userID INT,
    userValueID INT,
    FOREIGN KEY (userID) REFERENCES user(userID),
    FOREIGN KEY (userValueID) REFERENCES userValue(userValueID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO uebungRELworkout (userID, userValueID) VALUES
(1, 1),
(2, 2);
