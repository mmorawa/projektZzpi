CREATE USER 'user'@'%' IDENTIFIED BY 'zpi';
GRANT SELECT, INSERT, UPDATE, DELETE ON zpi.* TO 'user'@'%';

DROP DATABASE IF EXISTS `zpi`;
CREATE DATABASE IF NOT EXISTS `zpi` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zpi`;

CREATE TABLE `Karty` (
  `Id` int(10) NOT NULL,
  `IdKarty` varchar(100) NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Pracownicy` (
  `Id` int(11) NOT NULL,
  `IdKarty` varchar(100) NOT NULL,
  `IdStanowiska` int(100) NOT NULL,
  `NaZakladzie` int(11) NOT NULL DEFAULT '0',
  `Nazwisko` varchar(100) NOT NULL,
  `Imie` varchar(300) NOT NULL,
  `DataZatrudnienia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Miejscowosc` varchar(100) NOT NULL,
  `Ulica` varchar(100) NOT NULL,
  `NrDomu` varchar(10) NOT NULL,
  `NrMieszkania` int(10) NOT NULL,
  `KodPocztowy` varchar(10) NOT NULL,
  `Stawka` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `RejestrWe` (
  `Id` int(11) NOT NULL,
  `IdPracownika` int(11) NOT NULL,
  `godz_WE` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `RejestrWy` (
  `Id` int(11) NOT NULL,
  `IdPracownika` int(11) NOT NULL,
  `godz_WY` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `Stanowisko` (
  `Id` int(11) NOT NULL,
  `Nazwa` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `WebSiteUsers` (
  `Id` int(11) NOT NULL,
  `IdPracownika` int(11) NOT NULL,
  `Login` varchar(100) NOT NULL,
  `Haslo` varchar(300) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ZestawienieDzienne` (
  `Id` int(11) NOT NULL,
  `IdPracownika` int(100) NOT NULL,
  `Dzien` date DEFAULT NULL,
  `CzasPracy` int(11) DEFAULT NULL,
  `Zarobek` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ZestawienieMiesieczne` (
  `Id` int(11) NOT NULL,
  `IdPracownika` int(100) NOT NULL,
  `DataPodsumowania` date DEFAULT NULL,
  `CzasPracy` int(11) DEFAULT NULL,
  `Wynagrodzenie` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `Karty`
  ADD PRIMARY KEY (`Id`);

ALTER TABLE `Pracownicy`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdStanowiska` (`IdStanowiska`);

ALTER TABLE `RejestrWe`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPracownika` (`IdPracownika`);

ALTER TABLE `RejestrWy`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPracownika` (`IdPracownika`);


ALTER TABLE `Stanowisko`
  ADD PRIMARY KEY (`Id`);


ALTER TABLE `WebSiteUsers`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPracownika` (`IdPracownika`);

ALTER TABLE `ZestawienieDzienne`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPracownika` (`IdPracownika`);

ALTER TABLE `ZestawienieMiesieczne`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `IdPracownika` (`IdPracownika`);

ALTER TABLE `Pracownicy`
  ADD CONSTRAINT `Pracownicy_ibfk_1` FOREIGN KEY (`IdStanowiska`) REFERENCES `Stanowisko` (`Id`);

ALTER TABLE `RejestrWe`
  ADD CONSTRAINT `RejestrWe_ibfk_1` FOREIGN KEY (`IdPracownika`) REFERENCES `Pracownicy` (`Id`);

ALTER TABLE `RejestrWy`
  ADD CONSTRAINT `RejestrWy_ibfk_1` FOREIGN KEY (`IdPracownika`) REFERENCES `Pracownicy` (`Id`);

ALTER TABLE `WebSiteUsers`
  ADD CONSTRAINT `WebSiteUsers_ibfk_1` FOREIGN KEY (`IdPracownika`) REFERENCES `Pracownicy` (`Id`);

ALTER TABLE `ZestawienieDzienne`
  ADD CONSTRAINT `ZestawienieDzienne_ibfk_1` FOREIGN KEY (`IdPracownika`) REFERENCES `Pracownicy` (`Id`);

ALTER TABLE `ZestawienieMiesieczne`
  ADD CONSTRAINT `ZestawienieMiesieczne_ibfk_1` FOREIGN KEY (`IdPracownika`) REFERENCES `Pracownicy` (`Id`);
