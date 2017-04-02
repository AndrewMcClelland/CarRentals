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

    <form name="homepage" method="POST" action="goToAdminHomepage.php">
    <input value="btnHomepage" type="hidden" name="Back" >
    <input type="submit"  value="Back">
    </form>

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

	$user_rental_date = isset($_POST['rentalDate']) ? $_POST['rentalDate'] : false;

	// All reservations on the date
	$sql_reservations = "	SELECT ReservationID, MemberID, VIN, StartDate, EndDate, AccessCode
									FROM Reservations
									WHERE date '$user_rental_date' > StartDate AND date '$user_rental_date' < EndDate";

	$reservations_result = mysqli_query($cxn, $sql_reservations);

	if (mysqli_num_rows($reservations_result) > 0) {
		while($row = mysqli_fetch_array($reservations_result)) {
			echo "Reservation ID: " . $row['ReservationID'] . "<br>Member ID: " . $row["MemberID"]. "<br>VIN: " . $row["VIN"]. "<br>Start Date: " . $row["StartDate"]. "<br>End Date: " . $row["EndDate"] . "<br>Access Code: " . $row["AccessCode"] . "<br><br>";
		 }
	} else {
		echo "No cars being rented on: " . $user_rental_date . "<br><br>";
	}

	?>
