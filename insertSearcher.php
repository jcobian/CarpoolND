<?php session_start();?>
<html>
<head>
<style>
body {background-color:#041c42;}
p {font-size:14px}
p.Helv{font-family:Helvetica,serif}
</style>
<?php
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
oci_bind_by_name($s, ":f", $_SESSION['username']);
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
</head>
<body>
<a href="http://orchestra.cselab.nd.edu/~jwassel/CarpoolND/homePage.php">Go Back</a>
</body>
</html>
