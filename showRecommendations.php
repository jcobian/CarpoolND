<?php session_start();
if(!isset($_SESSION['username']))
{unset($_SESSION);
session_destroy();
session_write_close();
header("Location:index.html");
exit;
}

$carpoolIDs = $_GET['arr'];
$totalTripTime = $_GET['arr2'];
$totalTripTimeArr = array();
foreach($totalTripTime as $str){
	$totalTripTimeArr  = explode(',', $str);
}

foreach($totalTripTimeArr as &$time){
	$minutes = floor($time/60);
	$hours=floor($minutes/60);
	$minutes=$minutes-($hours*60);
	$time=$hours.":".$minutes; 
}
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
function clickedButton(sel) {
	if(sel.id=="goBack") {
		window.location.href="testWaypts.php";
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
<div>
<?php
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
$q = 'select c.carpool_id, c.driver, c.startname, c.endname, c.startdate, c.enddate, nvl(c.description,\'No Description\'), c.openseats, c2.year, c2.make, c2.model, u.firstname, u.lastname from carpool c, car c2, users u where c.driver = c2.owner AND c2.owner = u.username AND c.openseats > 0 AND c.carpool_id IN (';

if(!empty($carpoolIDs)){
foreach ($carpoolIDs as $value){
	$q = $q.$value.',';
	$e=$e+1;
}}
/*if(!empty($carpoolIDs)){
	$len = count($carpoolIDs);
	for($i=0; $i<$len;$i++){
		$q = $q.$carpoolIDs.','
	}
}*/
$q = $q.'0)';
/*
if(!empty($_GET['startDay']) && !empty($_GET['startMonth']) && !empty($_GET['startYear']) )
	$q = $q.' AND c.startDate >= to_date(:s,\'yyyy/mm/dd\')';
if(!empty($_GET['endDay']) && !empty($_GET['endMonth']) && !empty($_GET['endYear']) )
	$q = $q.' AND c.endDate <= to_date(:r,\'yyyy/mm/dd\')';
*/
$q = $q.' order by carpool_id';
//unset $value;
//$q = $q.' AND c.openseats > 0';
//print $q;
//Parse that SQL query into a statement

$s = oci_parse($c, $q);
oci_bind_by_name($s, ":r", $endDateString);
oci_bind_by_name($s, ":s", $startDateString);
//fix me!!!
//$worked = oci_bind_array_by_name($s, ":a", $carpoolIDs,1000,-1,SQLT_NUM);


//Execute the SQL statement/query
$worked=oci_execute($s);

if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}


//We want to print out the results of the query into an HTML table; so we'll need to write an HTML table. This can be done by closing the PHP and writing straight HTML code, or you can have PHP print the HTML code. Let's have PHP print the HTML for now.
print '<table border = "1" style="background-color:#FFFFFF; overflow-y:scroll; height:auto; display:block;">';
//We want to loop through all of the rows from the result of the query
          print '<tr>';
  print '<td><b>Starting Point </b></td> <td><b>Destination</b></td> <td><b>Start Date</b></td> <td><b>End Date</b></td> <td><b>Description</b></td> <td><b>Open Seats</b></td> <td><b>Car</b></td> <td><b>Driver</b></td> <td><b>Trip Time</b></td> <td><b>Request to Join</b></td>';
print '<tr>';
   $j = 0;
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
    		$k=0;
    		
    		foreach($totalTripTimeArr as $col){
    			//print $k.' ';
    			if($j===$k){
    				print '<td>'.$col.'</td>';
    			}
    			$k=$k+1;
    		}

    		//print '<td>'.$j.'</td>';
    	}
    	else
    	{
        	//Now we can print the current $column within the current $row inside of some HTML
        	print '<td>'.$column.'</td>';
        }
        
        $i = $i + 1;
    }
    $j=$j+1;
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
