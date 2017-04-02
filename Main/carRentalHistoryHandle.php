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

    $user_vin = isset($_POST['car_dropdown']) ? $_POST['car_dropdown'] : false;

	// Query all rental history for selected car
	$sql_rental_history = "	SELECT VIN, MemberID, PickupOdometer, DropoffOdometer, Status, Date
										FROM Car_Rental_History
										WHERE Car_Rental_History.VIN = $user_vin";

	$cars_rental_history_result = mysqli_query($cxn, $sql_rental_history);

	// Print out all the results from the car reservations query
	if (mysqli_num_rows($cars_rental_history_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($cars_rental_history_result)) {
			echo "VIN: " . $row["VIN"]. "<br>MemberID: " . $row["MemberID"]. "<br>PickupOdometer: " . $row["PickupOdometer"]. "<br>DropoffOdometer: " . $row["DropoffOdometer"].  "<br>Date: " . $row["Date"].  "<br><br>";
		}
	} else {
		echo "0 car car reservation results<br><br>";
	}

	mysqli_close($cxn);
    ?>

</body>
</html>
