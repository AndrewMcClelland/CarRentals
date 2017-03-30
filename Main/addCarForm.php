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
<h1>Add Car to Fleet</h1>
<p>Please complete the following form to add a new car</p>
</div>

<form action="addCarHandle.php" method="post">
	
	<!-- Input forms for Car info -->
	<div class="form-group">
		
		<label for="VIN">VIN:</label>
		<input type="text" name="VIN" class="form-control" placeholder="Must be numeric entry" id="VIN">
		
		<br/>
		
		<label for="Make">Make:</label>
		<input type="text" name="Make" class="form-control" placeholder="Must be alphanumeric entry" id="Make">
		
		<br/>
		
		<label for="Model">Model:</label>
		<input type="text" name="Model" class="form-control" placeholder="Must be alphanumeric entry" id="Model">
		
		<br/>
		
		<label for="Year">Year:</label>
		<input type="text" name="Year" class="form-control" placeholder="Must be alphanumeric entry" id="Year">
		
		<br/>
		
		<label for="Location">Pickup/Dropoff Location:</label>
		<!-- Dropdown table for KTCS Locations -->
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
		
		<!-- Checkbox to add new location -->
		<!--
		<form action="checkbox-form.php" method="post">
			Add new location?
			<input type="checkbox" name="formNewLocation" value="Yes" />
			<input type="submit" name="formNewLocationSubmit" value="Submit" />
		</form>
		-->
		
		<br/>
		<br/>
		
		<label for="Colour">Colour:</label>
		<input type="text" name="Colour" class="form-control" placeholder="Must be alphanumeric entry" id="Colour">
		
		<br/>
		
		<label for="Picture">Picture URL:</label>
		<input type="text" name="Picture" class="form-control" placeholder="Must be alphanumeric entry" id="Picture">
		
		<br/>
		
		<label for="RentalFee">Daily Rental Fee:</label>
		<input type="text" name="RentalFee" class="form-control" placeholder="Must be alphanumeric entry" id="RentalFee">
	
	</div>
	
	<br/><br/>
	
	<button type="submit" class="btn btn-default">Submit</button>
	
</form>

<br/><br/>

</body>
</html>