<!DOCTYPE html>
<html lang="en">
<head>
<title>Pickup/Drop-Off Car</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

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


      $memberID = "38";
      $VIN = "20140294";

      // Check to see if the object exists
      $sqlQuery = "select *
                   from Car_Rental_History
                   where Car_Rental_History.VIN=$VIN and Car_Rental_History.MemberID=$memberID";

      $resultVal = mysqli_query($cxn, $sqlQuery);
      if (mysqli_num_rows($resultVal) > 0)
      {
    		while($row = mysqli_fetch_assoc($resultVal))
        {
          // If object exists, assumed pickup values set - check to see if dropoff is set
          if($row["DropoffOdometer"] == 0 || $row["DropoffOdometer"] == NULL)
          { ?>
            <div class="container-fluid">
            <h1>Dropoff Tesla Model S</h1>
            <p>Please complete the following form before dropping off your keys</p>
            </div>

            <form action="pdhandle.php" method="post">
            <div class="form-group">
            <label for="dropoffOdoVal">Current Odometer Reading:</label>
            <input type="text" name="curOdoReading" class="form-control" placeholder="Must be numeric entry" id="dropoffOdoVal">
            </div>

            <div class="form-group">
            <label for="carStat"> Car Status </label>
            <input type="text" class="form-control" placeholder="Enter car status" name="carStatus" id="carStat" >
            <span class="help-block">Status can either be Normal, Damaged or Repair</span>
            </div>

            <div class="form-group">
            <label for="ratingVal">Rating:</label>
            <input type="text" name="ratingVar" class="form-control" placeholder="Must be numeric entry between 1-5" id="ratingVal">
            </div>

            <div class="form-group">
            <label for="commentVal">Comment:</label>
            <input type="text" name="commentVar" class="form-control" placeholder="Please enter any comments/concerns you may have about the rental" id="commentVal">
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
            </form>
          <?php
          }
          else
          {?>
            <h4>You have already completed this form and your rental</h4>
            <h4>Hope you enjoyed the ride service!</h4>
          <?php }
        }
      }
      else
      { ?>
        <div class="container-fluid">
        <h1>Pickup Tesla Model S</h1>
        <p>Please complete the following form to obtain your keys</p>
        </div>

        <form action="pdhandle.php" method="post">
        <div class="form-group">
        <label for="pickupOdoVal">Current Odometer Reading:</label>
        <input type="text" name="curOdoReading" class="form-control" placeholder="Must be numeric entry" id="pickupOdoVal">
        </div>

        <div class="form-group">
        <label for="carStat"> Car Status </label>
        <input type="text" class="form-control" placeholder="Enter car status" name="carStatus" id="carStat" >
        <span class="help-block">Status can either be Normal, Damaged or Repair</span>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        </form>
      <?php }
      ?>
</body>
</html>
