<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Homepage</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

  <?php
    include('session.php');
    include('navbaradmin.php');
    ?>
    


<div class="container-fluid">
<h1>Admin Homepage</h1>
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

	// Drop reservation based on dates everytime it loads
	date_default_timezone_set('America/New_York');
	$curr_date = date('Y-m-d');
	
	$sql_delete_reservations = "	DELETE FROM Reservations
													WHERE Reservations.EndDate < date '$curr_date'";
	
	mysqli_query($cxn, $sql_delete_reservations);
		
      //$memberID = "38";
      //$VIN = "20140294";

      // Will only be able to access this form if logged in as admin

      // Trick here is we want to be able to see the list of members
      // Query the whole member list and return memberID's
      $sqlQuery = "select *
                   from KTCS_Member";

      $resultVal = mysqli_query($cxn, $sqlQuery);
      $memberIDArry = array();
      $nameFirstArray = array();
      while($row = mysqli_fetch_assoc($resultVal))
      {
        array_push($memberIDArry, $row["MemberID"]);
        array_push($nameFirstArray, $row["NameFirst"]);
      }
      // print_r($memberIDArry);
      // print_r($nameFirstArray);
      ?>
        <div class="container-fluid" style="margin-left:20px;">
        <h3>Monthly Invoice</h3>
        <p>Please complete the following fields to obtain the monthly invoice of a given member</p>
        </div>
        <div class="well" style="margin-left:50px; margin-right:800px;">
        <form action="monthlyInvoiceHandle.php" method="post">
        <div class="form-group">
        <label for="memberIDVal">Member ID:</label>
        <select class="form-control" id="dopdownMember" name="memID" >
          <?php
          $curIndex = -1;
          foreach($nameFirstArray as $curName) {
            $curIndex = $curIndex + 1;
            echo $curIndex;?>
          <option value="<?php echo $memberIDArry[$curIndex]; ?>" ><?php echo $curName?></option>
          <?php } ?>
        </select>
        <!--<input type="text" name="memID" class="form-control" placeholder="Must be numeric entry" id="memberIDVal">-->
        </div>
        <div class="form-group">
        <label for="monthStat"> Start Invoice Month: </label>
        <input type="date" name="monthStat" value="<?php echo date('Y-m-d'); ?>" />
        </div>

        <div class="form-group">
        <label for="endMonthStat"> End Invoice Month: </label>
        <input type="date" name="endMonthStat" value="<?php echo date('Y-m-d'); ?>" />
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

<br/><hr>





<!-- Add a car -->
<div class="container-fluid" style="margin-left:20px;">
	<h3 >Add Car to Fleet  </h3>
	<p >Please click the button and complete the form on the following page to add a car to the fleet.</p>
</div>
<form action="addCarForm.php" method="post" style="margin-left:50px;">
	<button type="submit" class="btn btn-primary">Add Car to Fleet</button>
</form>

<br/><hr>






<!-- See car rental history -->
<div class="container-fluid" style="margin-left:20px;">
	<h3>View Rental History for Cars</h3>
	<p>Please select a car to view the car's rental history.</p>
</div>
<div class="well" style="margin-left:50px; margin-right:800px;">
<form action="carRentalHistoryHandle.php" method="post">
	<!-- Dropdown table for KTCS cars -->
	<label for="Cars">Cars:</label>
	<SELECT class="form-control" id="dopdownMember" NAME = "car_dropdown">
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
<br/>

	<button type="submit" class="btn btn-primary">View Car's Rental History</button>

</form>
</div>
<br/><hr>





<div class="container-fluid" style="margin-left:20px;">
<h3>Available Cars at Location</h3>
 <p>View available cars at given location and reservations for each car (if any):</p>
 </div>
<div class="well" style="margin-left:50px; margin-right:800px;">
<form action="availableCarsAtLocation.php" method="post">

	<!-- Dropdown table for KTCS Locations to show available cars -->
	<label for="LocationID"></label>

	<label for="Location:">Location:</label>
	<SELECT class="form-control" id="dopdownMember" NAME = "location_dropdown">
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
	<br/>
	<button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
<br/><hr>






<!--View cars that travelled > distance since last maintenance -->
<div class="container-fluid" style="margin-left:20px;">
<h3>Cars Since Maintenance</h3>
<p>Enter a distance and view all cars that have travelled that distance since last maintenance.</p>
</div>
<div class="well" style="margin-left:50px; margin-right:800px;">
<form action="carsDistanceSinceMaintenanceHandle.php" method="post">

	<div class="form-group">
		<label for="DistanceSinceMaintenance">Distance Since Last Maintenance:</label>
		<input type="text" name="DistanceSinceMaintenance" class="form-control" placeholder="Must be numeric entry (km)..." id="DistanceSinceMaintenance">
	</div>

	<button type="submit" class="btn btn-primary">View Specified Cars</button>

</form>
</div>

<br/><hr>

