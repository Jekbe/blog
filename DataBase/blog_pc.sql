-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 26, 2024 at 08:50 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `komentarze`
--

CREATE TABLE `komentarze` (
  `ID` int(11) NOT NULL,
  `Tresc_komentarza` text DEFAULT NULL,
  `ID_autora` int(11) DEFAULT NULL,
  `ID_postu` int(11) DEFAULT NULL,
  `Data_dodania` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `obserwowani`
--

CREATE TABLE `obserwowani` (
  `ID_obserwujacego` int(11) NOT NULL,
  `ID_obserwowanego` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obserwowani`
--

INSERT INTO `obserwowani` (`ID_obserwujacego`, `ID_obserwowanego`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `polubienia`
--

CREATE TABLE `polubienia` (
  `ID_polubienia` int(11) NOT NULL,
  `ID_uzytkownika` int(11) DEFAULT NULL,
  `ID_postu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `posty`
--

CREATE TABLE `posty` (
  `ID` int(11) NOT NULL,
  `Tytul_postu` varchar(255) DEFAULT NULL,
  `Tresc_postu` text DEFAULT NULL,
  `Oznaczenie_18plus` tinyint(1) DEFAULT NULL,
  `ID_autora` int(11) DEFAULT NULL,
  `Data_utworzenia` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posty`
--

INSERT INTO `posty` (`ID`, `Tytul_postu`, `Tresc_postu`, `Oznaczenie_18plus`, `ID_autora`, `Data_utworzenia`) VALUES
(1, 'pierwszy post', 'mój pierwszy post na tym forum', 0, 1, '2023-11-24 09:18:23'),
(2, 'test2', 'kolejny post', 0, 1, '2023-11-24 10:10:14'),
(3, 'test pelnoletni', 'czy jestes pelnoletni', 1, 1, '2023-11-27 12:49:12'),
(4, 'test pelnoletni', 'test czy pelnoletni', 1, 1, '2023-11-27 12:50:02'),
(5, 'post testa', 'to jest post na profilu test', 0, 2, '2023-11-29 11:53:45');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID` int(10) NOT NULL,
  `Nick` varchar(255) DEFAULT NULL,
  `Adres_email` varchar(255) DEFAULT NULL,
  `Haslo` varchar(255) DEFAULT NULL,
  `Data_rejestracji` timestamp NOT NULL DEFAULT current_timestamp(),
  `Jest_artysta` tinyint(1) DEFAULT 0,
  `Awatar` varchar(255) DEFAULT NULL,
  `Portfel` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `Pelnoletni` tinyint(1) DEFAULT NULL,
  `Dodatkowe` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID`, `Nick`, `Adres_email`, `Haslo`, `Data_rejestracji`, `Jest_artysta`, `Awatar`, `Portfel`, `Pelnoletni`, `Dodatkowe`) VALUES
(1, 'Jekbe', 'jekbe@gmail.com', '207023ccb44feb4d7dadca005ce29a64', '2024-06-11 19:37:07', 1, NULL, 600, 1, 'o mnie'),
(2, 'Test', 'test@gmail.com', '098f6bcd4621d373cade4e832627b4f6', '2023-11-29 11:51:50', 1, NULL, 600, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowienia`
--

CREATE TABLE `zamowienia` (
  `ID` int(10) NOT NULL,
  `Od` int(10) NOT NULL,
  `Do` int(10) NOT NULL,
  `Opis` text NOT NULL,
  `Przyklad` varchar(50) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0,
  `kwota` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`ID`, `Od`, `Do`, `Opis`, `Przyklad`, `Status`, `kwota`) VALUES
(1, 1, 2, 'moje zamówienie', 'Zamowienia/OC.jpg', 3, 150);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia`
--

CREATE TABLE `zdjecia` (
  `ID` int(11) NOT NULL,
  `Sciezka` varchar(255) DEFAULT NULL,
  `ID_postu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zdjecia`
--

INSERT INTO `zdjecia` (`ID`, `Sciezka`, `ID_postu`) VALUES
(1, './Obrazki/photo_2023-03-17_15-29-31.jpg', 1),
(2, 'Obrazki/photo_2023-03-17_15-29-15.jpg', 2),
(3, 'Obrazki/photo_2023-03-17_15-29-07.jpg', 2),
(4, 'Obrazki/photo_2023-03-17_15-28-30.jpg', 2),
(5, 'Obrazki/Wallpapers For Ubuntu.jpeg', 4),
(6, 'Obrazki/photo_2023-03-17_15-29-57.jpg', 5);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_autora` (`ID_autora`),
  ADD KEY `ID_postu` (`ID_postu`);

--
-- Indeksy dla tabeli `obserwowani`
--
ALTER TABLE `obserwowani`
  ADD PRIMARY KEY (`ID_obserwujacego`,`ID_obserwowanego`),
  ADD KEY `ID_obserwowanego` (`ID_obserwowanego`);

--
-- Indeksy dla tabeli `polubienia`
--
ALTER TABLE `polubienia`
  ADD PRIMARY KEY (`ID_polubienia`),
  ADD KEY `ID_uzytkownika` (`ID_uzytkownika`),
  ADD KEY `ID_postu` (`ID_postu`);

--
-- Indeksy dla tabeli `posty`
--
ALTER TABLE `posty`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_autora` (`ID_autora`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Do` (`Do`),
  ADD KEY `Od` (`Od`);

--
-- Indeksy dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_postu` (`ID_postu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polubienia`
--
ALTER TABLE `polubienia`
  MODIFY `ID_polubienia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posty`
--
ALTER TABLE `posty`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zdjecia`
--
ALTER TABLE `zdjecia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentarze`
--
ALTER TABLE `komentarze`
  ADD CONSTRAINT `Komentarze_ibfk_1` FOREIGN KEY (`ID_autora`) REFERENCES `uzytkownicy` (`ID`),
  ADD CONSTRAINT `Komentarze_ibfk_2` FOREIGN KEY (`ID_postu`) REFERENCES `posty` (`ID`);

--
-- Constraints for table `obserwowani`
--
ALTER TABLE `obserwowani`
  ADD CONSTRAINT `Obserwowani_ibfk_1` FOREIGN KEY (`ID_obserwujacego`) REFERENCES `uzytkownicy` (`ID`),
  ADD CONSTRAINT `Obserwowani_ibfk_2` FOREIGN KEY (`ID_obserwowanego`) REFERENCES `uzytkownicy` (`ID`);

--
-- Constraints for table `polubienia`
--
ALTER TABLE `polubienia`
  ADD CONSTRAINT `Polubienia_ibfk_1` FOREIGN KEY (`ID_uzytkownika`) REFERENCES `uzytkownicy` (`ID`),
  ADD CONSTRAINT `Polubienia_ibfk_2` FOREIGN KEY (`ID_postu`) REFERENCES `posty` (`ID`);

--
-- Constraints for table `posty`
--
ALTER TABLE `posty`
  ADD CONSTRAINT `Posty_ibfk_1` FOREIGN KEY (`ID_autora`) REFERENCES `uzytkownicy` (`ID`);

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`Do`) REFERENCES `uzytkownicy` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`Od`) REFERENCES `uzytkownicy` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD CONSTRAINT `Zdjecia_ibfk_1` FOREIGN KEY (`ID_postu`) REFERENCES `posty` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
