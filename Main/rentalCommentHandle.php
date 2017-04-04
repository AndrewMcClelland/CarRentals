<!DOCTYPE html>
<html lang="en">
<head>
<title>Rental Comment</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>


<?php
  include('session.php');
  include('navbaradmin.php');
  ?>
<div class="container-fluid" style="margin-left:20px;">
<h1>User Comments</h1>
</div>
<div class="well" style="margin-left:50px; margin-right:800px;">

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
            <button type="submit" class="btn btn-primary">Reply to Comment</button>
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


</div>
</body>
</html>
