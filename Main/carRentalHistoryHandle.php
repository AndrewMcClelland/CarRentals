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
<h1>Car Rental History</h1>
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

    $user_vin = isset($_POST['car_dropdown']) ? $_POST['car_dropdown'] : false;

	// Query all rental history for selected car
	$sql_rental_history = "	SELECT VIN, MemberID, PickupOdometer, DropoffOdometer, PickupStatus, DropoffStatus, PickupDate, DropoffDate
										FROM Car_Rental_History
										WHERE Car_Rental_History.VIN = $user_vin";

	$cars_rental_history_result = mysqli_query($cxn, $sql_rental_history);

	// Print out all the results from the car reservations query
	if (mysqli_num_rows($cars_rental_history_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($cars_rental_history_result)) {
			echo "VIN: " . $row["VIN"]. "<br>MemberID: " . $row["MemberID"]. "<br>PickupOdometer: " . $row["PickupOdometer"]. "<br>DropoffOdometer: " . $row["DropoffOdometer"].  "<br>Pickup Status: " . $row["PickupStatus"].  "<br>Dropoff Status: " . $row["DropoffStatus"]. "<br>Pickup date: " . $row["PickupDate"]. "<br>Dropoff Date: " . $row["DropoffDate"]. "<br><br>";
		}
	} else {
		echo "0 car car reservation results<br><br>";
	}

	mysqli_close($cxn);
    ?>
</div>
</body>
</html>
