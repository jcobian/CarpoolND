<html>
<body>

<?php
$time = $_GET['time'];
$carpool_id = $_GET['carpool_id'];
//Create a connection to the oracle database with the user xxx and the password yyy on the host zzz with the database www
$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}
//Write some SQL code to get rows from the wizards table
$q = 'update carpool set starttime= :t where carpool_id= :w';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);
oci_bind_by_name($s, ":t", $time);
oci_bind_by_name($s, ":w", $carpool_id);
//Execute the SQL statement/query
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}


oci_close($c);
print 'Confirmed Time Change';

?>

<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/homePage.php">Go Back</a>

</body>
</html>
