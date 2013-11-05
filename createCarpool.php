<?php session_start();?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<center><h2 style="background-color:#ffcc00"> Create a Carpool</h2></center>
<form action="insertCarpool.php" method="get">
<div class="insertForm">
<p><label for="startingPoint">Starting Point: <input name="startingPoint"/></p>
<p><label for="destination">Destination: <input name="destination"/></p>
<p><label for="startDate">Start Date: <input name="startDate"/></p>
<p><label for="startTime">Start Time: <input name="startTime"/></p>
<p><label for="ETA">Estimate Time of Arrival: <input name="ETA"/></p>
<p><label for="description">Description: <input name="description"/></p>
<p><label for="openSeats">Open Seats: <input name="openSeats"/></p>
<p><label for="passenger1">Passenger 1: <input name="passenger1"/></p>
<p><label for="passenger2">Passenger 2: <input name="passenger2"/></p>
<p><label for="passenger3">Passenger 3: <input name="passenger3"/></p>
<p><label for="passenger4">Passenger 4: <input name="passenger4"/></p>
<p><label for="passenger5">Passenger 5: <input name="passenger5"/></p>
<p><label for="passenger6">Passenger 6: <input name="passenger6"/></p>
<p><label for="passenger7">Passenger 7: <input name="passenger7"/></p>
<p><label for="passenger8">Passenger 8: <input name="passenger8"/></p>
<select name="carId">
  <option value="volvo">Volvo</option>
<?php
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = 'select car_id, Model from Car where owner = :a';
$s = oci_parse($c, $q);
oci_bind_by_name($s, ":a", $_SESSION['username']);
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}

while($row = oci_fetch_array($s,OCI_BOTH)){

		echo "<option value=\"".$row[0]."\">".$row[1]."</option>";

}
?>	
</select>
<input type="submit"/>
</div>
</form>
</body>
</html>
