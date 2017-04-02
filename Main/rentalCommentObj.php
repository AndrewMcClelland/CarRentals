<!DOCTYPE html>
<html lang="en">
<head>
<title>Reply to Comment</title>
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

    <form name="homepage" method="POST" action="goToAdminHomepage.php">
    <input value="btnHomepage" type="hidden" name="Back" >
    <input type="submit"  value="Back">
    </form>

<div class="container-fluid">
<h1>Reply to Comment</h1>
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

	$memID = $_POST["replyCommentVal"];
  $row = $_SESSION["curRow"];
  $origComment = $row["Comment"];
  ?>

  <h5><b>Orig Comment: </b> <?php echo $origComment ?></h5>
  </div>

  <form action="insertReplyComment.php" method="post">

  <div class="form-group">
  <label for="replyComment"> Reply: </label>
  <input type="text" class="form-control" placeholder="Reply to users comment" name="replyCommentVal" id="replyComment" >
  </div>

  <button type="submit" class="btn btn-default">Submit</button>
  </form>
