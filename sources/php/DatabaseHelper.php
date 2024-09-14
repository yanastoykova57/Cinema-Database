<?php

class DatabaseHelper
{
    // Since the connection details are constant, define them as const
    // We can refer to constants like e.g. DatabaseHelper::username
    const username = 'a11916925'; // use a + your matriculation number
    const password = 'dbs24'; // use your oracle db password
    const con_string = 'oracle19.cs.univie.ac.at:1521/orclcdb';  //on almighty "lab" is sufficient

    // Since we need only one connection object, it can be stored in a member variable.
    // $conn is set in the constructor.
    protected $conn;

    // Create connection in the constructor
    public function __construct()
    {
        try {
            // Create connection with the command oci_connect(String(username), String(password), String(connection_string))
            // The @ sign avoids the output of warnings
            // It could be helpful to use the function without the @ symbol during developing process
            $this->conn = oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string
            );

            //check if the connection object is != null
            if (!$this->conn) {
                // die(String(message)): stop PHP script and output message:
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    // Used to clean up
    public function __destruct()
    {
        // clean up
        oci_close($this->conn);
    }

    public function selectFromEmployeeWhere($Kinoid)
    {
        $sql = "SELECT * FROM Mitarbeiter
            WHERE Kinoid LIKE '%{$Kinoid}%'
            ORDER BY Kinoid ASC";

        $statement = oci_parse($this->conn, $sql);
        if (oci_execute($statement)) {
            oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        } else {
            $error = oci_error($statement);
            throw new Exception("Error: " . $error['message']);
        }

        //clean up;
        oci_free_statement($statement);
        
        return $res;
    }

    public function selectFromPurchaseWhere($KundenNr)
    {
        $sql = "SELECT * FROM Kauf
            WHERE KundenNr = :pkundenNr
            ORDER BY Preis ASC";

        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, 'pkundenNr', $KundenNr, SQLT_INT);

        if (oci_execute($statement)) {
            oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);
        } else {
            $error = oci_error($statement);
            throw new Exception("Error: " . $error['message']);
        }

        //clean up;
        oci_free_statement($statement);
        
        return $res;
    }

    public function selectFromClientWhere($KundenNr)
    {

         $sql = "BEGIN
         GetKundeInfo(:pkundenNr, :pname, :pphone, :rkundenNr);
         END;";

        $statement = oci_parse($this->conn, $sql);

        $pname='';
        $pphone='';
        $rkundenNr = 0;

        oci_bind_by_name($statement, ':pkundenNr', $KundenNr,-1, SQLT_INT);
        oci_bind_by_name($statement, ':pname', $pname, 255);
        oci_bind_by_name($statement, ':pphone', $pphone, 20);
        oci_bind_by_name($statement, ':rkundenNr', $rkundenNr, -1,SQLT_INT);
        
        oci_execute($statement);


        //clean up;
        oci_free_statement($statement);
        
        return [
            'KUNDENNR' => $rkundenNr,
            'NAME' => $pname,
            'TELEFONNR' => $pphone
        ];
    }

    public function selectKinoIDs()
    {
        $sql = "SELECT KinoID FROM Kino";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);

        $kinoIDs = array();

        while($row = oci_fetch_assoc($statement)) {
            $kinoIDs[] = $row['KinoID'];
        }

