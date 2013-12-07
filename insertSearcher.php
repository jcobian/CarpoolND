<?php session_start();
if(!isset($_SESSION['username']))
{unset($_SESSION);
session_destroy();
session_write_close();
header("Location:loginPage.php");
exit;
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
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
$startDateString = $startYear.'/'.$startMonth.'/'.$startDay.':'.$startHour.':'.$startMinute.':00'.$startAmPm;
$endDateString = $endYear.'/'.$endMonth.'/'.$endDay.':'.$endHour.':'.$endMinute.':00'.$endAmPm;

$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}


$q = "insert into searchers (search_id, username, startlat, startlng,endlat,endlng,startdate,enddate,startname,endname) values (seq_search_id.nextval, :f, :g, :h, :j, :k,to_date(:l,'yyyy/mm/dd:hh:mi:ssam'), to_date(:m,'yyyy/mm/dd:hh:mi:ssam'),:n,:o)";
//Parse that SQL query into a statement
$s = oci_parse($c, $q);

//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":f", $_SESSION['username']);
oci_bind_by_name($s, ":g", $startLat);
oci_bind_by_name($s, ":h", $startLong);
oci_bind_by_name($s, ":j", $endLat);
oci_bind_by_name($s, ":k", $endLong);
oci_bind_by_name($s, ":l", $startDateString);
oci_bind_by_name($s, ":m", $endDateString);
oci_bind_by_name($s, ":n", $startName);
oci_bind_by_name($s, ":o", $endName);


//Execute the SQL statement
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}
//header("Location:homePage.php");
?>
</head>
<body>
<table border="1">
<tr>
<td> Starting Point </td>
<td> Ending Point </td>
<td> Start Date </td>
<td> End Date </td>
<td> Open Seats </td>
<td> Driver </td>
</tr>
<?php
$q = "select startname, endname, startdate, enddate, openseats, driver
	from carpool where :g = startlat and :h=startlng and :j=endlat and :k=endlng and openseats>0";

//Parse that SQL query into a statement
$s = oci_parse($c, $q);
oci_bind_by_name($s, ":g", $startLat);
oci_bind_by_name($s, ":h", $startLong);
oci_bind_by_name($s, ":j", $endLat);
oci_bind_by_name($s, ":k", $endLong);
//Execute the SQL statement
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}
while($row=oci_fetch_array($s,OCI_ASSOC)) {
	print '<tr>';
	foreach ($row as $column) {
		print '<td>'.$column.'</td>';
	}
	print '</tr>';
}
oci_close($c);
header("Location:homePage.php");
?>
</table>
</body>
</html>
