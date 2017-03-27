<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Homepage</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<h1>Admin Homepage</h1>
</div>

<!-- Add a car -->
<form action="addCarForm.php" method="post">
	
	<button type="submit" class="btn btn-default">Add Car to Fleet</button>
	
</form>

<br/><br/>

<!-- See car rental history -->
<form action="carRentalHistoryHandle.php" method="post">
	
	<!-- Dropdown table for KTCS cars -->
	<label for="Cars">Cars:</label>
	<SELECT NAME = "car_dropdown">
    <option value="">Please select car...</option>
	
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

		$sql_cars_dropdown = "	SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
												FROM car";
														
		$car_dropdown_result = mysqli_query($cxn, $sql_cars_dropdown);
		
		while($row = mysqli_fetch_array($car_dropdown_result)) {
			$row_ID = $row["vin"];
			echo '<option value =' . $row_ID . '>' . $row["vin"]. ", " . $row["make"]. ", " . $row["model"]. ", " . $row["year"]. ", " . $row["locationid"] . ", " . $row["colour"] .", " . $row["picturelink"] .", " . $row["rentalfee"] .'</option>';
		 }
		
		mysqli_close($cxn);
	?>
	
	</SELECT>
	<br/><br/>
	
	<button type="submit" class="btn btn-default">View Car's Rental History</button>
	
</form>

<br/><br/>

<form action="availableCarsAtLocation.php" method="post">

	<!-- Dropdown table for KTCS Locations to show available cars -->
	<label for="LocationID">View available cars at given location and reservations for each car (if any):</label>
	<br/>
	<SELECT NAME = "location_dropdown">
    <option value="">Please select location...</option>
	
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

		$sql_location_dropdown = "	SELECT LocationID, AddressLine, PostalCode, Province, City, Country, Spaces
														FROM Parking_Location";
														
		$location_dropdown_result = mysqli_query($cxn, $sql_location_dropdown);
		
		while($row = mysqli_fetch_array($location_dropdown_result)) {
			$row_ID = $row["LocationID"];
			echo '<option value =' . $row_ID . '>' . $row["AddressLine"]. ", " . $row["PostalCode"]. ", " . $row["City"]. ", " . $row["Province"]. ", " . $row["Country"] . '</option>';
		 }

		
		mysqli_close($cxn);
	?>
	</SELECT>

	<button type="submit" class="btn btn-default">Submit</button>
</form>

<br/><br/>

<!--View cars that travelled > distance since last maintenance -->
<form action="carsDistanceSinceMaintenanceHandle.php" method="post">
	
	<div class="form-group">
		<label for="DistanceSinceMaintenance">DOESN'T WORK RN<br/>Distance Since Last Maintenance:</label>
		<input type="text" name="DistanceSinceMaintenance" class="form-control" placeholder="Must be numeric entry (km)..." id="DistanceSinceMaintenance">
	</div>
	
	<button type="submit" class="btn btn-default">View Specified Cars</button>
	
</form>

</body>
</html>