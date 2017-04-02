<!DOCTYPE html>
<html lang="en">
<head>
<title>Rental Comments</title>
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
        <div class="container-fluid">
        <h1>View Rental Comments</h1>
        <p>Please select the member to see if they have left any comments on a rental</p>
        </div>

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

        <button type="submit" class="btn btn-default">Submit</button>
        </form>
</body>
</html>
