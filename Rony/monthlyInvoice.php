<!DOCTYPE html>
<html lang="en">
<head>
<title>Monthly Invoice</title>
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
        <h1>Monthly Inovice</h1>
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
</body>
</html>
