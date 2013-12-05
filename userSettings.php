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
		window.location.href="createCar.php";
	}
	if(sel.id=="deleteCar") {
		window.location.href="deleteCar.php";
	}
	if(sel.id=="updateTime") {
		window.location.href="updateTime.php";
	}
	if(sel.id=="Home") {
		window.location.href="homePage.php";
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
<div id="content1" style="position:absolute; left:18%; bottom:100px">
<button id="Home" type="button" onclick="clickedButton(this)"> Home</button>
</body>
</html>
