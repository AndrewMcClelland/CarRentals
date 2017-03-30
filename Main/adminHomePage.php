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
        <div class="container-fluid">
        <h3>Monthly Inovice</h3>
        <p>Please complete the following fields to obtain the monthly invoice of a given member</p>
        </div>

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

        <button type="submit" class="btn btn-default">Submit</button>
</form>

<br/><hr><br/>

<!-- Add a car -->
<h3>Add Car to Fleet  </h3>
<p>Please click the button and complete the form on the following page to add a car to the fleet.</p>
<form action="addCarForm.php" method="post">
	
	<button type="submit" class="btn btn-default">Add Car to Fleet</button>
	
</form>

<br/><hr><br/>

<!-- See car rental history -->
<h3>View Rental History for Cars</h3>
<p>Please select a car to view the car's rental history.</p>
<form action="carRentalHistoryHandle.php" method="post">
	
	<!-- Dropdown table for KTCS cars -->
	<label for="Cars">Cars:</label>
	<SELECT NAME = "car_dropdown">
    <option value="">Please select car...</option>
	
	<?php
    
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

<br/><hr><br/>

<h3>Available Cars at Location</h3>
 <p>View available cars at given location and reservations for each car (if any):</p>
<form action="availableCarsAtLocation.php" method="post">

	<!-- Dropdown table for KTCS Locations to show available cars -->
	<label for="LocationID"></label>
	<br/>
	<SELECT NAME = "location_dropdown">
    <option value="">Please select location...</option>
	
	<?php

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

<br/><hr><br/>

<!--View cars that travelled > distance since last maintenance -->
<h3>Cars Since Maintenance</h3>
<p>Enter a distance and view all cars that have travelled that distance since last maintenance.</p>
<form action="carsDistanceSinceMaintenanceHandle.php" method="post">
	
	<div class="form-group">
		<label for="DistanceSinceMaintenance">DOESN'T WORK RN<br/>Distance Since Last Maintenance:</label>
		<input type="text" name="DistanceSinceMaintenance" class="form-control" placeholder="Must be numeric entry (km)..." id="DistanceSinceMaintenance">
	</div>
	
	<button type="submit" class="btn btn-default">View Specified Cars</button>
	
</form>

</body>
</html>