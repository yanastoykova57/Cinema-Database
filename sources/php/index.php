<?php
// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();
?>

<!DOCTYPE html>
<html lang = "en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css" rel="stylesheet">
    <link href="scripts.js" rel="stylesheet">
    <title>DBS Project</title>

</head>

<style>
body{
  background-color: #fff;
}
.melon{
  background-color: #6B58F5;
}
.khaki{
  background-color: #9345F5;
}
.cambridge_blue{
  background-color: #4265F4;
}
.eggplant{
  background-color: #B4F545;
}
.crayola{
  background-color: #B4F545;
}

.headerstyling{
  text-decoration: none;
  font-weight: bold;
  color: #fff;
  transition: color 0.3 ease;
}

.headerstyling:hover{
  color: #fff;
}

.headerstyling:active{
  color: #fff;
}

.container-center {
        max-width: 1200px; 
        margin: 170px;
        margin-top: 50px; 
    }

.card {
  border-radius: 0;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover{
  transform: translateY(-5px);
  box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}
</style>

<body>
<br>

<div class= "container container-center">
  <div class="row mb-3">
<!-- Add Cinema(Kino) -->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white melon mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="addCinema.php" class= "card-header headerstyling text-center"> ADD CINEMA</a>
<div class="card-body">
    <p class="card-text"> Add a new cinema to the database.</p>
    </div>
  </div>
</div>
<!-- Add Employee(Mitarbeiter) -->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white khaki mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="addMitarbeiter.php" class= "card-header headerstyling text-center"> ADD EMPLOYEE</a>
<div class="card-body">
    <p class="card-text"> Add a new employee to the database.</p>
    </div>
  </div>
  </div>
<!--- Add Client(Kunde) --->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white cambridge_blue mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="addClient.php" class= "card-header headerstyling text-center"> ADD CLIENT</a>
<div class="card-body">
    <p class="card-text"> Add a new client to the database.</p>
    </div>
  </div>
  </div>
  </div>
  <div class="row mb-3">
<!--- Add Product--->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white khaki mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="addProduct.php" class= "card-header headerstyling text-center"> ADD PRODUCT</a>
<div class="card-body">
    <p class="card-text"> Add a new product to the database.</p>
    </div>
  </div>
  </div>

<!--- Add Tickets, Snacks?--->
<!--- Add Purchase(Kauf)--->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white cambridge_blue mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="addPurchase.php" class= "card-header headerstyling text-center"> ADD PURCHASE</a>
<div class="card-body">
    <p class="card-text"> Add a new purchase to the database.</p>
    </div>
  </div>
  </div>
<!--- Add Payment(Bezahlung)--->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white melon mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="addPayment.php" class= "card-header headerstyling text-center"> ADD PAYMENT</a>
<div class="card-body">
    <p class="card-text"> Add a new payment to the database.</p>
    </div>
  </div>
  </div>
  </div>
  <div class="row mb-3">
<!--- Add Sells--->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white cambridge_blue mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="addSells.php" class= "card-header headerstyling text-center"> ADD SELLS</a>
<div class="card-body">
    <p class="card-text"> Assign a new sell to the database.</p>
    </div>
  </div>
  </div>
<!-- Delete Employee -->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white khaki mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="delMitarbeiter.php" class= "card-header headerstyling text-center"> DELETE EMPLOYEE</a>
<div class="card-body">
    <p class="card-text"> Delete an employee from the database.</p>
    </div>
  </div>
  </div>
<!-- Delete Payment -->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white melon mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="delPayment.php" class= "card-header headerstyling text-center"> DELETE PAYMENT</a>
<div class="card-body">
    <p class="card-text"> Delete a payment from the database.</p>
    </div>
  </div>
  </div>
  </div>
<!-- Search Employees -->
<div class="row mb-3">
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white khaki mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="searchEmployees.php" class= "card-header headerstyling text-center">SEARCH EMPLOYEES</a>
<div class="card-body">
    <p class="card-text"> Search employees working in a specific cinema.</p>
    </div>
  </div>
  </div>
<!-- Search Client -->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white melon mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="searchClient.php" class= "card-header headerstyling text-center">SEARCH CLIENT</a>
<div class="card-body">
    <p class="card-text"> Search client by ClientNR.</p>
    </div>
  </div>
  </div>
<!-- Search Purchase -->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white cambridge_blue mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="searchPurchase.php" class= "card-header headerstyling text-center">SEARCH PURCHASE</a>
<div class="card-body">
    <p class="card-text"> Search a purchase in the database.</p>
    </div>
  </div>
  </div>
  </div>
<!-- Update Salary -->
<div class="row mb-3">
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white melon mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="updateSalary.php" class= "card-header headerstyling text-center">UPDATE SALARY</a>
<div class="card-body">
    <p class="card-text"> Update an employee's salary.</p>
    </div>
  </div>
  </div>
<!-- Update PhoneNr -->
<div class="col-md-4 d-flex align-items-stretch">
<div class="card text-white khaki mb-3 d-flex flex-column h-100 w-100" style="max-width: 18rem;">
<a href="updateCPhoneNr.php" class= "card-header headerstyling text-center">UPDATE PHONE NUMBER</a>
<div class="card-body">
    <p class="card-text"> Update a client's phone number.</p>
    </div>
  </div>
  </div>
  </div>
</div> 
</body>
</html>