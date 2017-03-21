<!DOCTYPE html>
<html lang="en">
<head>
<title>Pickup/Drop-Off Car</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<h1>Thank you for submitting the form!</h1>
</div>

<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "KTCS";

    $cxn = mysqli_connect($host,$user,$password, $database);

    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
    }


    $memberID = "20";
    $VIN = "20140294";
    $pickupOdo = $_POST["curOdoReading"];
    $pickupStatus = $_POST["carStatus"];
    date_default_timezone_set('US/Eastern');
    $currentDate = date('Y-m-d H:i:s');

    // Before executing the car insertion check to see if the object exists
    $sqlQuery = "select *
                 from Car_Rental_History
                 where Car_Rental_History.VIN=$VIN and Car_Rental_History.MemberID=$memberID";

    $resultVal = mysqli_query($cxn, $sqlQuery);
    if (mysqli_num_rows($resultVal) > 0)
    {
      echo "Row exists<br></br>";
      // output data of each row
  		while($row = mysqli_fetch_assoc($resultVal))
      {
  			echo "VIN: " . $row["VIN"].
        "<br>MemberID: " . $row["MemberID"].
        "<br>Pickup Odometer: " . $row["PickupOdometer"].
        "<br>Pickup Status: " . $row["PickupStatus"].
        "<br>Pickup Date: " . $row["PickupDate"].
        "<br>Dropoff Odometer: " . $row["DropoffOdometer"].
        "<br>Dropoff Status: " .$row["DropoffStatus"].
        "<br>Dropoff Date: " .$row["DropoffDate"].
        "<br></br>";
        if($row["DropoffOdometer"] == 0 || $row["DropoffOdometer"] == NULL)
        {
          echo "Fill up the drop off values";
          $sqlQuery = "UPDATE Car_Rental_History
                      SET `DropoffOdometer`=$pickupOdo
                      WHERE MemberID=$memberID and VIN=$VIN";
          mysqli_query($cxn, $sqlQuery);
        }
        else
        {
          echo "Can't update dropoff values again - this can only be done once";
          echo "<br></br>Please consult admin if you made an error in the form";
        }
  		}
    }
    else
    {
      echo "Row does not exist - Creating object";
      echo "Fill with pickup values";
      // Create the pickup object
      mysqli_query($cxn, "insert into Car_Rental_History values
                 ('$VIN', '$memberID', '$pickupOdo', 'NULL', '$pickupStatus', 'NULL', '$currentDate', 'NULL')
                 ;");
    }
    ?>
    <!-- Need to ensure object is created before showing this -->
    <h4> Keys are now dispensing </h4>
    <h4>Please pickup them up below </h4>


</body>
</html>
