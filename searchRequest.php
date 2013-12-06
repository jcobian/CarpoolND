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
<script type="text/javascript">
function clickedButton(sel) {
	if(sel.id=="goBack") 
		window.location.href="homePage.php";
	

}

function joinClicked(sel, email) {
	var getValue = sel.id;
	alert("You have accepted " + email + " into your carpool!");
	window.location = "?getValue=" + getValue;

}
</script>
</head>
<body>
<center><h2> Requested Rides </h2></center>
<?php
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
$q = 'select distinct r.request_id, r.username, c.startname, c.endname, c.startdate, c.enddate from request r, carpool c where c.carpool_id = r.carpool_id and c.driver = :t and r.accepted = 0';

//Parse that SQL query into a statement

$s = oci_parse($c, $q);
oci_bind_by_name($s, ":t", $_SESSION['username']);

//Execute the SQL statement/query
oci_execute($s);

//We want to print out the results of the query into an HTML table; so we'll need to write an HTML table. This can be done by closing the PHP and writing straight HTML code, or you can have PHP print the HTML code. Let's have PHP print the HTML for now.
print '<table border = "1" style="background-color:#FFFFFF; overflow-y:scroll; height:auto; display:block;">';
//We want to loop through all of the rows from the result of the query
          print '<tr>';
  print '<td><b>User </b></td> <td><b>Start Point</b></td> <td><b>Destination </b></td> <td><b>Start Date</b></td> <td><b>End Date</b></td> <td><b></b></td>';
print '<tr>';
while ($row = oci_fetch_array($s,OCI_ASSOC)) {
    //Inside the loop we have get one $row at a time, so we need to handle this with HTML:

    print '<tr>';
    $request_id = 0;
    $i = 0;
    $email = '';
    //Inside of each $row we have several attributes/columns that we need to iterate through.
    foreach($row as $column) {
	if ($i == 0){
		$request_id = $column;
		$i = $i + 1;
		continue;
	}
	
	if ($i == 1){
		$email = $column;
	}
        	//Now we can print the current $column within the current $row inside of some HTML
        print '<td>'.$column.'</td>';

    }
    print '<td><button type ="button" onclick="joinClicked(this,\''.$email.'\'); clickedButton(this);" id = "'.$request_id.'">Accept</button></td>';
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
	$requestid = $_GET['getValue'];
	$q = 'update request set accepted = 1 where request_id = :u';
	$s = oci_parse($c, $q);
	//oci_bind_by_name($s, ":t", $_SESSION['username']);
	oci_bind_by_name($s, ":u", $requestid);
	oci_execute($s);
	
	$q = 'select carpool_id from request where request_id = :w';
	$s = oci_parse($c, $q);
	oci_bind_by_name($s, ":w", $requestid);
	oci_execute($s);
	$carpid = 0;
	while ($row = oci_fetch_array($s,OCI_ASSOC)) {
		foreach($row as $column){
			$carpid = $column;
		}
	}
	print "HERE";
	$q = 'update carpool set openseats = openseats - 1 where carpool_id = :c';
	$s = oci_parse($c, $q);
	oci_bind_by_name($s, ":c", $carpid);
	oci_execute($s);
}
?>
</div>
<button id="goBack" type="button" onclick="clickedButton(this)"> Go Back</button>
</body>
</html>
