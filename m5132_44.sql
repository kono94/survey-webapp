a-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 20. Nov 2019 um 01:55
-- Server-Version: 5.7.28-0ubuntu0.16.04.2
-- PHP-Version: 7.0.33-0ubuntu0.16.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `m5132_44`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `answer`
--

CREATE TABLE `answer` (
  `id` bigint(20) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `answer`
--

INSERT INTO `answer` (`id`, `title`) VALUES
(1, 'SPD'),
(2, 'CDU'),
(3, 'FDP'),
(4, 'Die Linke'),
(5, 'AfD'),
(6, 'Grüne/B90'),
(7, '1x Die Woche'),
(8, '2x Die Woche'),
(9, '3x Die Woche'),
(10, 'Jeden Tag, wenn es geht'),
(11, 'Gar nicht'),
(12, 'Fitness'),
(13, 'Vereinssport'),
(14, 'Joggen'),
(15, 'Yoga'),
(16, 'Ja\r'),
(17, 'Nein'),
(18, 'Ja\r'),
(19, 'Nein'),
(20, '< 1 Stunde\r'),
(21, '1-3 Stunden\r'),
(22, '4-6 Stunden\r'),
(23, '7+ Stunden'),
(24, 'sÃ¼ÃŸ und kÃ¶stlich\r'),
(25, 'zieh mich hoch\r'),
(26, 'das macht dick\r'),
(27, 'LeckermÃ¤ulchen'),
(28, 'VizebundesprÃ¤sident\r'),
(29, 'BundesratsprÃ¤sident\r'),
(30, 'BundestagsprÃ¤sident\r'),
(31, 'Bundeskanzler'),
(32, 'Harry Potter\r'),
(33, 'Peter Pan\r'),
(34, 'Jim Knopf\r'),
(35, 'Pippi Langstrumpf'),
(36, 'Fiasko\r'),
(37, 'Fresko\r'),
(38, 'Fiesta\r'),
(39, 'Friscro');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Sport'),
(2, 'Politik'),
(3, 'Lifestyle'),
(4, 'Marketing'),
(6, 'Wissen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `question`
--

CREATE TABLE `question` (
  `id` bigint(20) NOT NULL,
  `title` text,
  `question_type_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `question`
--

INSERT INTO `question` (`id`, `title`, `question_type_id`) VALUES
(1, 'Welche Partei würden Sie wählen?', 1),
(2, 'Wie oft treiben Sie Sport?', 1),
(3, 'Welche Art der Bewegung treiben Sie am meisten?', 1),
(4, 'Besitzen Sie ein Smartphone?', 1),
(5, 'Besitzen Sie eine PS4, XBOX oder einen Gaming PC?', 1),
(6, 'Wie lange konsumieren Sie Medien am Tag?', 1),
(7, 'Was bedeutet der Name der italienischen Nachspeise \"Tiramisu\" wÃ¶rtlich?', 1),
(8, 'Wer ist laut Grundgesetz der Vertreter des BundesprÃ¤sidenten?', 1),
(9, 'Welcher Kinderbuchheld entpuppt sich als Nachfahre von einem der Heiligen Drei KÃ¶nige?', 1),
(10, 'Wie bezeichnet man Wandmalerei auf feuchtem Kalkputz?', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `question_answer_option`
--

CREATE TABLE `question_answer_option` (
  `id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `answer_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `question_answer_option`
--

INSERT INTO `question_answer_option` (`id`, `question_id`, `answer_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 2, 7),
(8, 2, 8),
(9, 2, 9),
(10, 2, 10),
(11, 2, 11),
(13, 3, 12),
(14, 3, 13),
(15, 3, 14),
(16, 3, 15),
(17, 4, 16),
(18, 4, 17),
(19, 5, 18),
(20, 5, 19),
(21, 6, 20),
(22, 6, 21),
(23, 6, 22),
(24, 6, 23),
(25, 7, 24),
(26, 7, 25),
(27, 7, 26),
(28, 7, 27),
(29, 8, 28),
(30, 8, 29),
(31, 8, 30),
(32, 8, 31),
(33, 9, 32),
(34, 9, 33),
(35, 9, 34),
(36, 9, 35),
(37, 10, 36),
(38, 10, 37),
(39, 10, 38),
(40, 10, 39);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `question_type`
--

CREATE TABLE `question_type` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `question_type`
--

INSERT INTO `question_type` (`id`, `name`) VALUES
(1, 'Radio-Button Singleselect'),
(2, 'Freitexteingabe');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey`
--

CREATE TABLE `survey` (
  `id` bigint(20) NOT NULL,
  `title` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `description_text` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `survey`
--

INSERT INTO `survey` (`id`, `title`, `start_date`, `end_date`, `category_id`, `description_text`) VALUES
(1, 'Bewegungsumfrage', '2019-11-17', '2019-12-17', 1, 'Kurze Umfrage, um herauszufinden, wie oft sich die Befragten kÃ¶rperlich aktiv sind.'),
(2, 'Sonntagsfrage Bundestagswahl', '2019-11-17', '2019-11-17', 1, 'Wenn am nÃ¤chsten Sonntag Bundestagswahl wÃ¤re...'),
(3, 'Mediennutzung', '2019-11-13', '2019-12-27', 3, 'Fragen Ã¼ber das Verhalten und den Umgang mit Medien.'),
(4, 'Wer wird MillionÃ¤r Fragen', '2019-11-15', '2020-01-10', 6, 'Ein paar Wissensfragen!');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_question`
--

CREATE TABLE `survey_question` (
  `id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `survey_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `survey_question`
--

INSERT INTO `survey_question` (`id`, `question_id`, `survey_id`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 3, 1),
(4, 4, 3),
(5, 5, 3),
(6, 6, 3),
(7, 7, 4),
(8, 8, 4),
(9, 9, 4),
(10, 10, 4);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_result`
--

CREATE TABLE `survey_result` (
  `id` bigint(20) NOT NULL,
  `survey_id` bigint(20) NOT NULL,
  `question_answer_option_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `survey_result`
--

INSERT INTO `survey_result` (`id`, `survey_id`, `question_answer_option_id`) VALUES
(1, 1, 8),
(12, 4, 25),
(13, 4, 30),
(14, 4, 35),
(15, 4, 40),
(16, 4, 25),
(17, 4, 30),
(18, 4, 33),
(19, 4, 40),
(20, 3, 17),
(21, 3, 19),
(22, 3, 23),
(23, 1, 8),
(24, 1, 14);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_result_comment`
--

CREATE TABLE `survey_result_comment` (
  `id` bigint(20) NOT NULL,
  `survey_id` bigint(20) NOT NULL,
  `question_id` bigint(20) NOT NULL,
  `value` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_question_type_id_fk` (`question_type_id`);

--
-- Indizes für die Tabelle `question_answer_option`
--
ALTER TABLE `question_answer_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_answer_option_answer_id_fk` (`answer_id`),
  ADD KEY `question_answer_option_question_id_fk` (`question_id`);

--
-- Indizes für die Tabelle `question_type`
--
ALTER TABLE `question_type`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_category_id_fk` (`category_id`);

--
-- Indizes für die Tabelle `survey_question`
--
ALTER TABLE `survey_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_question_question_id_fk` (`question_id`),
  ADD KEY `survey_question_survey_id_fk` (`survey_id`);

--
-- Indizes für die Tabelle `survey_result`
--
ALTER TABLE `survey_result`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_result_question_answer_option_id_fk` (`question_answer_option_id`),
  ADD KEY `survey_result_survey_id_fk` (`survey_id`);

--
-- Indizes für die Tabelle `survey_result_comment`
--
ALTER TABLE `survey_result_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_comment_question_id_fk` (`question_id`),
  ADD KEY `survey_comment_survey_id_fk` (`survey_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `answer`
--
ALTER TABLE `answer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `question`
--
ALTER TABLE `question`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `question_answer_option`
--
ALTER TABLE `question_answer_option`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT für Tabelle `question_type`
--
ALTER TABLE `question_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `survey`
--
ALTER TABLE `survey`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `survey_question`
--
ALTER TABLE `survey_question`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `survey_result`
--
ALTER TABLE `survey_result`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT für Tabelle `survey_result_comment`
--
ALTER TABLE `survey_result_comment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_question_type_id_fk` FOREIGN KEY (`question_type_id`) REFERENCES `question_type` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `question_answer_option`
--
ALTER TABLE `question_answer_option`
  ADD CONSTRAINT `question_answer_option_answer_id_fk` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `question_answer_option_question_id_fk` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `survey_question`
--
ALTER TABLE `survey_question`
  ADD CONSTRAINT `survey_question_question_id_fk` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_question_survey_id_fk` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `survey_result`
--
ALTER TABLE `survey_result`
  ADD CONSTRAINT `survey_result_question_answer_option_id_fk` FOREIGN KEY (`question_answer_option_id`) REFERENCES `question_answer_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_result_survey_id_fk` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `survey_result_comment`
--
ALTER TABLE `survey_result_comment`
  ADD CONSTRAINT `survey_comment_question_id_fk` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`),
  ADD CONSTRAINT `survey_comment_survey_id_fk` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
