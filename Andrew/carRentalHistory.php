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
<p>Please complete the following form to view available cars</p>
</div>

<form action="carRentalHistoryHandle.php" method="post">
		
	<!-- Dropdown table for KTCS Locations -->
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

	<button type="submit" class="btn btn-default">Submit</button>
</form>

</body>
</html>