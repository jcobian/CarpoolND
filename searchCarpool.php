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


?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript">
window.onload = function() {
  document.getElementById("Year").selectedIndex = -1;
  document.getElementById("openSeats").selectedIndex = -1;
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
	<option value=2011 selected>2011</option>
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

</div>
	<input type="submit" />
	<form action="searchCarpool.php" method="get" role="form"><input type="submit" value = "Clear"/></form>
	</form>
	
	</div>
</div>
<div>
<?php
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
$q = 'select c.carpool_id, c.driver, c.startname, c.endname, c.startdate, c.enddate, c.description, c.openseats, c2.year, c2.make, c2.model, u.firstname, u.lastname from carpool c, car c2, users u where c.driver = c2.owner AND c2.owner = u.username';
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
//Parse that SQL query into a statement

$s = oci_parse($c, $q);
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
