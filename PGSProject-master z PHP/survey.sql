-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 04 Kwi 2017, 16:28
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 7.1.1

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

--
-- Zrzut danych tabeli `access`
--

INSERT INTO `access` (`idaccess`, `iduser`, `idsurvey`, `access`) VALUES
(1, 8, 1, 'rw'),
(2, 8, 2, 'rw');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `answeres`
--

CREATE TABLE `answeres` (
  `idanswer` int(11) NOT NULL,
  `idquestion` int(11) NOT NULL,
  `text` text NOT NULL,
  `idsurvey` int(11) NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `answeres`
--

INSERT INTO `answeres` (`idanswer`, `idquestion`, `text`, `idsurvey`, `type`) VALUES
(49, 115, 'ddd', 72, ''),
(50, 115, 'd', 72, ''),
(51, 116, 'fff', 72, ''),
(52, 116, 'gg', 72, ''),
(53, 117, 'Answere1', 1, ''),
(54, 117, 'a', 1, ''),
(55, 117, 'b', 1, ''),
(56, 117, 'c', 1, ''),
(57, 118, '1', 1, ''),
(58, 118, '2', 1, ''),
(59, 118, '3', 1, ''),
(60, 117, 'a', 2, ''),
(61, 117, 's', 2, ''),
(62, 117, 'a', 2, ''),
(63, 117, 'd', 2, ''),
(64, 117, 's', 2, ''),
(65, 121, 'da', 2, ''),
(66, 121, 'da', 2, ''),
(67, 121, 'da', 2, '');

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
(115, 72, 'ww'),
(116, 72, 'saa'),
(117, 1, 'question1'),
(118, 1, 'que2'),
(119, 2, 'question1'),
(120, 2, 'question1'),
(121, 2, 'sas');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `results`
--

CREATE TABLE `results` (
  `idresult` int(11) NOT NULL,
  `idsurvey` int(11) NOT NULL,
  `idquestion` int(11) NOT NULL,
  `idanswer` int(11) NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `surveys`
--

CREATE TABLE `surveys` (
  `idsurvey` int(11) NOT NULL,
  `iduser` int(11) NOT NULL,
  `text` text NOT NULL,
  `status` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `surveys`
--

INSERT INTO `surveys` (`idsurvey`, `iduser`, `text`, `status`, `data`) VALUES
(1, 0, 'jednka nie survey 1', 'complete', '0000-00-00'),
(2, 0, 'survey1', 'complete', '0000-00-00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `iduser` int(11) NOT NULL,
  `login` text NOT NULL,
  `pass` text NOT NULL,
  `email` text NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`iduser`, `login`, `pass`, `email`, `name`, `surname`) VALUES
(1, 'admin', 'admin', '0', 'Marek', '0'),
(2, 'login', 'password', 'email', '', ''),
(3, 'nick', 'pass', 'emaik@gmail.com', 'imie', 'nazwisko'),
(4, 'Crearthor', '$2y$10$CabHjD35v1ebNyZzycklHuV53pRxR8hiGn9EjKDlt3xs1wmD3v4aG', 'some@gmail.com', '', ''),
(6, 'crearthor', '$2y$10$u3Np75vUCfcWKejM3iy1meTSMeavj3GnZ.JCNbIqw0vwTS6LJYHli', 'test@gmail.com', 'Miosz', 'Bbliski'),
(8, 'test2', '$2y$10$GTb4VmUjd8tFaUl9w/BXsekHSweJspYiEgJ0pIj1zQxV89oq007mi', 'test2@gmail.com', 'Micosz', 'BzblicZski'),
(10, 'Logine', '$2y$10$mJgKIEGb606JCzVoOkSJl.BC09SBhwbjk8mDHMV4EkMH6ut2F4UZe', 'email@gmail.com', 'Name', 'Surname'),
(16, 'test', '$2y$10$6v/FKQ/4wH9hf3NgrkLoKO4cCckeqwhHee9lQkxPX1dxTXxdZ4DH.', 'test3@gmail.com', 'wq', 'rf');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`idaccess`);

--
-- Indexes for table `answeres`
--
ALTER TABLE `answeres`
  ADD PRIMARY KEY (`idanswer`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`idquestion`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`idresult`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`idsurvey`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`iduser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `access`
--
ALTER TABLE `access`
  MODIFY `idaccess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `answeres`
--
ALTER TABLE `answeres`
  MODIFY `idanswer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `idquestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;
--
-- AUTO_INCREMENT dla tabeli `results`
--
ALTER TABLE `results`
  MODIFY `idresult` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `surveys`
--
ALTER TABLE `surveys`
  MODIFY `idsurvey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
