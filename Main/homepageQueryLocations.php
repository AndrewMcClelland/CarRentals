<!DOCTYPE html>
<html lang="en">
<head>
<title>KTCS Locations</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php
    include('navbar.php');
    include('session.php');
    ?>
<div class="container-fluid" style="margin-left:50px;">
<h1>Available KTCS Locations:</h1>
</div>
<div class="well" style="margin-left:50px; margin-right:900px;">
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


	$sql_all_locations = "	SELECT LocationID, AddressLine, PostalCode, Province, City, Country, Spaces
									FROM Parking_Location";


	$locations_result = mysqli_query($cxn, $sql_all_locations);

	if (mysqli_num_rows($locations_result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($locations_result)) {
			echo "Location ID: " . $row["LocationID"].  "<br>Address Line: " . $row["AddressLine"]. "<br>Postal Code: " . $row["PostalCode"]. "<br>City: " . $row["City"]. "<br>Province: " . $row["Province"]. "<br>Country: " . $row["Country"]. "<br>Number of spaces: " . $row["Spaces"]. "<br><br>";
		}
	} else {
		echo "0 location results<br><br>";
	}

	mysqli_close($cxn);
    ?>
</div>
</body>
</html>
