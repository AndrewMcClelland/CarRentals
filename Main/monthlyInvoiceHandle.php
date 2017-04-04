<!DOCTYPE html>
<html lang="en">
<head>
<title>Monthly Invoice</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
</div>

<?php
  include('session.php');
  include('navbaradmin.php');
  ?>


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


    $memberID = $_POST["memID"];
    $dateToStart = $_POST["monthStat"];
    $dateToEnd = $_POST["endMonthStat"];
    // Need to query all results for the given date
    $sqlQuery = "select *
                 from Payment_History
                 where Payment_History.Date>='$dateToStart' and Payment_History.Date <= '$dateToEnd'
                 and MemberID=$memberID";

    $resultVal = mysqli_query($cxn, $sqlQuery);
    if (mysqli_num_rows($resultVal) > 0)
    {
      $startMonth = date("F", strtotime($dateToStart));
      ?>
      <div class="container-fluid" style="margin-left:20px;">
      <h3> Invoice: </h3>
      </div>
      <?php
  		while($row = mysqli_fetch_assoc($resultVal))
      {
        $dateFormattedPaidObject = date("F d", strtotime($row["Date"]));
          ?>
          <div class="well" style="margin-left:50px; margin-right:800px;">
          <h5><b>MemberID: </b> <?php echo $memberID ?></h5>
          <h5><b>Amount Paid: </b>$<?php echo $row["Amount"] ?></h5>
          <h5><b>Date Paid: </b><?php echo $dateFormattedPaidObject ?></h5>
          <h5><b>Description: </b><?php echo $row["Description"] ?></h5>
          </div>
          <br></br>
        <?php
      }
    }
    else
    {?>
        <h4>Sorry there are no invoices for the given dates specified.</h4>
    <?php }
    ?>



</body>
</html>
