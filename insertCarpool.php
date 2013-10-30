<html>
<head>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<?php
$username = $_GET['username'];
$startingPoint = $_GET['startingPoint'];
$destination = $_GET['destination'];
$startDate = $_GET['startDate'];
$startTime = $_GET['startTime'];
$ETA = $_GET['ETA'];
$description = $_GET['description'];
$openSeats = $_GET['openSeats'];
$driver = $_GET['driver'];
$passenger1 = $_GET['passenger1'];
$passenger2 = $_GET['passenger2'];
$passenger3 = $_GET['passenger3'];
$passenger4 = $_GET['passenger4'];
$passenger5 = $_GET['passenger5'];
$passenger6 = $_GET['passenger6'];
$passenger7 = $_GET['passenger7'];
$passenger8 = $_GET['passenger8'];

$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = 'select car_id from Car where owner = :a';
$s = oci_parse($c, $q);
oci_bind_by_name($s, ":a", $username);
oci_execute($s);
$carId = 0;
while($row = oci_fecth_array($s))
{
	foreach($row as $column)
	{
		$carId = $column;
	}
}
$carId = 0;

$q = 'insert into carpool (carpool_id,car_id, startingpoint, destination, startdate, starttime, eta, description, openseats, driver, user1, user2, user3, user4, user5, user6, user7, user8) values (seq_carpool_id.nextval, :f, :g, :h, :j, :k, :l, :m, :n, :p, :q, :r, :t, :v, :w, :x, :y, :z)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);

//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":f", $carId);
oci_bind_by_name($s, ":g", $startingPoint);
oci_bind_by_name($s, ":h", $destination);
oci_bind_by_name($s, ":j", $startDate);
oci_bind_by_name($s, ":k", $startTime);
oci_bind_by_name($s, ":l", $ETA);
oci_bind_by_name($s, ":m", $description);
oci_bind_by_name($s, ":n", $openSeats);
oci_bind_by_name($s, ":p", $driver);
oci_bind_by_name($s, ":q", $passenger1);
oci_bind_by_name($s, ":r", $passenger2);
oci_bind_by_name($s, ":t", $passenger3);
oci_bind_by_name($s, ":v", $passenger4);
oci_bind_by_name($s, ":w", $passenger5);
oci_bind_by_name($s, ":x", $passenger6);
oci_bind_by_name($s, ":y", $passenger7);
oci_bind_by_name($s, ":z", $passenger8);
//Execute the SQL statement
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}
oci_close($c);
?>
</head>
<body>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/index.html">Go Back</a>
</body>
</html>
