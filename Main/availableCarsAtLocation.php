<!DOCTYPE html>
<html lang="en">
<head>
<title>Available cars & reservations</title>
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

    <form name="homepage" method="POST" action="goToAdminHomepage.php">
    <input value="btnHomepage" type="hidden" name="Back" >
    <input type="submit"  value="Back">
    </form>

<div class="container-fluid">
<h1>Available cars & reservations</h1>
</div>
-->

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

	// Get current date
	date_default_timezone_set('America/New_York');
	//$curr_date = date('m/d/Y h:i:s a', time());
	// To show reservation for car at Union Location (car with VIN = 20140295), date must be before 2014-02-18
	$curr_date = date('2014-02-17');

	// Get selected KTCS location
	$user_location = isset($_POST['location_dropdown']) ? $_POST['location_dropdown'] : false;

	// Query all cars that match VIN in given location
	$sql_cars_atLocation = "	SELECT VIN
										FROM Car
										WHERE car.locationid = $user_location";

	// Query reservations for cars (ASSUMES WE DELETE RESERVATIONS ONCE THEY OCCUR OR ELSE WE'RE QUERYING OLD RESERVATIONS)
	$sql_cars_reservations = "	SELECT VIN
											FROM Reservations
											WHERE StartDate > date '$curr_date' AND Reservations.VIN IN ($sql_cars_atLocation)";


	// View car information for each car that's available and the car's rental info
	$sql_available_cars = "	SELECT *
										FROM Car JOIN Reservations USING (VIN)
										WHERE Car.VIN IN ($sql_cars_reservations)";


	//$cars_atLocation_result = mysqli_query($cxn, $sql_cars_atLocation);
	//$cars_reservations_result = mysqli_query($cxn, $sql_cars_reservations);
	$available_cars_result = mysqli_query($cxn, $sql_available_cars);

	/*
	echo "Cars at location:<br><br>";

	// Print out all the cars at selected location
	if (mysqli_num_rows($cars_atLocation_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($cars_atLocation_result)) {
			echo "VIN: " . $row["VIN"] . "<br><br>";
		}
	} else {
		echo "No cars at selected location.<br><br>";
	}

	echo "Reservations for cars at location:<br><br>";

	// Print out all the reservations for cars at location
	if (mysqli_num_rows($cars_reservations_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($cars_reservations_result)) {
			echo "VIN: " . $row["VIN"]. "<br><br>";
		}
	} else {
		echo "No reservations for cars at selected location.<br><br>";
	}
	*/

	echo "Information for cars with reservations at location:<br><br>";

	// Print out all the reservations for cars at location
	if (mysqli_num_rows($available_cars_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($available_cars_result)) {
			echo "<strong>Car Information:</strong><br>";
			echo "VIN: " . $row["VIN"]. "<br>Make: " . $row["Make"]. "<br>Model: " . $row["Model"]. "<br>Year: " . $row["Year"].  "<br>LocationID: " . $row["LocationID"].  "<br>Colour: " . $row["Colour"].  "<br>Picture Link: " . $row["PictureLink"].  "<br>Rental Fee: $" . $row["RentalFee"] . "<br><br>";

			echo "<strong>Reservation Information:</strong><br>";
			echo "ReservationID: " . $row["ReservationID"]. "<br>MemberID: " . $row["MemberID"]. "<br>VIN: " . $row["VIN"]. "<br>StartDate: " . $row["StartDate"].  "<br>EndDate: " . $row["EndDate"].  "<br>AccessCode: " . $row["AccessCode"] . "<br><br>";
		}
	} else {
		echo "SHOULD NEVER REACH HERE IF SECOND QUERY HAD RESULTS<br>No information for cars with reservations at location.<br><br>";
	}

	mysqli_close($cxn);
    ?>

</body>
</html>
