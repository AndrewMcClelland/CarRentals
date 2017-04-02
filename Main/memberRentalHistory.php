<!DOCTYPE html>
<html lang="en">
<head>
<title>Member Rental History</title>
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

    <form name="homepage" method="POST" action="goToUserHomepage.php">
    <input value="btnHomepage" type="hidden" name="Back" >
    <input type="submit"  value="Back">
    </form>

    <div class="container-fluid">
    <h1> <?php echo $_SESSION["firstName"]; ?>'s Rental History</h1>
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


      $memberID = $_SESSION["memberID"];

      // Query the Car_Rental_History table to get VIN of all rentals by user
      $sql_get_cars = "select VIN, PickupOdometer, PickupDate, PickupStatus, DropoffDate, DropoffStatus, DropoffOdometer, make, model, year, colour, rentalfee
                   from Car_Rental_History natural join Car
                   where Car_Rental_History.MemberID='$memberID'";

      /*$sql_get_cars = "SELECT vin, make, model, year, locationid, colour, picturelink, rentalfee
                 								FROM car
                 								WHERE vin in ($sqlQuery)";*/



      $resultVal = mysqli_query($cxn, $sql_get_cars);
      if (mysqli_num_rows($resultVal) > 0)
      {
        while($row = mysqli_fetch_assoc($resultVal))
        {?>
          <h4> <b>Rental: </b> <?php echo $row["year"] . " " . $row["make"] . " " . $row["model"]; ?></h4>
          <h4> <b> Car Colour: </b> <?php echo $row["colour"]; ?></h4>
          <h4> <b> Daily Rental Fee: </b> $<?php echo $row["rentalfee"]; ?></h4>
          <h4> <b> Pickup Odometer: </b> <?php echo $row["PickupOdometer"]; ?> km</h4>
          <h4> <b> Pickup Date: </b> <?php echo $row["PickupDate"]; ?></h4>
          <h4> <b> Pickup Status: </b> <?php echo $row["PickupStatus"]; ?></h4>
          <h4> <b> Dropoff Odometer: </b> <?php echo $row["DropoffOdometer"]; ?> km</h4>
          <h4> <b> Dropoff Date: </b> <?php echo $row["DropoffDate"]; ?></h4>
          <h4> <b> Dropoff Status: </b> <?php echo $row["DropoffStatus"]; ?></h4>
          <br/><hr><br/>
        <?php }
      }
      else
      { ?>
        <h4>No rentals have been completed for the user</h4>
      <?php }
      ?>
        </body>
</html>
