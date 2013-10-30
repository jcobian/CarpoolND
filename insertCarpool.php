<?php
print("Hello World");
$startingPoint = $_GET['startingPoint'];
$destination = $_GET['destination'];
$startDate = $_GET['startDate'];
$endDate = $_GET['endDate'];
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = 'select car_id from Car where owner = $username';
$s = oci_parse($c, $q);
oci_execute($s);
while($row = oci_fecth_array($s))
{
	foreach($row as $column)
	{
		$carId = $column;
	}
}

$q = 'insert into carpool (carpool_id,car_id,startingpoint, destination, startdate, enddate) values (:t, :v, :w, :x, :y, :z)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);

//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":t", seq_carpool_id.nextval);
oci_bind_by_name($s, ":v", $carId);
oci_bind_by_name($s, ":w", $startingPoint);
oci_bind_by_name($s, ":x", $destination);
oci_bind_by_name($s, ":y", $startDate);
oci_bind_by_name($s, ":z", $endDate);
//Execute the SQL statement
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}
oci_close($c);
?>
