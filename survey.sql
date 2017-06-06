-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 06 Cze 2017, 12:09
-- Wersja serwera: 5.7.18-0ubuntu0.16.04.1
-- Wersja PHP: 7.1.4-1+deb.sury.org~xenial+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `survey`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `access`
--

CREATE TABLE `access` (
  `idaccess` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `idsurvey` int(11) NOT NULL,
  `access` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answeres`
--

CREATE TABLE `answeres` (
  `idanswer` int(11) NOT NULL,
  `idquestion` int(11) NOT NULL,
  `text` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `answeres`
--

INSERT INTO `answeres` (`idanswer`, `idquestion`, `text`, `type`) VALUES
(1, 1, 'Anws1', 'checkbox'),
(4, 1, 'Anws2', 'text'),
(5, 3, 'Anws1', 'checkbox'),
(7, 3, 'Anws2', 'checkbox'),
(8, 2, 'Anws1', 'checkbox'),
(9, 4, 'Anws1', 'checkbox'),
(10, 5, 'pytanie', 'checkbox'),
(11, 5, 'pytanko nowe', 'text');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `questions`
--

CREATE TABLE `questions` (
  `idquestion` int(11) NOT NULL,
  `idsurvey` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `questions`
--

INSERT INTO `questions` (`idquestion`, `idsurvey`, `text`) VALUES
(1, 23, 'NowePytanie'),
(2, 23, 'Question1'),
(3, 23, 'Question2'),
(4, 23, 'Nowe Pytanie'),
(5, 23, 'Nowe Pytanie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `results`
--

CREATE TABLE `results` (
  `idresult` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idsurvey` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `results`
--

INSERT INTO `results` (`idresult`, `date`, `idsurvey`) VALUES
(1, '2017-06-06 10:05:59', 23),
(2, '2017-06-06 10:06:01', 23);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `resultsData`
--

CREATE TABLE `resultsData` (
  `idresults` int(11) NOT NULL,
  `idresultsdate` int(11) NOT NULL,
  `idanswer` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `resultsData`
--

INSERT INTO `resultsData` (`idresults`, `idresultsdate`, `idanswer`, `text`) VALUES
(2, 1, 1, 'true'),
(2, 4, 4, 'Zanotowana odpowiedz tekstowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `surveys`
--

CREATE TABLE `surveys` (
  `idsurvey` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `status` text NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `surveys`
--

INSERT INTO `surveys` (`idsurvey`, `iduser`, `title`, `description`, `status`, `date`) VALUES
(22, 40, 'Mysurvey', 'Test', 'complete', '2017-05-18 22:00:00'),
(23, 40, 'Test', '123', 'complete', '2017-05-19 15:30:26');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`iduser`, `login`, `password`, `email`, `name`, `surname`) VALUES
(40, 'siara', '202cb962ac59075b964b07152d234b70', 'siaramix@gmail.com', 'Piotr', 'Siarkiewicz'),
(41, 'ameba', '202cb962ac59075b964b07152d234b70', 'siara@gmail.com', 'Piotr', 'Siarkiewicz'),
(42, 'Siara123', '81dc9bdb52d04dc20036dbd8313ed055', 'siara@migmail.co', 'Piotr', 'Siarkiewicz');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`idaccess`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idsurvey` (`idsurvey`);

--
-- Indexes for table `answeres`
--
ALTER TABLE `answeres`
  ADD PRIMARY KEY (`idanswer`),
  ADD KEY `idquestion` (`idquestion`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`idquestion`),
  ADD KEY `idsurvey` (`idsurvey`),
  ADD KEY `idquestion` (`idquestion`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`idresult`),
  ADD KEY `idsurvey` (`idsurvey`);

--
-- Indexes for table `resultsData`
--
ALTER TABLE `resultsData`
  ADD PRIMARY KEY (`idresultsdate`),
  ADD KEY `idresults` (`idresults`),
  ADD KEY `idanswer` (`idanswer`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`idsurvey`),
  ADD KEY `iduser` (`iduser`),
  ADD KEY `idsurvey` (`idsurvey`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `login_2` (`login`),
  ADD KEY `iduser` (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `access`
--
ALTER TABLE `access`
  MODIFY `idaccess` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `answeres`
--
ALTER TABLE `answeres`
  MODIFY `idanswer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `idquestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `results`
--
ALTER TABLE `results`
  MODIFY `idresult` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `resultsData`
--
ALTER TABLE `resultsData`
  MODIFY `idresultsdate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT dla tabeli `surveys`
--
ALTER TABLE `surveys`
  MODIFY `idsurvey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_ibfk_2` FOREIGN KEY (`idsurvey`) REFERENCES `surveys` (`idsurvey`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `answeres`
--
ALTER TABLE `answeres`
  ADD CONSTRAINT `answeres_ibfk_1` FOREIGN KEY (`idquestion`) REFERENCES `questions` (`idquestion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`idsurvey`) REFERENCES `surveys` (`idsurvey`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`idsurvey`) REFERENCES `surveys` (`idsurvey`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `resultsData`
--
ALTER TABLE `resultsData`
  ADD CONSTRAINT `resultsData_ibfk_1` FOREIGN KEY (`idresults`) REFERENCES `results` (`idresult`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `resultsData_ibfk_2` FOREIGN KEY (`idanswer`) REFERENCES `answeres` (`idanswer`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
