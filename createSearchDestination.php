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
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<center><h2 style="background-color:#ffcc00"> Search for a carpool to a destination</h2></center>
<form action="searchDestination.php" method="get">
<div class="insertForm">
<p><label for="destination">Destination: <input name="destination"/></p>
</div>
<input type="submit"/>
</form>
</body>
</html>
