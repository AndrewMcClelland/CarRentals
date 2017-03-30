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


    $memberID = "38";
    $VIN = "20140294";
    $curOdo = $_POST["curOdoReading"];
    $curStatus = $_POST["carStatus"];
    date_default_timezone_set('US/Eastern');
    $currentDate = date('Y-m-d H:i:s');

    // Before executing the car insertion check to see if the object exists
    $sqlQuery = "select *
                 from Car_Rental_History
                 where Car_Rental_History.VIN=$VIN and Car_Rental_History.MemberID=$memberID";

    $resultVal = mysqli_query($cxn, $sqlQuery);
    if (mysqli_num_rows($resultVal) > 0)
    {
  		while($row = mysqli_fetch_assoc($resultVal))
      {
        if($row["DropoffOdometer"] == 0 || $row["DropoffOdometer"] == NULL)
        {
          $sqlQuery = "UPDATE Car_Rental_History
                      SET `DropoffOdometer`=$curOdo, `DropoffStatus`='$curStatus', `DropoffDate`='$currentDate'
                      WHERE MemberID=$memberID and VIN=$VIN";
          mysqli_query($cxn, $sqlQuery);

          // Now we need to create the rental comment object and tie it
          $ratingVal = $_POST["ratingVar"];
          $commentVal = $_POST["commentVar"];

          mysqli_query($cxn, "insert into Rental_Comment values
                     ('$VIN', '$memberID', '$ratingVal', '$commentVal', '$currentDate', 'NULL', 'NULL')
                     ;");
          ?>
          <h4> You have successfully filled out the dropoff form!</h4>
          <h4> Please place your keys in the compartment below</h4>
        <?php }
        else
        {?>
          <h4>Can't update dropoff values again - this can only be done once</h4>
          <h4>Please consult admin if you made an error in the form"</h4>
        <?php }
  		}
    }
    else
    {
      // Create the pickup object
      mysqli_query($cxn, "insert into Car_Rental_History values
                 ('$VIN', '$memberID', '$curOdo', 'NULL', '$curStatus', 'NULL', '$currentDate', 'NULL')
                 ;");
    ?>
    <h4> Keys are now dispensing </h4>
    <h4>Please pickup them up below </h4>
    <?php }
    ?>



</body>
</html>
