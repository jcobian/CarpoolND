<?php session_start();?>
<html>
<head>
<title>User Home</title>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
</head>
<body>
<center><h2 style="background-color:#ffcc00">CarpoolND</h2></center>
</head>
<body>
<?php
$username = $_POST['username'];
$password = $_POST['password'];
?>
<center>
<div id="homePageLinksDiv" style="background-color:#ffcc00">
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/insertCar.html">Add a Car</a>
<br></br>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/createCarpool.php">Create a Carpool</a>
<br></br>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/insertSearcher.html">Request a ride</a>
<br></br>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/deleteCar.php">Remove one of my cars</a>
<br></br>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/updateTime.php">Change Time of Carpool</a>
<br></br>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/searchCarpool.php">Show All Carpools</a>
<br></br>
</div>
</center>

</body>
</html>
