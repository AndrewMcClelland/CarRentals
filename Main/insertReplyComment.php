<!DOCTYPE html>
<html lang="en">
<head>
<title>Reply Comment</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
</div>

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


    $replyComment = $_POST["replyCommentVal"];
    $row = $_SESSION["curRow"];
    date_default_timezone_set('America/New_York');
    $curDate = date('Y-m-d');
    $curMember = $row["MemberID"];
    // Now we insert this into the DB

    $sqlQuery = "UPDATE `Rental_Comment` SET `ReplyComment`='$replyComment',`ReplyDate`='$curDate' WHERE `MemberID`=$curMember";

    $resultVal = mysqli_query($cxn, $sqlQuery);
    if ($resultVal == True)
    { ?>
      <h4> You have successfully replied to the user! Thank you!</h4>
    <?php }
    else
    {?>
        <h4>Sorry the given user selected has not left any comments on the rental.</h4>
    <?php }
    ?>



</body>
</html>
