<?php session_start();
if(!isset($_SESSION['username']))
{unset($_SESSION);
session_destroy();
session_write_close();
header("Location:index.html");
exit;
}
if(!empty($_GET['startLocation']))
	$startLocation = strtoupper($_GET['startLocation']);
if(!empty($_GET['endLocation']))
	$endLocation = strtoupper($_GET['endLocation']);
if(!empty($_GET['Make']))
	$Make = strtoupper($_GET['Make']);
if(!empty($_GET['Model']))
	$Model = strtoupper($_GET['Model']);
if(!empty($_GET['Year']))
	$Year = $_GET['Year'];
if(!empty($_GET['openSeats']))
	$openSeats = $_GET['openSeats'];

if(!empty($_GET['endDay']))
	$endDay = $_GET['endDay'];
if(!empty($_GET['endMonth']))
	$endMonth = $_GET['endMonth'];
if(!empty($_GET['endYear']))
	$endYear = $_GET['endYear'];
if(!empty($_GET['startDay']))
	$startDay = $_GET['startDay'];
if(!empty($_GET['startMonth']))
	$startMonth = $_GET['startMonth'];
if(!empty($_GET['startYear']))
	$startYear = $_GET['startYear'];			

$startDateString = $startYear.'/'.$startMonth.'/'.$startDay;
$endDateString = $endYear.'/'.$endMonth.'/'.$endDay;

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript">
window.onload = function() {
  document.getElementById("Year").selectedIndex = -1;
  document.getElementById("openSeats").selectedIndex = -1;
  updateTime();
}
function clickedButton(sel) {
	if(sel.id=="goBack") {
		window.location.href="homePage.php";
	}

}
function joinClicked(sel, email) {
	var getValue = sel.id;
	alert("A notification has been sent to " + email + "!");
	window.location = "?getValue=" + getValue;
}

function updateTime() {
  document.getElementById("startMonth").selectedIndex = -1;
  document.getElementById("startDay").selectedIndex = -1;
  document.getElementById("startYear").selectedIndex = -1;

  document.getElementById("endMonth").selectedIndex = -1;
  document.getElementById("endDay").selectedIndex = -1;
  document.getElementById("endYear").selectedIndex = -1;
}

function checkTimes(sel) {

  var today = new Date();
  var dd = today.getDate(); 
  var mm = today.getMonth()+1;
  var yyyy = today.getFullYear();
  if(sel == 'startDateDropdown'&& document.getElementById("startMonth").value!=-1 && document.getElementById("startDay").value !=-1 && document.getElementById("startYear").value !=-1){
  	var selectedDate = new Date(document.getElementById("startYear").value,document.getElementById("startMonth").value,  document.getElementById("startDay").value);
  	if(selectedDate<today){
  		document.getElementById("startMonth").value = mm;
  		document.getElementById("startDay").value = dd;
  		document.getElementById("startYear").value = yyyy;
	}
  }
  
  if(sel == 'endDateDropdown' && document.getElementById("endMonth").value!=-1 && document.getElementById("endDay").value !=-1 && document.getElementById("endYear").value !=-1){
  	var selectedDate = new Date(document.getElementById("endYear").value,document.getElementById("endMonth").value,  document.getElementById("endDay").value);
  	   	if(selectedDate<today){
  	   		document.getElementById("endMonth").value = mm;
  			document.getElementById("endDay").value = dd;
  			document.getElementById("endYear").value = yyyy;
  		}
  }
}
</script>
</head>
<body>
<div style="background-color:#FFFFFF">
	<form action="searchCarpool.php" method="get" role="form" id="queryForm">
	<div><label for="startLocation">Starting Location: </label><input type="text" name="startLocation" id="startLocation"/>
	<label for="endLocation">Destination: </label><input type="text" name="endLocation"/></div>
	<div><label for="Make">Make: </label><input name="Make"/>
	<label for="Model">Model: </label><input name="Model"/>
	<span>Min. Car Year: </span>
	<select name="Year" id="Year">
	<option value=2014>2014</option>
	<option value=2013>2013</option>
	<option value=2012>2012</option>
	<option value=2011>2011</option>
	<option value=2010>2010</option>
	<option value=2009>2009</option>
	<option value=2008>2008</option>
	<option value=2007>2007</option>
	<option value=2006>2006</option>
	<option value=2005>2005</option>
	<option value=2004>2004</option>
	<option value=2003>2003</option>
	<option value=2002>2002</option>
	<option value=2001>2001</option>
	<option value=2000>2000</option>
	<option value=1999>1999</option>
	<option value=1998>1998</option>
	<option value=1997>1997</option>
	<option value=1996>1996</option>
	<option value=1995>1995</option>
	<option value=1994>1994</option>
	<option value=1993>1993</option>
	<option value=1992>1992</option>
	<option value=1991>1991</option>
	<option value=1990>1990</option>
	<option value=1989>1989</option>
	<option value=1988>1988</option>
	<option value=1987>1987</option>
	<option value=1986>1986</option>
	<option value=1985>1985</option>
	<option value=1984>1984</option>
	<option value=1983>1983</option>
	<option value=1982>1982</option>
	<option value=1981>1981</option>
	<option value=1980>1980</option>
	<option value=1979>Older Than 1980</option>
	</select>
	
	<span>Min. Open Seats: </span>
	<select name="openSeats" id="openSeats">
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
<br></br>	
<span>Leave on or After: </span>
<select name="startMonth" id = "startMonth" class="startDateDropdown" onchange = "checkTimes('startDateDropdown');">
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
<select name="startDay" id = "startDay" class="startDateDropdown" onchange = "checkTimes('startDateDropdown');">
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
<select name="startYear" id = "startYear" class="startDateDropdown" onchange = "checkTimes('startDateDropdown');">
<option value=2013>2013</option>
<option value=2014>2014</option>
<option value=2015>2015</option>
<option value=2016>2016</option>
</select>


