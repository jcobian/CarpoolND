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
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      #map-canvas {
        height: 90%;
        margin-left: 0px;
        padding: 10px;
	width: 55%;
	float:right
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3key={AIzaSyA5NX_2Kc2TG3t9vePL-3gz2W6YAhoB1tA}&sensor=false">></script>
    <script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var geocoder;
window.onload = function() {

 updateTime();

}
function updateTime() {
var today = new Date();
  var dd = today.getDate(); 
  var mm = today.getMonth()+1;
  var yyyy = today.getFullYear();
  document.getElementById("startMonth").value = mm;
  document.getElementById("startDay").value = dd;
  document.getElementById("startYear").value = yyyy;

  document.getElementById("endMonth").value = mm;
  document.getElementById("endDay").value = dd;
  document.getElementById("endYear").value = yyyy;

}
function initialize() {
  
  geocoder = new google.maps.Geocoder();

  directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(41.850033, -87.6500523);
  var mapOptions = {
    zoom:7,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: chicago
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start = document.getElementById('start').value;
  var end = document.getElementById('end').value;
  var request = {
      origin:start,
      destination:end,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
    }
  });
}

  function codeAddress(sel) {
    var isEnd;
    var address;
    if(sel.id == 'start') {
	isEnd = 0;
        address = document.getElementById('start').value;}
    else { 
        isEnd = 1;
        address = document.getElementById('end').value;
    }
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
	if(isEnd==0) {
		document.getElementById("startLat").value = results[0].geometry.location.lat()
		document.getElementById("startLong").value = results[0].geometry.location.lng()
	} else {
		document.getElementById("endLat").value = results[0].geometry.location.lat()
		document.getElementById("endLong").value = results[0].geometry.location.lng()
	}
      	//alert("Position is: " + results[0].geometry.location.lat() + "," + results[0].geometry.location.lng());
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }


google.maps.event.addDomListener(window, 'load', initialize);

    </script>
</head>
<body>
<center><h2> Create a Carpool</h2></center>
    <div id="map-canvas"></div>
<form action="insertCarpool.php" method="get">
<div class="insertForm" style="float:left">

<div class="form-group"><label for="start">Starting Point: <input name="start" id="start" type="textbox" onchange="calcRoute(); codeAddress(this);"/></div>
<div class ="form-group"><label for="end">End Point: <input name="end" id="end" onchange="calcRoute(); codeAddress(this);"/></div>
<input name="startLat" id="startLat" type="hidden"/>
<input name="startLong" id="startLong" type="hidden"/>
<input name="endLat" id="endLat" type="hidden"/>
<input name="endLong" id="endLong" type="hidden"/>
<div class = "form-control">
<span>Start Date: </span>
<select name="startMonth" id = "startMonth">
<option value=01> January </option>
<option value=02> February </option>
<option value=03> March </option>
<option value=04> April </option>
<option value=05> May </option>
<option value=06> June </option>
<option value=07> July </option>
<option value=08> August </option>
<option value=09> September </option>
<option value=10> October </option>
<option value=11> November </option>
<option value=12> December </option>
</select>
<select name="startDay" id = "startDay">
<option value=01> 1 </option>
<option value=02> 2 </option>
<option value=03> 3 </option>
<option value=04> 4 </option>
<option value=05> 5 </option>
<option value=06> 6 </option>
<option value=07> 7 </option>
<option value=08> 8 </option>
<option value=09> 9 </option>
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
<select name="startYear" id = "startYear">
<option value=2013>2013</option>
<option value=2014>2014</option>
<option value=2015>2015</option>
<option value=2016>2016</option>
</select>
</div>
<div class = "form-control">
<span>Start Time: </span>
<select name="startHour" id = "startHour">
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
<select name="startMinute" id = "startMinute">
<option value=00 selected> 00 </option>
<option value=15> 15 </option>
<option value=30> 30 </option>
<option value=45> 45 </option>
</select>
<select name="startAmPm" id = "startAmPm">
<option value="am"> AM </option>
<option value="pm" selected> PM </option>
</select>
</div>
<div class = "form-control">
<span>ETA Date: </span>
<select name="endMonth" id = "endMonth">
<option value=01> January </option>
<option value=02> February </option>
<option value=03> March </option>
<option value=04> April </option>
<option value=05> May </option>
<option value=06> June </option>
<option value=07> July </option>
<option value=08> August </option>
<option value=09> September </option>
<option value=10> October </option>
<option value=11> November </option>
<option value=12> December </option>
</select>
<select name="endDay" id = "endDay">
<option value=01> 1 </option>
<option value=02> 2 </option>
<option value=03> 3 </option>
<option value=04> 4 </option>
<option value=05> 5 </option>
<option value=06> 6 </option>
<option value=07> 7 </option>
<option value=08> 8 </option>
<option value=09> 9 </option>
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
<select name="endYear" id = "endYear">
<option value=2013>2013</option>
<option value=2014>2014</option>
<option value=2015>2015</option>
<option value=2016>2016</option>
</select>
</div>
<div class = "form-control">
<span>ETA (local time): </span>
<select name="endHour" id = "endHour">
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
<select name="endMinute" id = "endMinute">
<option value=00 selected> 00 </option>
<option value=15> 15 </option>
<option value=30> 30 </option>
<option value=45> 45 </option>
</select>
<select name="endAmPm" id = "endAmPm">
<option value="am"> AM </option>
<option value="pm" selected> PM </option>
</select>
</div>
<div class = "form-group"><label for="description">Description: <input name="description"/></div>
<div class = "form-control">
<span>Open Seats: </span>
<select name="openSeats">
<option value=1> 1 </option>
<option value=2> 2 </option>
<option value=3> 3 </option>
<option value=4 selected> 4 </option>
<option value=5> 5 </option>
<option value=6> 6 </option>
<option value=7> 7 </option>
<option value=8> 8 </option>
<option value=9> 9 </option>
</select>
</div>
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
<br></br>
<input type="submit"/>
</div> <!--closes insertForm -->
</form>
</body>
</html>
