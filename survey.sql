-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Maj 2017, 16:25
-- Wersja serwera: 10.1.21-MariaDB
-- Wersja PHP: 7.1.2

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
(7, 18, 14, 'rw'),
(8, 19, 16, 'rw');

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
(90, 141, '1', ''),
(91, 141, '2', ''),
(92, 141, '3', ''),
(93, 142, 'A', ''),
(94, 142, 'B', ''),
(95, 142, 'C', '');

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
(131, 14, 'My question'),
(141, 16, 'Pytanie 1'),
(142, 16, 'Pytanie 2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `results`
--

CREATE TABLE `results` (
  `idresult` int(11) NOT NULL,
  `idsurvey` int(11) NOT NULL,
  `idquestion` int(11) NOT NULL,
  `idanswer` int(11) NOT NULL,
  `text_answer` text NOT NULL,
  `iduser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `surveys`
--

INSERT INTO `surveys` (`idsurvey`, `iduser`, `title`, `description`, `status`, `date`) VALUES
(14, 18, 'My survey', '', 'in progress', '2017-04-09 00:00:00'),
(16, 19, 'Ankieta 1', '', 'in progress', '2017-04-10 00:00:00'),
(17, 19, 'cos', 'jakis', 'completed', '0000-00-00 00:00:00'),
(18, 19, 'd', 'f', 'enabled', '2017-05-05 00:00:00'),
(19, 19, 'fa', 's', 'enabled', '2017-05-03 00:00:00'),
(20, 19, 'ss', 'dd', 'enabled', '2017-05-11 00:00:00'),
(21, 19, 'udalosie', 'udalos sie', 'enabled', '2017-05-03 00:00:00'),
(22, 19, '33', '22', 'enabled', '0000-00-00 00:00:00'),
(23, 19, 'da', 'ad', 'enabled', '2017-05-17 12:33:09'),
(24, 19, 'd', 'd', 'enabled', '2017-05-17 12:47:51'),
(25, 19, 'ss', 'aa', 'enabled', '2017-05-17 12:48:40'),
(26, 19, 'aa', '11', 'complete', '2017-05-17 12:50:19'),
(28, 23, '11', '22', 'complete', '2017-05-17 12:50:43'),
(29, 23, '42', '12', 'complete', '2017-05-17 01:22:46'),
(30, 18, '23', '1', 'complete', '2017-05-17 01:44:49'),
(31, 18, '41', 'ss', 'complete', '2017-05-17 01:56:25'),
(32, 18, '12441', 'sss', 'complete', '2017-05-17 01:56:46'),
(33, 19, '1241', '12', 'complete', '2017-05-17 01:57:22'),
(34, 19, 'lsl', 'kka', 'complete', '2017-05-17 04:24:59');

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
(18, 'PtakiLatajaKluczem', '$2y$10$AOzrZTKVMmyhVWb6WJI15efzSiuJkSSvCPkjJAoFpI3.aME0qkNza', 'siaramix@gmail.com', 'Piotr', 'Siarkiewicz'),
(19, 'crearthor', '$2y$10$RA9Bx2i3Ko/CzTNlv8h7I.CMS/JnUvcM52TBv/OX4qz53.EIo8boG', 'email@gmail.com', 'Milosz', 'Bablinski'),
(20, 'wpadka', '$2y$10$TgYIoNX/m6cIC.Ticfb1AO8J2on3nWiBfn4/Nh1JCeW33ob3GvWyq', 'wpadocha@gmail.com', 'MioszBbliski', 'Bbliski'),
(23, 'test', '202cb962ac59075b964b07152d234b70', 'test@gmail.com', 'eduweb', 'B?bli?ski'),
(24, 'test2', '$2y$10$lrq7HKP0b525cTMpoeQKOedwJJH7ul9JTgN4PDWzXplK1TxrorV06', 'test2@gmail.com', 'eduweb', 'b'),
(26, 'test3', '25d55ad283aa400af464c76d713c07ad', 'test3@gmail.com', 'eduweb', 's'),
(29, 'wpadkaa', '202cb962ac59075b964b07152d234b70', 'wpadsocha@gmail.com', 'eduweb', 'B?bli?ski');

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
  ADD KEY `idquestion` (`idquestion`),
  ADD KEY `idsurvey` (`idsurvey`),
  ADD KEY `idanswer` (`idanswer`),
  ADD KEY `iduser` (`iduser`);

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
  MODIFY `idaccess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT dla tabeli `answeres`
--
ALTER TABLE `answeres`
  MODIFY `idanswer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT dla tabeli `questions`
--
ALTER TABLE `questions`
  MODIFY `idquestion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;
--
-- AUTO_INCREMENT dla tabeli `results`
--
ALTER TABLE `results`
  MODIFY `idresult` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `surveys`
--
ALTER TABLE `surveys`
  MODIFY `idsurvey` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
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
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`idsurvey`) REFERENCES `surveys` (`idsurvey`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`idquestion`) REFERENCES `questions` (`idquestion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_3` FOREIGN KEY (`idanswer`) REFERENCES `answeres` (`idanswer`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_4` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`iduser`) REFERENCES `users` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
