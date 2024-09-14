SELECT * FROM Kino;
SELECT * FROM Mitarbeiter;
SELECT * FROM Kunde;
SELECT * FROM Produkt;
SELECT * FROM Tickets;
SELECT * FROM Snacks;
SELECT * FROM verkauft;
SELECT * FROM Kauf;
SELECT * FROM Bezahlung;
SELECT * FROM Ermaessigung;

select * from Kino, Mitarbeiter where kino.kinoID = mitarbeiter.Kinoid; 
select * from produkt, tickets where produkt.produktNR = tickets.produktNr; 

--NATURAL JOIN--
SELECT * FROM view_mitarbeiter;

-----GROUPBY,HAVING-----
SELECT * FROM view_product;

-----MAX, MIN, SUM-----
SELECT * FROM max_price;
SELECT * FROM min_salary;
SELECT * FROM sum_price1;

---TEST STORED PROCEDURE---
SET SERVEROUTPUT ON;
DECLARE
    pkundenNr NUMBER;
    pname VARCHAR(255);
    pphone NUMBER;
BEGIN
GetKundeInfo(2222, pname, pphone, pkundenNr);

DBMS_OUTPUT.PUT_LINE('KUNDENNR: ' || pkundenNr);
DBMS_OUTPUT.PUT_LINE('NAME: ' || pname);
DBMS_OUTPUT.PUT_LINE('PHONENR: ' || pphone);
END;
/


ALTER TRIGGER kino_tr DISABLE;