<!-- See cars with most/min rentals -->
<div class="container-fluid" style="margin-left:20px;">
<h3>View Cars with Most/Minimum Rentals</h3>
<p>Below are the cars with the highest/lowest number of rentals</p>
</div>
<div class="well" style="margin-left:50px; margin-right:800px;">
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

		/*
		$sql_rental_count = "	SELECT VIN, count(VIN) as Count_VIN
											FROM Car_Rental_History
											GROUP BY VIN";
		*/

		// Count number of occurrences of each VIN, order in ascending, limit to 1 so top one is chosen (most occurrences)
		$sql_max_count = "	SELECT VIN, COUNT(VIN) as Max_VIN
											FROM Car_Rental_History
											GROUP BY VIN
											ORDER BY Max_VIN DESC
											LIMIT 1";

		// Count number of occurrences of each VIN, order in descending, limit to 1 so top one is chosen (least occurrences)
		$sql_min_count = "		SELECT VIN, COUNT(VIN) as Min_VIN
											FROM Car_Rental_History
											GROUP BY VIN
											ORDER BY Min_VIN ASC
											LIMIT 1";

		$max_count_result = mysqli_query($cxn, $sql_max_count);
		$min_count_result = mysqli_query($cxn, $sql_min_count);

		?>

		<p><br/>Car with Most Rentals<br/></p>
		<?php

		while($row = mysqli_fetch_array($max_count_result)) {
			//echo "VIN = " . $row["VIN"] . " Count = " . $row["Count_VIN"] ."<br>";
			$VIN_max = $row["VIN"];
			echo " Occurrences = " . $row["Max_VIN"] ."<br>";
		 }

		 $sql_max_car = "SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
									FROM car
									WHERE car.vin = '$VIN_max'";

		 $max_car_result = mysqli_query($cxn, $sql_max_car);

		 while($row = mysqli_fetch_array($max_car_result)) {
			echo "VIN: " . $row['vin'] . "<br>Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"]. "<br>Location ID: " . $row["locationid"] . "<br>Colour: " . $row["colour"] ."<br>Picture Link: " . $row["picturelink"] ."<br>Rental Fee: $" . $row["rentalfee"] .'</option>';
		 }

		 ?>

		<br><br>

		<p>Car with Least Rentals<br/></p>
		<?php

		 while($row = mysqli_fetch_array($min_count_result)) {
			//echo "VIN = " . $row["VIN"] . " Count = " . $row["Count_VIN"] ."<br>";
			$VIN_min = $row["VIN"];
			echo " Occurrences = " . $row["Min_VIN"] ."<br>";
		 }

		$sql_min_car = "	SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
									FROM car
									WHERE car.vin = '$VIN_min'";

		$min_car_result = mysqli_query($cxn, $sql_min_car);

		 while($row = mysqli_fetch_array($min_car_result)) {
			echo "VIN: " . $row['vin'] . "<br>Make: " . $row["make"]. "<br>Model: " . $row["model"]. "<br>Year: " . $row["year"]. "<br>Location ID: " . $row["locationid"] . "<br>Colour: " . $row["colour"] ."<br>Picture Link: " . $row["picturelink"] ."<br>Rental Fee: $" . $row["rentalfee"] .'</option>';
		 }

		mysqli_close($cxn);
	?>
</div>
<br/><hr>






<!-- Damaged -->
<div class="container-fluid" style="margin-left:20px;">
<h3>View Damaged/Need Repair Cars</h3>
<p>Please complete the following form to view all rentals on the selected date:</p>
</div>

<form action="damagedRepairCarsHandle.php" method="post" style="margin-left:50px;">

	<button type="submit" class="btn btn-primary">View Damaged/Need Repair Cars</button>

</form>

<br/><hr>






<!-- See car rental history -->


<div class="container-fluid" style="margin-left:20px;">
<h3>View Rental's On Given Day</h3>
<p>Please complete the following form to view all rentals on the selected date:</p>
</div>
<div class="well" style="margin-left:50px; margin-right:800px;">
<form action="rentalsOnDayHandle.php" method="post">


		<div class="form-group">
        <label for="rentalDate"> Date: </label>
        <input type="date" name="rentalDate" value="<?php echo date('Y-m-d'); ?>" />
		</div>

	<br/>

	<button type="submit" class="btn btn-primary">View Car Rentals</button>

</form>
</div>
<br/><hr>

    <?php
    //echo $_SESSION['login_user'];
    //echo $_SESSION["memberID"];

      $host = "localhost";
      $user = "root";
      $password = "";
      $database = "KTCS";
      $cxn = mysqli_connect($host,$user,$password, $database);

      if (mysqli_connect_errno()) {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          die();
      }


      //$memberID = "38";
      //$VIN = "20140294";

      // Will only be able to access this form if logged in as admin

      // Trick here is we want to be able to see the list of members
      // Query the whole member list and return memberID's
      $sqlQuery = "select *
                   from KTCS_Member";

      $resultVal = mysqli_query($cxn, $sqlQuery);
      $memberIDArry = array();
      $nameFirstArray = array();
      while($row = mysqli_fetch_assoc($resultVal))
      {
        array_push($memberIDArry, $row["MemberID"]);
        array_push($nameFirstArray, $row["NameFirst"]);
      }
      // print_r($memberIDArry);
      // print_r($nameFirstArray);
      ?>
        <div class="container-fluid" style="margin-left:20px;">
        <h3>View Rental Comments</h3>
        <p>Please select the member to see if they have left any comments on a rental</p>
        </div>
        <div class="well" style="margin-left:50px; margin-right:800px;">
        <form action="rentalCommentHandle.php" method="post">
        <div class="form-group">
        <label for="memberIDVal">Member:</label>
        <select class="form-control" id="dopdownMember" name="memID" >
          <?php
          $curIndex = -1;
          foreach($nameFirstArray as $curName) {
            $curIndex = $curIndex + 1;
            echo $curIndex;?>
          <option value="<?php echo $memberIDArry[$curIndex];?>" ><?php echo $curName?></option>
          <?php } ?>
        </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
	</div>
	<br>

</body>
</html>
