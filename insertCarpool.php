<?php session_start();?>
<html>
<head>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<?php

$startingPoint = $_GET['startingPoint'];
$destination = $_GET['destination'];
$startMonth= $_GET['startMonth'];
$startDay= $_GET['startDay'];
$startYear= $_GET['startYear'];
$endNonth= $_GET['endMonth'];
$endDay= $_GET['endDay'];
$endYear= $_GET['endYear'];
$startHour = $_GET['startHour'];
$startMinute= $_GET['startMinute'];
$startAmPm = $_GET[startAmPm'];
$endHour = $_GET['endHour'];
$endMinute= $_GET['endMinute'];
$endAmPm = $_GET[endAmPm'];
$description = $_GET['description'];
$openSeats = $_GET['openSeats'];
$passenger1 = $_GET['passenger1'];
$passenger2 = $_GET['passenger2'];
$passenger3 = $_GET['passenger3'];
$passenger4 = $_GET['passenger4'];
$passenger5 = $_GET['passenger5'];
$passenger6 = $_GET['passenger6'];
$passenger7 = $_GET['passenger7'];
$passenger8 = $_GET['passenger8'];
$carId = $_GET['carId'];

$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = 'insert into carpool (carpool_id,car_id, startingpoint, destination, startDate, endDate, description, openseats) values (seq_carpool_id.nextval, :f, :g, :h, :j, :k, :l, :m, :n, :p)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);


//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":f", $carId);
oci_bind_by_name($s, ":g", $startingPoint);
oci_bind_by_name($s, ":h", $destination);
oci_bind_by_name($s, ":j", $startDate);
oci_bind_by_name($s, ":l", $endDate);
oci_bind_by_name($s, ":m", $description);
oci_bind_by_name($s, ":n", $openSeats);
oci_bind_by_name($s, ":p", $_SESSION['username']);
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
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/homePage.php">Go Back</a>
</body>
</html>
