<!DOCTYPE html>
<html lang="en">
<head>
<title >KTCS Homepage</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
</head>
<body>

	<?php
	include('navbar.php');
    include('session.php');
    ?>

<div class="container-fluid" style="margin-left:50px;"">
<h1>KTCS Homepage</h1>
<p>Please complete the following form to view available cars</p>
</div>
<div class="well" style="margin-left:50px; margin-right:800px;">
<form form class="form" action="homepagehandle.php" method="post" >

	<!-- To/From Date Form -->
	From:
    <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>" />
    <br/><br/>
    To:
    <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />

	<br/><br/>

	<label for="LocationID">Location ID:</label>
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

		// Drop reservation based on dates everytime it loads
		date_default_timezone_set('America/New_York');
		$curr_date = date('Y-m-d');

		$sql_delete_reservations = "	DELETE FROM Reservations
														WHERE Reservations.EndDate < date '$curr_date'";

		mysqli_query($cxn, $sql_delete_reservations);

		$sql_location_dropdown = "	SELECT LocationID, AddressLine, PostalCode, Province, City, Country, Spaces
			FROM Parking_Location";

		$location_dropdown_result = mysqli_query($cxn, $sql_location_dropdown);

		while($row = mysqli_fetch_array($location_dropdown_result)) {
			$row_ID = $row["LocationID"];
			echo '<option value =' . $row_ID . '>' . $row["AddressLine"]. ", " . $row["PostalCode"]. ", " . $row["City"]. ", " . $row["Province"]. ", " . $row["Country"] . '</option>';
		 }
		 
		 echo '<option value = ALL>' . "All..." . '</option>';

		mysqli_close($cxn);
	?>
	</SELECT>

	<button type="submit" class="btn btn-default">Submit</button>
</form>
</div>

<br/><br/>

</body>
</html>
