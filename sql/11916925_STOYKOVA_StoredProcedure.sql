CREATE OR REPLACE PROCEDURE GetKundeInfo(pkundenNr IN NUMBER, pname OUT VARCHAR,
pphone OUT NUMBER, rkundenNr OUT NUMBER) 
AS
v_code INT;
v_errm VARCHAR(200);
    BEGIN
        SELECT KundenNr, Name, TelefonNr
        INTO rkundenNr, pname, pphone
        FROM Kunde
        WHERE KundenNr = pkundenNr;
    EXCEPTION
    WHEN NO_DATA_FOUND THEN
        v_code := -1001;
        v_errm := 'Entries were not found for this KaufNr';
        DBMS_OUTPUT.PUT_LINE(v_code || ' ' || v_errm);
    WHEN OTHERS THEN
        v_code := SQLCODE;
        v_errm := SUBSTR(SQLERRM, 1, 64);
        DBMS_OUTPUT.PUT_LINE(v_code || ' ' || v_errm);
    END;
