CREATE USER 'User'@'%' IDENTIFIED VIA mysql_native_password USING '*47D5B9F177716660E61F6E91EA70C0CD3C631859';
GRANT SELECT, INSERT, UPDATE, DELETE ON *.* TO 'User'@'%' REQUIRE NONE WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON zpi.* TO 'User'@'%';
CREATE DATABASE zpi CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE Stanowisko (
Id INT NOT NULL auto_increment,
Nazwa VARCHAR(100) NOT NULL,
PRIMARY KEY(Id)
)ENGINE = InnoDB;

CREATE TABLE Pracownicy	(
Id INT NOT NULL auto_increment,
IdKarty INT (100) NOT NULL,
IdStanowiska INT (100) NOT NULL,
Nazwisko VARCHAR(100) NOT NULL,
Imie VARCHAR(300) NOT NULL,
DataZatrudnienia DATE,
Miejscowosc VARCHAR (100) NOT NULL,
Ulica	VARCHAR (100) NOT NULL,
NrDomu VARCHAR (10) NOT NULL,
NrMieszkania INT (10) NOT NULL,
KodPocztowy VARCHAR (10) NOT NULL,
Stawka FLOAT,
StawkaNadgodzin FLOAT ,
PRIMARY KEY(Id),
FOREIGN KEY(IdKarty) REFERENCES Karta(Id),
FOREIGN KEY(IdStanowiska) REFERENCES Stanowisko(Id)
) ENGINE = InnoDB;

CREATE TABLE  RejestrWe (
Id INT NOT NULL auto_increment,
IdPracownika INT NOT NULL,
godz_WE TIME NOT NULL,
kiedy	DATE	NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE= InnoDB;

CREATE TABLE  RejestrWy (
Id INT NOT NULL auto_increment,
IdPracownika INT NOT NULL,
godz_WY TIME NOT NULL,
kiedy	DATE	NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE= InnoDB;

CREATE TABLE ZestawienieDzienne(
Id	INT NOT NULL auto_increment,
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
LiczbaSpoznien INT NOT NULL,
CzasSpoznien TIME,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
)ENGINE = InnoDB;


CREATE TABLE Wynagrodzenie	(
Id INT NOT NULL auto_increment,
IdPracownika INT (100) NOT NULL,
DataPodsumowania DATE,
Kwota FLOAT NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE = InnoDB;

CREATE TABLE WebSiteUsers(
Id INT NOT NULL auto_increment,
IdPracownika INT NOT NULL,
Login VARCHAR(100) NOT NULL,
Haslo	VARCHAR(300) NOT NULL,
Email	VARCHAR(100) NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(Id)
) ENGINE = InnoDB;

CREATE TABLE Karta	(
Id INT NOT NULL auto_increment,
IdKarty INT (100) NOT NULL,
Primary KEY(Id)
) Engine = InnoDB;
