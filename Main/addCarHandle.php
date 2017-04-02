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

	// Getting passed user values from form
    $user_VIN = isset($_POST['VIN']) ? $_POST['VIN'] : false;
	$user_make = isset($_POST['Make']) ? $_POST['Make'] : false;
	$user_model = isset($_POST['Model']) ? $_POST['Model'] : false;
	$user_year = isset($_POST['Year']) ? $_POST['Year'] : false;
	$user_location = isset($_POST['location_dropdown']) ? $_POST['location_dropdown'] : false;
	$user_colour = isset($_POST['Colour']) ? $_POST['Colour'] : false;
	$user_picture = isset($_POST['Picture']) ? $_POST['Picture'] : false;
	$user_rentalFee = isset($_POST['RentalFee']) ? $_POST['RentalFee'] : false;

	/*
	echo $user_VIN . "<br>";
	echo $user_make . "<br>";
	echo $user_model . "<br>";
	echo $user_year . "<br>";
	echo $user_location . "<br>";
	echo $user_colour . "<br>";
	echo $user_picture . "<br>";
	echo $user_rentalFee . "<br>";
	*/


	$sql_insert_car = "	INSERT INTO Car (VIN, Make, Model, Year, LocationID, Colour, PictureLink, RentalFee)
							VALUES ('$user_VIN', '$user_make', '$user_model', '$user_year', '$user_location', '$user_colour', '$user_picture', '$user_rentalFee')";

	if (mysqli_query($cxn, $sql_insert_car)) {
		echo "New car inserted successfully!";
	} else {
		echo "Error: " . $sql_insert_car . "<br>" . mysqli_error($cxn);
	}


	mysqli_close($cxn);
 ?>

</body>
</html>
