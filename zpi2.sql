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
Ulica	VARCHAR (100) NOT NULL,
NrDomu VARCHAR (10) NOT NULL,
NrMieszkania INT (10) NOT NULL,
KodPocztowy VARCHAR (10) NOT NULL,
Stawka FLOAT,
StawkaNadgodzin FLOAT ,
PRIMARY KEY(IdPracownika),
FOREIGN KEY(IdStanowiska) REFERENCES Stanowisko(IdStanowiska)
) ENGINE = InnoDB;

CREATE TABLE  RejestrWe (
IdRWe INT NOT NULL auto_increment,
IdPracownika INT NOT NULL,
godz_WE TIME NOT NULL,
kiedy	DATE	NOT NULL,
PRIMARY KEY(IdRWE),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
) ENGINE= InnoDB;

CREATE TABLE  RejestrWy (
IdRWy INT NOT NULL auto_increment,
IdPracownika INT NOT NULL,
godz_WY TIME NOT NULL,
kiedy	DATE	NOT NULL,
PRIMARY KEY(IdRWy),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
) ENGINE= InnoDB;

CREATE TABLE ZestawienieDzienne(
Id	INT NOT NULL auto_increment,
IdPracownika	INT(100) NOT NULL,
Dzien DATE,
CzasPracy TIME,
Nadgodziny TIME,
CzasSpoznienia TIME,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
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
IdPracownika INT NOT NULL,
Login VARCHAR(100) NOT NULL,
Haslo	VARCHAR(300) NOT NULL,
Email	VARCHAR(100) NOT NULL,
PRIMARY KEY(Id),
FOREIGN KEY(IdPracownika) REFERENCES Pracownicy(IdPracownika)
) ENGINE = InnoDB;
