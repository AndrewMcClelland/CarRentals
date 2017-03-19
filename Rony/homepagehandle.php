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
    
    
    $memberID = "20";
    $VIN = "20140294";
    $pickupOdo = $_POST["curOdoReading"];
    $pickupStatus = $_POST["carStatus"];
    date_default_timezone_set('US/Eastern');
    $currentDate = date('Y-m-d H:i:s');

    mysqli_query($cxn, "insert into Car_Rental_History values
                 ('$VIN', '$memberID', '$pickupOdo', 'NULL', '$pickupStatus', 'NULL', '$currentDate', 'NULL')
                 ;");
    ?>
    <!-- Need to ensure object is created before showing this -->
    <h4> Keys are now dispensing </h4>
    <h4>Please pickup them up below </h4>


</body>
</html>
