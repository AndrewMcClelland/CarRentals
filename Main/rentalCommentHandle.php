<!DOCTYPE html>
<html lang="en">
<head>
<title>Rental Comment</title>
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


    $memberID = $_POST["memID"];
    // Need to query all results for the given date
    $sqlQuery = "select *
                 from Rental_Comment
                 where Rental_Comment.MemberID =$memberID";

    $resultVal = mysqli_query($cxn, $sqlQuery);
    if (mysqli_num_rows($resultVal) > 0)
    {
  		while($row = mysqli_fetch_assoc($resultVal))
      {
          ?>
          <h5><b>Member: </b> <?php echo $memberID ?></h5>
          <h5><b>VIN: </b>$<?php echo $row["VIN"] ?></h5>
          <h5><b>Rating: </b><?php echo $row["Rating"] ?></h5>
          <h5><b>Comment: </b><?php echo $row["Comment"] ?></h5>
          <h5><b>Date of Comment: </b><?php echo $row["Date"] ?></h5>
          <?php
          if ($row["ReplyComment"] != "")
          {
            ?>
            <h5><b>Replied Comment from Admin: </b><?php echo $row["ReplyComment"] ?></h5>
            <h5><b>Replied Date: </b><?php echo $row["ReplyDate"] ?></h5>

          <?php }
          else
          { ?>
            <form name="reply_comment" method="POST" action="rentalCommentObj.php">
            <input value="<?php echo $memberID; $_SESSION["curRow"] = $row;?>" type="hidden" name="replyCommentVal">
            <input type="submit"  value="Reply To Comment">
            </form>
            <br></br>
          <?php }
          ?>
        <?php
      }
    }
    else
    {?>
        <h4>Sorry the given user selected has not left any comments on the rental.</h4>
    <?php }
    ?>



</body>
</html>
