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

<?php
//Create a connection to the oracle database with the user xxx and the password yyy on the host zzz with the database www
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    //$e = oci_error();
    //trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
print "Hddd";
}
//Write some SQL code to get rows from the wizards table
$q = 'select startlat from carpool';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query
oci_execute($s);
//$originsLatArray = oci_fetch_array($s,OCI_ASSOC);
$originsLatArray = array();

while ($row = oci_fetch_array($s,OCI_ASSOC)) {
	foreach($row as $column) {
		print "a  ";
		array_push($originsLatArray, "$column");
	}
}

//2nd query
$q = 'select startlng from carpool';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query
oci_execute($s);

$originsLngArray = array();

while ($row = oci_fetch_array($s,OCI_ASSOC)) {
	foreach($row as $column) {
		array_push($originsLngArray, "$column");
	}
}

//3rd query
$q = 'select endlat from carpool';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query
oci_execute($s);

$endLatArray = array();

while ($row = oci_fetch_array($s,OCI_ASSOC)) {
	foreach($row as $column) {
		array_push($endLatArray, "$column");
	}
}

//4th query
$q = 'select endlng from carpool';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query
oci_execute($s);

$endLngArray = array();

while ($row = oci_fetch_array($s,OCI_ASSOC)) {
	foreach($row as $column) {
		array_push($endLngArray, "$column");
	}
}

//5th query
$q = 'select carpool_id from carpool';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query
oci_execute($s);

$carpoolIDArray = array();

while ($row = oci_fetch_array($s,OCI_ASSOC)) {
	foreach($row as $column) {
		array_push($carpoolIDArray, "$column");
	}
}

?>
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

//var originsLatArray = <?php echo json_encode($originsLatArray);?>;
//alert(JSON(originsLatArray[0]))
//document.write(originsLatArray[0]);

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var geocoder;
var isDone = new Boolean();
isDone=false;
var increment = 0;
var resultsArray = new Array();
var initialTimesArray = new Array();
var waypointsTimesArray = new Array();

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

function callback(index,arrType,len,time) {
	increment++;
	//alert("callback called");
	if(arrType==0) {
		initialTimesArray[index] = time;
	} else {
		waypointsTimesArray[index] = time;
	}
	var limit = len*2;
	if(increment == limit)
	{
		alert("Limit hit");
		isDone = true;
		increment = 0;
		var size1 = initialTimesArray.length;
		var size2 = waypointsTimesArray.length;
		var c = 0;
		var c2=0;
		for(var i=0;i<size1;i++) {
			if(initialTimesArray[i] != 0) {
				c++; //lol
			}
			if(waypointsTimesArray[i] !=0) {
				c2++;
			}
		}
		alert("Size 1 = " + size1 + " Size 2 = " + size2);
	}	
}

function findTimes() {
	var originsLatArray = <?php echo json_encode($originsLatArray);?>;
	var originsLngArray = <?php echo json_encode($originsLngArray);?>;
	var destLatArray = <?php echo json_encode($endLatArray);?>;
	var destLngArray = <?php echo json_encode($endLngArray);?>;
	var carpoolIDArray = <?php echo json_encode($carpoolIDArray);?>;
	var len = carpoolIDArray.length;
	
	alert("Number of carpools = " + len);
	for(var index = 0; index < len; index++)
	{

			var initialTime = calcRouteWithoutWaypts(originsLatArray[index], originsLngArray[index], destLatArray[index], destLngArray[index], callback,index,len);
			var waypointTime = calcRoute(originsLatArray[index], originsLngArray[index], destLatArray[index], destLngArray[index], callback,index,len);		
		//alert("something else");
		/*
		var thisInterval = setInterval(function(){
			if(isDone) {
				alert("Done calculating calcX and Y");
				isDone = false;
				clearInterval(this);
				//continue;
			}
			
			
		}, 1000);*/
		
			
	}
}

