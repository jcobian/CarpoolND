<?php session_start();?>
<html>
<head>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<div style="background-color:#ffcc00">
<?php
//Create a connection to the oracle database with the user xxx and the password yyy on the host zzz with the database www
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
$q = 'select make, model, year from car where username = :t';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
//Execute the SQL statement/query

oci_bind_by_name($s, ":t", $_SESSION['username']);

oci_execute($s);

//We want to print out the results of the query into an HTML table; so we'll need to write an HTML table. This can be done by closing the PHP and writing straight HTML code, or you can have PHP print the HTML code. Let's have PHP print the HTML for now.

print '<table>';
//We want to loop through all of the rows from the result of the query
          print '<tr>';
  print '<td><b>Make </b></td> <td><b>Model</b></td> <td><b>Year</b></td>';
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

?>
</div>
</head>
<body>
<center><h2 style="background-color:#ffcc00"> Delete a Car From your Profile</h2></center>
<form action="showDeletedCar.php" method="get">
<div id= "inner" style="background-color:#ffcc00">
Make: <input name="Make"/>
<br></br>
Model: <input name="Model"/>
<br></br>
Year: <input name="Year"/>
<br></br>
</div>
<input type="submit"/>
</form>
</body>
</html>

