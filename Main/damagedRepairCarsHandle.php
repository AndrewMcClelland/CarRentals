<!DOCTYPE html>
<html lang="en">
<head>
<title>KTCS Homepage</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<h1>Damaged/Need Repair Cars</h1>
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
	
	// Return VIN of cars that were damaged or not running and haven't been maintenanced since
	$sql_damageRepair_cars = "	SELECT VIN
												FROM Car_Rental_History JOIN Car_Maintenance_History USING(VIN)
												WHERE Car_Rental_History.Status IN ('damaged', 'not running') AND Car_Rental_History.Date > Car_Maintenance_History.Date";
	
	$sql_car_info = "	SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
								FROM car
								WHERE car.vin IN ($sql_damageRepair_cars)";
	
	$car_info_result = mysqli_query($cxn, $sql_car_info);
	
	
	while($row = mysqli_fetch_array($car_info_result)) {
			//echo "VIN: " . $row['VIN'] . "<br>";
			echo "VIN: " . $row['vin'] . "<br>Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"]. "<br>Location ID: " . $row["locationid"] . "<br>Colour: " . $row["colour"] ."<br>Picture Link: " . $row["picturelink"] ."<br>Rental Fee: $" . $row["rentalfee"] . "<br><br>";
		 }
	
	?>