function calcRoute(startLat, startLng, endLat, endLng, callback,index,len) {
  var driverStart = new google.maps.LatLng(startLat, startLng);
  var driverEnd = new google.maps.LatLng(endLat, endLng);
  var passengerStart = document.getElementById('start').value;
  var passengerEnd = document.getElementById('end').value;
  var waypts = [];
  
  waypts.push({
	location: passengerStart,
	stopover: true
  });
  waypts.push({
	location: passengerEnd,
	stopover: true
  });
  var riderRequest = {
      origin:driverStart,
      waypoints: waypts,
      destination:driverEnd,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
  };
  directionsService.route(riderRequest, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      //directionsDisplay.setDirections(response);
      var total_time = 0;
      for(var i = 0; i < response.routes[0].legs.length; i++) {
        total_time = total_time + response.routes[0].legs[i].duration.value;
      }
	callback(index,1,len,total_time);
	//return total_time;	
    }
  });
  
}


function calcRouteWithoutWaypts(startLat, startLng, endLat, endLng, callback,index,len) {
  var driverStart = new google.maps.LatLng(startLat, startLng);
  var driverEnd = new google.maps.LatLng(endLat, endLng);

  var riderRequest = {
      origin:driverStart,
      destination:driverEnd,
      travelMode: google.maps.DirectionsTravelMode.DRIVING
  };
  directionsService.route(riderRequest, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      //directionsDisplay.setDirections(response);
      var total_time = 0;
      for(var i = 0; i < response.routes[0].legs.length; i++) {
        total_time = total_time + response.routes[0].legs[i].duration.value;
      }
      	callback(index,0,len,total_time);
	return total_time;	

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
<center><h2> Request a Ride</h2></center>
    <div id="map-canvas"></div>
<form action="insertSearcher.php" method="get">
<div class="insertForm" style="float:left">
<div class="form-group"><label for="start">Starting Point: <input name="start" id="start" type="textbox" onchange="codeAddress(this);"/></div>
<div class ="form-group"><label for="end">End Point: <input name="end" id="end" onchange="findTimes(); codeAddress(this);"/></div>
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
<span>ETA: </span>
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




<input type="submit"/>
</div>
</form>
</body>
</html>
<!--<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Waypoints in directions</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(41.850033, -87.6500523);
  var mapOptions = {
    zoom: 6,
    center: chicago
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start = document.getElementById('start').value;
  var end = document.getElementById('end').value;
  var waypts = [];
  var checkboxArray = document.getElementById('waypoints');
  for (var i = 0; i < checkboxArray.length; i++) {
    if (checkboxArray.options[i].selected == true) {
      waypts.push({
          location:checkboxArray[i].value,
          stopover:true});
    }
  }

  var request = {
      origin: start,
      destination: end,
      waypoints: waypts,
      optimizeWaypoints: true,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      var route = response.routes[0];
      var summaryPanel = document.getElementById('directions_panel');
      summaryPanel.innerHTML = '';
      // For each route, display summary information.
      for (var i = 0; i < route.legs.length; i++) {
        var routeSegment = i + 1;
        summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment + '</b><br>';
        summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
        summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
        summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
      }
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas" style="float:left;width:70%;height:100%;"></div>
    <div id="control_panel" style="float:right;width:30%;text-align:left;padding-top:20px">
    <div style="margin:20px;border-width:2px;">
    <b>Start:</b>
    <select id="start">
      <option value="Halifax, NS">Halifax, NS</option>
      <option value="Boston, MA">Boston, MA</option>
      <option value="New York, NY">New York, NY</option>
      <option value="Miami, FL">Miami, FL</option>
    </select>
    <br>
    <b>Waypoints:</b> <br>
    <i>(Ctrl-Click for multiple selection)</i> <br>
    <select multiple id="waypoints">
      <option value="montreal, quebec">Montreal, QBC</input>
      <option value="toronto, ont">Toronto, ONT</input>
      <option value="chicago, il">Chicago</input>
      <option value="winnipeg, mb">Winnipeg</input>
      <option value="fargo, nd">Fargo</input>
      <option value="calgary, ab">Calgary</input>
      <option value="spokane, wa">Spokane</input>
    </select>
    <br>
    <b>End:</b>
    <select id="end">
      <option value="Vancouver, BC">Vancouver, BC</option>
      <option value="Seattle, WA">Seattle, WA</option>
      <option value="San Francisco, CA">San Francisco, CA</option>
      <option value="Los Angeles, CA">Los Angeles, CA</option>
    </select>
    <br>
      <input type="submit" onclick="calcRoute();">
    </div>
    <div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>
    </div>
  </body>
</html>
-->

