<?php
$username = $_GET['username'];
$startDate = $_GET['startDate'];
$startingPoint = $_GET['startingPoint'];
$destination = $_GET['destination'];
$description = $_GET['description'];

$c = oci_connect('jwassel', 'jasonwassel', '//localhost/curt');
if (!$c) {
    $e = oci_error();   // For oci_connect errors do not pass a handle
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}

$q = 'insert into searchers (search_id, username, startdate, startingpoint, destination, description) values (seq_search_id.nextval, :f, :g, :h, :j, :k)';
//Parse that SQL query into a statement
$s = oci_parse($c, $q);

//Next we bind the variables to the placeholders.
oci_bind_by_name($s, ":f", $username);
oci_bind_by_name($s, ":g", $startDate);
oci_bind_by_name($s, ":h", $startingPoint);
oci_bind_by_name($s, ":j", $destination);
oci_bind_by_name($s, ":k", $description);

//Execute the SQL statement
if(!oci_execute($s))
{
	$e = oci_error($s);
	print $e['message'];
}
oci_close($c);
?>
