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
    
<div class="container-fluid">
<h1>Reserve Car</h1>
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

	$reservation_ID = uniqid();
	$Member_ID = $_SESSION["memberID"];
	$row = $_SESSION["fucker"];
	$reserved_car_VIN = $_POST["search"];
        echo "CAR RESERVED IS " . $reserved_car_VIN;
	$user_start_date = $_SESSION["start_date"];
	$user_end_date = $_SESSION["end_date"];
	$access_code = uniqid();
	$test1 = strtotime($user_start_date);
	$test2 = strtotime($user_end_date);
	$datt = $test2 - $test1;
	$numDays = floor($datt/(60 * 60 * 24));

	$amount = $numDays * floatval($row["rentalfee"]);
	date_default_timezone_set('America/New_York');
	$curr_date = date('Y-m-d');
	$description = "You rented the " . " " . $row['year'] . " " . $row['make'] . " " . $row['model'];

	$SQL_insert_reservation = "	INSERT INTO Reservations (ReservationID, MemberID, VIN, StartDate, EndDate, AccessCode)
													VALUES ('$reservation_ID', '$Member_ID', '$reserved_car_VIN', '$user_start_date', '$user_end_date', '$access_code')";


	$SQL_insert_payment = "	INSERT INTO Payment_history (MemberID, Amount, Date, Description)
												VALUES ('$Member_ID', '$amount', '$curr_date', '$description')";

	if (mysqli_query($cxn, $SQL_insert_reservation)) {
		?>
		<h4 style="margin-left:15px;"><?php echo "Car Reserved! <br>Access code is: " . $access_code . "<br>"; ?></h4>
	<?php } else {
		echo "Error: " . $SQL_insert_reservation . "<br>" . mysqli_error($cxn);
	}

	if (mysqli_query($cxn, $SQL_insert_payment)) {
		echo "<br>";
	} else {
		echo "Error: " . $SQL_insert_payment . "<br>" . mysqli_error($cxn);
	}

	?>