        oci_free_statement($statement);
        return $kinoIDs;
    }

    public function selectKundenNR()
    {
        $sql = "SELECT KundenNr FROM Kunde";
        $statement = oci_parse($this->conn, $sql);
        oci_execute($statement);

        $kundenNrs = array();

        while($row = oci_fetch_assoc($statement)) {
            $kundenNrs[] = $row['KinoID'];
        }

        oci_free_statement($statement);
        return $kundenNrs;
    }

    public function insertIntoMitarbeiter($SV_Nummer, $MitarbeiterName, $Kinoid, $E_Mail, $Gehalt, $Leiter_SV_Nummer)
    {
        $sql = "INSERT INTO Mitarbeiter (SV_Nummer, MitarbeiterName, Kinoid, E_Mail, Gehalt, Leiter_SV_Nummer) VALUES (:sv, :name, :kinoid, :email, :salary, :manager)";

        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ":sv", $SV_Nummer);
        oci_bind_by_name($statement, ":name", $MitarbeiterName);
        oci_bind_by_name($statement, ":kinoid", $Kinoid);
        oci_bind_by_name($statement, ":email", $E_Mail);
        oci_bind_by_name($statement, ":salary", $Gehalt);
        oci_bind_by_name($statement, ":manager", $Leiter_SV_Nummer);

		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    public function insertIntoKino($Name, $Adresse, $TelefonNr)
    {
        $sql = "INSERT INTO Kino (Name, Adresse, TelefonNr) VALUES ('{$Name}', '{$Adresse}', '{$TelefonNr}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    public function insertIntoEmploys($SV_Nummer, $KinoID)
    {
        $sql = "INSERT INTO beschaeftigt (SV_Nummer, KinoID) VALUES ('{$SV_Nummer}', '{$KinoID}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);
        return $success;
    }

    public function insertIntoClient($KundenNr ,$Name, $TelefonNr)
    {
        $sql = "INSERT INTO Kunde (KundenNr, Name, TelefonNr) VALUES ('{$KundenNr}','{$Name}', '{$TelefonNr}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        return $success;
    }

    public function insertIntoSells($KundenNr, $ProduktNr, $SV_Nummer)
    {
        $sql = "INSERT INTO verkauft (KundenNr, ProduktNr, SV_Nummer) VALUES ('{$KundenNr}','{$ProduktNr}', '{$SV_Nummer}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        return $success;
    }

    public function insertIntoProduct($ProduktNr, $Bezeichnung, $Preis, $KaufNR)
    {
        $sql = "INSERT INTO Produkt (ProduktNr, Bezeichnung, Preis, KaufNR)
         VALUES ('{$ProduktNr}', '{$Bezeichnung}', '{$Preis}', '{$KaufNR}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        return $success;
    }

    public function insertIntoPayment($RechnungsNr, $KaufNr, $Zahlungsart, $Summe)
    {
        $sql = "INSERT INTO Bezahlung (RechnungsNr, KaufNr, Zahlungsart, Summe) VALUES ('{$RechnungsNr}', '{$KaufNr}', '{$Zahlungsart}', '{$Summe}')";

        $statement = oci_parse($this->conn, $sql);
		$success = oci_execute($statement) && oci_commit($this->conn);
        oci_free_statement($statement);

        return $success;
    }

    public function insertIntoPurchase($KaufNr, $Datum, $Preis, $KundenNr)
{
    $sql = "INSERT INTO Kauf (KaufNr, Datum, Preis, KundenNr) VALUES ('{$KaufNr}', TO_DATE(:Datum, 'YYYY-MM-DD'), '{$Preis}', '{$KundenNr}')";

    $statement = oci_parse($this->conn, $sql);
    oci_bind_by_name($statement, ':KaufNr', $KaufNr);
    oci_bind_by_name($statement, ':Datum', $Datum);
    oci_bind_by_name($statement, ':Preis', $Preis);
    oci_bind_by_name($statement, ':KundenNr', $KundenNr);

    $success = oci_execute($statement) && oci_commit($this->conn);
    oci_free_statement($statement);

    return $success;
}

    public function deleteMitarbeiter($SV_Nummer)
    {
        $errorcode = 0;
	    $sql = 'DELETE FROM Mitarbeiter WHERE SV_Nummer = :SV_Nummer';
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':SV_Nummer', $SV_Nummer);
        oci_bind_by_name($statement, ':errorcode', $errorcode);

        $success = oci_execute($statement);

	    $error_info = oci_error($statement);

        oci_free_statement($statement);

        return $success ? true : $error_info['code'];
    }

    public function deletePayment($RechnungsNr)
    {
        $errorcode = 0;
	    $sql = 'DELETE FROM Bezahlung WHERE RechnungsNr = :RechnungsNr';
        $statement = oci_parse($this->conn, $sql);

        oci_bind_by_name($statement, ':RechnungsNr', $RechnungsNr);
        oci_bind_by_name($statement, ':errorcode', $errorcode);

        $success = oci_execute($statement);

	    $error_info = oci_error($statement);

        oci_free_statement($statement);

        return $success ? true : $error_info['code'];
    }

    public function updateSalary($SV_Nummer, $new_salary)
    {
        $sql = "UPDATE Mitarbeiter SET Gehalt = '$new_salary' WHERE Mitarbeiter.SV_Nummer = '$SV_Nummer' ";

        $statement = oci_parse($this->conn, $sql);

		$success = oci_execute($statement) && oci_commit($this->conn);
        if (!$success) {
            $e = oci_error($statement);
            echo htmlentities($e['message'], ENT_QUOTES);
            exit;  
        }
        
        oci_free_statement($statement);
        return $success;
    }

    public function updatePhone($KundenNr, $new_phonenr)
    {
        $sql = "UPDATE Kunde SET TelefonNr = '$new_phonenr' WHERE Kunde.KundenNr = '$KundenNr' ";

        $statement = oci_parse($this->conn, $sql);

		$success = oci_execute($statement) && oci_commit($this->conn);
        if (!$success) {
            $e = oci_error($statement);
            echo htmlentities($e['message'], ENT_QUOTES);
            exit;  
        }
        
        oci_free_statement($statement);
        return $success;
    }
}