<span>Arrive By: </span>
<select name="endMonth" id = "endMonth" class="endDateDropdown" onchange = "checkTimes('endDateDropdown');">
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
<select name="endDay" id = "endDay" class="endDateDropdown" onchange = "checkTimes('endDateDropdown');">
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
<select name="endYear" id = "endYear" class="endDateDropdown" onchange = "checkTimes('endDateDropdown');">
<option value=2013>2013</option>
<option value=2014>2014</option>
<option value=2015>2015</option>
<option value=2016>2016</option>
</select>

</div>
	<input type="submit" />
	<form action="searchCarpool.php" method="get" role="form"><input type="submit" value = "Clear"/></form>
	</form>
	
	</div>
</div>
<div>
<?php
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
$q = 'select c.carpool_id, c.driver, c.startname, c.endname, c.startdate, c.enddate, nvl(c.description,\'No Description\'), c.openseats, c2.year, c2.make, c2.model, u.firstname, u.lastname from carpool c, car c2, users u where c.driver = c2.owner AND c2.owner = u.username';
if(!empty($_GET['startLocation']))
	$q = $q.' AND c.startname = :t ';
if(!empty($_GET['endLocation']))
	$q = $q.' AND c.endname = :u ';
if(!empty($_GET['Make']))
	$q = $q.' AND c2.make = :v ';
if(!empty($_GET['Model']))
	$q = $q.' AND c2.model = :x ';
if(!empty($_GET['Year']))
	$q = $q.' AND c2.year >= :y ';
if(!empty($_GET['openSeats']))
	$q = $q.' AND c.openseats >= :z';
if(!empty($_GET['startDay']) && !empty($_GET['startMonth']) && !empty($_GET['startYear']) )
	$q = $q.' AND c.startDate >= to_date(:s,\'yyyy/mm/dd\')';
if(!empty($_GET['endDay']) && !empty($_GET['endMonth']) && !empty($_GET['endYear']) )
	$q = $q.' AND c.endDate <= to_date(:r,\'yyyy/mm/dd\')';
$q = $q.' AND c.openseats > 0';
//Parse that SQL query into a statement

$s = oci_parse($c, $q);
oci_bind_by_name($s, ":r", $endDateString);
oci_bind_by_name($s, ":s", $startDateString);
oci_bind_by_name($s, ":t", $startLocation);
oci_bind_by_name($s, ":u", $endLocation);
oci_bind_by_name($s, ":v", $Make);
oci_bind_by_name($s, ":x", $Model);
oci_bind_by_name($s, ":y", $Year);
oci_bind_by_name($s, ":z", $openSeats);
//Execute the SQL statement/query
oci_execute($s);

//We want to print out the results of the query into an HTML table; so we'll need to write an HTML table. This can be done by closing the PHP and writing straight HTML code, or you can have PHP print the HTML code. Let's have PHP print the HTML for now.
print '<table border = "1" style="background-color:#FFFFFF; overflow-y:scroll; height:auto; display:block;">';
//We want to loop through all of the rows from the result of the query
          print '<tr>';
  print '<td><b>Starting Point </b></td> <td><b>Destination</b></td> <td><b>Start Date</b></td> <td><b>End Date</b></td> <td><b>Description</b></td> <td><b>Open Seats</b></td> <td><b>Car</b></td> <td><b>Driver</b></td> <td><b>Request to Join</b></td>';
print '<tr>';
while ($row = oci_fetch_array($s,OCI_ASSOC)) {
    //Inside the loop we have get one $row at a time, so we need to handle this with HTML:
$len = count($row);
    print '<tr>';
    $i = 0;
    $carpoolid = 0;
    $email = "";
    //Inside of each $row we have several attributes/columns that we need to iterate through.
    foreach($row as $column) {
    	if($i == 0 || $i == 1)
    	{
    		if($i==0)
    			$carpoolid = $column;
    		if($i==1)
    			$email = $column;
    		$i = $i + 1;
    		continue;
    	}	
    	if($i == $len-5)
    	{
    		print '<td>'.$column.' ';
    	}
    	else if($i == $len-4)
    	{
    		print $column.' ';
    	}
       	else if($i == $len-3)
    	{
    		print $column.'</td>';
    	}
    	else if($i == $len-2)
    	{
    		print '<td>'.$column.' ';
    	}
    	else if($i == $len-1)
    	{
    		print $column.'</td>';
    	}
    	else
    	{
        	//Now we can print the current $column within the current $row inside of some HTML
        	print '<td>'.$column.'</td>';
        }
        $i = $i + 1;
    }
    print '<td><button type ="button" onclick="joinClicked(this,\''.$email.'\')" id = "'.$carpoolid.'">Join</button></td>';
    //Thus ends the $row...
    print '<tr>';
}
//...and the table
print '</table>';

//Now let's close the PHP code and end the HTML.
?>
<?php
if(isset($_GET['getValue']))
{
	$carpid = $_GET['getValue'];
	$q = 'insert into request(username, carpool_id, accepted, request_id) values(:t, :u, 0, seq_request_id.nextval)';
	$s = oci_parse($c, $q);
	oci_bind_by_name($s, ":t", $_SESSION['username']);
	oci_bind_by_name($s, ":u", $carpid);
	oci_execute($s);
}
?>
</div>
<button id="goBack" type="button" onclick="clickedButton(this)"> Go Back</button>
</body>
</html>
