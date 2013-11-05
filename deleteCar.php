<?php session_start();?>
<html>
<head>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<?php
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
?>
</head>
<body>
<center><h2 style="background-color:#ffcc00"> Delete a Car From your Profile</h2></center>
<div class="insertForm" style="background-color:#ffcc00">
<form action="showDeletedCar.php" method="get">
<span>Car: </span><select name="carId">
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
</select>
<br></br>
<input type="submit"/>
</form>
</div>
</body>
</html>

