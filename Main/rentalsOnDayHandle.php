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
<h1>Current Rentals</h1>
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

	$user_rental_date = isset($_POST['rentalDate']) ? $_POST['rentalDate'] : false;

	// All reservations on the date
	$sql_reservations = "	SELECT ReservationID, MemberID, VIN, StartDate, EndDate, AccessCode
									FROM Reservations
									WHERE date '$user_rental_date' >= StartDate AND date '$user_rental_date' <= EndDate";

	$reservations_result = mysqli_query($cxn, $sql_reservations);

	if (mysqli_num_rows($reservations_result) > 0) {
		while($row = mysqli_fetch_array($reservations_result)) {
			echo "Reservation ID: " . $row['ReservationID'] . "<br>Member ID: " . $row["MemberID"]. "<br>VIN: " . $row["VIN"]. "<br>Start Date: " . $row["StartDate"]. "<br>End Date: " . $row["EndDate"] . "<br>Access Code: " . $row["AccessCode"] . "<br><br>";
		 }
	} else {
		echo "No cars being rented on: " . $user_rental_date . "<br><br>";
	}

	?>
</div>