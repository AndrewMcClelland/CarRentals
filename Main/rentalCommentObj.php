<!DOCTYPE html>
<html lang="en">
<head>
<title>Reply to Comment</title>
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
<h1>Reply to Comment</h1>
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

	$memID = $_POST["replyCommentVal"];
  $row = $_SESSION["curRow"];
  $origComment = $row["Comment"];
  ?>

  <h5><b>Orig Comment: </b> <?php echo $origComment ?></h5>

  <form action="insertReplyComment.php" method="post">

  <div class="form-group">
  <label for="replyComment"> Reply: </label>
  <input type="text" class="form-control" placeholder="Reply to users comment" name="replyCommentVal" id="replyComment" >
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>
</body>