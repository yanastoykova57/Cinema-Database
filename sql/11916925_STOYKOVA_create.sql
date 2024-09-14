CREATE SEQUENCE kinoID_seq
	START WITH 1
	INCREMENT BY 1
	MINVALUE 1
	MAXVALUE 20
	NOCYCLE
    CACHE 10;

Create table Kino(
KinoID int PRIMARY KEY NOT NULL,
Name varchar(50),
Adresse varchar(100),
TelefonNr int UNIQUE  
);


CREATE OR REPLACE TRIGGER kino_tr
BEFORE INSERT ON Kino
FOR EACH ROW
BEGIN
    IF :NEW.KinoID IS NULL THEN
   :NEW.KinoID := kinoID_seq.NEXTVAL;
   END IF;
END kino_tr;
/

Create table Mitarbeiter (
SV_Nummer int PRIMARY KEY NOT NULL,
MitarbeiterName varchar(255),
Kinoid int,
E_Mail varchar(255),
Gehalt int,
FOREIGN KEY (Kinoid) REFERENCES Kino(KinoID),
Leiter_SV_Nummer int,
FOREIGN KEY (Leiter_SV_Nummer) REFERENCES Mitarbeiter(SV_Nummer)
);

Create table Kunde(
KundenNr INT PRIMARY KEY,
Name varchar(255),
TelefonNr int UNIQUE
);


Create table Kauf(
KaufNr INT PRIMARY KEY,
Datum date,
Preis int,
KundenNr int,
FOREIGN KEY (KundenNr) REFERENCES Kunde(KundenNr) ON DELETE CASCADE
);


Create table Produkt(
ProduktNr int PRIMARY KEY,
Bezeichnung varchar(255),
Preis int,
KaufNR int,
FOREIGN KEY (KaufNR) REFERENCES Kauf(KaufNr)
);

Create table Tickets(
ProduktNr int PRIMARY KEY,
Sitzplatz int,
Filmname varchar(255),
FOREIGN KEY (ProduktNr) REFERENCES Produkt(ProduktNr) ON DELETE CASCADE,
CHECK(Sitzplatz BETWEEN 1 AND 100) 
);

Create table Snacks(
ProduktNr int PRIMARY KEY,
Marke varchar(50),
Groesse char(10),
FOREIGN KEY (ProduktNr) REFERENCES Produkt(ProduktNr) ON DELETE CASCADE
);

CREATE OR REPLACE TRIGGER check_size
BEFORE INSERT OR UPDATE ON Snacks
FOR EACH ROW
DECLARE
    invalid_size EXCEPTION;
BEGIN
    IF :NEW.Groesse NOT IN ('S', 'M', 'L') THEN
    RAISE invalid_size;
    END IF;
EXCEPTION
    WHEN invalid_size THEN
        raise_application_error(-20001, 'Invalid snack size.');
END check_size;
/


Create table verkauft(
KundenNr int,
ProduktNr int,
SV_Nummer int,
PRIMARY KEY (ProduktNr, KundenNr),
FOREIGN KEY (ProduktNr) REFERENCES Produkt(ProduktNr) ON DELETE CASCADE,
FOREIGN KEY (KundenNr) REFERENCES Kunde(KundenNr) ON DELETE CASCADE,
FOREIGN KEY (SV_Nummer) REFERENCES Mitarbeiter(SV_Nummer) ON DELETE CASCADE
);


Create table Bezahlung(
RechnungsNr INT PRIMARY KEY,
KaufNr int,
Zahlungsart varchar(50),
Summe float,
FOREIGN KEY (KaufNr) REFERENCES Kauf(KaufNr) ON DELETE CASCADE 
);

Create table Ermaessigung(
KaufNr int,
EID int,
Prozent varchar(5),
Bezeichnung varchar(50),
PRIMARY KEY (KaufNr, EID),
FOREIGN KEY (KaufNr) REFERENCES Kauf(KaufNr) ON DELETE CASCADE
);


------------------------------VIEWS---------------------------
-----GROUP BY,HAVING-----
CREATE VIEW view_product AS
SELECT bezeichnung, preis 
FROM produkt
GROUP BY bezeichnung, preis 
HAVING preis < 7;

--NATURAL JOIN--
CREATE VIEW view_mitarbeiter AS
SELECT *
FROM Mitarbeiter
NATURAL JOIN Kino;

-----MAX-----
CREATE VIEW max_price AS
SELECT MAX(preis) AS max_preis
FROM Produkt;

-----MIN-----
CREATE VIEW min_salary AS
SELECT MIN(Gehalt) AS min_gehalt
FROM Mitarbeiter;

----SUM----
CREATE VIEW sum_price1 AS
SELECT SUM(Preis) AS sum_preis
FROM Kauf
WHERE KundenNr = 1800;