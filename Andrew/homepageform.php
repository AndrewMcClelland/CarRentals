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
<h1>KTCS Homepage</h1>
<p>Please complete the following form to view available cars</p>
</div>

<form action="homepagehandle.php" method="post">
	
	<!-- To/From Date Form -->
	From:
    <input type="date" name="dateFrom" value="<?php echo date('Y-m-d'); ?>" />
    <br/><br/>
    To:
    <input type="date" name="dateTo" value="<?php echo date('Y-m-d'); ?>" />
	
	<br/><br/>
	
	<!-- Location ID Form -->
	<div class="form-group">
	<label for="LocationID">Location ID:</label>
	<input type="text" name="LocationID" class="form-control" placeholder="Must be numeric entry" id="LocationID">
	</div>

<button type="submit" class="btn btn-default">Submit</button>
</form>

<br/><br/>

<!-- View all locations button -->
<form action="homepageQueryLocations.php" method="post">
<button type="submit" class="btn btn-default">View All KTCS Locations</button>
</form>

</body>
</html>