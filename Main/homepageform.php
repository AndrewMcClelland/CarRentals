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
    <h4> Hi <?php echo $_SESSION["firstName"] ?></h4>
    <!-- associate buton with it -->
    <form name="logout" method="POST" action="logout.php">
    <input value="btnLogout" type="hidden" name="Logout" >
    <input type="submit"  value="Logout">
    </form>

<div class="container-fluid">
<h1>KTCS Homepage</h1>
<p>Please complete the following form to view available cars</p>
</div>

<form action="homepagehandle.php" method="post">

	<!-- To/From Date Form -->
	From:
    <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>" />
    <br/><br/>
    To:
    <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />

	<br/><br/>

	<!-- Location ID Form -->
	<!-- <div class="form-group">
	<label for="LocationID">Location ID:</label>
	<input type="text" name="LocationID" class="form-control" placeholder="Must be numeric entry" id="LocationID">
	</div>

	<!-- Dropdown table for KTCS Locations -->
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

		//echo "<select service = 'service'>";
		//echo "<select name=\"location_select\">";
		//echo '<option value="">'.'Please Select Location'.'</option>';

		$sql_location_dropdown = "	SELECT LocationID, AddressLine, PostalCode, Province, City, Country, Spaces
														FROM Parking_Location";

		$location_dropdown_result = mysqli_query($cxn, $sql_location_dropdown);

		while($row = mysqli_fetch_array($location_dropdown_result)) {
			$row_ID = $row["LocationID"];
			echo '<option value =' . $row_ID . '>' . $row["AddressLine"]. ", " . $row["PostalCode"]. ", " . $row["City"]. ", " . $row["Province"]. ", " . $row["Country"] . '</option>';
		 }

		//echo '</select>';
		//$selected_option = $_POST['location_select'];
		//echo $selected_option;

		mysqli_close($cxn);
	?>
	</SELECT>

	<button type="submit" class="btn btn-default">Submit</button>
</form>

<br/><br/>

<!-- View all locations button -->
<form action="homepageQueryLocations.php" method="post">
<button type="submit" class="btn btn-default">View All KTCS Locations</button>
</form>

</body>
</html>
