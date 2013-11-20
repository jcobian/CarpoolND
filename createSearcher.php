<?php session_start();
if(!isset($_SESSION['username']))
{unset($_SESSION);
session_destroy();
session_write_close();
header("Location:index.html");
exit;
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<center><h2> Request a Ride</h2></center>
<form action="insertSearcher.php" method="get">
<div class="insertForm">
<div class="form-group"><label for="startDate">Start Date: <input name="startDate"/></div>
<div class="form-group"><label for="startingPoint">Starting Point: <input name="startingPoint"/></div>
<div class="form-group"><label for="destination">Destination: <input name="destination"/></div>
<div class="form-group"><label for="description">Description: <input name="description"/></div>
<input type="submit"/>
</div>
</form>
</body>
</html>

