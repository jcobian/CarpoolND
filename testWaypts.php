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
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js" type="text/javascript"></script>    
<script>

//var originsLatArray = <?php echo json_encode($originsLatArray);?>;
//alert(JSON(originsLatArray[0]))
//document.write(originsLatArray[0]);

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;
var geocoder;
var isDone = new Boolean();
var increment = 0;
var carpoolIDResults = new Array();
var originsLatArray = <?php echo json_encode($originsLatArray);?>;
var originsLngArray = <?php echo json_encode($originsLngArray);?>;
var destLatArray = <?php echo json_encode($endLatArray);?>;
var destLngArray = <?php echo json_encode($endLngArray);?>;
var carpoolIDArray = <?php echo json_encode($carpoolIDArray);?>;
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
function addTable() {
	    $('#resultsTable').append(
	    <?php
		print "'<table><tr><td>Hello</td></tr></table>'";
			?>);

}
function sendAction() {
		window.location.href = "showRecommendations.php?arr[]=" + carpoolIDResults;

}
function callback(currentIndex,len,nextCarpoolID) {
	//alert(increment);
	//alert("Callback called. Completed inc = " +increment + " and curr index = " + currentIndex + " and len = " + len);
	increment++;
	if(currentIndex==len) {
		isDone=true;
		alert("Limit reached");
		var newLen = carpoolIDResults.length;
		for(var i=0;i<newLen;i++) {
			//alert(i + " = " + carpoolIDResults[i]);
		}
		//addTable();
		//document.getElementById("arr").value = carpoolIDResults;
		document.getElementById("formButton").style.display='block';
		
		
	} else {
		 setTimeout(function(){calcRouteWithoutWaypts(originsLatArray[increment], originsLngArray[increment], destLatArray[increment], destLngArray[increment],carpoolIDResults,carpoolIDArray[increment],len,currentIndex+1)},1200);

		
	}

}
function findTimes() {
		var len=carpoolIDArray.length;
		alert(len);
		var currentIndex = 1;
		 calcRouteWithoutWaypts(originsLatArray[0], originsLngArray[0], destLatArray[0], destLngArray[0],carpoolIDResults,carpoolIDArray[0],len,currentIndex);
		 

}
function calcRouteWithoutWaypts(startLat, startLng, endLat, endLng, carpoolIDResults,carpoolID,len,currentIndex) {
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
      var total_time_without_waypts = 0;
      for(var i = 0; i < response.routes[0].legs.length; i++) {
        total_time_without_waypts = total_time_without_waypts + response.routes[0].legs[i].duration.value;
      }
      //alert("total_time without waypts (in seconds): " + total_time_without_waypts);
	calcRoute(startLat, startLng, endLat, endLng,total_time_without_waypts, carpoolIDResults, carpoolID,len,currentIndex);  
    }
  });
}



function calcRoute(startLat, startLng, endLat, endLng,initialTime, carpoolIDResults,carpoolID,len,currentIndex) {
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
     // directionsDisplay.setDirections(response);
      var total_time_with_waypts = 0;
      for(var i = 0; i < response.routes[0].legs.length; i++) {
        total_time_with_waypts = total_time_with_waypts + response.routes[0].legs[i].duration.value;
      }
	//alert("Initial time = " + initialTime + " Waypoints time = " + total_time_with_waypts);
	if(initialTime < total_time_with_waypts) {
		carpoolIDResults.push(carpoolID);
		//alert("Added, carpool id = " + carpoolID + " len is now = " + carpoolIDResults.length);

	}	

	callback(currentIndex,len);
		
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

   <?php 
	if(!empty($_GET['arr']))
	{
		//var_dump($_GET['arr']);
		print 'addTable();';
	}
?>
google.maps.event.addDomListener(window, 'load', initialize);

    </script>

</head>
<body>
<center><h2> Request a Ride</h2></center>
    <div id="map-canvas"></div>
<form action="javascript:sendAction();">
<div class="insertForm" style="float:left">
<div class="form-group"><label for="start">Starting Point: <input name="start" id="start" type="textbox" onchange="codeAddress(this);"/></div>
<div class ="form-group"><label for="end">End Point: <input name="end" id="end" onchange="findTimes(); codeAddress(this);"/></div>
<input name="poop" id="poop" type="hidden"/>
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




<input type="submit" style="display:none;" id="formButton"/>
</div>
</form>
<br></br><br></br>
<div id="resultsTable" style="float:left">

</div>

</body>
</html>

