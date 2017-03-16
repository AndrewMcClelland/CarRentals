<!DOCTYPE html>
<html lang="en">
<head>
<title>Pickup/Drop-Off Car</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<h1>Pickup Tesla Model S</h1>
<p>Please complete the following form to obtain your keys</p>
</div>

<form action="pdhandle.php" method="post">
<div class="form-group">
<label for="pickupOdoVal">Current Odometer Reading:</label>
<input type="text" name="curOdoReading" class="form-control" placeholder="Must be numeric entry" id="pickupOdoVal">
</div>

<div class="form-group">
<label for="carStat"> Car Status </label>
<input type="text" class="form-control" name="carStatus" id="carStat" >
<span class="help-block">Status can either be Normal, Damaged or Repair</span>
</div>
<button type="submit" class="btn btn-default">Submit</button>
</form>




</body>
</html>
