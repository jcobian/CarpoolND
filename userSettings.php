<?php session_start();?>
<html>
<head>
<title> CarpoolND: User Settings </title>
</head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<?php
$username = $_SESSION['username'];
?>
<script type="text/javascript">
function clickedButton(sel) {
	if(sel.id=="addCar") {
		window.location.href="insertCar.html";
	}
	if(sel.id=="deleteCar") {
		window.location.href="deleteCar.php";
	}
	if(sel.id=="updateTime") {
		window.location.href="updateTime.php";
	}

}
</script>

<body>
<h2 align="center"> <?php print $username ?> </h2>

<table>
<tr><td> <button id="addCar" type="button" onclick="clickedButton(this)"> Add a Car</button></td></tr>
<tr><td> <button id="deleteCar" type="button" onclick="clickedButton(this)"> Remove one of my cars</button></td></tr>
<tr><td> <button id="updateTime" type="button" onclick="clickedButton(this)"> Change one of my carpool times</button></td></tr>
</table>

</body>
</html>
