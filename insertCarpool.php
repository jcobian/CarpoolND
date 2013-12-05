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
<?php
$startName = strtoupper($_GET['start']);
$endName = strtoupper($_GET['end']);
$startLat = $_GET['startLat'];
$startLong = $_GET['startLong'];
$endLat = $_GET['endLat'];
$endLong = $_GET['endLong'];

$startMonth= $_GET['startMonth'];
$startDay= $_GET['startDay'];
$startYear= $_GET['startYear'];
$endMonth= $_GET['endMonth'];
$endDay= $_GET['endDay'];
$endYear= $_GET['endYear'];
$startHour = $_GET['startHour'];
$startMinute= $_GET['startMinute'];
$startAmPm = $_GET['startAmPm'];
$endHour = $_GET['endHour'];
$endMinute= $_GET['endMinute'];
$endAmPm = $_GET['endAmPm'];
//to_date('1998/05/31:12:00AM', 'yyyy/mm/dd:hh:miam')
$startDateString = $startYear.'/'.$startMonth.'/'.$startDay.':'.$startHour.':'.$startMinute.':00'.$startAmPm;
$endDateString = $endYear.'/'.$endMonth.'/'.$endDay.':'.$endHour.':'.$endMinute.':00'.$endAmPm;
$description = $_GET['description'];
$openseats = $_GET['openSeats'];
$carId = $_GET['carId'];
$driver = $_SESSION['username'];
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = "insert into carpool (carpool_id,car_id, startlat,startlng,endlat,endlng,startDate, endDate, description, openseats,driver,startname,endname) values (seq_carpool_id.nextval, :f, :g, :h, :j, :k, to_date(:l,'yyyy/mm/dd:hh:mi:ssam'), to_date(:m,'yyyy/mm/dd:hh:mi:ssam'), :n, :p, :z,:q,:r)";
//Parse that SQL query into a statement
$s = oci_parse($c, $q);


//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":f", $carId);
oci_bind_by_name($s, ":g", $startLat);
oci_bind_by_name($s, ":h", $startLong);
oci_bind_by_name($s, ":j", $endLat);
oci_bind_by_name($s, ":k", $endLong);

//print $startDateString."\n";
//print $endDateString."\n";
oci_bind_by_name($s, ":l", $startDateString);
oci_bind_by_name($s, ":m", $endDateString);
//print 'got here!!!!';
oci_bind_by_name($s, ":n", $description);

oci_bind_by_name($s, ":p", $openseats);
oci_bind_by_name($s, ":z", $driver);
oci_bind_by_name($s, ":q", $startName);
oci_bind_by_name($s, ":r", $endName);

//Execute the SQL statement
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}
oci_close($c);
header("Location:homePage.php");
?>
</head>
<body>
</body>
</html>
