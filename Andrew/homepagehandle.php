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
<h1>Thank you for submitting the form!</h1>
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
    
	// HOW DOES THIS WORK?
    $LocationIDInput = $_POST["LocationID"];
	
    $sql = "SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee FROM car WHERE car.locationid = $LocationIDInput";
	$result = mysqli_query($cxn, $sql);
	
	if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo "VIN: " . $row["vin"]. "<br>Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"].  "<br>LocationID: " . $row["locationid"].  "<br>Colour: " . $row["colour"].  "<br>Picture Link: " . $row["picturelink"].  "<br>Rental Fee: $" . $row["rentalfee"].   "<br><br>";
    }
} else {
    echo "0 results";
}
	
	mysqli_close($cxn);
    ?>

</body>
</html>
