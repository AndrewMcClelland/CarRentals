How do we check the most recent car rental history of a given car? (because that'll show the most recent dropoff odo)

<!--
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
<h1>Car Rental History</h1>
</div>
-->

<?php
    
	/*
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "KTCS";
    
    $cxn = mysqli_connect($host,$user,$password, $database);
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
    }
    
    $user_distance = isset($_POST['DistanceSinceMaintenance']) ? $_POST['DistanceSinceMaintenance'] : false;
	
	// Query all cars in maintenance table
	$sql_maintenance = "	SELECT VIN, Odometer
									FROM Car_Maintenance_History";
	
	// Query all cars in rental history table
	$sql_rental = "	SELECT VIN, DropoffOdometer
							FROM Car_Rental_History";
	
	$maintenance_result = mysqli_query($cxn, $sql_maintenance);
	$rental_result = mysqli_query($cxn, $sql_rental);
	
	// Print out all the results from the queries that have > $user_distance since maintenance OR have > $user_distance and have had no maintenance
	if (mysqli_num_rows($sql_rental) > 0) {
		// Loop through each car in the rental table
		while($rental_row = mysqli_fetch_assoc($sql_rental)) {
			
			$rental_dropoff_ODO = $rental_row["DropoffOdometer"];
			$rental_VIN = $rental_row["VIN"];
			
			
			while($maintenance_row = mysqli_fetch_assoc($maintenance_result)) {
				
			}
			
			echo "VIN: " . $row["VIN"]. "<br>MemberID: " . $row["MemberID"]. "<br>PickupOdometer: " . $row["PickupOdometer"]. "<br>DropoffOdometer: " . $row["DropoffOdometer"].  "<br>Date: " . $row["Date"].  "<br><br>";
		}
	} else {
		echo "0 cars that travelled > $user_distance since last maintenance.<br><br>";
	}
	
	mysqli_close($cxn);
    ?>

</body>
</html>

