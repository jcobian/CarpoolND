<?php session_start();?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<div>
<?php
//Create a connection to the oracle database with the user xxx and the password yyy on the host zzz with the database www
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
//Write some SQL code to get rows from the wizards table
$q = 'select carpool_id, startingpoint, destination, startdate, starttime, eta, description, openseats, driver from carpool';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query
oci_execute($s);

//We want to print out the results of the query into an HTML table; so we'll need to write an HTML table. This can be done by closing the PHP and writing straight HTML code, or you can have PHP print the HTML code. Let's have PHP print the HTML for now.
print '<table>';
//We want to loop through all of the rows from the result of the query
          print '<tr>';
  print '<td><b>Carpool Id </b></td><td><b>Starting Point </b></td> <td><b>Destination</b></td> <td><b>Start Date</b></td> <td><b>Start Time</b></td> <td><b>ETA</b></td> <td><b>Description</b></td> <td><b>Open Seats</b></td> <td><b>Driver</b></td>';
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
</head>
<body>
<form action="confirmTimeChange.php" method="get">
<div class="insertForm">
Carpool Id: <input name="carpool_id"/> <br></br>
New Time: <input name="time"/><br></br>
</div>
<input type="submit"/>
</form>
</body>
</html>
