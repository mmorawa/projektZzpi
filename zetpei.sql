CREATE USER 'user'@'%' IDENTIFIED BY 'zpi';
GRANT SELECT, INSERT, UPDATE, DELETE ON zpi.* TO 'user'@'%';

CREATE DATABASE zpi CHARACTER SET utf8 COLLATE utf8_general_ci;
USE zpi;
CREATE TABLE Stanowisko (
Id INT NOT NULL auto_increment,
Nazwa VARCHAR(100) NOT NULL,
PRIMARY KEY(Id)
)ENGINE = InnoDB;

CREATE TABLE Pracownicy	(
Id INT NOT NULL auto_increment,
IdKarty INT (100),
IdStanowiska INT (100),
NaZakladzie INT (11) NOT NULL,
Nazwisko VARCHAR(100) NOT NULL,
Imie VARCHAR(300) NOT NULL,
DataZatrudnienia DATE,
Miejscowosc VARCHAR (100) NOT NULL,
Ulica	VARCHAR (100) NOT NULL,
NrDomu VARCHAR (10) NOT NULL,
NrMieszkania INT (10) NOT NULL,
KodPocztowy VARCHAR (10) NOT NULL,
Stawka FLOAT,
PRIMARY KEY(Id),
FOREIGN KEY(IdStanowiska) REFERENCES Stanowisko(Id),
FOREIGN KEY(IdKarty) REFERENCES Karty(Id)
) ENGINE= InnoDB;

CREATE TABLE Karty(
Id INT (10) NOT NULL auto_increment,
IdKarty VARCHAR (100) NOT NULL,
PRIMARY KEY(Id)
)ENGINE= InnoDB;

CREATE TABLE  RejestrWe (
Id INT (11) NOT NULL auto_increment,
IdPracownika INT (11) NOT NULL,
godz_WE TIMESTAMP,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE= InnoDB;

CREATE TABLE  RejestrWy (
Id INT (11) NOT NULL auto_increment,
IdPracownika INT (11) NOT NULL,
godz_WY TIMESTAMP,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE= InnoDB;

CREATE TABLE ZestawienieDzienne(
Id	INT (11) NOT NULL auto_increment,
IdPracownika	INT(100) NOT NULL,
Dzien DATE,
CzasPracy TIME,
Nadgodziny TIME,
CzasSpoznienia TIME,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
)ENGINE = InnoDB;

CREATE TABLE ZestawienieMiesieczne(
Id	INT NOT NULL auto_increment,
IdPracownika	INT(100) NOT NULL,
DataPodsumowania DATE,
CzasPracy TIME,
Nadgodziny TIME,
LiczbaSpoznien INT (11),
CzasSpoznien TIME,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
)ENGINE = InnoDB;


CREATE TABLE Wynagrodzenie	(
Id INT NOT NULL auto_increment,
IdPracownika INT (100) NOT NULL,
DataPodsumowania DATETIME,
Kwota FLOAT NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE = InnoDB;

CREATE TABLE WebSiteUsers(
Id INT (11) NOT NULL auto_increment,
IdPracownika INT (11) NOT NULL,
Login VARCHAR(100) NOT NULL,
Haslo	VARCHAR(300) NOT NULL,
Email	VARCHAR(100) NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE = InnoDB;