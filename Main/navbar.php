<link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css">
<?php include('session.php');?>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="homepageform.php"><?php echo $_SESSION["firstName"] ?>'s Account</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
      <ul class="nav navbar-nav">
        <li><a href="homepageform.php">Home<span class="sr-only">(current)</span></a></li>
        <li><a href="homepageQueryLocations.php">Locations</a></li>
        <li><a href="pdform.php">Pickup/Dropoff Form</a></li>
        <li><a href="memberRentalHistory.php">Rental History</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        	<li><a href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>