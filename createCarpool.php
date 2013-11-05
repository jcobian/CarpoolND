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
<p>
<span>Start Date: </span>
<select name="month">
<option value=1> January </option>
<option value=2> February </option>
<option value=3> March </option>
<option value=4> April </option>
<option value=5> May </option>
<option value=6> June </option>
<option value=7> July </option>
<option value=8> August </option>
<option value=9> September </option>
<option value=10> October </option>
<option value=11> November </option>
<option value=12> December </option>
</select>
<select name="day">
<option value=1> 1 </option>
<option value=2> 2 </option>
<option value=3> 3 </option>
<option value=4> 4 </option>
<option value=5> 5 </option>
<option value=6> 6 </option>
<option value=7> 7 </option>
<option value=8> 8 </option>
<option value=9> 9 </option>
<option value=10> 10 </option>
<option value=11> 11 </option>
<option value=12> 12 </option>
<option value=13> 13 </option>
<option value=14> 14 </option>
<option value=15> 15 </option>
<option value=16> 16 </option>
<option value=17> 17 </option>
<option value=18> 18 </option>
<option value=19> 19 </option>
<option value=20> 20 </option>
<option value=21> 21 </option>
<option value=22> 22 </option>
<option value=23> 23 </option>
<option value=24> 24 </option>
<option value=25> 25 </option>
<option value=26> 26 </option>
<option value=27> 27 </option>
<option value=28> 28 </option>
<option value=29> 29 </option>
<option value=30> 30 </option>
<option value=31> 31 </option>
</select>
<select name="year">
<option value=2013>2013</option>
<option value=2014>2014</option>
<option value=2015>2015</option>
<option value=2016>2016</option>
</select>
</p>
<p>
<span>Start Time: </span>
<select name="startHour">
<option value=1> 1 </option>
<option value=2> 2 </option>
<option value=3> 3 </option>
<option value=4> 4 </option>
<option value=5> 5 </option>
<option value=6> 6 </option>
<option value=7> 7 </option>
<option value=8> 8 </option>
<option value=9> 9 </option>
<option value=10> 10 </option>
<option value=11> 11 </option>
<option value=12 selected> 12 </option>
</select>
<span>:</span>
<select name="startMinute">
<option value=0 selectd> 00 </option>
<option value=15> 15 </option>
<option value=30> 30 </option>
<option value=45> 45 </option>
</select>
<select name="startAmPm">
<option value="am"> A.M. </option>
<option value="pm" selected> P.M. </option>
</select>
</p>
<p>
<span>ETA: </span>
<select name="endHour">
<option value=1> 1 </option>
<option value=2> 2 </option>
<option value=3> 3 </option>
<option value=4> 4 </option>
<option value=5> 5 </option>
<option value=6> 6 </option>
<option value=7> 7 </option>
<option value=8> 8 </option>
<option value=9> 9 </option>
<option value=10> 10 </option>
<option value=11> 11 </option>
<option value=12 selected> 12 </option>
</select>
<span>:</span>
<select name="endMinute">
<option value=0 selected> 00 </option>
<option value=15> 15 </option>
<option value=30> 30 </option>
<option value=45> 45 </option>
</select>
<select name="endAmPm">
<option value="am"> A.M. </option>
<option value="pm" selected> P.M. </option>
</select>
</p>
<p><label for="description">Description: <input name="description"/></p>
<p>
<span>Open Seats: </span>
<select name="openSeats">
<option value=1> 1 </option>
<option value=2> 2 </option>
<option value=3> 3 </option>
<option value=4> 4 </option>
<option value=5> 5 </option>
<option value=6> 6 </option>
<option value=7> 7 </option>
<option value=8> 8 </option>
<option value=9> 9 </option>
</select>
</p>
<p><label for="passenger1">Passenger 1: <input name="passenger1"/></p>
<p><label for="passenger2">Passenger 2: <input name="passenger2"/></p>
<p><label for="passenger3">Passenger 3: <input name="passenger3"/></p>
<p><label for="passenger4">Passenger 4: <input name="passenger4"/></p>
<p><label for="passenger5">Passenger 5: <input name="passenger5"/></p>
<p><label for="passenger6">Passenger 6: <input name="passenger6"/></p>
<p><label for="passenger7">Passenger 7: <input name="passenger7"/></p>
<p><label for="passenger8">Passenger 8: <input name="passenger8"/></p>
<span>Car: </span><select name="carId">
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
oci_close($c);
?>	
</select>
<input type="submit"/>
</div>
</form>
</body>
</html>
