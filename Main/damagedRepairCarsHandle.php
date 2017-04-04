<!DOCTYPE html>
<html lang="en">
<head>
<title>KTCS Homepage</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

  <?php
    include('session.php');
    include('navbaradmin.php');
    ?>
<div class="container-fluid" style="margin-left:20px;">
<h1>Damaged/Need Repair Cars</h1>
</div>
<div class="well" style="margin-left:50px; margin-right:800px;">
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

	// Return VIN of cars that were damaged or not running and haven't been maintenanced since
	$sql_damageRepair_cars = "SELECT VIN
												FROM Car_Rental_History JOIN Car_Maintenance_History USING(VIN)
												WHERE Car_Rental_History.DropoffStatus IN ('damaged', 'not running') AND Car_Rental_History.DropoffDate > Car_Maintenance_History.Date";

	$sql_car_info = "	SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
								FROM car
								WHERE car.vin IN ($sql_damageRepair_cars)";

	$car_info_result = mysqli_query($cxn, $sql_car_info);


	while($row = mysqli_fetch_array($car_info_result)) {
			//echo "VIN: " . $row['VIN'] . "<br>";
			echo "VIN: " . $row['vin'] . "<br>Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"]. "<br>Location ID: " . $row["locationid"] . "<br>Colour: " . $row["colour"] ."<br>Picture Link: " . $row["picturelink"] ."<br>Rental Fee: $" . $row["rentalfee"] . "<br><br>";
		 }

	?>
</div>