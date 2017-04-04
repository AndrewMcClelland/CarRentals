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
    include('navbar.php');
    ?>

<div class="container-fluid" style="margin-left:50px;">
<h1>Thank you for submitting the form!</h1>
</div>
<div class="well" style="margin-left:50px; margin-right:1000px;">
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

	// HOW DOES THIS WORK?
    $LocationIDInput = isset($_POST['location_dropdown']) ? $_POST['location_dropdown'] : false;
	$user_start_date = date('Y-m-d', strtotime($_POST['dateFrom']));
	$user_end_date = date('Y-m-d', strtotime($_POST['dateTo']));


	if($LocationIDInput == "ALL") {
		// Query all cars
	$sql_all_cars_lcoation = " SELECT vin
										  FROM car";
	} else {
		// Query all cars at location
	$sql_all_cars_lcoation = " SELECT vin
										  FROM car
										  WHERE car.locationid = $LocationIDInput";
	}

	// Query all cars that aren't valid
	$sql_reservations = "	SELECT vin
									FROM Reservations
									WHERE (Reservations.startdate >= date '$user_start_date' AND Reservations.startdate <= date '$user_end_date' AND Reservations.enddate >= date '$user_start_date' AND Reservations.enddate >= date '$user_end_date') OR
												(Reservations.startdate <= date '$user_start_date' AND Reservations.startdate <= date '$user_end_date' AND Reservations.enddate >= date '$user_start_date' AND Reservations.enddate >= date '$user_end_date') OR
												(Reservations.startdate <= date '$user_start_date' AND Reservations.startdate <= date '$user_end_date' AND Reservations.enddate >= date '$user_start_date' AND Reservations.enddate <= date '$user_end_date') OR
												(Reservations.startdate >= date '$user_start_date' AND Reservations.startdate <= date '$user_end_date' AND Reservations.enddate >= date '$user_start_date' AND Reservations.enddate <= date '$user_end_date')";

	// Query all cars that match VIN from returned reservations query
	$sql_cars_reservations = "SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
											FROM car
											WHERE vin in ($sql_all_cars_lcoation) AND vin NOT IN ($sql_reservations)";

	//$cars_result = mysqli_query($cxn, $sql_cars);
	//$reservations_result = mysqli_query($cxn, $sql_reservations);
	$cars_reservations_result = mysqli_query($cxn, $sql_cars_reservations);

	/*
	if (mysqli_num_rows($cars_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($cars_result)) {
			echo "VIN: " . $row["vin"]. "<br>Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"].  "<br>LocationID: " . $row["locationid"].  "<br>Colour: " . $row["colour"].  "<br>Picture Link: " . $row["picturelink"].  "<br>Rental Fee: $" . $row["rentalfee"].   "<br><br>";
		}
	} else {
		echo "0 car results<br><br>";
	}

	if (mysqli_num_rows($reservations_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($reservations_result)) {
			echo "VIN: " . $row["vin"]. "<br><br>";
		}
	} else {
		echo "0 reservations results<br><br>";
	}
	*/

	// Print out all the results from the car reservations query
	if (mysqli_num_rows($cars_reservations_result) > 0) {
		// output data of each row
    $_SESSION["row_info"] = "";
		while($row = mysqli_fetch_assoc($cars_reservations_result)) {
			echo "VIN: " . $row["vin"]. "<br>Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"].  "<br>LocationID: " . $row["locationid"].  "<br>Colour: " . $row["colour"].  "<br>Picture Link: " . $row["picturelink"].  "<br>Rental Fee: $" . $row["rentalfee"];

?>

			<form name="register_car" method="POST" action="reservationhandle.php">
			<input value="<?php echo $row["vin"];$_SESSION["fucker"] = $row; $_SESSION["start_date"] = $user_start_date; $_SESSION["end_date"] = $user_end_date;?>" type="hidden" name="search">
			<input type="submit"  value="Reserve Car" class="btn btn-primary" >
			</form>



 <?php
			echo "<br><br>";

		}
	} else {
		echo "0 car results<br><br>";
	}

	mysqli_close($cxn);
    ?>
</div>
</body>
</html>
