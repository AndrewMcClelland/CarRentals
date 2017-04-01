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

  <?php
    include('session.php');
    ?>
    <h4> Hi Admin <?php echo $_SESSION["adminEmail"] ?></h4>
    <!-- associate buton with it -->
    <form name="logout" method="POST" action="logout.php">
    <input value="btnLogout" type="hidden" name="Logout" >
    <input type="submit"  value="Logout">
    </form>

<div class="container-fluid">
<h1>Car Rental History</h1>
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

    $user_distance = isset($_POST['DistanceSinceMaintenance']) ? $_POST['DistanceSinceMaintenance'] : false;
	$array_VIN = array(); // array to hold all valid VIN, used to query car info at the end

	// Query all unique VIN in Car_Maintenance_History and return its highest Odometer value (its latest one)
	$sql_maintenance_VIN_ODO = "	SELECT VIN, max(Odometer) as LatestMaintenanceODO
													FROM Car_Maintenance_History
													GROUP BY VIN";

	// Query all unique VIN in Car_Rental_History and return its highest dropoff Odometer value (its latest one)
	$sql_rental_VIN_ODO = "	SELECT VIN, max(DropoffOdometer) as LatestDropoffODO
											FROM Car_Rental_History
											GROUP BY VIN";

	$maintenance_result = mysqli_query($cxn, $sql_maintenance_VIN_ODO);
	$rental_result = mysqli_query($cxn, $sql_rental_VIN_ODO);
	
	/*
	if (mysqli_num_rows($maintenance_result) > 0) {
		// Loop through each car in the rental table
		while($row = mysqli_fetch_assoc($maintenance_result)) {

			echo "VIN: " . $row["VIN"]. "<br>Most Recent Maintenance Odometer: " . $row['LatestMaintenanceODO'] . "<br><br>";
		}
	} else {
		echo "No maintenance values.<br><br>";
	}
	*/
	/*
	if (mysqli_num_rows($rental_result) > 0) {
		// Loop through each car in the rental table
		while($row = mysqli_fetch_assoc($rental_result)) {

			echo "VIN: " . $row["VIN"]. "<br>Most Recent Dropoff Odometer: " . $row['LatestDropoffODO'] . "<br><br>";
		}
	} else {
		echo "No dropoff values.<br><br>";
	}
	
	*/
	
	?>
	
	<br/><hr><br/>
	
	<?php
	// Loop through all Car_Rental_History results and compare VINs to see how far travelled since maintenance
	if (mysqli_num_rows($rental_result) > 0) {
		$found_a_car = false;
		// Loop through each car in the rental table
		while($rental_row = mysqli_fetch_assoc($rental_result)) {
			$rental_vin = $rental_row["VIN"];
			$rental_LatestDropoffODO = $rental_row['LatestDropoffODO'];
			$is_in_maintenance = false;
						
			//Loop through each car in maintenance table, check VIN against current Car_Reservation_VIN and see if distance since maintenance is valied
			// Use boolean flag to see if the car in car_rental_history exists in car_maintenance. If not, compare dropoff odo to 0 km (instead of most recent maintenance)
			while($maintenance_row = mysqli_fetch_assoc($maintenance_result)) {
				$maintenance_vin =  $maintenance_row["VIN"];
				$maintenance_ODO = $maintenance_row['LatestMaintenanceODO'];
				
				// Compare VINs: if equal, compare Rental_Dropoff_Odo to Maintenance_Odo and only print if it's greater than user distance. Break the maintenance loop (because we found matching VIN) and look at next rental VIN
				if($rental_vin == $maintenance_vin) {
					$is_in_maintenance = true;
					if( $user_distance <= ($rental_LatestDropoffODO - $maintenance_ODO)) {
						
						$found_a_car = true;
						
						echo "VIN: " . $rental_vin . " has travelled " . ($rental_LatestDropoffODO - $maintenance_ODO) . " km since last maintenance.<br>";
						
						// Query all unique car info for the relevant VIN in array
						$sql_valid_VIN_info = "	SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
															FROM Car
															WHERE Car.vin = $rental_vin";

						$valid_VIN_info_result = mysqli_query($cxn, $sql_valid_VIN_info);
						
						while($row = mysqli_fetch_array($valid_VIN_info_result)) {
								echo "Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"].  "<br>LocationID: " . $row["locationid"].  "<br>Colour: " . $row["colour"].  "<br>Picture Link: " . $row["picturelink"].  "<br>Rental Fee: $" . $row["rentalfee"] . "<br><br>";
						}
						
						$array_VIN[] = $rental_vin;
					}
					break; // break no matter what since we found matching VIN
				}
				// If VIN not equal, do nothing and keep looping through maintenance to see if we can find matching VIN.
			}
			// If we get here when the flag is still false, it means we couldnt find matching VIN in car_maintenance. So we compare this VIN's dropoff odo to 0 instead,
			if(!$is_in_maintenance) {
				if( $user_distance <= $rental_LatestDropoffODO) {
						
						$found_a_car = true;
						
						echo "VIN: " . $rental_vin . " has travelled " . ($rental_LatestDropoffODO) . " km since last maintenance.<br>";
						
						// Query all unique car info for the relevant VIN in array
						$sql_valid_VIN_info = "	SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
															FROM Car
															WHERE Car.vin = $rental_vin";

						$valid_VIN_info_result = mysqli_query($cxn, $sql_valid_VIN_info);
						
						while($row = mysqli_fetch_array($valid_VIN_info_result)) {
								echo "Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"].  "<br>LocationID: " . $row["locationid"].  "<br>Colour: " . $row["colour"].  "<br>Picture Link: " . $row["picturelink"].  "<br>Rental Fee: $" . $row["rentalfee"] . "<br><br>";
						}
						
						$array_VIN[] = $rental_vin;
					}
				break; // break no matter what since we already compared distances
			}
		}
	} else {
		echo "No car rental history.<br><br>";
	}
	
	// Print if no cars found
	if(!$found_a_car) {
		echo "No cars have travelled " . $user_distance . " km since their last maintenances.";
	}
	
	mysqli_close($cxn);
    ?>

</body>
</html>
