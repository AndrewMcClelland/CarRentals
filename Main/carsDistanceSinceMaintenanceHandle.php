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

	// Query all unique VIN in Car_Maintenance_History and return its highest Odometer value (its latest one)
	$sql_maintenance_VIN_ODO = "	SELECT VIN, max(Odometer) as LatestMaintenanceODO
													FROM Car_Maintenance_History
													GROUP BY VIN";

	// Query all unique VIN in Car_Rental_History and return its highest dropoff Odometer value (its latest one)
	$sql_rental_VIN_ODO = "	SELECT VIN, max(DropoffOdometer) as LatestDropoffODO
											FROM Car_Rental_History
											GROUP BY VIN";

	$maintenance_result = mysqli_query($cxn, $sql_maintenance);
	$rental_result = mysqli_query($cxn, $sql_rental);

	if (mysqli_num_rows($maintenance_result) > 0) {
		// Loop through each car in the rental table
		while($row = mysqli_fetch_assoc($maintenance_result)) {

			echo "VIN: " . $row["VIN"]. "<br>Most Recent Maintenance Odometer: " . $row['LatestMaintenanceODO'] . "<br><br>";
		}
	} else {
		echo "No maintenance values.<br><br>";
	}

	if (mysqli_num_rows($rental_result) > 0) {
		// Loop through each car in the rental table
		while($row = mysqli_fetch_assoc($rental_result)) {

			echo "VIN: " . $row["VIN"]. "<br>Most Recent Dropoff Odometer: " . $row['LatestDropoffODO'] . "<br><br>";
		}
	} else {
		echo "No dropoff values.<br><br>";
	}

	mysqli_close($cxn);
    ?>

</body>
</html>
