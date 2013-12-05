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
<script type="text/javascript">
function clickedButton(sel) {
	if(sel.id=="goBack") {
		window.location.href="userSettings.php";
	}

}
</script>
<?php
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
?>
</head>
<body>
<center><h2> Delete a Car From your Profile</h2></center>
<div class="insertForm">
<form action="showDeletedCar.php" method="get">
<div class="form-control"><span>Car: </span><select name="carId">
<?php
$q = 'select car_id, Make, Model from Car where owner = :a';
$s = oci_parse($c, $q);
oci_bind_by_name($s, ":a", $_SESSION['username']);
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}

while($row = oci_fetch_array($s,OCI_BOTH)){

	echo "<option value=\"".$row[0]."\">".$row[1]." ".$row[2]."</option>";

}
oci_close($c);
?>	
</div>
</select>
<br></br>
<input type="submit"/>
</form>
</div>
<div id="content1" style="position:absolute; left:18%; bottom:100px">
<button id="goBack" type="button" onclick="clickedButton(this)"> Go Back</button>
</body>
</html>

