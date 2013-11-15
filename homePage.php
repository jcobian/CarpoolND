<?php session_start();?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<title>User Home</title>
</head>
<body>
<center><h2>CarpoolND</h2></center>
</head>
<body>
<?php
$username = $_POST['username'];
$password = $_POST['password'];
?>
<center>
<div id="homePageLinksDiv">
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/insertCar.html">Add a Car</a>
<br></br>
<a href="http://orchestra.cselab.nd.edu/~olamb/CarpoolND/createCarpool.php">Create a Carpool</a>
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
