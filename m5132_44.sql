-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 29. Nov 2019 um 23:42
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
  `title` text NOT NULL,
  `description_text` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `answer`
--

INSERT INTO `answer` (`id`, `title`, `description_text`) VALUES
(1, 'M1', 'ah ja'),
(2, 'M2', 'ee'),
(3, 'The Wire', ''),
(4, 'The Sopranos', ''),
(5, 'Breaking Bad', ''),
(6, 'Lost', ''),
(7, 'Dexter', ''),
(8, 'Scrubs', ''),
(9, 'Game Of Thrones', ''),
(10, 'Dr. House', ''),
(11, 'Januar', ''),
(12, 'Februar', ''),
(13, 'MÃ¤rz', ''),
(14, 'April', ''),
(15, 'Mai', ''),
(16, 'Juni', ''),
(17, 'Juli', ''),
(18, 'August', ''),
(19, 'September', ''),
(20, 'Oktober', ''),
(21, 'November', ''),
(22, 'Dezember', ''),
(23, '300 Liter', ''),
(27, '600 Liter', ''),
(28, '1000 Liter', ''),
(29, '1700 Liter', ''),
(30, '2500 Liter', '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `category`
--

CREATE TABLE `category` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(50) DEFAULT '#000000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `category`
--

INSERT INTO `category` (`id`, `name`, `color`) VALUES
(4, 'Lifestyle', '#ff62f5'),
(5, 'Sport', '#00ff18'),
(6, 'Wissen', '#3922f9'),
(7, 'Abgabe', '#ff0038'),
(8, 'Technik', '#fdd65b');

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
  `description_text` mediumtext,
  `single_select` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `survey`
--

INSERT INTO `survey` (`id`, `title`, `start_date`, `end_date`, `category_id`, `description_text`, `single_select`) VALUES
(2, 'Aktive Umfrage fÃ¼r Bewertung', '2019-12-12', '2020-01-25', 4, 'Ihr Lieblingsmonat?\r\n(Single-Select)', 1),
(3, 'Inaktive Umfrage fÃ¼r Bewertung (November)', '2019-11-01', '2019-11-30', 4, 'Welche Serien haben Sie bereits gesehen?\r\n(Multi-Select)', 0),
(4, 'Inaktive Umfrage fÃ¼r Bewertung (Februar/MÃ¤rz)', '2020-02-01', '2020-03-31', 6, 'Wie viel Liter Kunstblut gingen fÃ¼r beide Teile des Kultfilms \"Kill Bill\" drauf?\r\n(Single-Select)', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_answer_option`
--

CREATE TABLE `survey_answer_option` (
  `id` bigint(20) NOT NULL,
  `survey_id` bigint(20) NOT NULL,
  `answer_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `survey_answer_option`
--

INSERT INTO `survey_answer_option` (`id`, `survey_id`, `answer_id`) VALUES
(3, 3, 3),
(4, 3, 4),
(5, 3, 5),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 3, 9),
(10, 3, 10),
(11, 2, 11),
(12, 2, 12),
(13, 2, 13),
(14, 2, 14),
(15, 2, 15),
(16, 2, 16),
(17, 2, 17),
(18, 2, 18),
(19, 2, 19),
(20, 2, 20),
(21, 2, 21),
(22, 2, 22),
(23, 4, 23),
(27, 4, 27),
(28, 4, 28),
(29, 4, 29),
(30, 4, 30);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_voting`
--

CREATE TABLE `survey_voting` (
  `id` bigint(20) NOT NULL,
  `survey_id` bigint(20) NOT NULL,
  `voting_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `survey_voting_answer`
--

CREATE TABLE `survey_voting_answer` (
  `id` bigint(20) NOT NULL,
  `survey_voting_id` bigint(20) NOT NULL,
  `survey_answer_option_id` bigint(20) NOT NULL
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
-- Indizes für die Tabelle `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_category_id_fk` (`category_id`);

--
-- Indizes für die Tabelle `survey_answer_option`
--
ALTER TABLE `survey_answer_option`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_answer_option_answer_id_fk` (`answer_id`),
  ADD KEY `qsurvey_answer_option_survey_id_fk` (`survey_id`);

--
-- Indizes für die Tabelle `survey_voting`
--
ALTER TABLE `survey_voting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_voting_survey_id_fk` (`survey_id`);

--
-- Indizes für die Tabelle `survey_voting_answer`
--
ALTER TABLE `survey_voting_answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `survey_voting_answer_survey_voting_id_fk` (`survey_voting_id`),
  ADD KEY `survey_voting_answer_survey_answer_option_id_fk` (`survey_answer_option_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `answer`
--
ALTER TABLE `answer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `category`
--
ALTER TABLE `category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT für Tabelle `survey`
--
ALTER TABLE `survey`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `survey_answer_option`
--
ALTER TABLE `survey_answer_option`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT für Tabelle `survey_voting`
--
ALTER TABLE `survey_voting`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `survey_voting_answer`
--
ALTER TABLE `survey_voting_answer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `survey`
--
ALTER TABLE `survey`
  ADD CONSTRAINT `survey_category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON UPDATE CASCADE;

--
-- Constraints der Tabelle `survey_answer_option`
--
ALTER TABLE `survey_answer_option`
  ADD CONSTRAINT `qsurvey_answer_option_survey_id_fk` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_answer_option_answer_id_fk` FOREIGN KEY (`answer_id`) REFERENCES `answer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `survey_voting`
--
ALTER TABLE `survey_voting`
  ADD CONSTRAINT `survey_voting_survey_id_fk` FOREIGN KEY (`survey_id`) REFERENCES `survey` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `survey_voting_answer`
--
ALTER TABLE `survey_voting_answer`
  ADD CONSTRAINT `survey_voting_answer_survey_answer_option_id_fk` FOREIGN KEY (`survey_answer_option_id`) REFERENCES `survey_answer_option` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `survey_voting_answer_survey_voting_id_fk` FOREIGN KEY (`survey_voting_id`) REFERENCES `survey_voting` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
