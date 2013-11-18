<?php session_start();?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<title>User Home</title>
<?php
$username = $_SESSION['username'];
?>
<script type="text/javascript">
function clickedButton(sel) {
	if(sel.id=="addCar") {
		window.location.href="insertCar.html";
	}
	if(sel.id=="createCarpool") {
		window.location.href="createCarpool.php";
	}
	if(sel.id=="insertSearcher") {
		window.location.href="insertSearcher.html";
	}
	if(sel.id=="deleteCar") {
		window.location.href="deleteCar.php";
	}
	if(sel.id=="updateTime") {
		window.location.href="updateTime.php";
	}
	if(sel.id=="searchCarpools") {
		window.location.href="searchCarpool.php";
	}	


}
</script>
</head>
<body>
<table width="100%" >
<tr><td align="center"><h2>CarpoolND</h2> </td><td> <h4>User: <?php print $username ?></h4> </td>  </tr>
</table>
<table>
<tr><td> <button id="addCar" type="button" onclick="clickedButton(this)"> Add a Car</button></td></tr>
<tr><td> <button id="createCarpool" type="button" onclick="clickedButton(this)"> Create Carpool</button></td></tr>
<tr><td> <button id="insertSearcher" type="button" onclick="clickedButton(this)"> Request a ride</button></td></tr>
<tr><td> <button id="deleteCar" type="button" onclick="clickedButton(this)"> Remove one of my cars</button></td></tr>
<tr><td> <button id="updateTime" type="button" onclick="clickedButton(this)"> Change Carpool Time</button></td></tr>
<tr><td> <button id="searchCarpools" type="button" onclick="clickedButton(this)"> Search For Carpools</button></td></tr>

</table>
</body>
</html>
