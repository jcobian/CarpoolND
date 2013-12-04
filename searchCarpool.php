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
	if(sel.id=="goBack") {
		window.location.href="homePage.php";
	}

}
</script>
</head>
<body>
<div>
<?php
//Create a connection to the oracle database with the user xxx and the password yyy on the host zzz with the database www
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
//Write some SQL code to get rows from the wizards table
$q = 'select startname, endname, startdate, enddate, description, openseats, driver from carpool';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query
oci_execute($s);

//We want to print out the results of the query into an HTML table; so we'll need to write an HTML table. This can be done by closing the PHP and writing straight HTML code, or you can have PHP print the HTML code. Let's have PHP print the HTML for now.
print '<table>';
//We want to loop through all of the rows from the result of the query
          print '<tr>';
  print '<td><b>Starting Point </b></td> <td><b>Destination</b></td> <td><b>Start Date</b></td> <td><b>End Date</b></td> <td><b>Description</b></td> <td><b>Open Seats</b></td> <td><b>Driver</b></td>';
print '<tr>';
while ($row = oci_fetch_array($s,OCI_ASSOC)) {
    //Inside the loop we have get one $row at a time, so we need to handle this with HTML:

    print '<tr>';
    //Inside of each $row we have several attributes/columns that we need to iterate through.
    foreach($row as $column) {
        //Now we can print the current $column within the current $row inside of some HTML
        print '<td>'.$column.'</td>';
    }
    //Thus ends the $row...
    print '<tr>';
}
//...and the table
print '</table>';

//Now let's close the PHP code and end the HTML.
?>
</div>
<button id="goBack" type="button" onclick="clickedButton(this)"> Go Back</button>
</body>
</html>
