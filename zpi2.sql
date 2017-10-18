CREATE TABLE Uzytkownicy(
Id INT NOT NULL auto_increment,
IdPracownika INT NOT NULL,
Login VARCHAR NOT NULL,
Haslo VARCHAR NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
) ENGINE = InnoDB;

CREATE TABLE Stanowisko (
IdStanowiska INT NOT NULL auto_increment,
Nazwa VARCHAR(100) NOT NULL,
PRIMARY KEY(IdStanowiska)
)ENGINE = InnoDB;

CREATE TABLE Pracownicy	(
IdPracownika INT NOT NULL auto_increment,
IdStanowiska INT (100) NOT NULL,
Nazwisko VARCHAR(100) NOT NULL,
Imie VARCHAR(300) NOT NULL,
DataZatrudnienia DATE,
Miejscowosc VARCHAR (100) NOT NULL,
NrDomu VARCHAR (10) NOT NULL,
NrMieszkania INT (10) NOT NULL,
KodPocztowy VARCHAR (10) NOT NULL,
Stawka FLOAT NOT NULL,
StawkaNadgodzin FLOAT NOT NULL,
PRIMARY KEY(IdPracownika),
FOREIGN KEY(IdStanowiska) REFERENCES Stanowisko(IdStanowiska)
) ENGINE = InnoDB;

CREATE TABLE  Rejestr (
Id INT NOT NULL auto_increment,
IdPracownika INT NOT NULL,
godz_WE datetime NOT NULL,
godz_WY datetime NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
) ENGINE= InnoDB;

CREATE TABLE ZestawienieDzienne(
Id	INT NOT NULL auto_increment,
IdPracownika	INT(100) NOT NULL,
Dzien date,
CzasPracy TIME,
Nadgodziny TIME,
CzasSpoznienia TIME,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
)ENGINE = InnoDB;

CREATE TABLE ZestawienieMiesieczne(
Id	INT NOT NULL auto_increment,
IdPracownika	INT(100) NOT NULL,
DataPodsumowania date,
CzasPracy TIME,
Nadgodziny TIME,
LiczbaSpoznien INT NOT NULL,
CzasSpoznien TIME,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
)ENGINE = InnoDB;


CREATE TABLE Wynagrodzenie	(
Id INT NOT NULL auto_increment,
IdPracownika INT (100) NOT NULL,
DataPodsumowania DATE,
Kwota FLOAT NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
) ENGINE = InnoDB;

CREATE TABLE WebSiteUsers(
Id INT NOT NULL auto_increment,
IdPracownika INT (100) NOT NULL,
Login VARCHAR NOT NULL,
Haslo VARCHAR NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
) ENGINE = InnoDB;
